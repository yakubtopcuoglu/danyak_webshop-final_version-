$(document).ready(function() {
	$("#online").load("anzahlUserOnline.php");
        var refreshId = setInterval(function() {
            $("#online").load("anzahlUserOnline.php");
        }, 10000);
});
