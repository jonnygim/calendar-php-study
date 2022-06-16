<meta http-equiv="content-type" content="text/html; charset=utf-8">
<?php
session_start();
$con = mysqli_connect('localhost', '****', '****', '****');

function alert($msg, $link) {
	echo "<script>alert('".$msg."'); location.replace('".$link."');</script>";
}

function alertE($msg) {
	echo "<script>alert('".$msg."'); history.back(); </script>";
}