<?php

// echo "Hallo 1234";

session_start();

$sEmail="";
$sPassword="";
$sPasswordHash="";
$bLoginSuccess=false;
$iChecker=0;

?>


<?php
//Operating System


$user_agent = $_SERVER['HTTP_USER_AGENT'];

function getOS() { 

    global $user_agent;

    $os_platform  = "Unknown OS Platform";

    $os_array     = array(
                          '/windows nt 10/i'      =>  'Windows 10',
                          '/windows nt 6.3/i'     =>  'Windows 8.1',
                          '/windows nt 6.2/i'     =>  'Windows 8',
                          '/windows nt 6.1/i'     =>  'Windows 7',
                          '/windows nt 6.0/i'     =>  'Windows Vista',
                          '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                          '/windows nt 5.1/i'     =>  'Windows XP',
                          '/windows xp/i'         =>  'Windows XP',
                          '/windows nt 5.0/i'     =>  'Windows 2000',
                          '/windows me/i'         =>  'Windows ME',
                          '/win98/i'              =>  'Windows 98',
                          '/win95/i'              =>  'Windows 95',
                          '/win16/i'              =>  'Windows 3.11',
                          '/macintosh|mac os x/i' =>  'Mac OS X',
                          '/mac_powerpc/i'        =>  'Mac OS 9',
                          '/linux/i'              =>  'Linux',
                          '/ubuntu/i'             =>  'Ubuntu',
                          '/iphone/i'             =>  'iPhone',
                          '/ipod/i'               =>  'iPod',
                          '/ipad/i'               =>  'iPad',
                          '/android/i'            =>  'Android',
                          '/blackberry/i'         =>  'BlackBerry',
                          '/webos/i'              =>  'Mobile'
                    );

    foreach ($os_array as $regex => $value)
        if (preg_match($regex, $user_agent))
            $os_platform = $value;

    return $os_platform;
}

function getBrowser() {

    global $user_agent;

    $browser        = "Unknown Browser";

    $browser_array = array(
                            '/msie/i'      => 'Internet Explorer',
                            '/firefox/i'   => 'Firefox',
                            '/safari/i'    => 'Safari',
                            '/chrome/i'    => 'Chrome',
                            '/edge/i'      => 'Edge',
                            '/opera/i'     => 'Opera',
                            '/netscape/i'  => 'Netscape',
                            '/maxthon/i'   => 'Maxthon',
                            '/konqueror/i' => 'Konqueror',
                            '/mobile/i'    => 'Handheld Browser'
                     );

    foreach ($browser_array as $regex => $value)
        if (preg_match($regex, $user_agent))
            $browser = $value;

    return $browser;
}


$user_os        = getOS();
$user_browser   = getBrowser();

$device_details = "Browser: ".$user_browser." Operating System: ".$user_os."";
//OS finished
?>
<!-- JS Resolution -->
<!-- <script type="text/javascript">
   document.cookie = 'window_width='+screen.width+'; expires=Fri, 3 Aug 2901 20:47:11 UTC; path=/';
   document.cookie = 'window_height='+screen.height+'; expires=Fri, 3 Aug 2901 20:47:11 UTC; path=/';
</script> -->
<?php
//Resolution
$sWidth = $_COOKIE['window_width'];
$sHeight = $_COOKIE['window_height'];
//Resolution finish

if (isset($_POST['username']))
{
    $sEmail=$_POST['username'];
}
if (isset($_POST['password']))
{
    $sPassword=$_POST['password'];
}
// if(isset($_POST['width']) && isset($_POST['height'])) {
//     $sWidth = $_POST['width'];
//     $sHeight = $_POST['height'];
// }

$sPasswordHash=hash('sha512',$sPassword);

