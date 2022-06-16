<?php
include 'connect.php';

$start = $_POST['date'];
$end = $_POST['date'];
$title = $_POST['title'];
$memo = $_POST['memo'];

echo $start;
echo $end;


$sql = "INSERT INTO `calendar` SET `title` = '".$title."', `start` = '".$start."', `end` = '".$end."', `memo` = '".$memo."'";

if(mysqli_query($con, $sql)) {
	echo "<script>window.opener.location.reload(); window.close();</script>";
}



/*
if(!empty($_POST['title']) && !empty($_POST['year']) && !empty($_POST['month']) && !empty($_POST['day'])){
	extract($_POST);
	$start = date("Y-m-d", mktime(0, 0, 0, $month, $day, $year));
	$end = date("Y-m-d", mktime(0, 0, 0, $month, $day, $year));

	include 'connect.php'; // DB 연결
	$sql = "INSERT INTO `calendar` SET `title` = '".$title."', `start` = '".$start."', `end` = '".$end."', `memo` = ''";
	$result = mysqli_query($con, $sql);
	if($result){
		echo 1;
	} else {
		echo 0;
	}
} else {
	echo -1;
}*/

