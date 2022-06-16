<?php

if($yy == '') $yy = date('Y'); // 4자리 연도
if($mm == '') $mm = date('n'); // 0을 포함하지 않는 월
if($dd == '') $dd = date('j'); // 0을 포함하지 않는 일


$last_day = date('t', mktime(0, 0, 0, $mm, 1, $yy)); // 주어진 날의 총 일 수
$start_wday = date("w", strtotime($yy."-".$mm."-01")); // 시작요일 (0: 일요일, 6: 토요일)
$last_wday = date('w', strtotime($yy."-".$mm."-".$last_day)); // 마지막 요일 (0: 일요일, 6: 토요일)
$total_week = ceil(($last_day + $start_week) / 7); // 총 몇 주
echo $start_week;


// 이전 달, 다음 달
$prevmonth = $month - 1;
$nextmonth = $month + 1;

$prevyear = $nextyear = $year;

if ($month == 1) { // 1월의 이전 달은 - 연도-1 12월
$prevmonth = 12;
$prevyear = $year - 1;
} elseif ($month == 12) { // 12월의 다음 달은 - 연도 +1  1월
$nextmonth = 1;
$nextyear = $year + 1;
}
// 일반적인 이전 년도, 다음 년도
$pre_year = $year - 1;
$next_year = $year + 1;


