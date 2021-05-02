<?php
// connect to database
$conn = mysqli_connect("localhost", "root", "", "peminjaman_pickup_dan_truck_db");

// read data
function read($query) {
	global $conn;
	$result = mysqli_query($conn, $query);
	$records = [];
	while ($tuples = mysqli_fetch_assoc($result)) {
		$records[] = $tuples;
	}
	return $records;
}

// Insert data to database
function execute_query($query) {
	global $conn;
	mysqli_query($conn, $query);
	if (mysqli_affected_rows($conn) > 0) {
		return true;
	}
	return false;
}

function check_file_type($file_type) {
	$accepted_values = ["image/jpeg", "image/jpg", "image/png"];
	if (in_array($file_type, $accepted_values)) {
		return true;
	}
	return false;
}

function insert_driver($record, $img) {
	global $conn;
	$nama_driver = htmlspecialchars($record["nama-driver"]);
	$jenis_kelamin_driver = htmlspecialchars($record["jenisKelamin"]);
	$harga = htmlspecialchars($record["harga"]);
	$nama_foto = $img['foto-driver']['name'];
	$tipe_file = $img['foto-driver']['type'];
	$file_path_sementara = $img['foto-driver']['tmp_name'];
	$dummy = explode("/", $tipe_file);
	$ekstensi = "." . $dummy[1];
	$nama_foto_simpan = uniqid() . $ekstensi;
	if(!check_file_type($tipe_file)) {
		return false;
	} elseif ($img['foto-driver']['size'] > 500000) {
		return false;
	}
	move_uploaded_file($file_path_sementara, 'Images/Driver/' . $nama_foto_simpan);
	$query = "INSERT INTO driver VALUES('', '$nama_driver', '$jenis_kelamin_driver', $harga, '$nama_foto_simpan')";
	if(execute_query($query)){
		return true;
	}
	return false;
}

function insert_unit($record) {
	$id_model = htmlspecialchars($record["id-model-kendaraan"]);
	$plat_nomor = htmlspecialchars($record["plat-nomor-kendaraan"]);
	$query = "INSERT INTO unit_kendaraan VALUES('', $id_model, '$plat_nomor')";
	if(execute_query($query)){
		return true;
	}
	return false;
}

function update_unit($record) {
	$ID_kendaraan = htmlspecialchars($record["id-kendaraan-update"]);
	$plat_nomor = htmlspecialchars($record["plat-nomor-update"]);
	$query = "UPDATE unit_kendaraan SET plat_nomor = '$plat_nomor' WHERE ID_kendaraan = $ID_kendaraan";
	if(execute_query($query)){
		return true;
	}
	return false; 
}

function delete_unit($record){
	$ID_kendaraan = htmlspecialchars($record["id-kendaraan-hapus"]);
	$query = "DELETE FROM unit_kendaraan WHERE ID_kendaraan = $ID_kendaraan";
	if(execute_query($query)){
		return true;
	}
	return false; 
}

function insert_helper($record, $img) {
	global $conn;
	$nama_helper = htmlspecialchars($record["nama-helper"]);
	$jenis_kelamin_helper = htmlspecialchars($record["jenisKelamin"]);
	$harga = htmlspecialchars($record["harga"]);
	$nama_foto = $img['foto-helper']['name'];
	$tipe_file = $img['foto-helper']['type'];
	$file_path_sementara = $img['foto-helper']['tmp_name'];
	$dummy = explode("/", $tipe_file);
	$ekstensi = "." . $dummy[1];
	$nama_foto_simpan = uniqid() . $ekstensi;
	if(!check_file_type($tipe_file)) {
		return false;
	} elseif ($img['foto-helper']['size'] > 500000) {
		return false;
	}
	move_uploaded_file($file_path_sementara, 'Images/Helper/' . $nama_foto_simpan);
	$query = "INSERT INTO helper VALUES('', '$nama_helper', '$jenis_kelamin_helper', $harga, '$nama_foto_simpan')";
	if(execute_query($query)){
		return true;
	}
	return false;
}

function insert_vehicle($record, $img) {
	global $conn;
	$model_kendaraan = htmlspecialchars($record["model-kendaraan"]);
	$manufaktur = htmlspecialchars($record["manufaktur-kendaraan"]);
	$harga = htmlspecialchars($record["harga"]);
	$nama_foto = $img['foto-kendaraan']['name'];
	$tipe_file = $img['foto-kendaraan']['type'];
	$file_path_sementara = $img['foto-kendaraan']['tmp_name'];
	$dummy = explode("/", $tipe_file);
	$ekstensi = "." . $dummy[1];
	$nama_foto_simpan = uniqid() . $ekstensi;
	if(!check_file_type($tipe_file)) {
		return false;
	} elseif ($img['foto-kendaraan']['size'] > 500000) {
		return false;
	}
	move_uploaded_file($file_path_sementara, 'Images/TipeMobil/' . $nama_foto_simpan);
	$query = "INSERT INTO tipe_kendaraan VALUES('', '$model_kendaraan', '$manufaktur', $harga, '$nama_foto_simpan')";
	if(execute_query($query)){
		return true;
	}
	return false;
}

