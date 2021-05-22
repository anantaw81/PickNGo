<?php 
	session_start();
	require 'functions.php';
	if(!isset($_SESSION["login_admin"])) {
		header("location: form_login.php");
		exit;
	}
    $tuples = read("SELECT * FROM detail_peminjaman;");
    if(isset($_POST["submit-search-tanggal"])) {
        $tanggal_batas_awal = $_POST["search-tanggal-batas-awal"];
        $tanggal_batas_akhir = $_POST["search-tanggal-batas-akhir"];
        if($_POST["search-model"] != -1) {
            $id_model_kendaraan = $_POST["search-model"];
            $tuples = read("SELECT * FROM detail_peminjaman WHERE ((tanggal_peminjaman BETWEEN '$tanggal_batas_awal' AND '$tanggal_batas_akhir') OR (tanggal_pengembalian BETWEEN '$tanggal_batas_awal' AND '$tanggal_batas_akhir')) AND (ID_model_kendaraan = $id_model_kendaraan);");
        } else {
            $tuples = read("SELECT * FROM detail_peminjaman WHERE ((tanggal_peminjaman BETWEEN '$tanggal_batas_awal' AND '$tanggal_batas_akhir') OR (tanggal_pengembalian BETWEEN '$tanggal_batas_awal' AND '$tanggal_batas_akhir'));");
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
  		<h2> Admin </h2>	
  		<a href="beranda_admin.php"><i class="fa fa-truck"></i><span>List Kendaraan</span></a>
  		<a href="list_driver_admin.php"><i class = "fa fa-address-book"></i><span>List Driver</span></a>
  		<a href="list_helper_admin.php"><i class = "fa fa-address-book-o"></i><span>List Helper</span></a>
  		<a href="request_peminjaman_admin.php"><i class = "fa fa-hourglass" ></i><span>Request Peminjaman</span></a>
  		<a href="validasi_user_admin.php"><i class = "fa fa-check-circle"></i><span>Validasi Pengguna</span></a>
        <a href="validasi_pembayaran_admin.php"><i class = "fa fa-money"></i><span>Validasi Pembayaran</span></a>
  		<a href="list_peminjaman_admin.php" style="background-color: #b34509;"><i class = "fa fa-list"></i><span>List Peminjaman</span></a>
  		<a href="" class = "logout" data-bs-toggle="modal" data-bs-target="#modalLogout"><span>Logout</span></a>
  	</div>

      <div class = "content">
        <form action="" method="post" autocomplete="off" class="search-form">
            <div class="utility-bar">
                <div></div>
                <div class="search-bar">
                    <input type="date" placeholder = "Cari berdasarkan nama" class="search-field" name="search-tanggal-batas-awal" required>
                    <input type="date" placeholder = "Cari berdasarkan nama" class="search-field" name="search-tanggal-batas-akhir" required>
                    <?php $model = read("SELECT * FROM tipe_kendaraan;"); ?>
                    <select class="search-field" id="search-model" name="search-model" required>
                    <option value = "-1" selected>Pilih Model Kendaraan</option>
                    <?php foreach ($model as $model_kendaraan): ?>
                        <option value = "<?= $model_kendaraan["ID_model"] ?>"><?= $model_kendaraan["model"] ?></option>
                    <?php endforeach; ?>
                    </select>
                    <button type="submit" class="fa fa-search search-button" name="submit-search-tanggal"></button>
                </div>
            </div>
        </form>
        <div class="row card-container">
            
            <?php foreach ($tuples as $tuple): ?>
                    <div class="card mb-3 mt-5 col-xxl-10 offset-xxl-1 col-lg-10 offset-lg-1 col-md-10 offset-md-1 col-sm-10 offset-sm-1 col-10 offset-1">
                        <div class="row g-0">
                            <div class="col-md-3 d-flex align-items-center justify-content-center">
                            <img src="Images/TipeMobil/<?= $tuple["gambar"] ?>" alt="..." style="min-width: 286px; max-width: 286px;">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <p class="card-text">Model Kendaraan: <?= $tuple["model"] ?></p>
                                    <?php if($tuple["plat_nomor"] != NULL): ?>
                                        <p class="card-text">Plat Nomor Kendaraan: <?= $tuple["plat_nomor"] ?></p>
                                    <?php else: ?>
                                        <p class="card-text">Plat Nomor Kendaraan: NULL</p>
                                    <?php endif;?>
                                    <p class="card-text">Tanggal Peminjaman: <?= $tuple["tanggal_peminjaman"] ?></p>
                                    <p class="card-text">Tanggal Pengembalian: <?= $tuple["tanggal_pengembalian"] ?></p>
                                    <?php if ($tuple["nama_driver"] != NULL): ?>
                                        <p class="card-text">Nama Driver: <?= $tuple["nama_driver"] ?></p>
                                    <?php else: ?>
                                        <p class="card-text">Nama Driver: NULL</p>
                                    <?php endif;?>
                                    <?php if($tuple["jumlah_helper"] == 2): ?>
                                        <?php if ($tuple["ID_helper_1"] != NULL): ?>
                                            <p class="card-text">Nama Helper: <?= $tuple["nama_helper_1"] ?></p>
                                        <?php else: ?>
                                            <p class="card-text">Nama Helper: NULL</p>
                                        <?php endif;?>
                                        <?php if ($tuple["ID_helper_2"] != NULL): ?>
                                            <p class="card-text">Nama Helper: <?= $tuple["nama_helper_2"] ?></p>
                                        <?php else: ?>
                                            <p class="card-text">Nama Helper: NULL</p>
                                        <?php endif;?>
                                    <?php elseif($tuple["jumlah_helper"] == 1): ?>
                                        <?php if ($tuple["ID_helper_1"] != NULL): ?>
                                            <p class="card-text">Nama Helper: <?= $tuple["nama_helper_1"] ?></p>
                                        <?php else: ?>
                                            <p class="card-text">Nama Helper: NULL</p>
                                        <?php endif;?>
                                    <?php endif;?>
                                    <p class="card-text">Total Harga: Rp<?= $tuple["harga_peminjaman"] ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php endforeach;?>
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
    


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
  
  </body>
    
</html>