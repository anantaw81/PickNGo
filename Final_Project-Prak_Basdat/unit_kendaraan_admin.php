<?php 
	session_start();
	require 'functions.php';
  $id_model = $_GET['p_k_model'];
  $query = "SELECT * FROM tipe_kendaraan WHERE ID_model = $id_model";
  $model_data = read($query);
  $query = "SELECT * FROM (unit_kendaraan INNER JOIN tipe_kendaraan ON unit_kendaraan.ID_model = tipe_kendaraan.ID_model) WHERE unit_kendaraan.ID_model = $id_model;";
	$tuples = read($query);
	if(!isset($_SESSION["login_admin"])) {
		header("location: form_login.php");
		exit;
	}

  if(isset($_POST["submit-add"])) {
      $insert_status = insert_unit($_POST);
      if (isset($insert_status)) {
        if ($insert_status === true) {
          $_SESSION["bool_status_insert"] = true;
        } else {
          $_SESSION["bool_status_insert"] = false;
        }
        header("location: unit_kendaraan_admin.php?p_k_model=$id_model;");
        exit;
      }
  }

  if(isset($_POST["submit-update"])) {
    $update_status = update_unit($_POST);
      if (isset($update_status)) {
        if ($update_status === true) {
          $_SESSION["bool_status_update"] = true;
        } else {
          $_SESSION["bool_status_update"] = false;
        }
        header("location: unit_kendaraan_admin.php?p_k_model=$id_model;");
        exit;
      }
  }

  if(isset($_POST["submit-delete"])) {
    $delete_status = delete_unit($_POST);
      if (isset($delete_status)) {
        if ($delete_status === true) {
          $_SESSION["bool_status_delete"] = true;
        } else {
          $_SESSION["bool_status_delete"] = false;
        }
        header("location: unit_kendaraan_admin.php?p_k_model=$id_model;");
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
  		<h2> Admin </h2>
  		<a href="beranda_admin.php" style="background-color: #b34509;"><i class="fa fa-truck"></i><span>List Kendaraan</span></a>
  		<a href="list_driver_admin.php"><i class = "fa fa-address-book"></i><span>List Driver</span></a>
  		<a href="list_helper_admin.php"><i class = "fa fa-address-book-o"></i><span>List Helper</span></a>
  		<a href="request_peminjaman_admin.php"><i class = "fa fa-hourglass"></i><span>Request Peminjaman</span></a>
  		<a href="validasi_user_admin.php"><i class = "fa fa-check-circle"></i><span>Validasi Pengguna</span></a>
      <a href="validasi_pembayaran_admin.php"><i class = "fa fa-money"></i><span>Validasi Pembayaran</span></a>
  		<a href="list_peminjaman_admin"><i class = "fa fa-list"></i><span>List Peminjaman</span></a>
  		<a href="" class = "logout" data-bs-toggle="modal" data-bs-target="#modalLogout"><span>Logout</span></a>
  	</div>

    <div class = "content">
      <form action="" method="post" autocomplete="off" class="search-form">
        <div class="utility-bar">
            <div></div>
            <div class="search-bar">
              <div class="filter">Filter</div>
                <input type="text" placeholder = "Cari berdasarkan model" class="search-field" name="keyword">
                <button type="submit" class="fa fa-search search-button" name="search"></button>
            </div>
        </div>
      </form>

      <?php if(isset($_SESSION["bool_status_insert"]) && $_SESSION["bool_status_insert"] === true): ?>
        <div class="col-xxl-11 mt-5 col-md-10 col-sm-10 col-lg-10 col-9 alert alert-success alert-dismissible fade show mx-auto" role="alert">
            Unit Pickup/Truk berhasil ditambahkan!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION["bool_status_insert"]); ?>
      <?php elseif(isset($_SESSION["bool_status_insert"]) && $_SESSION["bool_status_insert"] === false): ?>
          <div class="col-xxl-11 mt-5 col-md-10 col-sm-10 col-lg-10 col-9 alert alert-danger alert-dismissible fade show mx-auto" role="alert">
              Unit Pickup/Truk tidak berhasil ditambahkan!
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php unset($_SESSION["bool_status_insert"]); ?>
      <?php endif; ?>

      <?php if(isset($_SESSION["bool_status_delete"]) && $_SESSION["bool_status_delete"] === true): ?>
        <div class="col-xxl-11 mt-5 col-md-10 col-sm-10 col-lg-10 col-9 alert alert-success alert-dismissible fade show mx-auto" role="alert">
            Unit Pickup/Truk berhasil dihapuskan!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION["bool_status_delete"]); ?>
      <?php elseif(isset($_SESSION["bool_status_delete"]) && $_SESSION["bool_status_delete"] === false): ?>
          <div class="col-xxl-11 mt-5 col-md-10 col-sm-10 col-lg-10 col-9 alert alert-danger alert-dismissible fade show mx-auto" role="alert">
              Unit Pickup/Truk tidak berhasil dihapuskan!
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php unset($_SESSION["bool_status_delete"]); ?>
      <?php endif; ?>

      <?php if(isset($_SESSION["bool_status_update"]) && $_SESSION["bool_status_update"] === true): ?>
        <div class="col-xxl-11 mt-5 col-md-10 col-sm-10 col-lg-10 col-9 alert alert-success alert-dismissible fade show mx-auto" role="alert">
            Data unit Pickup/Truk berhasil diperbaharui!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION["bool_status_update"]); ?>
      <?php elseif(isset($_SESSION["bool_status_update"]) && $_SESSION["bool_status_update"] === false): ?>
          <div class="col-xxl-11 mt-5 col-md-10 col-sm-10 col-lg-10 col-9 alert alert-danger alert-dismissible fade show mx-auto" role="alert">
              Data unit Pickup/Truk tidak berhasil diperbaharui!
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php unset($_SESSION["bool_status_update"]); ?>
      <?php endif; ?>

      <div class="table-responsive mt-5 col-xxl-10 offset-xxl-1 col-lg-10 offset-lg-1 col-md-10 offset-md-1 col-sm-10 offset-sm-1 col-10 offset-1 table-tuples">
        <div class="wrapper mb-2">
          <a href = "beranda_admin.php" class="btn btn-secondary">kembali</a>
          <a href="#" class="btn btn-primary"  role="button" onclick="addUnitFunc('<?= $model_data[0]["model"] ?>', '<?= $id_model ?>')"><i class="fa fa-plus-circle"></i> Tambah Unit</a>
        </div>
        <div class="card mb-3">
          <div class="row g-0">
            <div class="col-md-4 mx-auto d-block" style = "min-width: 286px;">
              <img class="mx-auto d-block" src="Images/TipeMobil/<?= $model_data[0]["gambar"]; ?>" alt="...">
            </div>
            <div class="col-md-8">
              <div class="card-body">
                <h5 class="card-title"><?= $model_data[0]["model"] ?></h5>
              </div>
              <ul class="list-group list-group-flush">
                <li class="list-group-item">Manufaktur: <?= $model_data[0]["manufaktur"] ?></li>
                <li class="list-group-item">Harga: <?= $model_data[0]["harga_sewa"] ?>/hari</li>
              </ul>
            </div>
          </div>
        </div>
        
        <table class="table">
          <thead class = "text-center" style="background-color: #000033; color: white;">
            <th>ID Kendaraan</th>
            <th>Plat Nomor</th>
            <th>Aksi</th>
          </thead>
          <tbody class="text-center">
            <?php foreach ($tuples as $tuple): ?>
              <tr>
                <td><?= $tuple["ID_kendaraan"] ?></td>
                <td><?= $tuple["plat_nomor"] ?></td>

                <td><a class="btn btn-warning mx-1" href="#" role="button" onclick="updateUnit('<?= $tuple['model'] ?>', '<?= $id_model ?>', '<?= $tuple['plat_nomor'] ?>', '<?= $tuple["ID_kendaraan"] ?>')">Ubah</a>
                  <a class="btn btn-danger" href="#" role="button" onclick="deleteUnit('<?= $tuple['plat_nomor'] ?>', '<?= $tuple["ID_kendaraan"] ?>')">Hapus</a></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>

      </div>
      
    </div>

    <!-- JAVASCRIPT --> 
    <script type="text/javascript">
      function addUnitFunc(model, id){
        var myModal = new bootstrap.Modal(document.getElementById('addUnit'));
        document.getElementById("id-model-kendaraan").value = id;
        document.getElementById("model-kendaraan").value = model;
        myModal.show();
      }

      function updateUnit(model, id_model, platNomor, id_kendaraan){
        var myModal = new bootstrap.Modal(document.getElementById('updateForm'));
        document.getElementById("id-model-update").value = id_model;
        document.getElementById("id-kendaraan-update").value = id_kendaraan;
        document.getElementById("nama-model-update").value = model;
        document.getElementById("plat-nomor-update").value = platNomor;
        myModal.show();
      }

      function deleteUnit(platNomor, id_kendaraan){
        var myModal = new bootstrap.Modal(document.getElementById('deleteForm'));
        document.getElementById("id-kendaraan-hapus").value = id_kendaraan;
        document.getElementById("plat-nomor-hapus").value = platNomor;
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

      <div class="modal fade" id="addUnit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Tambahkan Unit</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            </button>
          </div>
          <div class="modal-body">
            <form action="" method="post" enctype="multipart/form-data">
              <div class="form-group">
                <label for="id-model-kendaraan" class="col-form-label d-none">ID Model</label>
                <input type="text" class="form-control d-none" id="id-model-kendaraan" name="id-model-kendaraan" readonly>
              </div>
              <div class="form-group">
                <label for="model-kendaraan" class="col-form-label">Model Pickup/Truk</label>
                <input type="text" class="form-control" id="model-kendaraan" name="model-kendaraan" readonly>
              </div>
              <div class="form-group">
                <label for="plat-nomor-kendaraan" class="col-form-label">Plat Nomor Kendaraan</label>
                <input type="text" class="form-control" id="plat-nomor-kendaraan" name="plat-nomor-kendaraan" required>
              </div>
              <div class="text-center mt-2">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button id="submit-add" type="submit" class="btn btn-primary" name="submit-add">Tambahkan</button>
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
            <h5 class="modal-title" id="exampleModalLabel">Ubah Data Unit Pickup/Truk</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
              <!-- <span aria-hidden="true">&times;</span> -->
            </button>
          </div>
          <div class="modal-body">
            <form action="" method="post" enctype="multipart/form-data" id="updatehelperForm">
              <div class="form-group">
                <label for="id-model-update" class="col-form-label d-none">ID Model</label>
                <input type="text" class="form-control d-none" id="id-model-update" name="id-model-update" readonly>
              </div>
              <div class="form-group">
                <label for="id-kendaraan-update" class="col-form-label">ID Kendaraan</label>
                <input type="text" class="form-control" id="id-kendaraan-update" name="id-kendaraan-update" readonly>
              </div>
              <div class="form-group">
                <label for="nama-model-update" class="col-form-label">Model Pickup/Truk</label>
                <input type="text" class="form-control" id="nama-model-update" name="nama-model-update" readonly>
              </div>
              <div class="form-group">
                <label for="plat-nomor-update" class="col-form-label">Plat Nomor</label>
                <input type="text" class="form-control" id="plat-nomor-update" name="plat-nomor-update" required>
              </div>
              <div class="text-center mt-2">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button id="submit-update" type="submit" class="btn btn-warning" name="submit-update">Perbaharui</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="deleteForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Hapus Data Unit Pickup/Truk</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
              <!-- <span aria-hidden="true">&times;</span> -->
            </button>
          </div>
          <div class="modal-body">
            <form action="" method="post" enctype="multipart/form-data" id="updatehelperForm">
              <p> 
                  Apakah anda yakin untuk menghapus data kendaraan ini?
              </p>
              <div class="form-group">
                <label for="id-kendaraan-hapus" class="col-form-label">ID Kendaraan</label>
                <input type="text" class="form-control" id="id-kendaraan-hapus" name="id-kendaraan-hapus" readonly>
              </div>
              <div class="form-group">
                <label for="plat-nomor-hapus" class="col-form-label">Plat Nomor</label>
                <input type="text" class="form-control" id="plat-nomor-hapus" name="plat-nomor-hapus" readonly="">
              </div>
              <div class="text-center mt-2">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button id="submit-delete" type="submit" class="btn btn-danger" name="submit-delete">Hapus</button>
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
  </body>
</html>