function update_driver($record, $img) {
	global $conn;
	$id = htmlspecialchars($record["id-driver"]);
	$nama_driver = htmlspecialchars($record["nama-driver-update"]);
	$jenis_kelamin_driver = htmlspecialchars($record["jenisKelamin-update"]);
	$harga = htmlspecialchars($record["harga-driver-update"]);
	if($img["foto-driver-update"]["error"] == 4) {
		$query = "UPDATE driver SET nama = '$nama_driver', jenis_kelamin = '$jenis_kelamin_driver', tarif = $harga WHERE ID_driver = $id;";
	} else {
		$nama_foto = $img['foto-driver-update']['name'];
		$tipe_file = $img['foto-driver-update']['type'];
		$file_path_sementara = $img['foto-driver-update']['tmp_name'];
		$dummy = explode("/", $tipe_file);
		$ekstensi = "." . $dummy[1];
		$nama_foto_simpan = uniqid() . $ekstensi;
		if(!check_file_type($tipe_file)) {
			return false;
		} elseif ($img['foto-driver-update']['size'] > 500000) {
			return false;
		}
		move_uploaded_file($file_path_sementara, 'Images/Driver/' . $nama_foto_simpan);
		$query = "UPDATE driver SET nama = '$nama_driver', jenis_kelamin = '$jenis_kelamin_driver', tarif = $harga, nama_foto = '$nama_foto_simpan' WHERE ID_driver = $id;";
	}
	if(execute_query($query)){
		return true;
	}
	return false;
}

function update_helper($record, $img) {
	global $conn;
	$id = htmlspecialchars($record["id-helper"]);
	$nama_helper = htmlspecialchars($record["nama-helper-update"]);
	$jenis_kelamin_helper = htmlspecialchars($record["jenisKelamin-update"]);
	$harga = htmlspecialchars($record["harga-helper-update"]);
	if($img["foto-helper-update"]["error"] == 4) {
		$query = "UPDATE helper SET nama = '$nama_helper', jenis_kelamin = '$jenis_kelamin_helper', tarif = $harga WHERE ID_helper = $id;";
	} else {
		$nama_foto = $img['foto-helper-update']['name'];
		$tipe_file = $img['foto-helper-update']['type'];
		$file_path_sementara = $img['foto-helper-update']['tmp_name'];
		$dummy = explode("/", $tipe_file);
		$ekstensi = "." . $dummy[1];
		$nama_foto_simpan = uniqid() . $ekstensi;
		if(!check_file_type($tipe_file)) {
			return false;
		} elseif ($img['foto-helper-update']['size'] > 500000) {
			return false;
		}
		move_uploaded_file($file_path_sementara, 'Images/Helper/' . $nama_foto_simpan);
		$query = "UPDATE helper SET nama = '$nama_helper', jenis_kelamin = '$jenis_kelamin_helper', tarif = $harga, nama_foto = '$nama_foto_simpan' WHERE ID_helper = $id;";
	}
	if(execute_query($query)){
		return true;
	}
	return false;
}

function update_vehicle($record, $img) {
	global $conn;
	$id = htmlspecialchars($record["id-model"]);
	$model = htmlspecialchars($record["nama-model-update"]);
	$manufaktur = htmlspecialchars($record["nama-manufaktur-update"]);
	$harga = htmlspecialchars($record["harga-model-update"]);
	if($img["foto-model-update"]["error"] == 4) {
		$query = "UPDATE tipe_kendaraan SET model = '$model', manufaktur = '$manufaktur', harga_sewa = $harga WHERE ID_model = $id;";
	} else {
		$nama_foto = $img['foto-model-update']['name'];
		$tipe_file = $img['foto-model-update']['type'];
		$file_path_sementara = $img['foto-model-update']['tmp_name'];
		$dummy = explode("/", $tipe_file);
		$ekstensi = "." . $dummy[1];
		$nama_foto_simpan = uniqid() . $ekstensi;
		if(!check_file_type($tipe_file)) {
			return false;
		} elseif ($img['foto-model-update']['size'] > 500000) {
			return false;
		}
		move_uploaded_file($file_path_sementara, 'Images/TipeMobil/' . $nama_foto_simpan);
		$query = "UPDATE tipe_kendaraan SET model = '$model', manufaktur = '$manufaktur', harga_sewa = $harga, gambar = '$nama_foto_simpan' WHERE ID_model = $id;";
	}
	if(execute_query($query)){
		return true;
	}
	return false;
}

