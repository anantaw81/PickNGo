<?php 
	session_start();
	require 'functions.php';
	if(!isset($_SESSION["login_admin"])) {
		header("location: form_login.php");
		exit;
	}
  $jumlah_data_per_page = 10;
  $jumlah_data = read("SELECT COUNT(*) AS jumlah_data FROM request_peminjaman WHERE (gambar_bukti_pembayaran != '' AND status_peminjaman='accepted') OR status_peminjaman='not valid payment';");
  $jumlah_page = ceil($jumlah_data[0]["jumlah_data"]/$jumlah_data_per_page);
  if(isset($_GET["page_validasi_pembayaran"])) {
    $page_saat_ini = $_GET["page_validasi_pembayaran"];
  } else {
    $page_saat_ini = 1;
  }
  $batas_bawah = $jumlah_data_per_page*$page_saat_ini-$jumlah_data_per_page;
  $tuples = read("SELECT * FROM request_peminjaman WHERE (gambar_bukti_pembayaran != '' AND status_peminjaman='accepted') OR status_peminjaman='not valid payment' LIMIT $batas_bawah, $jumlah_data_per_page;");

  if(isset($_POST["submit-pembayaran-valid"])){
    $payment_validation_status = payment_validation($_POST["ID-pembayaran-valid"], 'paid');
    if (isset($payment_validation_status)) {
        if ($payment_validation_status === true) {
          $_SESSION["bool_status_payment_validation"] = true;
        } else {
          $_SESSION["bool_status_payment_validation"] = false;
        }
        header("location: validasi_pembayaran_admin.php");
        exit;
    }
  }

  if(isset($_POST["submit-pembayaran-tidak-valid"])){
    $payment_validation_tidak_valid_status = payment_validation($_POST["ID-pembayaran-tidak-valid"], 'not valid payment');
    if (isset($payment_validation_tidak_valid_status)) {
        if ($payment_validation_tidak_valid_status === true) {
          $_SESSION["bool_status_payment_not_valid"] = true;
        } else {
          $_SESSION["bool_status_payment_not_valid"] = false;
        }
        header("location: validasi_pembayaran_admin.php");
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
      <a href="validasi_pembayaran_admin.php" style="background-color: #b34509;"><i class = "fa fa-money"></i><span>Validasi Pembayaran</span></a>
  		<a href="list_peminjaman_admin.php" ><i class = "fa fa-list"></i><span>List Peminjaman</span></a>
      <a href="list_pengembalian_admin.php"><i class = "fa fa-list-alt"></i><span>List Pengembalian</span></a>
  		<a href="" class = "logout" data-bs-toggle="modal" data-bs-target="#modalLogout"><span>Logout</span></a>
  	</div>

    <div class = "content">
      <div class="row card-container">
            <?php if((isset($_SESSION["bool_status_payment_validation"]) && $_SESSION["bool_status_payment_validation"] == true) || (isset($_SESSION["bool_status_payment_not_valid"]) && $_SESSION["bool_status_payment_not_valid"] == true)): ?>
            <div class="mt-5 col-xxl-10 offset-xxl-1 col-lg-10 offset-lg-1 col-md-10 offset-md-1 col-sm-10 offset-sm-1 col-10 offset-1  alert alert-success alert-dismissible fade show mx-auto" role="alert">
              Validasi pembayaran berhasil dilakukan!
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION["bool_status_payment_not_valid"]); ?>
            <?php unset($_SESSION["bool_status_payment_validation"]); ?>
          <?php elseif((isset($_SESSION["bool_status_payment_validation"]) && $_SESSION["bool_status_payment_validation"] == false) || (isset($_SESSION["bool_status_payment_not_valid"]) && $_SESSION["bool_status_payment_not_valid"] == false)): ?>
            <div class="mt-5 col-xxl-10 offset-xxl-1 col-lg-10 offset-lg-1 col-md-10 offset-md-1 col-sm-10 offset-sm-1 col-10 offset-1  alert alert-danger alert-dismissible fade show mx-auto" role="alert">
                Validasi pembayaran tidak berhasil dilakukan!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION["bool_status_payment_not_valid"]); ?>
            <?php unset($_SESSION["bool_status_payment_validation"]); ?>
          <?php endif; ?>
            <div class="table-responsive mt-5 col-xxl-10 offset-xxl-1 col-lg-10 offset-lg-1 col-md-10 offset-md-1 col-sm-10 offset-sm-1 col-10 offset-1 table-tuples">
                <table class="table shadow">
                    <thead class = "text-center" style="background-color: #000033; color: white;">
                        <th>#</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th style="width: 16.66%">Alamat</th>
                        <th>Model Kendaraan</th>
                        <th>Tanggal Peminjaman</th>
                        <th>Tanggal Pengembalian</th>
                        <th>Harga Peminjaman</th>
                        <th>Aksi</th>
                    </thead>
                    <tbody class="text-center">
                        <?php $counter = 0?>
                        <?php foreach ($tuples as $tuple): ?>
                        <?php $counter += 1?>
                        <?php 
                        $id_model = $tuple["ID_model"];
                        $unit_kendaraan = read("SELECT * FROM unit_kendaraan WHERE id_model = '$id_model';");
                        ?>
                        <tr>
                            <td><?= $counter ?></td>
                            <td><?= $tuple["nama"] ?></td>
                            <td><?= $tuple["username"] ?></td>
                            <td><?= $tuple["alamat"] ?></td>
                            <td><?= $tuple["model"] ?></td>
                            <td><?= $tuple["tanggal_peminjaman"] ?></td>
                            <td><?= $tuple["tanggal_pengembalian"] ?></td>
                            <td><?= $tuple["harga_peminjaman"] ?></td>
                            <td><a class="btn btn-primary mx-1 mt-1 mb-1" href="#" role="button" onclick="showImg('<?= $tuple['gambar_bukti_pembayaran'] ?>')">Lihat</a><a class="btn btn-success mx-1 mt-1 mb-1" href="#" role="button" onclick="showAcceptModal('<?= $tuple['ID_peminjaman'] ?>')">Terima</a>
                            <a class="btn btn-danger mt-1 mb-1" href="#" role="button" onclick="showDeclineModal(<?= $tuple['ID_peminjaman'] ?>)">Tolak</a></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row mx-auto ms-5 ps-5">
          <nav aria-label="Page navigation example" class="pagination-button" style="background-color: white;">
            <ul class="pagination pagination-sm offset-xxl-4" style="background-color: white;">
              <?php if($page_saat_ini == 1): ?>
                <li class="page-item disabled">
                  <a class="page-link" href="#" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                  </a>
                </li>
              <?php else: ?>
                <li class="page-item">
                  <a class="page-link" href="validasi_pembayaran_admin.php?page_validasi_pembayaran=<?= $page_saat_ini-1; ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                  </a>
                </li>
              <?php endif;?>
              <?php for($i=1; $i<=$jumlah_page; $i++):?>
                <li class="page-item"><a class="page-link" href="validasi_pembayaran_admin.php?page_validasi_pembayaran=<?= $i; ?>"><?= $i ?></a></li>
              <?php endfor;?>
              <?php if($page_saat_ini == $jumlah_page): ?>
                <li class="page-item disabled">
                  <a class="page-link" href="#" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                  </a>
                </li>
              <?php else: ?>
                <li class="page-item">
                  <a class="page-link" href="validasi_pembayaran_admin.php?page_validasi_pembayaran=<?= $page_saat_ini+1; ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                  </a>
                </li>
              <?php endif;?>
            </ul>
          </nav>
        </div>
    </div>

    <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Bukti Pembayaran</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            </button>
          </div>
          <div class="modal-body text-center" id="image-body">
          </div>
          <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
      </div>
    </div>

    <script>
        function showImg(image_name) {
            var myModal = new bootstrap.Modal(document.getElementById('imageModal'));
            document.getElementById('image-body').innerHTML = "";
            var img = document.createElement("img");
            img.width = "450";
            img.height = "800";
            img.src = "Images/BuktiPembayaran/".concat(image_name);
            var src = document.getElementById("image-body");
            src.appendChild(img);
            myModal.show();
        }

        function showAcceptModal(id_peminjaman){
          var myModal = new bootstrap.Modal(document.getElementById('validModal'));
          document.getElementById("ID-pembayaran-valid").value = id_peminjaman;
          myModal.show();
        }

        function showDeclineModal(id_peminjaman){
          var myModal = new bootstrap.Modal(document.getElementById('notValidModal'));
          document.getElementById("ID-pembayaran-tidak-valid").value = id_peminjaman;
          myModal.show();
        }
    </script>

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
            <form action="" method="post" enctype="multipart/form-data" id="validasiPembayaran">
              <p> 
                  Apakah anda yakin bukti pembayaran ini valid?
              </p>
              <div class="form-group">
                <label for="ID-pembayaran-valid" class="col-form-label d-none">ID Peminjaman</label>
                <input type="text" class="form-control d-none" id="ID-pembayaran-valid" name="ID-pembayaran-valid" readonly>
              </div>
              <div class="text-center mt-2">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-success" name="submit-pembayaran-valid">Ya</button>
              </div>
            </form>
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
            <form action="" method="post" enctype="multipart/form-data" id="validasiPembayaran">
              <p> 
                  Apakah anda yakin bukti pembayaran ini tidak valid?
              </p>
              <div class="form-group">
                <label for="ID-pembayaran-tidak-valid" class="col-form-label d-none">ID Peminjaman</label>
                <input type="text" class="form-control d-none" id="ID-pembayaran-tidak-valid" name="ID-pembayaran-tidak-valid" readonly>
              </div>
              <div class="text-center mt-2">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-success" name="submit-pembayaran-tidak-valid">Ya</button>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
  
  </body>
    
</html>