<?php 
	session_start();
	require 'functions.php';
	$tuples = read("SELECT tipe_kendaraan.ID_model, model, manufaktur, harga_sewa, gambar, jumlah_unit FROM tipe_kendaraan LEFT JOIN (SELECT ID_model, COUNT(ID_kendaraan) AS jumlah_unit FROM unit_kendaraan GROUP BY ID_model) AS n ON tipe_kendaraan.ID_model = n.ID_model ORDER BY harga_sewa;");
	if(!isset($_SESSION["login_admin"])) {
		header("location: form_login.php");
		exit;
	}

  if(isset($_POST["submit"])) {
    $insert_status = null;
    $insert_status = insert_vehicle($_POST, $_FILES);
    if (isset($insert_status)) {
      if ($insert_status === true) {
        $_SESSION["bool_status_input"] = true;
      } else {
        $_SESSION["bool_status_input"] = false;
      }
      header("location: list_model_kendaraan_admin.php");
      exit;
    }
  }

  if(isset($_POST["submit-update"])) {
    $update_status = null;
    $update_status = update_vehicle($_POST, $_FILES);
    if (isset($update_status)) {
      if ($update_status === true) {
        $_SESSION["bool_status_update"] = true;
      } else {
        $_SESSION["bool_status_update"] = false;
      }
      header("location: list_model_kendaraan_admin.php");
      exit;
    }
  }

  if(isset($_POST["search-model-list-model-admin"])) {
    $keyword = $_POST["keyword-search-model-list-model-admin"];
    $tuples = read("SELECT tipe_kendaraan.ID_model, model, manufaktur, harga_sewa, gambar, jumlah_unit FROM tipe_kendaraan LEFT JOIN (SELECT ID_model, COUNT(ID_kendaraan) AS jumlah_unit FROM unit_kendaraan GROUP BY ID_model) AS n ON tipe_kendaraan.ID_model = n.ID_model WHERE model LIKE '%$keyword%';");
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
  		<a href="index.php" class="logo"><img src="Images/Logo/logo.png" style="max-height:60px;" class="img-fluid"></a>
  		<button type="button" id = "logout-button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalLogout">
        Logout
      </button>
  		<label for="hamburger-menu" class="hamburger"><i class="fa fa-bars"></i></label>
  	</nav>

  	<div class="sidebar">
  		<h2> Admin </h2>
  		<a href="beranda_admin.php"><i class="fa fa-home"></i><span>Beranda</span></a>
        <a href="list_model_kendaraan_admin.php" style="background-color: #b34509;"><i class="fa fa-truck"></i><span>List Kendaraan</span></a>
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
    <form action="" method="post" autocomplete="off" class="search-form">
        <div class="utility-bar">
            <div></div>
            <div class="input-group">
              <div class="form-floating">
                <input type="text" class="form-control" id="floatingInput" placeholder="Cari berdasarkan nama" name="keyword-search-model-list-model-admin">
                <label for="floatingInput">Cari Berdasarkan Nama</label>
              </div>
              <button type="submit" class="fa fa-search btn btn-dark searchbtn" name="search-model-list-model-admin"></button>
            </div>
        </div>
      </form>

      <?php if(isset($_SESSION["bool_status_input"]) && $_SESSION["bool_status_input"] === true): ?>
        <div class="col-xxl-11 mt-5 col-md-10 col-sm-10 col-lg-10 col-9 alert alert-success alert-dismissible fade show mx-auto" role="alert">
            Model Pickup/Truk berhasil ditambahkan!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION["bool_status_input"]); ?>
      <?php elseif(isset($_SESSION["bool_status_input"]) && $_SESSION["bool_status_input"] === false): ?>
          <div class="col-xxl-11 mt-5 col-md-10 col-sm-10 col-lg-10 col-9 alert alert-danger alert-dismissible fade show mx-auto" role="alert">
              File yang diunggah bukan .jpg/.jpeg/.png atau melebihi 500KB! Model Pickup/Truk tidak berhasl ditambahkan!
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php unset($_SESSION["bool_status_input"]); ?>
      <?php endif; ?>

      <?php if(isset($_SESSION["bool_status_update"]) && $_SESSION["bool_status_update"] === true): ?>
        <div class="col-xxl-11 mt-5 col-md-10 col-sm-10 col-lg-10 col-9 alert alert-success alert-dismissible fade show mx-auto" role="alert">
            Model pickup/truk berhasil diperbaharui!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION["bool_status_update"]); ?>
      <?php elseif(isset($_SESSION["bool_status_update"]) && $_SESSION["bool_status_update"] === false): ?>
          <div class="col-xxl-11 mt-5 col-md-10 col-sm-10 col-lg-10 col-9 alert alert-danger alert-dismissible fade show mx-auto" role="alert">
              File yang diunggah bukan .jpg/.jpeg/.png atau melebihi 500KB! Data model pickup/truk tidak berhasil diperbaharui!
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php unset($_SESSION["bool_status_update"]); ?>
      <?php endif; ?>

      <?php if(isset($_SESSION["delete_bool"]) && $_SESSION["delete_bool"] === true): ?>
        <div class="col-xxl-11 mt-5 col-md-10 col-sm-10 col-lg-10 col-9 alert alert-success alert-dismissible fade show mx-auto" role="alert">
            Model pickup/truk berhasil dihapuskan!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION["delete_bool"]); ?>
      <?php elseif(isset($_SESSION["delete_bool"]) && $_SESSION["delete_bool"] === false): ?>
          <div class="col-xxl-11 mt-5 col-md-10 col-sm-10 col-lg-10 col-9 alert alert-danger alert-dismissible fade show mx-auto" role="alert">
              Model pickup/truk tidak berhasil dihapuskan!
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php unset($_SESSION["delete_bool"]); ?>
      <?php endif; ?>

      <div class="row card-container">
        <div class="col-xxl-3 col-xl-4 col-lg-6 col-md-6 col-sm-12">
            <div class="card mt-5 mx-auto btn shadow" style="width: 18rem; height: 438px; margin-bottom:20px; padding:5px;">
              <i class = "fa fa-plus-circle" style="line-height: 300px; font-size: 7rem; color: green;" data-bs-toggle="modal" data-bs-target="#addVehicleModel"></i>
              <p>Tambah Model</p>
            </div>
        </div>
        <?php foreach ($tuples as $tuple): ?>
          <div class="col-xxl-3 col-xl-4 col-lg-6 col-md-6 col-sm-12">
            <div class="card mt-5 mx-auto shadow" style="width: 18rem; margin-bottom:20px; padding:5px;">
              <img class="card-img-top" src = "Images/TipeMobil/<?= $tuple["gambar"]; ?>" alt="Card image cap">
              <div class="card-body">
                <h5 class="card-title"><?= $tuple["model"] ?></h5>
              </div>
              <ul class="list-group list-group-flush">
                <li class="list-group-item"><?= $tuple["manufaktur"] ?></li>
                <?php  
                	if (is_null($tuple["jumlah_unit"])) {
                		$tuple["jumlah_unit"] = 0;
                	}
                ?>
                <li class="list-group-item">Jumlah Unit: <?= $tuple["jumlah_unit"] ?></li>
                <li class="list-group-item">Harga: <?= $tuple["harga_sewa"] ?>/hari</li>
              </ul>
              <div class="card-body text-center">
                <a class="btn btn-primary" href="unit_kendaraan_admin.php?p_k_model=<?= $tuple["ID_model"]; ?>" role="button">Lihat Unit</a>
                <a class="btn btn-success" href="#" role="button" onclick="updateVehicle('<?= $tuple['ID_model'] ?>', '<?= $tuple['model'] ?>', '<?= $tuple['manufaktur'] ?>', '<?= $tuple['harga_sewa'] ?>')">Ubah</a>
                <a class="btn btn-danger" href="deletelogic.php?p_k=<?= $tuple["ID_model"]; ?>&type=Kendaraan" role="button" onclick="return confirm('Apakah anda yakin akan menghapus model <?= $tuple["model"] ?>?')">Hapus</a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

    </div>
    
    <!-- JAVASCRIPT --> 
    <script type="text/javascript">
      function updateVehicle(id, model, manufaktur, tarif){
        var myModal = new bootstrap.Modal(document.getElementById('updateForm'));
        document.getElementById("id-model").value = id;
        document.getElementById("nama-model-update").value = model;
        document.getElementById("nama-manufaktur-update").value = manufaktur;
        document.getElementById("harga-model-update").value = tarif;
        myModal.show();
      }
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

      <div class="modal fade" id="addVehicleModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Tambahkan Model Pickup/Truk</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            </button>
          </div>
          <div class="modal-body">
            <form action="" method="post" enctype="multipart/form-data">
              <div class="form-group">
                <label for="model-kendaraan" class="col-form-label">Model Pickup/Truk</label>
                <input type="text" class="form-control" id="model-kendaraan" name="model-kendaraan" required>
              </div>
              <div class="form-group">
                <label for="manufaktur-kendaraan" class="col-form-label">Manufaktur Pickup/Truk</label>
                <input type="text" class="form-control" id="manufaktur-kendaraan" name="manufaktur-kendaraan" required>
              </div>
              <div class="form-group">
                  <label for="harga-sewa" class="col-form-label">Harga/hari (Rp)</label>
                  <input type="text" class="form-control" id="harga-sewa" name="harga" required>
              </div>
              <div class="form-group">
                  <label for="gambar-kendaraan" class="col-form-label">Foto Pickup/Truk</label>
                  <input type="file" class="form-control" id="gambar-kendaraan" name="foto-kendaraan" accept = "image/jpeg, image/jpg, image/png" required>
              </div>
              <div class="form-group text-center mt-2">
                  <input type="checkbox" name="konfirmasi-input" id="konfirmasi-input" value="agree" required>
                  <label for="konfirmasi-input" class="col-form-label">Konfirmasi Penambahan Model Kendaraan</label>
              </div>
              <div class="text-center mt-2">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                <button id="submit" type="submit" class="btn btn-success" name="submit">Tambahkan</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="updateForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ubah Data Model Pickup/Truk</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
              <!-- <span aria-hidden="true">&times;</span> -->
            </button>
          </div>
          <div class="modal-body">
            <form action="" method="post" enctype="multipart/form-data" id="updatehelperForm">
              <div class="form-group">
                <label for="id-model" class="col-form-label d-none">ID Model</label>
                <input type="text" class="form-control d-none" id="id-model" name="id-model" readonly>
              </div>
              <div class="form-group">
                <label for="nama-model-update" class="col-form-label">Model Pickup/Truk</label>
                <input type="text" class="form-control" id="nama-model-update" name="nama-model-update" required>
              </div>
              <div class="form-group">
                <label for="nama-manufaktur-update" class="col-form-label">Manufaktur Pickup/Truk</label>
                <input type="text" class="form-control" id="nama-manufaktur-update" name="nama-manufaktur-update" required>
              </div>
              <div class="form-group">
                  <label for="harga-model-update" class="col-form-label">Harga/hari (Rp)</label>
                  <input type="text" class="form-control" id="harga-model-update" name="harga-model-update" required>
              </div>
              <div class="form-group">
                  <label for="gambar-model-update" class="col-form-label">Unggah Foto Baru</label>
                  <input type="file" class="form-control" id="gambar-model-update" name="foto-model-update" accept = "image/jpeg, image/jpg, image/png">
              </div>
              <div class="form-group text-center mt-2">
                  <input type="checkbox" name="konfirmasi-input" id="konfirmasi-input" value="agree" required>
                  <label for="konfirmasi-input" class="col-form-label">Konfirmasi Perubahan Data Model Pickup/Truk</label>
              </div>
              <div class="text-center mt-2">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                <button id="submit-update" type="submit" class="btn btn-success" name="submit-update">Perbaharui</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>