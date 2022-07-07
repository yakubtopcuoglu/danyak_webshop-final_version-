<!-- Carousel Item--->
<div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="3" aria-label="Slide 4"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="4" aria-label="Slide 5"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="5" aria-label="Slide 6"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="6" aria-label="Slide 7"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="7" aria-label="Slide 8"></button>
  </div>

  <!-- Wrapper for slides -->
  <div class="carousel-inner">
    <div class="carousel-item active" >
      <img src="../images/carousselPic4.jpg" class="d-block w-100" alt="...">
      <div class="carousel-caption d-none d-md-block" style="background-color:black; width:100%;left:0">
        <h5>Elden Ring</h5>
        <p>BANDAI NAMCO Entertainment Inc.</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="../images/fifa23.jpg" class="d-block w-100" alt="...">
      <div class="carousel-caption d-none d-md-block" style="background-color:black; width:100%;left:0">
        <h5>FIFA 23</h5>
        <p>Electronic Arts</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="../images/randc.jpg" class="d-block w-100" alt="...">
      <div class="carousel-caption d-none d-md-block" style="background-color:black; width:100%;left:0">
        <h5>Ratchet & Clank: Rift Apart</h5>
        <p>Sony Interactive Entertainment</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="../images/carouselPic2.jpg" class="d-block w-100" alt="...">
      <div class="carousel-caption d-none d-md-block" style="background-color:black; width:100%;left:0">
        <h5>God of War Ragnarök </h5>
        <p>Sony Interactive Entertainment</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="../images/carousselPic3.jpg" class="d-block w-100" alt="...">
      <div class="carousel-caption d-none d-md-block" style="background-color:black; width:100%;left:0">
        <h5>Marvel's Spider-Man: Miles Morales</h5>
        <p>Sony Interactive Entertainment Europe</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="../images/carousselPic1.jpg" class="d-block w-100" alt="...">
      <div class="carousel-caption d-none d-md-block" style="background-color:black; width:100%;left:0">
        <h5>Grand Theft Auto V</h5>
        <p>Rockstar Games</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="../images/carousselPic5.jpg" class="d-block w-100" alt="...">
      <div class="carousel-caption d-none d-md-block" style="background-color:black; width:100%;left:0">
        <h5>Grän Türismö 7</h5>
        <p>Polyphony Digital Inc.</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="../images/carousselPic6.jpg" class="d-block w-100" alt="...">
      <div class="carousel-caption d-none d-md-block" style="background-color:black; width:100%;left:0">
        <h5>Red Dead Redemption II</h5>
        <p>Rockstar Games</p>
      </div>
    </div>
  </div>

  <!-- Left and right controls/icons -->
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>

<script>
        // Handle Bootstrap carousel slide event
        $('.carousel').carousel({
            interval: 2000
        });
    </script>