try
{
    //DB
    include 'dbsettings.php';
    //verbindung zur datenbank
    $conn = new PDO("mysql:host=$servername;dbname=$dbDatabasename", $dbLoginUsername, $dbPassword);
    //set the PDo error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    //echo $sPasswordHash;

    //SQL
    $sql = "SELECT * FROM ws_login WHERE email='$sEmail' AND pin='$sPasswordHash'";
    $sql;
    foreach ($conn->query($sql) as $row)
    {
        //echo 'Test';
        $bLoginSuccess=true;
        $_SESSION["firstname"] = $row["firstname"];
        $_SESSION["surname"] = $row["surname"];
        $_SESSION["email"] = $row["email"];
        $_SESSION["login"] = 111;
        $_SESSION["time"] = time();
        $_SESSION["emailconfirmed"]=$row["emailconfirmed"];
        $_SESSION["loggedin"]=$row["loggedin"];
        // $time="";
        // $time=$_SESSION["time"];

        // if($sEmail!=$row["email"] OR $sPassword== $row["pin"])
        // {
        //     $bLoginSuccess=false;
        // }
    }


    //echo $bLoginSuccess;
    // Hier if erste mal login dann pflicht zur pw änderung! danach zur portalview.php
    if($bLoginSuccess)
    {
        // echo $_SESSION["emailconfirmed"];
        // echo $sEmail==$_SESSION["surname"];
        // echo $sPassword==$row["pin"];
        // echo '<br>'.$_SESSION["emailconfirmed"]!="no";
        if($_SESSION["emailconfirmed"]!="no" AND $sEmail==$_SESSION["email"] AND $sPasswordHash==$row["pin"] )

        {
            // Login Daten speichern in Tabelle userDaten
            try{
                $sqlLoginData = "INSERT INTO user_data (resolution,operatingsystem,email)
            VALUES(?,?,?)";
                $stmt=$conn->prepare($sqlLoginData);
                $stmt->execute([$sWidth."x".$sHeight,$device_details,$sEmail]);
            }
            catch(PDOException $e)
            {
                // $handle = fopen ("error_login.txt", "w");
                // fwrite ($handle, $e->getMessage());
                // fclose ($handle);
                // echo $e;
            }
            
            $sqlUpdateLoggedIn="UPDATE ws_login SET loggedin ='1' WHERE ws_login.email =?";
            $stmt2=$conn->prepare($sqlUpdateLoggedIn);
            $stmt2->execute([$sEmail]);
            $iChecker=1;
            
            // echo 'Alles ok';
        }
        elseif($_SESSION["emailconfirmed"]=="no" AND $sEmail==$_SESSION["email"] AND $sPasswordHash== $row["pin"] )
        {   

            // Login Daten speichern in Tabelle userDaten
            try{
                $sqlLoginData = "INSERT INTO user_data (resolution,operatingsystem,email)
            VALUES(?,?,?)";
                $stmt=$conn->prepare($sqlLoginData);
                $stmt->execute([$sWidth."x".$sHeight,$device_details,$sEmail]);
            }
            catch(PDOException $e)
            {
                // $handle = fopen ("error_login.txt", "w");
                // fwrite ($handle, $e->getMessage());
                // fclose ($handle);
                // echo $e;
            }
            $sqlUpdateLoggedIn="UPDATE ws_login SET loggedin ='1' WHERE ws_login.email =?";
            $stmt2=$conn->prepare($sqlUpdateLoggedIn);
            $stmt2->execute([$sEmail]);
            //echo 'Neue Email wurde nicht bestätigt';
            // Falls email noch nicht bestätigt wurde 
            // header("Location: newpassword.php");
            // PW Änderung pflicht!
            $iChecker=2;
        }

    }

    else
    {
        //echo 'Pass ist falsch';
        // Falls $bLoginSuccess falsch ist wieder auf Login 
        // header("Location: login.php");
        $iChecker=3;
        
    }
    //close connection
    $conn = null;
}
catch(PDOException $e)
{
    $handle = fopen ("error_login.txt", "w");
    fwrite ($handle, $e->getMessage());
    fclose ($handle);
    // echo("TEST");
}

if($bLoginSuccess)
{
    if($iChecker==1){
        //echo $sWidth."x".$sHeight,"x",$sEmail;
        header("Location: portalview.php");
    }
    elseif($iChecker==2){
        header("Location: newPW.php");
    }
    
}
else
{
    header("Location: login.php");
}

?>