echo $thisyear;
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="utf-8">
	<style>
		#main {border: 1px solid #000;}
		.info {width: 14%; text-align: center;}
		.day {width: 130; height:120; text-align: left; valign: top; background-color: #FFFFFF;}
	</style>
	<script>
		$(".calcell").click(function(){
		var val=$(this).attr("id");
		var date = val.split('-');
		var year = date[0];
		var month = date[1];
		var day = date[2];
		//var title = prompt('Event Title:');
		window.open("popup.php?y="+year+"&m="+month+"&d="+day, "schedule", "width: 100px, height: 100px, left: 0, top: 0");
		//$(".calcell", opener.document).val(key);
		});
	</script>
</head>
<body>
<div id="container">
	<form>
		<table id="main">
			<tr>
			<td height="50" align="center" bgcolor="#FFFFFF" colspan="7"><?=sel_yy($yy,'submit();')?>년 <?=sel_mm($mm,'submit();')?>월 <input type="submit" value="보기"></td>
			</tr>
			<tr>
			<td width="130" height="30" align="center" bgcolor="#DDDDDD"><b>일</b></td>
			<td width="130" align="center" bgcolor="#DDDDDD"><b>월</b></td>
			<td width="130" align="center" bgcolor="#DDDDDD"><b>화</b></td>
			<td width="130" align="center" bgcolor="#DDDDDD"><b>수</b></td>
			<td width="130" align="center" bgcolor="#DDDDDD"><b>목</b></td>
			<td width="130" align="center" bgcolor="#DDDDDD"><b>금</b></td>
			<td width="130" align="center" bgcolor="#DDDDDD"><b>토</b></td>
			</tr>
			<?
			$today_yy = date('Y');
			$today_mm = date('m');
			// 화면에 표시할 화면의 초기값을 1로 설정
			$day=1;

			// 세로줄
			for($i=1; $i <= $total_week; $i++) { ?>
			<tr>
				<?php
				// 가로줄
				for ($j=0; $j<7; $j++){?>
					<td class="day">
					<?
					// i : 주 , $total_week : 마지막 주
					// start_day : 달의 시작 요일, last_day : 달의 마지막 요일
					//첫번째 주이고 시작요일보다 $j가 작거나 마지막주이고 $j가 마지막 요일보다 크면 표시하지 않아야하므로
					//    그 반대의 경우 -  ! 으로 표현 - 에만 날자를 표시한다.
					if (!(($i == 1 && $j < $start_wday) || ($i == $total_week && $j > $last_wday))) {
						if($j == 0){ // 0이면 일요일
							echo "<font color='#FF0000'><b>";
						}else if($j == 6){ // 6이면 토요일
							echo "<font color='#0000FF'><b>";
						}else{ // 평일
							echo "<font color='#000000'><b>";
						}

						// 오늘 날자면 밑줄
						if($today_yy == $yy && $today_mm == $mm && $day == date("j")){
							echo "<u>";
						}

						// 날짜 출력
						echo $day;

						if($today_yy == $yy && $today_mm == $mm && $day == date("j")){
							echo "</u>";
						}

						echo "</b></font> &nbsp;";

						//스케줄 출력
						//$schstr = get_schedule($yy,$mm,$day);
						echo $schstr;

						// 날짜 증가
						$day++;
					}?>
					</td>
				<?}?>
			</tr>
			<?}?>
		</table>
	</form>
</div>
</body>
</html>
<!--
<?
$yy = $_REQUEST['yy'];
$mm = $_REQUEST['mm'];
if($yy == '') $yy = date('Y');
if($mm == '') $mm = date('m');

function sel_yy($yy, $func) {
if($yy == '') $yy = date('Y');

if($func=='') {
$str = "<select name='yy'>\n<option value=''></option>\n";
} else {
$str = "<select name='yy' onChange='$func'>\n<option value=''></option>\n";
}
$gijun = date('Y');
for($i=$gijun-5;$i<$gijun+2;$i++) {
if($yy == $i) $str .= "<option value='$i' selected>$i</option>";
else $str .= "<option value='$i'>$i</option>";
}
$str .= "</select>";
return $str;
}

function sel_mm($mm, $func) {
if($func=='') {
$str = "<select name='mm'>\n";
} else {
$str = "<select name='mm' onChange='$func'>\n";
}
for($i=1;$i<13;$i++) {
if($mm == $i) $str .= "<option value='$i' selected>{$i}월</option>";
else $str .= "<option value='$i'>{$i}월</option>";
}
$str .= "</select>";
return $str;
}

function get_schedule($yy,$mm,$dd) {
$mm = str_pad($mm, 2, "0", STR_PAD_LEFT);
$dd = str_pad($dd, 2, "0", STR_PAD_LEFT);
$dtstr = $yy."-".$mm."-".$dd;
$sql = "SELECT *
FROM schedule
WHERE frdt <= '$dtstr' AND todt >= '$dtstr' ORDER BY frdt, todt";
$ret = dbquery($sql) or die(mysql_error());
while($row = dbfetch($ret)) {
$str .= "<font style='font-size:8pt;'>- $row[name]</font><br>";
}
return $str;
}


// 1. 총일수 구하기
$last_day = date("t", strtotime($yy."-".$mm."-01"));

// 2. 시작요일 구하기
$start_week = date("w", strtotime($yy."-".$mm."-01"));

// 3. 총 몇 주인지 구하기
$total_week = ceil(($last_day + $start_week) / 7);

// 4. 마지막 요일 구하기
$last_week = date('w', strtotime($yy."-".$mm."-".$last_day));
?>
<form name="form" method="get">
<table width='910' cellpadding='0' cellspacing='1' bgcolor="#999999">
<tr>
<td height="50" align="center" bgcolor="#FFFFFF" colspan="7">
<?=sel_yy($yy,'submit();')?>년 <?=sel_mm($mm,'submit();')?>월 <input type="submit" value="보기"></td>
</tr>
<tr>
<td width="130" height="30" align="center" bgcolor="#DDDDDD"><b>일</b></td>
<td width="130" align="center" bgcolor="#DDDDDD"><b>월</b></td>
<td width="130" align="center" bgcolor="#DDDDDD"><b>화</b></td>
<td width="130" align="center" bgcolor="#DDDDDD"><b>수</b></td>
<td width="130" align="center" bgcolor="#DDDDDD"><b>목</b></td>
<td width="130" align="center" bgcolor="#DDDDDD"><b>금</b></td>
<td width="130" align="center" bgcolor="#DDDDDD"><b>토</b></td>
</tr>

<?
$today_yy = date('Y');
$today_mm = date('m');
// 5. 화면에 표시할 화면의 초기값을 1로 설정
$day=1;

// 6. 총 주 수에 맞춰서 세로줄 만들기
for($i=1; $i <= $total_week; $i++){?>
<tr>
<?
// 7. 총 가로칸 만들기
for ($j=0; $j<7; $j++){
?>
<td width="130" height="120" align="left" valign="top" bgcolor="#FFFFFF">
<?
// 8. 첫번째 주이고 시작요일보다 $j가 작거나 마지막주이고 $j가 마지막 요일보다 크면 표시하지 않아야하므로
//    그 반대의 경우 -  ! 으로 표현 - 에만 날자를 표시한다.
if (!(($i == 1 && $j < $start_week) || ($i == $total_week && $j > $last_week))){

if($j == 0){
// 9. $j가 0이면 일요일이므로 빨간색
echo "<font color='#FF0000'><b>";
}else if($j == 6){
// 10. $j가 0이면 일요일이므로 파란색
echo "<font color='#0000FF'><b>";
}else{
// 11. 그외는 평일이므로 검정색
echo "<font color='#000000'><b>";
}

// 12. 오늘 날자면 굵은 글씨
if($today_yy == $yy && $today_mm == $mm && $day == date("j")){
echo "<u>";
}

// 13. 날자 출력
echo $day;

if($today_yy == $yy && $today_mm == $mm && $day == date("j")){
echo "</u>";
}

echo "</b></font> &nbsp;";

//스케줄 출력
//$schstr = get_schedule($yy,$mm,$day);
echo $schstr;

// 14. 날자 증가
$day++;
}
?>
</td>
<?}?>
</tr>
<?}?>
</table>
</form>
-->