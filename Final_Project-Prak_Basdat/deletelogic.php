<?php
	session_start();
	require 'functions.php';
	if($_GET["type"] === "Driver") {
		if (delete_driver($_GET["p_k"])) {
			$_SESSION["delete_bool"] = true;
		} else{
			$_SESSION["delete_bool"] = false;
		}
		header("location: listdriver.php");
	} elseif ($_GET["type"] === "Kendaraan") {
		if (delete_vehicle($_GET["p_k"])) {
			$_SESSION["delete_bool"] = true;
		} else{
			$_SESSION["delete_bool"] = false;
		}
		header("location: menuadmin.php");
	} else {
		if (delete_helper($_GET["p_k"])) {
			$_SESSION["delete_bool"] = true;
		} else{
			$_SESSION["delete_bool"] = false;
		}
		header("location: listhelper.php");
	}
	
	
    exit;
?>