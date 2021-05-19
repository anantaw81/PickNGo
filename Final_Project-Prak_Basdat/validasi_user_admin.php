<?php 
    session_start();
	require 'functions.php';
    if(!isset($_SESSION["login_admin"])) {
		header("location: form_login.php");
		exit;
	}
    $tuples = read("SELECT * FROM data_pelanggan_baru;");

    if(isset($_POST["submit-valid"])){
        $validation_status = null;
        $validation_status = user_validation($_POST["ID-akun-valid"], 'valid');
        if (isset($validation_status)) {
            if ($validation_status === true) {
              $_SESSION["bool_status_validation"] = true;
            } else {
              $_SESSION["bool_status_validation"] = false;
            }
            header("location: validasi_user_admin.php");
            exit;
        }
    }

    if(isset($_POST["submit-not-valid"])){
        $not_valid_status = null;
        $not_valid_status = user_validation($_POST["ID-akun-not-valid"], 'not valid');
        if (isset($not_valid_status)) {
            if ($not_valid_status === true) {
              $_SESSION["bool_status_not_valid"] = true;
            } else {
              $_SESSION["bool_status_not_valid"] = false;
            }
            header("location: validasi_user_admin.php");
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
  		<a href="beranda_admin.php"><i class="fa fa-truck"></i><span>List Kendaraan</span></a>
  		<a href="list_driver_admin.php"><i class = "fa fa-address-book"></i><span>List Driver</span></a>
  		<a href="list_helper_admin.php"><i class = "fa fa-address-book-o"></i><span>List Helper</span></a>
  		<a href="request_peminjaman_admin.php"><i class = "fa fa-hourglass"></i><span>Request Peminjaman</span></a>
  		<a href="validasi_user_admin.php" style="background-color: #b34509;"><i class = "fa fa-check-circle"></i><span>Validasi Pengguna</span></a>
      <a href="validasi_pembayaran_admin.php"><i class = "fa fa-money"></i><span>Validasi Pembayaran</span></a>
  		<a href="list_peminjaman_admin.php"><i class = "fa fa-list"></i><span>List Peminjaman</span></a>
  		<a href="" class = "logout" data-bs-toggle="modal" data-bs-target="#modalLogout"><span>Logout</span></a>
  	</div>

    <div class = "content">
        <form action="" method="post" autocomplete="off" class="search-form">
            <div class="utility-bar">
                <div></div>
                <div class="search-bar">
                <div class="filter">Filter</div>
                    <input type="text" placeholder = "Cari berdasarkan nama" class="search-field" name="keyword">
                    <button type="submit" class="fa fa-search search-button" name="search"></button>
                </div>
            </div>
        </form>
        <div class="table-responsive mt-5 col-xxl-10 offset-xxl-1 col-lg-10 offset-lg-1 col-md-10 offset-md-1 col-sm-10 offset-sm-1 col-10 offset-1 table-tuples">
            <table class="table">
                <thead class = "text-center" style="background-color: #000033; color: white;">
                    <th>NIK</th>
                    <th>Nama</th>
                    <th style="width: 16.66%">Alamat</th>
                    <th>Kabupaten</th>
                    <th>Jenis Kelamin</th>
                    <th>Aksi</th>
                </thead>
                <tbody class="text-center">
                    <?php foreach ($tuples as $tuple): ?>
                    <tr>
                        <td><?= $tuple["NIK"] ?></td>
                        <td><?= $tuple["nama"] ?></td>
                        <td><?= $tuple["alamat"] ?></td>
                        <td><?= $tuple["kabupaten"] ?></td>
                        <td><?= $tuple["jenis_kelamin"] ?></td>
                        <td><a class="btn btn-success mx-1 mt-1 mb-1" href="#" role="button" onclick="valid_user('<?= $tuple['ID_akun'] ?>', '<?= $tuple['NIK'] ?>')">Valid</a>
                        <a class="btn btn-danger mt-1 mb-1" href="#" role="button" onclick="not_valid_user('<?= $tuple['ID_akun'] ?>', '<?= $tuple['NIK'] ?>')">Tidak Valid</a></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>


    <div class="modal fade" id="validModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Validasi</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
              <!-- <span aria-hidden="true">&times;</span> -->
            </button>
          </div>
          <div class="modal-body">
            <form action="" method="post" enctype="multipart/form-data" id="updatehelperForm">
              <p> 
                  Apakah anda yakin data pelanggan ini valid?
              </p>
              <div class="form-group">
                <label for="ID-akun-valid" class="col-form-label d-none">ID Akun</label>
                <input type="text" class="form-control d-none" id="ID-akun-valid" name="ID-akun-valid" readonly>
              </div>
              <div class="form-group">
                <label for="NIK-valid" class="col-form-label">NIK</label>
                <input type="text" class="form-control" id="NIK-valid" name="NIK-valid" readonly>
              </div>
              <div class="text-center mt-2">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-success" name="submit-valid">Ya</button>
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

    <div class="modal fade" id="notValidModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Validasi</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
              <!-- <span aria-hidden="true">&times;</span> -->
            </button>
          </div>
          <div class="modal-body">
            <form action="" method="post" enctype="multipart/form-data" id="updatehelperForm">
              <p> 
                  Apakah anda yakin data pelanggan ini tidak valid?
              </p>
              <div class="form-group">
                <label for="ID-akun-not-valid" class="col-form-label d-none">ID Akun</label>
                <input type="text" class="form-control d-none" id="ID-akun-not-valid" name="ID-akun-not-valid" readonly>
              </div>
              <div class="form-group">
                <label for="NIK-hapus" class="col-form-label">NIK</label>
                <input type="text" class="form-control" id="NIK-not-valid" name="NIK-not-valid" readonly>
              </div>
              <div class="text-center mt-2">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-success" name="submit-not-valid">Ya</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- JAVASCRIPT --> 
    <script type="text/javascript">

      function valid_user(ID_akun, NIK){
        var myModal = new bootstrap.Modal(document.getElementById('validModal'));
        document.getElementById("NIK-valid").value = NIK;
        document.getElementById("ID-akun-valid").value = ID_akun;
        myModal.show();
      }

      function not_valid_user(ID_akun, NIK){
        var myModal = new bootstrap.Modal(document.getElementById('notValidModal'));
        document.getElementById("NIK-not-valid").value = NIK;
        document.getElementById("ID-akun-not-valid").value = ID_akun;
        myModal.show();
      }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
  
  </body>
    
</html>