<?php 
    session_start();
	require 'functions.php';
    if(!isset($_SESSION["login_admin"])) {
		header("location: form_login.php");
		exit;
	}

  $tuples = read("SELECT pelanggan.*, akun_pelanggan.ID_akun, akun_pelanggan.username FROM pelanggan INNER JOIN akun_pelanggan ON pelanggan.ID_pelanggan = akun_pelanggan.ID_pelanggan WHERE status_akun = 'valid'");
  if(isset($_POST["submit-blokir"])) {
      $status_pemblokiran = blokir_pelanggan($_POST["ID-akun-blokir"]);
      if ($status_pemblokiran === true) {
        $_SESSION["bool_status_blokir"] = true;
      } else {
        $_SESSION["bool_status_blokir"] = false;
      }
      header("location: list_pelanggan_admin.php");
      exit;
  }
  if(isset($_POST["search-list-pelanggan"])) {
    $keyword = $_POST["keyword-search-list-pelanggan"];
    $tuples = read("SELECT pelanggan.*, akun_pelanggan.ID_akun, akun_pelanggan.username FROM pelanggan INNER JOIN akun_pelanggan ON pelanggan.ID_pelanggan = akun_pelanggan.ID_pelanggan WHERE (status_akun = 'valid') AND (nama LIKE '%$keyword%' OR username LIKE '%$keyword%' OR alamat LIKE '%$keyword%' OR kabupaten LIKE '%$keyword%');");
  }
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
  		<a href="beranda_admin.php"><i class="fa fa-home"></i><span>Beranda</span></a>
        <a href="list_model_kendaraan_admin.php"><i class="fa fa-truck"></i><span>List Kendaraan</span></a>
  		<a href="list_driver_admin.php"><i class = "fa fa-address-book"></i><span>List Driver</span></a>
  		<a href="list_helper_admin.php"><i class = "fa fa-address-book-o"></i><span>List Helper</span></a>
        <a href="list_pelanggan_admin.php" style="background-color: #b34509;"><i class = "fa fa-user"></i><span>List Pelanggan</span></a>
  		<a href="request_peminjaman_admin.php"><i class = "fa fa-hourglass"></i><span>Request Peminjaman</span></a>
  		<a href="validasi_user_admin.php" ><i class = "fa fa-check-circle"></i><span>Validasi Pengguna</span></a>
      <a href="validasi_pembayaran_admin.php"><i class = "fa fa-money"></i><span>Validasi Pembayaran</span></a>
  		<a href="list_peminjaman_admin.php"><i class = "fa fa-list"></i><span>List Peminjaman</span></a>
      <a href="list_pengembalian_admin.php"><i class = "fa fa-list-alt"></i><span>List Pengembalian</span></a>
  		<a href="" class = "logout" data-bs-toggle="modal" data-bs-target="#modalLogout"><span>Logout</span></a>
  	</div>

    <div class = "content">
        <form action="" method="post" autocomplete="off" class="search-form">
            <div class="utility-bar">
                <div></div>
                <div class="input-group">
                <div class="form-floating">
                    <input type="text" class="form-control" id="floatingInput" placeholder="Cari berdasarkan nama" name="keyword-search-list-pelanggan">
                    <label for="floatingInput">Cari Berdasarkan Nama/Username/Alamat/Kabupaten</label>
                </div>
                <button type="submit" class="fa fa-search btn btn-dark searchbtn" name="search-list-pelanggan"></button>
                </div>
            </div>
        </form>
        <?php if(isset($_SESSION["bool_status_blokir"]) && $_SESSION["bool_status_blokir"] === true): ?>
            <div class="col-xxl-11 mt-5 col-md-10 col-sm-10 col-lg-10 col-9 alert alert-success alert-dismissible fade show mx-auto" role="alert">
                Pelanggan berhasil diblokir!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION["bool_status_blokir"]); ?>
        <?php elseif(isset($_SESSION["bool_status_blokir"]) && $_SESSION["bool_status_blokir"] === false): ?>
            <div class="col-xxl-11 mt-5 col-md-10 col-sm-10 col-lg-10 col-9 alert alert-danger alert-dismissible fade show mx-auto" role="alert">
                Pelanggan tidak berhasil diblokir!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION["bool_status_blokir"]); ?>
        <?php endif; ?>
        <div class="table-responsive mt-5 col-xxl-10 offset-xxl-1 col-lg-10 offset-lg-1 col-md-10 offset-md-1 col-sm-10 offset-sm-1 col-10 offset-1 shadow table-tuples">
            <table class="table shadow">
                <thead class = "text-center" style="background-color: #000033; color: white;">
                    <th>#</th>
                    <th>Nama</th>
                    <th>Username</th>
                    <th style="width: 16.66%">Alamat</th>
                    <th>Kabupaten</th>
                    <th>Jenis Kelamin</th>
                    <th>Nomor Telepon</th>
                    <th>Aksi</th>
                </thead>
                <tbody class="text-center">
                    <?php $counter = 0; ?>
                    <?php foreach ($tuples as $tuple): ?>
                    <?php $counter += 1;?>
                    <tr>
                        <td><?= $counter ?></td>
                        <td><?= $tuple["nama"] ?></td>
                        <td><?= $tuple["username"] ?></td>
                        <td><?= $tuple["alamat"] ?></td>
                        <td><?= $tuple["kabupaten"] ?></td>
                        <td><?= $tuple["jenis_kelamin"] ?></td>
                        <td><?= $tuple["nomor_telepon"] ?></td>
                        <td>
                        <a class="btn btn-danger mt-1 mb-1" href="#" role="button" onclick="blokir(<?= $tuple['ID_akun'] ?>)">Blokir</a></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>
    

    <div class="modal fade" id="modalBlokir" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Pemblokiran</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
              <!-- <span aria-hidden="true">&times;</span> -->
            </button>
          </div>
          <div class="modal-body">
            <form action="" method="post" enctype="multipart/form-data" id="updatehelperForm">
              <p> 
                  Apakah anda yakin akan memblokir pelanggan ini?
              </p>
              <div class="form-group">
                <label for="ID-akun-blokir" class="col-form-label d-none">ID Akun</label>
                <input type="text" class="form-control d-none" id="ID-akun-blokir" name="ID-akun-blokir" readonly>
              </div>
              <div class="text-center mt-2">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-success" name="submit-blokir">Ya</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    
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

    <!-- JAVASCRIPT --> 
    <script type="text/javascript">

      function blokir(ID_akun){
        var myModal = new bootstrap.Modal(document.getElementById('modalBlokir'));
        document.getElementById("ID-akun-blokir").value = ID_akun;
        myModal.show();
      }

    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
  
  </body>
    
</html>