function delete_driver($driver_p_k) {
	global $conn;
	$query = "DELETE FROM driver WHERE ID_driver = $driver_p_k;";
	if(execute_query($query)){
		return true;
	}
	return false;
}

function delete_helper($helper_p_k) {
	global $conn;
	$query = "DELETE FROM helper WHERE ID_helper = $helper_p_k;";
	if(execute_query($query)){
		return true;
	}
	return false;
}

function delete_vehicle($model_p_k) {
	global $conn;
	$query = "DELETE FROM unit_kendaraan WHERE ID_model = $model_p_k;";
	if(execute_query($query)){
		$query = "DELETE FROM tipe_kendaraan WHERE ID_model = $model_p_k;";
		if(execute_query($query)){
			return true;
		}
	}
	return false;
}

function check_username($uname, $tabel) {
	global $conn;
	mysqli_query($conn, "SELECT * FROM $tabel WHERE username = \"$uname\";");
	return mysqli_affected_rows($conn);
}

function check_NIK($nik) {
	global $conn;
	mysqli_query($conn, "SELECT * FROM akun_pelanggan WHERE NIK = \"$nik\";");
	return mysqli_affected_rows($conn);
}

// register user
function register_new_user($record) {
	global $conn;
	$nik = $record["NIK"];
	$uname = stripslashes($record["username"]);
	$pwd = mysqli_real_escape_string($conn, $record["password_akun_login"]);
	$pwd_konf = mysqli_real_escape_string($conn, $record["password_akun_konfirmasi"]);
	if ($pwd !== $pwd_konf) {
		return 1;
	} elseif (check_NIK($nik) > 0) {
		return 2;
	} elseif ((check_username($uname, "akun_pelanggan")) > 0 || (check_username($uname, "admin") > 0)) {
		return 3;
	} else {
  		$nama = $record["nama"];
  		$alamat = $record["alamat"];
  		$kabupaten = $record["asal_kabupaten"];
  		$jenis_kelamin = $record["jenisKelamin"];
  		$no_telp = $record["nomor_telepon"];
  		$hashed_pwd = password_hash($pwd, PASSWORD_DEFAULT);
  		$query_pelanggan = "INSERT INTO pelanggan VALUES('', '$nik', '$nama', '$alamat', '$kabupaten', '$jenis_kelamin', '$no_telp');";
  		$query_akun = "INSERT INTO akun_pelanggan VALUES('', '$uname', '$hashed_pwd', 'not verified', LAST_INSERT_ID());";
		
  		if (execute_query($query_pelanggan) && execute_query($query_akun)) {
  			return 4;
  		}
	}
}

function user_validation($ID_akun, $status) {
	global $conn;
	$query = "UPDATE akun_pelanggan SET status_akun = '$status' WHERE ID_akun = $ID_akun;";
	return execute_query($query);
}

function login($record) {
	global $conn;
	$uname = stripslashes($record["username_login"]);
	$pwd = mysqli_real_escape_string($conn, $record["password_akun_login"]);
	$query = "SELECT * FROM akun WHERE username = \"$uname\";";
	$res_set = mysqli_query($conn, $query);
	if(mysqli_num_rows($res_set) === 1){
		$tuple = mysqli_fetch_assoc($res_set);
		if (password_verify($pwd, $tuple["password_akun"])) {
			if ($tuple['jenis_akun'] === 'pelanggan') {
				$_SESSION["login_pelanggan"] = true;
				$_SESSION["username"] = $uname;
				$_SESSION["id_akun"] = $tuple["ID_akun"];
				header("Location: menuuser.php");
				exit;
			} else {
				$_SESSION["login_admin"] = true;
				$_SESSION["username"] = $uname;
				header("Location: menuadmin.php");
				exit;
			}
		}
	}
	
	$wrong_pass = true;
	return $wrong_pass;
}

function request_peminjaman($record, $id_model) {
	$tanggal_peminjaman = $record["konfirmasi-tgl-peminjaman"];
	$tanggal_pengembalian = $record["konfirmasi-tgl-pengembalian"];
	$id_akun = $_SESSION["id_akun"];
	$butuh_driver = $record["konfirmasi-driver"];
	$jumlah_helper = $record["konfirmasi-helper"];
	
}

?>