<?php
if(!empty($_POST['id'])){
	include 'connect.php'; // DB 연결

	$id = $_POST['id'];
	$sqlDelete = "DELETE from `calendar` WHERE `idx` =".$id;
	$result = mysqli_query($con, $sqlDelete);
	if($result){
		echo 1;
	} else {
		echo 0;
	}
	mysqli_close($con);
}
?>