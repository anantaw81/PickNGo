<?php 
    session_start();
	require 'functions.php';
    if(!isset($_SESSION["login_pelanggan"])) {
        header("location: form_login.php");
        exit;
    }
    $id = $_SESSION["id_akun"];
    $tuples = read("SELECT * FROM request_peminjaman WHERE ID_akun = '$id';");

    if(isset($_POST["submit-pembayaran"])) {
        $status_unggah = null;
        $status_unggah = uploadBuktiPembayaran($_POST, $_FILES);
        if (isset($status_unggah)) {
          if ($status_unggah === true) {
            $_SESSION["bool_status_unggah"] = true;
          } else {
            $_SESSION["bool_status_unggah"] = false;
          }
          header("location: request_peminjaman_user.php");
          exit;
        }
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
    <title>Hello, world!</title>
</head>
<body>
    <input type="checkbox" id="hamburger-menu">
  	<nav>
  		<a href="index.php" class="logo">Pick N Go</a>
  		<button type="button" id = "logout-button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalLogout">
        Logout
      </button>
  		<label for="hamburger-menu" class="hamburger"><i class="fa fa-bars"></i></label>
  	</nav>

  	<div class="sidebar">
  		<h2>
  			<?= $_SESSION["username"]?>
  		</h2>
  		<a href="profil_user.php"><i class="fa fa-user"></i><span>Profil</span></a>
  		<a href="beranda_user.php"><i class="fa fa-truck"></i><span>Beranda</span></a>
  		<a href="request_peminjaman_user.php" style="background-color: #b34509;"><i class = "fa fa-hourglass"></i><span>Request Peminjaman</span></a>
  		<a href="list_peminjaman_user.php"><i class = "fa fa-credit-card-alt"></i><span>List Peminjaman</span></a>
  		<a href="" class = "logout" data-bs-toggle="modal" data-bs-target="#modalLogout"><span>Logout</span></a>
  	</div>

    <div class = "content">
        <div class="row card-container">
            <div class="utility-bar">
            <div></div>
            <div class="search-bar">
                <div class="filter">Filter</div>
                <input type="text" placeholder = "Cari berdasarkan nama" class="search-field">
                <button type="submit" class="fa fa-search search-button"></button>
            </div>
            </div>
            <?php foreach ($tuples as $tuple): ?>
                <?php if($tuple["status_peminjaman"] === "not accepted yet"):?>
                    <?php $status = "Tunggu Persetujuan";?>
                <?php elseif($tuple["status_peminjaman"] === "accepted"):?>
                    <?php $status = "Disetujui! Unggah bukti pembayaran anda!";?>
                <?php elseif($tuple["status_peminjaman"] === "rejected"):?>
                    <?php $status = "Ditolak!";?>
                    <?php elseif($tuple["status_peminjaman"] === "not valid payment"):?>
                    <?php $status = "Pembayaran tidak valid!!";?>
                <?php endif;?>
                <?php if($tuple["status_peminjaman"] === "not accepted yet" || $tuple["status_peminjaman"] === "rejected"):?>
                    <div class="card mb-3 mt-5 col-xxl-10 offset-xxl-1 col-lg-10 offset-lg-1 col-md-10 offset-md-1 col-sm-10 offset-sm-1 col-10 offset-1">
                        <div class="row g-0">
                            <div class="col-md-3 d-flex align-items-center justify-content-center">
                            <img src="Images/TipeMobil/<?= $tuple["gambar"] ?>" alt="..." style="min-width: 286px; max-width: 286px;">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <p class="card-text">Model Kendaraan: <?= $tuple["model"] ?></p>
                                    <p class="card-text">Tanggal Peminjaman: <?= $tuple["tanggal_peminjaman"] ?></p>
                                    <p class="card-text">Tanggal Pengembalian: <?= $tuple["tanggal_pengembalian"] ?></p>
                                    <p class="card-text">Driver: <?= $tuple["opsi_driver"] ?></p>
                                    <p class="card-text">Jumlah Helper: <?= $tuple["jumlah_helper"] ?></p>
                                    
                                    <p class="card-text">Status: <?= $status ?> </p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php elseif($tuple["status_peminjaman"] === "accepted" | $tuple["status_peminjaman"] === "not valid payment"): ?>
                    <div class="card mb-3 mt-5 col-xxl-10 offset-xxl-1 col-lg-10 offset-lg-1 col-md-10 offset-md-1 col-sm-10 offset-sm-1 col-10 offset-1">
                        <div class="row g-0">
                            <div class="col-md-3 d-flex align-items-center justify-content-center">
                            <img src="Images/TipeMobil/<?= $tuple["gambar"] ?>" alt="..." style="min-width: 286px; max-width: 286px;">
                            </div>
                            <div class="col-md-6">
                                <div class="card-body">
                                    <p class="card-text">Model Kendaraan: <?= $tuple["model"] ?></p>
                                    <p class="card-text">Tanggal Peminjaman: <?= $tuple["tanggal_peminjaman"] ?></p>
                                    <p class="card-text">Tanggal Pengembalian: <?= $tuple["tanggal_pengembalian"] ?></p>
                                    <p class="card-text">Driver: <?= $tuple["opsi_driver"] ?></p>
                                    <p class="card-text">Jumlah Helper: <?= $tuple["jumlah_helper"] ?></p>
                                    <p class="card-text">Status: <?= $status ?> </p>
                                    <p class="card-text">Total Harga: Rp<?= $tuple["harga_peminjaman"] ?></p>
                                </div>
                            </div>
                            <?php if(is_null($tuple["gambar_bukti_pembayaran"])): ?>
                              <div class="col-md-3 mt-3">
                                  <a class="btn btn-primary offset-4" href="#" role="button" onclick="uploadPayment(<?= $tuple['ID_peminjaman'] ?>)">Unggah Bukti Pembayaran</a>
                              </div>
                            <?php else: ?>
                                <div class="col-md-3 mt-3">
                                  <a class="btn btn-primary offset-4" href="#" role="button" onclick="uploadPayment(<?= $tuple['ID_peminjaman'] ?>)">Perbaharui Bukti Pembayaran</a>
                              </div>
                            <?php endif;?>
                        </div>
                    </div>
                <?php endif;?>
            <?php endforeach;?>
        </div>
    </div>

    <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Unggah Bukti Pembayaran</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
              <!-- <span aria-hidden="true">&times;</span> -->
            </button>
          </div>
          <div class="modal-body">
            <form action="" method="post" enctype="multipart/form-data" id="acceptRequestForm">
              <div class="form-group">
                    <label for="ID-peminjaman-payment" class="col-form-label d-none">ID peminjaman</label>
                    <input type="text" class="form-control d-none" id="ID-peminjaman-payment" name="ID-peminjaman-payment" readonly>
              </div>
              <div class="form-group">
                  <label for="bukti-pembayaran" class="col-form-label">Bukti Pembayaran</label>
                  <input type="file" class="form-control" id="bukti-pembayaran" name="bukti-pembayaran" accept = "image/jpeg, image/jpg, image/png" required>
              </div>
              <div class="text-center mt-4">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-success" name="submit-pembayaran">Unggah</button>
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
        function uploadPayment(id_peminjaman){
            var myModal = new bootstrap.Modal(document.getElementById('paymentModal'));
            document.getElementById("ID-peminjaman-payment").value = id_peminjaman;
            myModal.show();
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
  
  </body>
    
</html>
