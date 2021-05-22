<?php 
    session_start();
	require 'functions.php';
    if(!isset($_SESSION["login_admin"])) {
		header("location: form_login.php");
		exit;
	}
  $tuples = read("SELECT * FROM request_peminjaman WHERE status_peminjaman = 'not accepted yet' ORDER BY ID_peminjaman;");

  if (isset($_POST["submit-acc-request"])) {
    $accept_status = accept_peminjaman($_POST);
    if (isset($accept_status)) {
      if ($accept_status == 1) {
        $_SESSION["bool_status_accept"] = 1;
      } elseif ($accept_status == 2) {
        $_SESSION["bool_status_accept"] = 2;
      } else {
        $_SESSION["bool_status_accept"] = 0;
      }
      header("location: request_peminjaman_admin.php");
      exit;
    }
  }

  if(isset($_POST["submit-reject-request"])) {
    $reject_status = reject_peminjaman($_POST);
    if (isset($reject_status)){
      if ($reject_status) {
        $_SESSION["bool_status_reject"] = true;
      } else {
        $_SESSION["bool_status_accept"] = false;
      }
      header("location: request_peminjaman_admin.php");
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
  		<a href="request_peminjaman_admin.php" style="background-color: #b34509;"><i class = "fa fa-hourglass" ></i><span>Request Peminjaman</span></a>
  		<a href="validasi_user_admin.php"><i class = "fa fa-check-circle"></i><span>Validasi Pengguna</span></a>
      <a href="validasi_pembayaran_admin.php"><i class = "fa fa-money"></i><span>Validasi Pembayaran</span></a>
  		<a href="list_peminjaman_admin.php"><i class = "fa fa-list"></i><span>List Peminjaman</span></a>
  		<a href="" class = "logout" data-bs-toggle="modal" data-bs-target="#modalLogout"><span>Logout</span></a>
  	</div>

    <div class = "content">
        <?php if(isset($_SESSION["bool_status_reject"]) && $_SESSION["bool_status_reject"] === true): ?>
          <div class="col-xxl-11 mt-5 col-md-10 col-sm-10 col-lg-10 col-9 alert alert-success alert-dismissible fade show mx-auto" role="alert">
            Permintaan peminjaman telah ditolak!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          <?php unset($_SESSION["bool_status_reject"]); ?>
        <?php elseif(isset($_SESSION["bool_status_reject"]) && $_SESSION["bool_status_reject"] === false): ?>
          <div class="col-xxl-11 mt-5 col-md-10 col-sm-10 col-lg-10 col-9 alert alert-danger alert-dismissible fade show mx-auto" role="alert">
              Terjadi kesalahan pada query!
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          <?php unset($_SESSION["bool_status_reject"]); ?>
        <?php endif; ?>

        <?php if(isset($_SESSION["bool_status_accept"]) && $_SESSION["bool_status_accept"] == 1): ?>
          <div class="col-xxl-11 mt-5 col-md-10 col-sm-10 col-lg-10 col-9 alert alert-success alert-dismissible fade show mx-auto" role="alert">
            Request berhasil diterima!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          <?php unset($_SESSION["bool_status_accept"]); ?>
        <?php elseif(isset($_SESSION["bool_status_accept"]) && $_SESSION["bool_status_accept"] == 0):?>
          <div class="col-xxl-11 mt-5 col-md-10 col-sm-10 col-lg-10 col-9 alert alert-danger alert-dismissible fade show mx-auto" role="alert">
              Lengkapi data unit kendaraan, driver, ataupun helper!
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          <?php unset($_SESSION["bool_status_accept"]); ?>
        <?php elseif(isset($_SESSION["bool_status_accept"]) && $_SESSION["bool_status_accept"] == 2): ?>
          <div class="col-xxl-11 mt-5 col-md-10 col-sm-10 col-lg-10 col-9 alert alert-danger alert-dismissible fade show mx-auto" role="alert">
              Terjadi kesalahan pada query!
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          <?php unset($_SESSION["bool_status_accept"]); ?>
        <?php endif; ?>
        <div class="table-responsive mt-5 col-xxl-10 offset-xxl-1 col-lg-10 offset-lg-1 col-md-10 offset-md-1 col-sm-10 offset-sm-1 col-10 offset-1 table-tuples">
            <table class="table">
                <thead class = "text-center" style="background-color: #000033; color: white;">
                    <th>#</th>
                    <th>Nama</th>
                    <th style="width: 16.66%">Alamat</th>
                    <th>Model Kendaraan</th>
                    <th>Tanggal Peminjaman</th>
                    <th>Tanggal Pengembalian</th>
                    <th>Opsi Driver</th>
                    <th>Jumlah Helper</th>
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
                        <td><?= $tuple["alamat"] ?></td>
                        <td><?= $tuple["model"] ?></td>
                        <td><?= $tuple["tanggal_peminjaman"] ?></td>
                        <td><?= $tuple["tanggal_pengembalian"] ?></td>
                        <?php if($tuple["opsi_driver"]==0): ?>
                          <td>Tidak</td>
                        <?php else: ?>
                          <td>Ya</td>
                        <?php endif?>
                        <td><?= $tuple["jumlah_helper"] ?></td>
                        <td><a class="btn btn-success mx-1 mt-1 mb-1" href="#" role="button" onclick='terimaRequest(<?php echo ($tuple["opsi_driver"]); ?>, <?php echo ($tuple["jumlah_helper"]); ?>, <?php echo ($tuple["ID_peminjaman"]); ?>, <?php echo json_encode($unit_kendaraan); ?>)'>Terima</a>
                        <a class="btn btn-danger mt-1 mb-1" href="#" role="button" onclick="tolakRequest(<?= $tuple['ID_peminjaman'] ?>)">Tolak</a></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    
    <div class="modal fade" id="acceptModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Terima Request</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
              <!-- <span aria-hidden="true">&times;</span> -->
            </button>
          </div>
          <div class="modal-body">
            <form action="" method="post" enctype="multipart/form-data" id="acceptRequestForm">
              <div class="form-group">
                    <label for="ID-peminjaman-accept" class="col-form-label">ID peminjaman</label>
                    <input type="text" class="form-control" id="ID-peminjaman-accept" name="ID-peminjaman-accept" readonly>
              </div>
              <div class="form-group">
                    <label for="jumlah-helper-accept" class="col-form-label d-none">Jumlah Helper</label>
                    <input type="number" class="form-control d-none" id="jumlah-helper-accept" name="jumlah-helper-accept" readonly>
              </div>
              <div class="form-group">
                    <label for="butuh-driver-accept" class="col-form-label">Butuh Driver</label>
                    <input type="number" class="form-control" id="butuh-driver-accept" name="butuh-driver-accept" readonly>
              </div>
              <div class="form-group">
                <label for="unit-kendaraan" class="col-form-label">Unit Kendaraan</label>
                <select class="form-select" id="unit-kendaraan" name="unit-kendaraan" required>
                </select>
              </div>
              <div class="form-group">
                <label for="driver" class="col-form-label" id="label-driver">Driver</label>
                <?php $driver = read("SELECT * FROM driver;"); ?>
                <select class="form-select" id="driver-selection" name="driver-selection" required>
                  <option selected>Pilih Driver</option>
                  <?php foreach ($driver as $driver_personel): ?>
                    <option value = "<?= $driver_personel["ID_driver"] ?>"><?= $driver_personel["nama"] ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="form-group">
                <label for="helper-1" class="col-form-label" id="label-helper-1">Helper</label>
                <?php $helper = read("SELECT * FROM helper;"); ?>
                <select class="form-select" id="helper-1" name="helper-1" required>
                  <option selected>Pilih Helper</option>
                  <?php foreach ($helper as $helper_personel): ?>
                    <option value = "<?= $helper_personel["ID_helper"] ?>"><?= $helper_personel["nama"] ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="form-group">
                <label for="helper-2" class="col-form-label" id="label-helper-2">Helper</label>
                <?php $helper = read("SELECT * FROM helper;"); ?>
                <select class="form-select" id="helper-2" name="helper-2" required>
                  <option selected>Pilih Helper</option>
                  <?php foreach ($helper as $helper_personel): ?>
                    <option value = "<?= $helper_personel["ID_helper"] ?>"><?= $helper_personel["nama"] ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="mb-3 form-check mt-3">
                    <input type="checkbox" class="form-check-input" id="konfirmasi-accept" required>
                    <label class="form-check-label" for="konfirmasi-accept">Konfirmasi Penerimaan Permintaan Peminjaman</label>
                </div>
              <div class="text-center mt-4">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-success" name="submit-acc-request">Accept</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Tolak Request</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
              <!-- <span aria-hidden="true">&times;</span> -->
            </button>
          </div>
          <div class="modal-body">
            <form action="" method="post" enctype="multipart/form-data" id="acceptRequestForm">
            <p>Apakah anda yakin akan menolak permintaan ini?</p>
              <div class="form-group">
                    <label for="ID-peminjaman-reject" class="col-form-label d-none">ID peminjaman</label>
                    <input type="text" class="form-control d-none" id="ID-peminjaman-reject" name="ID-peminjaman-reject" readonly>
              </div>
              <div class="form-group">
                    <label for="keterangan-reject-peminjaman" class="col-form-label">Keterangan Penolakan</label>
                    <textarea id="keterangan-reject-peminjaman" name="keterangan-reject-peminjaman" rows = "5" class="form-control"></textarea>
              </div>
              <div class="text-center mt-4">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                <button type="submit" class="btn btn-success" name="submit-reject-request">Ya</button>
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
      function terimaRequest(opsi_driver, jumlah_helper, id_peminjaman, unit_kendaraan) {
        document.getElementById("butuh-driver-accept").value = opsi_driver;
        document.getElementById("jumlah-helper-accept").value = jumlah_helper;
        var select_dropdown = document.getElementById("unit-kendaraan");
        select_dropdown.options.length = 0;
        var dummy = document.createElement("option");
        dummy.text = "Pilih Unit";
        dummy.value = -1;
        select_dropdown.add(dummy);
        for (var i = 0; i < unit_kendaraan.length; i++) {
          var option = document.createElement("option");
          option.text = unit_kendaraan[i]["plat_nomor"];
          option.value = unit_kendaraan[i]["ID_kendaraan"];
          select_dropdown.add(option);
        }
        var myModal = new bootstrap.Modal(document.getElementById('acceptModal'));
        var id = document.getElementById("ID-peminjaman-accept");
        id.value = id_peminjaman;

        if (jumlah_helper == 0) {
          var helper1 = document.getElementById("helper-1");
          var labelhelper1 = document.getElementById("label-helper-1");
          var helper2 = document.getElementById("helper-2");
          var labelhelper2 = document.getElementById("label-helper-2");
          helper1.style.display = "none";
          helper2.style.display = "none";
          labelhelper1.style.display = "none";
          labelhelper2.style.display = "none";
        } else if (jumlah_helper == 1) {
          var helper1 = document.getElementById("helper-1");
          var labelhelper1 = document.getElementById("label-helper-1");
          var helper2 = document.getElementById("helper-2");
          var labelhelper2 = document.getElementById("label-helper-2");
          helper1.style.display = "none";
          labelhelper1.style.display = "none";
          helper2.style.display = "block";
          labelhelper2.style.display = "block";
        } else {
          var helper1 = document.getElementById("helper-1");
          var labelhelper1 = document.getElementById("label-helper-1");
          var helper2 = document.getElementById("helper-2");
          var labelhelper2 = document.getElementById("label-helper-2");
          helper1.style.display = "block";
          labelhelper1.style.display = "block";
          helper2.style.display = "block";
          labelhelper2.style.display = "block";
        }

        if (opsi_driver == 0) {
          var driver_input = document.getElementById("driver-selection");
          var driver_label = document.getElementById("label-driver");
          driver_input.style.display = "none";
          driver_label.style.display = "none";
        } else {
          var driver_input = document.getElementById("driver-selection");
          var driver_label = document.getElementById("label-driver");
          driver_input.style.display = "block";
          driver_label.style.display = "block";
        }

        myModal.show();
      }

      function tolakRequest(ID_peminjaman) {
        var myModal = new bootstrap.Modal(document.getElementById('rejectModal'));
        document.getElementById("ID-peminjaman-reject").value = ID_peminjaman;
        myModal.show();
      }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
  
  </body>
    
</html>