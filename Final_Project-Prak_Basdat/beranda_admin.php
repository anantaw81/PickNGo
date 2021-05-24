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
  $menunggu_pembayaran = read("SELECT COUNT(*) AS menunggu_pembayaran FROM request_peminjaman WHERE status_peminjaman = 'accepted' AND gambar_bukti_pembayaran = NULL;"); // sudah accepted namun belum mengunggah foto
  $pembayaran_baru = read("SELECT COUNT(*) AS pembayaran_baru FROM request_peminjaman WHERE status_peminjaman = 'accepted' AND gambar_bukti_pembayaran != NULL;");
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
    <title>Hello, world!</title>
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

    <div class = "content">
      <div class="row">
        <div class="col-xxl-3 card mb-3" style="max-width: 330px;">
          <div class="row g-0">
            <div class="col-md-4 text-center">
              <i class = "fa fa-plus-circle " style="line-height: 88px; font-size: 3rem; color: green;" data-bs-toggle="modal" data-bs-target="#ModalForm"></i>
            </div>
            <div class="col-md-8">
              <div class="card-body">
                <h5 class="card-title"><?= $pelanggan_baru[0]["jumlah_pelanggan_baru"]; ?></h5>
                <p class="card-text">Pengguna Baru</p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xxl-3 card mb-3" style="max-width: 330px;">
          <div class="row g-0">
            <div class="col-md-4 text-center">
              <i class = "fa fa-user-circle-o " style="line-height: 88px; font-size: 3rem; color: blue;" data-bs-toggle="modal" data-bs-target="#ModalForm"></i>
            </div>
            <div class="col-md-8">
              <div class="card-body">
                <h5 class="card-title"><?= $total_pelanggan[0]["jumlah_pelanggan"]; ?></h5>
                <p class="card-text">Total Pengguna</p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xxl-3 card mb-3" style="max-width: 330px;">
          <div class="row g-0">
            <div class="col-md-4 text-center">
              <i class = "fa fa-address-book" style="line-height: 88px; font-size: 3rem; color: blue;" data-bs-toggle="modal" data-bs-target="#ModalForm"></i>
            </div>
            <div class="col-md-8">
              <div class="card-body">
                <h5 class="card-title"><?= $total_driver[0]["jumlah_driver"]; ?></h5>
                <p class="card-text">Driver</p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xxl-3 card mb-3" style="max-width: 330px;">
          <div class="row g-0">
            <div class="col-md-4 text-center">
              <i class = "fa fa-address-book-o" style="line-height: 88px; font-size: 3rem; color: blue;" data-bs-toggle="modal" data-bs-target="#ModalForm"></i>
            </div>
            <div class="col-md-8">
              <div class="card-body">
                <h5 class="card-title"><?= $total_helper[0]["jumlah_helper"]; ?></h5>
                <p class="card-text">Helper</p>
              </div>
            </div>
          </div>
        </div>
        
      </div>
      <div class="row">
        <div class="col-xxl-3 card mb-3" style="max-width: 330px;">
          <div class="row g-0">
            <div class="col-md-4 text-center">
              <i class = "fa fa-bar-chart" style="line-height: 88px; font-size: 3rem; color: blue;" data-bs-toggle="modal" data-bs-target="#ModalForm"></i>
            </div>
            <div class="col-md-8">
              <div class="card-body">
                <h5 class="card-title"><?= $request_peminjaman[0]["request_peminjaman"]; ?></h5>
                <p class="card-text">Request Peminjaman</p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xxl-3 card mb-3" style="max-width: 330px;">
          <div class="row g-0">
            <div class="col-md-4 text-center">
              <i class = "fa fa-clock-o" style="line-height: 88px; font-size: 3rem; color: blue;" data-bs-toggle="modal" data-bs-target="#ModalForm"></i>
            </div>
            <div class="col-md-8">
              <div class="card-body">
                <h5 class="card-title"><?= $menunggu_pembayaran[0]["menunggu_pembayaran"]; ?></h5>
                <p class="card-text">Menunggu Pembayaran</p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xxl-3 card mb-3" style="max-width: 330px;">
          <div class="row g-0">
            <div class="col-md-4 text-center">
              <i class = "fa fa-credit-card-alt" style="line-height: 88px; font-size: 3rem; color: blue;" data-bs-toggle="modal" data-bs-target="#ModalForm"></i>
            </div>
            <div class="col-md-8">
              <div class="card-body">
                <h5 class="card-title"><?= $pembayaran_baru[0]["pembayaran_baru"]; ?></h5>
                <p class="card-text">Pembayaran Baru</p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xxl-3 card mb-3" style="max-width: 330px;">
          <div class="row g-0">
            <div class="col-md-4 text-center">
              <i class = "fa fa-calendar-check-o" style="line-height: 88px; font-size: 3rem; color: blue;" data-bs-toggle="modal" data-bs-target="#ModalForm"></i>
            </div>
            <div class="col-md-8">
              <div class="card-body">
                <h5 class="card-title"><?= $total_peminjaman[0]["total_peminjaman"]; ?></h5>
                <p class="card-text">Total Peminjaman</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-xxl-3 card mb-3" style="max-width: 330px;">
          <div class="row g-0">
            <div class="col-md-4 text-center">
              <i class = "fa fa fa-truck" style="line-height: 88px; font-size: 3rem; color: blue;" data-bs-toggle="modal" data-bs-target="#ModalForm"></i>
            </div>
            <div class="col-md-8">
              <div class="card-body">
                <h5 class="card-title"><?= $total_model_kendaraan[0]["total_model_kendaraan"]; ?></h5>
                <p class="card-text">Model Pickup/Truk</p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xxl-3 card mb-3" style="max-width: 330px;">
          <div class="row g-0">
            <div class="col-md-4 text-center">
              <i class = "fa fa fa-truck" style="line-height: 88px; font-size: 3rem; color: blue;" data-bs-toggle="modal" data-bs-target="#ModalForm"></i>
            </div>
            <div class="col-md-8">
              <div class="card-body">
                <h5 class="card-title"><?= $total_unit_kendaraan[0]["total_unit_kendaraan"]; ?></h5>
                <p class="card-text">Unit Pickup/Truk</p>
              </div>
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