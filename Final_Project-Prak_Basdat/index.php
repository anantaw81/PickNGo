<?php 
session_start();
require 'functions.php';
$tuples = read("SELECT * FROM peminjaman_terbanyak;");
$data =read("SELECT COUNT(*) AS total_peminjaman FROM peminjaman");
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style2.css">
    <link rel="icon" href="gambar/Logo/logo_square.png" type="image/x-icon" />
    <title>PickNGo</title>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a href="index.php" class="navbar-brand ms-3"><img src="gambar/Logo/logo.png" style="max-height:60px;" class="img-fluid"></a>
        <button class="navbar-toggler me-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse ms-3" id="navbarTogglerDemo01">
            <ul class = "navbar-nav mx-auto">
                <li class="nav-item me-5"><a class = "nav-link" href="#teratas">Pickup dan Truck</a></li>
                <li class="nav-item"><a class = "nav-link" href="#hubungi" >Hubungi Kami</a></li>
            </ul>
            <a class="btn btn-primary btn-dark me-3" href="form_registrasi.php" role="button">Signup</a>
            <a class="btn btn-primary btn-dark me-3" href="form_login.php" role="button">Login</a>
        </div>
    </nav>

<!-- Carrousel-->
    <div class="ml-0">
      <div id="carouselExampleDark" class="carousel carousel-dark slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
          <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
          <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
          <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="gambar/1.png" class="d-block w-100" alt="...">
            <div class="carousel-caption d-none d-md-block">
            </div>
          </div>
          <div class="carousel-item">
            <img src="gambar/2.png" class="d-block w-100" alt="...">
            <div class="carousel-caption d-none d-md-block">
            </div>
          </div>
          <div class="carousel-item">
            <img src="gambar/3.png" class="d-block w-100" alt="...">
            <div class="carousel-caption d-none d-md-block">
            </div>
          </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>
    </div>

    <div class = "content next">
    <a name="teratas"></a>
      <h3 class="display-3 d-flex justify-content-center">
        Peminjaman Teratas
      </h3>
      <div class="row card-container">
        <?php foreach ($tuples as $tuple): ?>
          <div class="col-xxl-3 col-xl-4 col-lg-6 col-md-6">
            <div class="card mt-5 mx-auto" style="width: 18rem;">
              <img class="card-img-top" src="Images/TipeMobil/<?= $tuple["gambar"]; ?>" alt="Gambar <?= $tuple["model"] ?>">
              <div class="card-body">
                <h5 class="card-title"><?= $tuple["model"] ?></h5>
                <p class="card-text"><?= $tuple["manufaktur"] ?></p>
              </div>
              <ul class="list-group list-group-flush">
                <li class="list-group-item">Jumlah Peminjaman: <?= $tuple["jumlah_peminjaman"] ?></li>
                <li class="list-group-item">Harga: <?= $tuple["harga_sewa"] ?>/hari</li>
              </ul>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="top-buffer next">
      <h3 class="display-3 d-flex justify-content-center">
        Tentang Kami
      </h3>
      <img src="gambar/Logo/logo_square.png" alt="Tentang Saya" class="right">
      <p>PickNGo adalah perusahaan penyedia layanan sewa pickup dan truck yang berdiri sejak tahun 2021. Berpusat di Bali, PickNGo siap melayani kebutuhan anda terhadap kendaraan pickup dan truk serta pemindahan barang-barang berukuran besar.</p>
    </div>

    <div class="next container-fluid top-buffer" id="footer" style="background-color:white;">
    <a name="hubungi"></a>
      <div class="row align-items-center">
        <h3 class="display-3 d-flex justify-content-center">
          Hubungi Kami
        </h3>
      </div>
      <div class="row row-cols-3" >
        <div class="col-4 sm-3" style="margin-bottom:3vw;">
          <div class="row justify-content-evenly align-items-center" style="padding-bottom: 2%;">
            <div class="card" style="width: 20vw; background-color:rgba(51,34,0,0);">
              <div class="card-body  mx-auto">
                <h5 class="card-title text-center"><i class="fa fa-map-marker" aria-hidden="true" style="font-size:3vw; color:#b34509;"></i></h5>
                <h4 class="card-title text-center" style="color:#b34509;">Alamat</h4>
                <p class="card-text text-center" style="color:#b34509;">Jl By Pass Ngurah Rai, Bali, Indonesia.</p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-4 sm-3" style="margin-bottom:3vw;">
          <div class="row justify-content-evenly align-items-center" style="padding-bottom: 2%;">
            <div class="card" style="width: 20vw; background-color:rgba(51,34,0,0);">
              <div class="col card-body mx-auto" >
                <h5 class="card-title text-center"><i class="fa fa-phone" aria-hidden="true" style="font-size:3vw; color:#b34509;"></i></h5>
                <h4 class="card-title text-center" style="color:#b34509;">Telepon</h4>
                <p class="card-text text-center" style="color:#b34509;">081-83947938192-Phone <br> 021-221222-Fax</p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-4 sm-3" style="margin-bottom:3vw;">
          <div class="row justify-content-evenly align-items-center" style="padding-bottom: 2%;">
            <div class="card" style="width: 20vw; background-color:rgba(51,34,0,0);">
              <div class="card-body mx-auto">
                <h5 class="card-title text-center"><i class="fa fa-envelope" aria-hidden="true" style="font-size:3vw; color:#b34509;"></i></h5>
                <h4 class="card-title text-center" style="color:#b34509;">Email</h4>
                <p class="card-text text-center" style="color:#b34509;">pickngo@gmail.com <br> pickngocs@gmail.com</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="about top-buffer">
      <a href="">Copyright 2022</a>
    </div>





    




    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
    -->
  </body>
</html>