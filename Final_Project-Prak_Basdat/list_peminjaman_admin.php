<?php 
	session_start();
	require 'functions.php';
	if(!isset($_SESSION["login_admin"])) {
		header("location: form_login.php");
		exit;
	}
    
    $tuples = read("SELECT detail_peminjaman.*, tanggal_pengembalian_sebenarnya FROM detail_peminjaman LEFT JOIN pengembalian ON pengembalian.ID_peminjaman = detail_peminjaman.ID_peminjaman ORDER BY ID_peminjaman DESC;");
    if(isset($_POST["submit-search-tanggal"])) {
        $tanggal_batas_awal = $_POST["search-tanggal-batas-awal"];
        $tanggal_batas_akhir = $_POST["search-tanggal-batas-akhir"];
        if($_POST["search-model"] != -1) {
            $id_model_kendaraan = $_POST["search-model"];
            $tuples = read("SELECT detail_peminjaman.*, tanggal_pengembalian_sebenarnya FROM detail_peminjaman LEFT JOIN pengembalian ON pengembalian.ID_peminjaman = detail_peminjaman.ID_peminjaman WHERE ((tanggal_peminjaman BETWEEN '$tanggal_batas_awal' AND '$tanggal_batas_akhir') OR (tanggal_pengembalian BETWEEN '$tanggal_batas_awal' AND '$tanggal_batas_akhir')) AND (ID_model_kendaraan = $id_model_kendaraan) ORDER BY ID_peminjaman DESC;");
        } else {
            $tuples = read("SELECT detail_peminjaman.*, tanggal_pengembalian_sebenarnya FROM detail_peminjaman LEFT JOIN pengembalian ON pengembalian.ID_peminjaman = detail_peminjaman.ID_peminjaman WHERE ((tanggal_peminjaman BETWEEN '$tanggal_batas_awal' AND '$tanggal_batas_akhir') OR (tanggal_pengembalian BETWEEN '$tanggal_batas_awal' AND '$tanggal_batas_akhir')) ORDER BY ID_peminjaman DESC;");
        }
    }
    
    if(isset($_POST["submit-pengembalian"])) {
        $status_pengembalian = pengembalian($_POST["ID-peminjaman-pengembalian"], $_POST["denda-pengembalian"], $_POST["tanggal-pengembalian-seharusnya"]);
        if (isset($status_pengembalian)) {
            if ($status_pengembalian == true) {
              $_SESSION["bool_status_pengembalian"] = true;
            } else {
              $_SESSION["bool_status_pengembalian"] = false;
            }
            header("location: list_peminjaman_admin.php");
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
      <a href="list_pelanggan_admin.php"><i class = "fa fa-user"></i><span>List Pelanggan</span></a>
  		<a href="request_peminjaman_admin.php"><i class = "fa fa-hourglass" ></i><span>Request Peminjaman</span></a>
  		<a href="validasi_user_admin.php"><i class = "fa fa-check-circle"></i><span>Validasi Pengguna</span></a>
      <a href="validasi_pembayaran_admin.php"><i class = "fa fa-money"></i><span>Validasi Pembayaran</span></a>
  		<a href="list_peminjaman_admin.php" style="background-color: #b34509;"><i class = "fa fa-list"></i><span>List Peminjaman</span></a>
      <a href="list_pengembalian_admin.php"><i class = "fa fa-list-alt"></i><span>List Pengembalian</span></a>
  		<a href="" class = "logout" data-bs-toggle="modal" data-bs-target="#modalLogout"><span>Logout</span></a>
  	</div>
      <div class = "content">
        <form action="" method="post" autocomplete="off" class="search-form">
            <div class="utility-bar">
                <div></div>
                <div class="input-group">
                    <div class="form-floating b-container">
                        <input type="date" class="form-control" id="floatingInput" placeholder="Cari berdasarkan nama" name="search-tanggal-batas-awal" required>
                        <label for="floatingInput">Batas Awal</label>
                    </div>
                    <div class="form-floating b-container">
                        <input type="date" class="form-control" id="floatingInput1" placeholder="Cari berdasarkan nama" name="search-tanggal-batas-akhir" required>
                        <label for="floatingInput1">Batas Akhir</label>
                    </div>
                    <?php $model = read("SELECT * FROM tipe_kendaraan;"); ?>
                    <select class="form-select b-conatiner" id="search-model" name="search-model" style="margin-bottom:10px;"  required>
                    <option value = "-1" selected>Pilih Model Kendaraan</option>
                    <?php foreach ($model as $model_kendaraan): ?>
                        <option value = "<?= $model_kendaraan["ID_model"] ?>"><?= $model_kendaraan["model"] ?></option>
                    <?php endforeach; ?>
                    </select>
                    <button type="submit" class="fa fa-search btn btn-dark searchbtn" name="submit-search-tanggal"></button>
                </div>
            </div>
        </form>
        <?php if(isset($_SESSION["bool_status_pengembalian"]) && $_SESSION["bool_status_pengembalian"] === true): ?>
          <div class="col-xxl-11 mt-5 col-md-10 col-sm-10 col-lg-10 col-9 alert alert-success alert-dismissible fade show mx-auto" role="alert">
            Pengembalian telah dikonfirmasi!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          <?php unset($_SESSION["bool_status_pengembalian"]); ?>
        <?php elseif(isset($_SESSION["bool_status_pengembalian"]) && $_SESSION["bool_status_pengembalian"] === false): ?>
          <div class="col-xxl-11 mt-5 col-md-10 col-sm-10 col-lg-10 col-9 alert alert-danger alert-dismissible fade show mx-auto" role="alert">
              Terjadi kesalahan pada query!
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          <?php unset($_SESSION["bool_status_pengembalian"]); ?>
        <?php endif; ?>
        <div class="row card-container">
            <?php foreach ($tuples as $tuple): ?>
                    <div class="card mb-3 mt-5 col-xxl-10 offset-xxl-1 col-lg-10 offset-lg-1 col-md-10 offset-md-1 col-sm-10 offset-sm-1 col-10 offset-1 shadow">
                        <div class="row g-0">
                            <div class="col-md-3 d-flex align-items-center justify-content-center">
                            <img src="Images/TipeMobil/<?= $tuple["gambar"] ?>" class="img-fluid"  alt="..." style=" max-width: 100%;">
                            </div>
                            <div class="col-md-7">
                                <div class="card-body">
                                    <p class="card-text">Nama Peminjam: <?= $tuple["nama"] ?></p>
                                    <?php if($tuple["model"] != NULL): ?>
                                      <p class="card-text">Model Kendaraan: <?= $tuple["model"] ?></p>
                                    <?php else: ?>
                                      <p class="card-text">Model Kendaraan: NULL</p>
                                    <?php endif;?>
                                    <?php if($tuple["plat_nomor"] != NULL): ?>
                                        <p class="card-text">Plat Nomor Kendaraan: <?= $tuple["plat_nomor"] ?></p>
                                    <?php else: ?>
                                        <p class="card-text">Plat Nomor Kendaraan: NULL</p>
                                    <?php endif;?>
                                    <p class="card-text">Tanggal Peminjaman: <?= $tuple["tanggal_peminjaman"] ?></p>
                                    <p class="card-text">Tanggal Pengembalian: <?= $tuple["tanggal_pengembalian"] ?></p>
                                    <?php if ($tuple["opsi_driver"] != 0): ?>
                                        <?php if ($tuple["nama_driver"] != NULL): ?>
                                            <p class="card-text">Nama Driver: <?= $tuple["nama_driver"] ?></p>
                                        <?php else: ?>
                                            <p class="card-text">Nama Driver: NULL</p>
                                        <?php endif;?>
                                    <?php endif; ?>
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
                            <?php if($tuple["tanggal_pengembalian_sebenarnya"] == NULL): ?>
                                <div class="col-md-2 mt-3">
                                    <a class="btn btn-outline-dark btn-lg offset-3" href="#" role="button"  onclick="pengembalian('<?= $tuple['ID_peminjaman']; ?>', '<?= $tuple['tanggal_pengembalian']; ?>')">Konfirmasi Pengembalian</a>
                                </div>
                            <?php endif;?>
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
    
    <div class="modal fade" id="modalPengembalian" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Pengembalian</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
              <!-- <span aria-hidden="true">&times;</span> -->
            </button>
          </div>
          <div class="modal-body">
            <form action="" method="post" enctype="multipart/form-data" id="formPengembalian">
              <div class="form-group">
                    <label for="ID-peminjaman-pengembalian" class="col-form-label d-none">ID peminjaman</label>
                    <input type="text" class="form-control d-none" id="ID-peminjaman-pengembalian" name="ID-peminjaman-pengembalian" readonly>
              </div>
              <div class="form-group">
                  <label for="tanggal-pengembalian-seharusnya" class="col-form-label d-none">Tanggal Pengembalian Seharusnya</label>
                  <input type="text" class="form-control d-none" id="tanggal-pengembalian-seharusnya" name="tanggal-pengembalian-seharusnya" required readonly>
              </div>
              <div class="form-group">
                  <label for="denda-pengembalian" class="col-form-label">Denda Per Hari (Rp)</label>
                  <input type="number" class="form-control" id="denda-pengembalian" name="denda-pengembalian" required min="0">
              </div>
              <div class="text-center mt-4">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-success" name="submit-pengembalian">Submit</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    
    <!-- JAVASCRIPT --> 
    <script type="text/javascript">
        function pengembalian(ID_peminjaman, tanggal_pengembalian) {
            var myModal = new bootstrap.Modal(document.getElementById('modalPengembalian'));
            document.getElementById("ID-peminjaman-pengembalian").value = ID_peminjaman;
            document.getElementById("tanggal-pengembalian-seharusnya").value = tanggal_pengembalian;
            myModal.show();
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
  
  </body>
    
</html>