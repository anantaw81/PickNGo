<?php 
	session_start();
	require 'functions.php';
	// $tuples = read("SELECT tipe_kendaraan.ID_model, model, manufaktur, harga_sewa, gambar, jumlah_unit FROM tipe_kendaraan LEFT JOIN (SELECT ID_model, COUNT(ID_kendaraan) AS jumlah_unit FROM unit_kendaraan GROUP BY ID_model) AS n ON tipe_kendaraan.ID_model = n.ID_model ORDER BY harga_sewa;");
	if(!isset($_SESSION["login_admin"])) {
		header("location: form_login.php");
		exit;
	}

  $pelanggan_baru = read("SELECT COUNT(*) AS jumlah_pelanggan_baru FROM data_pelanggan_baru;");
  $total_pelanggan= read("SELECT COUNT(*) AS jumlah_pelanggan FROM akun_pelanggan;");
  $total_driver = read("SELECT COUNT(*) AS jumlah_driver FROM driver");
  $total_helper = read("SELECT COUNT(*) AS jumlah_helper FROM helper");
  $request_peminjaman = read("SELECT COUNT(*) AS request_peminjaman FROM request_peminjaman WHERE status_peminjaman = 'not accepted yet';");
  $menunggu_pembayaran = read("SELECT COUNT(*) AS menunggu_pembayaran FROM request_peminjaman WHERE status_peminjaman = 'accepted' AND gambar_bukti_pembayaran IS NULL;"); // sudah accepted namun belum mengunggah foto
  $pembayaran_baru = read("SELECT COUNT(*) AS pembayaran_baru FROM request_peminjaman WHERE status_peminjaman = 'accepted' AND gambar_bukti_pembayaran IS NOT NULL;");
  $total_peminjaman = read("SELECT COUNT(*) AS total_peminjaman FROM peminjaman;");
  $total_model_kendaraan = read("SELECT COUNT(*) AS total_model_kendaraan FROM tipe_kendaraan;");
  $total_unit_kendaraan = read("SELECT COUNT(*) AS total_unit_kendaraan FROM unit_kendaraan;");
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="styling.css">
    <link rel="icon" href="Images/Logo/logo_square.png" type="image/x-icon" />
    <title>Pick N Go</title>
  </head>
  <body>
  	<input type="checkbox" id="hamburger-menu">
  	<nav>
  		<a href="index.php" class="logo"><img src="Images/Logo/logo.png" style="max-height:60px;" class="img-fluid"></a>
  		<button type="button" id = "logout-button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalLogout">
        Logout
      </button>
  		<label for="hamburger-menu" class="hamburger"><i class="fa fa-bars"></i></label>
  	</nav>

  	<div class="sidebar">
  		<h2> Admin </h2>
  		<a href="beranda_admin.php" style="background-color: #b34509;"><i class="fa fa-home"></i><span>Beranda</span></a>
      <a href="list_model_kendaraan_admin.php"><i class="fa fa-truck"></i><span>List Kendaraan</span></a>
  		<a href="list_driver_admin.php"><i class = "fa fa-address-book"></i><span>List Driver</span></a>
  		<a href="list_helper_admin.php"><i class = "fa fa-address-book-o"></i><span>List Helper</span></a>
      <a href="list_pelanggan_admin.php"><i class = "fa fa-user"></i><span>List Pelanggan</span></a>
  		<a href="request_peminjaman_admin.php"><i class = "fa fa-hourglass"></i><span>Request Peminjaman</span></a>
  		<a href="validasi_user_admin.php"><i class = "fa fa-check-circle"></i><span>Validasi Pengguna</span></a>
      <a href="validasi_pembayaran_admin.php"><i class = "fa fa-money"></i><span>Validasi Pembayaran</span></a>
  		<a href="list_peminjaman_admin.php"><i class = "fa fa-list"></i><span>List Peminjaman</span></a>
      <a href="list_pengembalian_admin.php"><i class = "fa fa-list-alt"></i><span>List Pengembalian</span></a>
  		<a href="" class = "logout"><span>Logout</span></a>
  	</div>

    <div class="content">
      <div class="row gx-4 row-cols-3 justify-content-evenly align-items-center shadow mx-auto" style="margin:3%; max-width:70%; padding:3%; background-color:rgba(0,3,51,0.7660014689469538); border-radius:30px;">
        <div class="col-4 sm-3" style="width:20%;" >
          <div class="row" style="padding-bottom: 3%;">
            <div class="card-body ">
              <h5 class="card-title text-center"><i class="fa fa-users" aria-hidden="true" style="font-size:5vw; color:white;"></i></h5>
              <h3 class="card-text fs-2 text-center" style=" padding-top:1vh; color:white;">PENGGUNA</h3>
            </div>
          </div>
        </div>
        <div class="col-4 sm-3" style="width:20%;">
            <div class="row" style="padding-bottom: 3%;">
              <div class="col card-body shadow" style="border-radius:20px; padding:15%; background-color:rgba(252,124,54,0.8690826672465861);">
                <h5 class="card-title fs-1 fw-bolder text-center"><?= $pelanggan_baru[0]["jumlah_pelanggan_baru"]; ?></h5>
                <h3 class="card-text fs-4 text-center" style=" padding-top:1vh;">Pengguna Baru</h3>
              </div>
            </div>
        </div>
        <div class="col-4 sm-3" style=" width:20%;">
            <div class="row" style="padding-bottom: 3%;">
              <div class="col card-body shadow" style="border-radius:20px; padding:15%; background-color:rgba(252,124,54,0.8690826672465861)">
                <h5 class="card-title fs-1 fw-bolder text-center"><?= $total_pelanggan[0]["jumlah_pelanggan"]; ?></h5>
                <h3 class="card-text fs-4 text-center" style=" padding-top:1vh;">Total Pengguna</h3>
              </div>
            </div>
        </div>
      </div>

      <div class="row gx-4 row-cols-3 justify-content-evenly align-items-center shadow mx-auto" style="margin:3%; max-width:70%; padding:3%; background-color:rgba(0,3,51,0.7660014689469538); border-radius:30px;">
        <div class="col-4 sm-3" style="width:20%;" >
          <div class="row" style="padding-bottom: 3%;">
            <div class="card-body ">
              <h5 class="card-title text-center"><i class="fa fa-briefcase" aria-hidden="true" style="font-size:5vw; color:white;"></i></h5>
              <h3 class="card-text fs-3 text-center" style=" padding-top:1vh; color:white;">PEGAWAI</h3>
            </div>
          </div>
        </div>
        <div class="col-4 sm-3" style="width:20%;">
            <div class="row" style="padding-bottom: 3%;">
              <div class="col card-body shadow" style="border-radius:20px; padding:15%; background-color:rgba(252,124,54,0.8690826672465861);">
                <h5 class="card-title fs-1 fw-bolder text-center"><?= $total_driver[0]["jumlah_driver"]; ?></h5>
                <h3 class="card-text fs-4 text-center" style=" padding-top:1vh;">Driver</h3>
              </div>
            </div>
        </div>
        <div class="col-4 sm-3" style=" width:20%;">
            <div class="row" style="padding-bottom: 3%;">
              <div class="col card-body shadow" style="border-radius:20px; padding:15%; background-color:rgba(252,124,54,0.8690826672465861)">
                <h5 class="card-title fs-1 fw-bolder text-center"><?= $total_helper[0]["jumlah_helper"]; ?></h5>
                <h3 class="card-text fs-4 text-center" style=" padding-top:1vh;">Helper</h3>
              </div>
            </div>
        </div>
      </div>

      <div class="row gx-4 row-cols-3 justify-content-evenly align-items-center shadow mx-auto" style="margin:3%; max-width:70%; padding:3%; background-color:rgba(0,3,51,0.7660014689469538); border-radius:30px;">
        <div class="col-4 sm-3" style="width:20%;" >
          <div class="row" style="padding-bottom: 3%;">
            <div class="card-body ">
              <h5 class="card-title text-center"><i class="fa fa-truck" aria-hidden="true" style="font-size:6vw; color:white;"></i></h5>
              <h3 class="card-text fs-3 text-center" style=" padding-top:1vh; color:white;">PEMINJAMAN</h3>
            </div>
          </div>
        </div>
        <div class="col-4 sm-3" style="width:20%;">
            <div class="row" style="padding-bottom: 3%;">
              <div class="col card-body shadow" style="border-radius:20px; padding:15%; background-color:rgba(252,124,54,0.8690826672465861);">
                <h5 class="card-title fs-1 fw-bolder text-center"><?= $request_peminjaman[0]["request_peminjaman"]; ?></h5>
                <h3 class="card-text fs-4 text-center" style=" padding-top:1vh;">Request Peninjaman</h3>
              </div>
            </div>
        </div>
        <div class="col-4 sm-3" style=" width:20%;">
            <div class="row" style="padding-bottom: 3%;">
              <div class="col card-body shadow" style="border-radius:20px; padding:15%; background-color:rgba(252,124,54,0.8690826672465861)">
                <h5 class="card-title fs-1 fw-bolder text-center"><?= $total_peminjaman[0]["total_peminjaman"]; ?></h5>
                <h3 class="card-text fs-4 text-center" style=" padding-top:1vh;">Total Peminjaman</h3>
              </div>
            </div>
        </div>
      </div>

      <div class="row gx-4 row-cols-3 justify-content-evenly align-items-center shadow mx-auto" style="margin:3%; max-width:70%; padding:3%; background-color:rgba(0,3,51,0.7660014689469538); border-radius:30px;">
        <div class="col-4 sm-3" style="width:20%;" >
          <div class="row" style="padding-bottom: 3%;">
            <div class="card-body ">
              <h5 class="card-title text-center"><i class="fa fa-credit-card-alt" aria-hidden="true" style="font-size:5vw; color:white;"></i></h5>
              <h3 class="card-text fs-3 text-center" style=" padding-top:1vh; color:white;">PEMBAYARAN</h3>
            </div>
          </div>
        </div>
        <div class="col-4 sm-3" style="width:20%;">
            <div class="row" style="padding-bottom: 3%;">
              <div class="col card-body shadow" style="border-radius:20px; padding:15%; background-color:rgba(252,124,54,0.8690826672465861);">
                <h5 class="card-title fs-1 fw-bolder text-center"><?= $menunggu_pembayaran[0]["menunggu_pembayaran"]; ?></h5>
                <h3 class="card-text fs-4 text-center" style=" padding-top:1vh;">Menunggu Pembayaran</h3>
              </div>
            </div>
        </div>
        <div class="col-4 sm-3" style=" width:20%;">
            <div class="row" style="padding-bottom: 3%;">
              <div class="col card-body shadow" style="border-radius:20px; padding:15%; background-color:rgba(252,124,54,0.8690826672465861)">
                <h5 class="card-title fs-1 fw-bolder text-center"><?= $pembayaran_baru[0]["pembayaran_baru"]; ?></h5>
                <h3 class="card-text fs-4 text-center" style=" padding-top:1vh;">Pembayaran Baru</h3>
              </div>
            </div>
        </div>
      </div>
    </div>
    
    
    <!-- JAVASCRIPT --> 
    <script type="text/javascript">

    </script>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
    -->
    <!-- Modal -->
      <div class="modal" id="modalLogout" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Logout</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              Apakah anda yakin akan logout?
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
              <a href="logoutlogic.php" class="btn btn-danger">Logout</a>
            </div>
          </div>
        </div>
      </div>
  </body>
</html>