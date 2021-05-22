<?php 
    session_start();
	require 'functions.php';
    if(!isset($_SESSION["login_pelanggan"])) {
        header("location: form_login.php");
        exit;
    }
    $id = $_SESSION["id_akun"];
    $tuples = read("SELECT * FROM akun_pelanggan INNER JOIN pelanggan ON akun_pelanggan.ID_pelanggan = pelanggan.ID_pelanggan WHERE ID_akun = '$id';");
    if (isset($_POST["update-biodata-submit"])) {
      if (ctype_space($_POST["update-NIK"]) || ctype_space($_POST["update-nama"]) || ctype_space($_POST["update-alamat"]) || ctype_space($_POST["update-nomor-telepon"] || ctype_space($_POST["update-jenis-kelamin"]))) {
        echo "<script> alert('Tolong lengkapi data anda!'); </script>";
      } elseif ($_POST["update-NIK"] != $tuples[0]["NIK"] || $_POST["update-nama"] != $tuples[0]["nama"] || $_POST["update-alamat"] != $tuples[0]["alamat"] || $_POST["update-kabupaten"] != $tuples[0]["kabupaten"] || $_POST["update-jenis-kelamin"] != $tuples[0]["jenis_kelamin"]) {
        $update_biodata_status = update_biodata($_POST, $tuples[0]["ID_pelanggan"], $tuples[0]["NIK"], $tuples[0]["ID_akun"]);
      } else {
        $update_biodata_status = update_biodata($_POST,  $tuples[0]["ID_pelanggan"], $tuples[0]["NIK"], $tuples[0]["ID_akun"]);
      }
      if (isset($update_biodata_status)) {
        if ($update_biodata_status === true) {
          $_SESSION["bool_status_update_biodata"] = true;
        } else {
          $_SESSION["bool_status_update_biodata"] = false;
        }
        header("location: profil_user.php");
        exit;
      }
    }

    if (isset($_POST["update-username-submit"])) {
      if (ctype_space($_POST["update-username"]) || ctype_space($_POST["update-password-konfirmasi"])) {
        echo "<script> alert('Tolong lengkapi data anda!'); </script>";
      } elseif ($_POST["update-username"] != $tuples[0]["username"]) {
        $update_username_status = update_username($_POST, $tuples[0]["password_pelanggan"], $tuples[0]["ID_akun"]);
      }
      if (isset($update_username_status)) {
        $_SESSION["bool_status_update_username"] = $update_username_status;
        header("location: profil_user.php");
        exit;
      }
    }

    if (isset($_POST["update-password-submit"])) {
      if (ctype_space($_POST["update-password-sekarang"]) || ctype_space($_POST["update-password-baru"]) || ctype_space($_POST["update-konfirmasi-password-baru"])) {
        echo "<script> alert('Tolong lengkapi data anda!'); </script>";
      } elseif (isset($_POST["update-password-sekarang"]) || isset($_POST["update-password-baru"]) || isset($_POST["update-konfirmasi-password-baru"])) {
        $update_password_status = update_password($_POST, $tuples[0]["password_pelanggan"], $tuples[0]["ID_akun"]);
      }
      if (isset($update_password_status)) {
        $_SESSION["bool_status_update_password"] = $update_password_status;
        header("location: profil_user.php");
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
  		<a href="profil_user.php" style="background-color: #b34509;"><i class="fa fa-user"></i><span>Profil</span></a>
  		<a href="beranda_user.php"><i class="fa fa-truck"></i><span>Beranda</span></a>
  		<a href="request_peminjaman_user.php"><i class = "fa fa-hourglass"></i><span>Request Peminjaman</span></a>
  		<a href="list_peminjaman_user.php"><i class = "fa fa-credit-card-alt"></i><span>List Peminjaman</span></a>
  		<a href="" class = "logout" data-bs-toggle="modal" data-bs-target="#modalLogout"><span>Logout</span></a>
  	</div>

    <div class = "content">
      <div class="text-center mt-4">
        <h1>Edit Profile</h1>
      </div>
      <?php if(isset($_SESSION["bool_status_update_biodata"]) && $_SESSION["bool_status_update_biodata"] === true): ?>
        <div class="col-xxl-8 mt-5 col-md-10 col-sm-10 col-lg-10 col-9 alert alert-success alert-dismissible fade show mx-auto" role="alert">
            Biodata berhasil diperbaharui!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION["bool_status_update_biodata"]); ?>
      <?php elseif(isset($_SESSION["bool_status_update_biodata"]) && $_SESSION["bool_status_update_biodata"] === false): ?>
          <div class="col-xxl-8 mt-5 col-md-8 col-sm-10 col-lg-10 col-9 alert alert-danger alert-dismissible fade show mx-auto" role="alert">
              Biodata tidak berhasil diperbaharui! NIK sudah digunakan!
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php unset($_SESSION["bool_status_update_biodata"]); ?>
      <?php endif; ?>

      <?php if(isset($_SESSION["bool_status_update_username"]) && $_SESSION["bool_status_update_username"] === 0): ?>
        <div class="col-xxl-8 mt-5 col-md-10 col-sm-10 col-lg-10 col-9 alert alert-success alert-dismissible fade show mx-auto" role="alert">
            Username berhasil diperbaharui!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION["bool_status_update_username"]); ?>
      <?php elseif(isset($_SESSION["bool_status_update_username"]) && $_SESSION["bool_status_update_username"] === 3): ?>
          <div class="col-xxl-8 mt-5 col-md-8 col-sm-10 col-lg-10 col-9 alert alert-danger alert-dismissible fade show mx-auto" role="alert">
              Terjadi kesalahan pada query!
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php unset($_SESSION["bool_status_update_username"]); ?>
      <?php elseif(isset($_SESSION["bool_status_update_username"]) && $_SESSION["bool_status_update_username"] === 2): ?>
          <div class="col-xxl-8 mt-5 col-md-8 col-sm-10 col-lg-10 col-9 alert alert-danger alert-dismissible fade show mx-auto" role="alert">
              Password konfirmasi tidak sesuai!
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php unset($_SESSION["bool_status_update_username"]); ?>
      <?php elseif(isset($_SESSION["bool_status_update_username"]) && $_SESSION["bool_status_update_username"] === 1): ?>
          <div class="col-xxl-8 mt-5 col-md-8 col-sm-10 col-lg-10 col-9 alert alert-danger alert-dismissible fade show mx-auto" role="alert">
              Username telah digunakan!
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php unset($_SESSION["bool_status_update_username"]); ?>
      <?php endif; ?>

      <?php if(isset($_SESSION["bool_status_update_password"]) && $_SESSION["bool_status_update_password"] === 4): ?>
        <div class="col-xxl-8 mt-5 col-md-10 col-sm-10 col-lg-10 col-9 alert alert-success alert-dismissible fade show mx-auto" role="alert">
            Password berhasil diperbaharui!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION["bool_status_update_password"]); ?>
      <?php elseif(isset($_SESSION["bool_status_update_password"]) && $_SESSION["bool_status_update_password"] === 3): ?>
          <div class="col-xxl-8 mt-5 col-md-8 col-sm-10 col-lg-10 col-9 alert alert-danger alert-dismissible fade show mx-auto" role="alert">
              Terjadi kesalahan pada query!
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php unset($_SESSION["bool_status_update_password"]); ?>
      <?php elseif(isset($_SESSION["bool_status_update_password"]) && $_SESSION["bool_status_update_password"] === 2): ?>
          <div class="col-xxl-8 mt-5 col-md-8 col-sm-10 col-lg-10 col-9 alert alert-danger alert-dismissible fade show mx-auto" role="alert">
              Password konfirmasi tidak sesuai!
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php unset($_SESSION["bool_status_update_password"]); ?>
      <?php elseif(isset($_SESSION["bool_status_update_password"]) && $_SESSION["bool_status_update_password"] === 1): ?>
          <div class="col-xxl-8 mt-5 col-md-8 col-sm-10 col-lg-10 col-9 alert alert-danger alert-dismissible fade show mx-auto" role="alert">
              Password tidak sesuai!
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php unset($_SESSION["bool_status_update_password"]); ?>
      <?php endif; ?>
      
      <fieldset class="scheduler-border col-md-8 offset-md-2 shadow" >
        <legend class="scheduler-border">Biodata</legend>
          <div class="row">
          <form class="form-horizontal" action="#" method="post">
              <div class="row mt-2">
                  <div class="col-md-6">
                      <label for="update-NIK" class="form-label">NIK</label>
                      <input type="text" class="form-control" id="update-NIK" name="update-NIK" value="<?= $tuples[0]["NIK"] ?>">
                  </div>
                  <div class="col-md-6">
                      <label for="update-nama" class="form-label">Nama</label>
                      <input type="text" class="form-control" id="update-nama" name="update-nama" value="<?= $tuples[0]["nama"] ?>">
                  </div>
              </div>
              <div class="row mt-3">
                  <div class="col-md-12">
                      <label for="update-alamat" class="form-label">Alamat</label>
                      <input type="text" class="form-control" id="update-alamat" name="update-alamat" value="<?= $tuples[0]["alamat"] ?>">
                  </div>
              </div>
              <div class="row mt-3">
                  <div class="col-md-6 ">
                      <label for="update-kabupaten" class="form-label">Kabupaten/Kota</label>
                      <select class="form-select" id="update-kabupaten" name="update-kabupaten" required>
                          <option value="Badung" <?=$tuples[0]['kabupaten'] == 'Badung' ? ' selected="selected"' : '';?>>Badung</option>
                          <option value="Bangli" <?=$tuples[0]['kabupaten'] == 'Bangli' ? ' selected="selected"' : '';?>>Bangli</option>
                          <option value="Buleleng" <?=$tuples[0]['kabupaten'] == 'Buleleng' ? ' selected="selected"' : '';?>>Buleleng</option>
                          <option value="Gianyar" <?=$tuples[0]['kabupaten'] == 'Gianyar' ? ' selected="selected"' : '';?>>Gianyar</option>
                          <option value="Jembrana" <?=$tuples[0]['kabupaten'] == 'Jembrana' ? ' selected="selected"' : '';?>>Jembrana</option>
                          <option value="Karangasem" <?=$tuples[0]['kabupaten'] == 'Karangasem' ? ' selected="selected"' : '';?>>Karangasem</option>
                          <option value="Klungkung" <?=$tuples[0]['kabupaten'] == 'Klungkung' ? ' selected="selected"' : '';?>>Klungkung</option>
                          <option value="Tabanan" <?=$tuples[0]['kabupaten'] == 'Tabanan' ? ' selected="selected"' : '';?>>Tabanan</option>
                          <option value="Denpasar" <?=$tuples[0]['kabupaten'] == 'Denpasar' ? ' selected="selected"' : '';?>>Denpasar</option>
                      </select>
                  </div>
                  <div class="col-md-6">
                      <label for="update-nomor-telepon" class="form-label">Nomor Telepon</label>
                      <input type="text" class="form-control" id="update-nomor-telepon" name="update-nomor-telepon" value="<?= $tuples[0]["nomor_telepon"] ?>">
                  </div>
              </div>
              <div class="row mt-3">
                <div class="col-md-6 ">
                <label for="update-jenis-kelamin" class="form-label">Jenis Kelamin</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="update-jenis-kelamin" <?php echo ($tuples[0]["jenis_kelamin"] =='Pria')? 'checked':'' ?> id="gridRadios1" value="Pria" checked required>
                        <label class="form-check-label" for="gridRadios1">
                          Pria
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="update-jenis-kelamin" <?php echo ($tuples[0]["jenis_kelamin"] =='Wanita')? 'checked':'' ?> id="gridRadios2" value="Wanita" required>
                        <label class="form-check-label" for="gridRadios2">
                          Wanita
                        </label>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="" class="form-label">Status</label>
                    <input type="text" class="form-control" id="" name="" disabled value="<?= $tuples[0]["status_akun"] ?>">
                </div>
              </div>
              <div class="mt-3 ">
                    <button type="submit" name = "update-biodata-submit" class="btn btn-primary">Simpan Perubahan</button>
              </div>
          </form>
          </div>
        </legend>
      </fieldset>
      
      <div class="row mt-4">
        <fieldset class="scheduler-border col-md-4 offset-md-2 shadow" >
          <legend class="scheduler-border">Username</legend>
            <div class="row">
              <form class="form-horizontal" action="#" method="post" >
                <div class="row mt-3">
                    <div class="">
                        <label for="update-username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="update-username" name="update-username" value="<?= $tuples[0]["username"] ?>">
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="">
                        <label for="update-password-konfirmasi" class="form-label">Password Konfirmasi</label>
                        <input type="password" class="form-control" id="update-password-konfirmasi" name="update-password-konfirmasi">
                    </div>
                </div>
                <div class="mt-3 ">
                      <button type="submit" name = "update-username-submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
              </form>
            </div>
          </legend>
        </fieldset>

        <fieldset class="scheduler-border col-md-4 shadow" style="margin-left: 8px;">
          <legend class="scheduler-border" >Password</legend>
            <div class="row">
              <form class="" action="#" method="post" >
              <div class="row mt-3">
                  <div class="">
                      <label for="update-password-sekarang" class="form-label">Password Saat Ini</label>
                      <input type="password" class="form-control" id="update-password-sekarang" name="update-password-sekarang">
                  </div>
              </div>
              <div class="row mt-3">
                  <div class="">
                      <label for="update-password-baru" class="form-label">Password Baru</label>
                      <input type="password" class="form-control" id="update-password-baru" name="update-password-baru">
                  </div>
              </div>
              <div class="row mt-3">
                  <div class="">
                      <label for="update-konfirmasi-password-baru" class="form-label">Konfirmasi Password Baru</label>
                      <input type="password" class="form-control" id="update-konfirmasi-password-baru" name="update-konfirmasi-password-baru">
                  </div>
              </div>
              <div class="mt-3">
                    <button type="submit" name = "update-password-submit" class="btn btn-primary">Simpan Perubahan</button>
              </div>
              </form>
            </div>
          </legend>
        </fieldset>
      </div>
      <br>
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
