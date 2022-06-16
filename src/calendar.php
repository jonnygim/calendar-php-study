<?php
include "connect.php";

/*if (!isset($cellh))
    $cellh = 70; // date cell height
    if (!isset($tablew))
    $tablew = 650; //table width*/
$cellw = 130;


//---- 오늘 날짜
$thisyear = date('Y'); // 4자리 연도
$thismonth = date('n'); // 0을 포함하지 않는 월
$today = date('j'); // 0을 포함하지 않는 일

// $year, $month 값이 없으면 현재 날짜
$year = isset($_GET['year']) ? $_GET['year'] : $thisyear;
$month = isset($_GET['month']) ? $_GET['month'] : $thismonth;
$day = isset($_GET['day']) ? $_GET['day'] : $today;

//------ 날짜의 범위 체크
if (($year > 2038) or ($year < 1900))
	alertE("연도는 1900 ~ 2038년만 가능합니다.");

$last_day = date('t', mktime(0, 0, 0, $month, 1, $year)); // 해당월의 총일수 구하기 t = 주어진 달에 일 수

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


$sql = "SELECT * FROM `calendar` WHERE MONTH(`start`) =".$month;
$result = mysqli_query($con, $sql);
while ($row = mysqli_fetch_array($result)) {
    $schedule[] = array(0 => date("n-j", strtotime($row['start'])),
								1 => date("n-j", strtotime($row['end'])),
								2 => $row['title'],
								3 => $row['idx']);
}

?>

<!DOCTYPE html>
<html lang="ko">
<head>
	<title>Calendar</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<style>
		body{margin-top: 20px; }
		.all {border-width: 1;border-color: #cccccc;border-style: solid;}
		font {font-family: 굴림체;font-size: 12px;color: #505050;    }
		font.title {font-family: 굴림체;font-size: 12px;font-weight: bold;color: #2579CF;    }
		font.week {font-family: 돋움,돋움체;color: #ffffff;font-size: 8pt;    letter-spacing: -1;}
		font.holy {font-family: tahoma;font-size: 22px;color: #FF6C21;}
		font.blue {font-family: tahoma;font-size: 22px;color: #0000FF;}
		font.black {font-family: tahoma;font-size: 22px;color: #000000;}
		font.sblue {font-family: tahoma;font-size: 14px;color: blue;    }
		font.red {font-family: tahoma;font-size: 14px;color: red;}
		font.num {font-family: tahoma;font-size: 14px;background-color: #DBA901;}
		font.gray {font-family: tahoma;font-size: 14px;color: #bbbbbb;}
		.main {float: left;width: 70%;border: 5px solid #ccc;background-color: #fff;m }
		.right {float: right;width: 20%;background-color: #fff;border: 5px solid #eee;}
		.cellh {height: 100;}
		.head {text-align: center;}
		.info th {width: 14%; text-align: center;}
	</style>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<script>
		$(function() {
			/* $(".calcell").click(function(){
				var val=$(this).attr("id");
				var date = val.split('-');
				var year = date[0];
				var month = date[1];
				var day = date[2];
				var title = prompt('Event Title:');
				$.ajax({
					url : 'add_event.php',
					type : 'POST',
					data :{year:date[0],month:date[1],day:date[2],title:title},
					success : function(data){
						if(data == 1){
							location.reload();
						} else if(data == 0) {
							alert('등록에 실패했습니다.');
						}
					},
					error: function(jqXHR, textStatus, errorThrown){
						alert("arjax error : " + textStatus + "\n" + errorThrown);
					}
				});
			});*/
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

			/*$(".num").click(function(e){
				var val=$(this).attr("uid");
				var deleteMsg = confirm("정말 삭제하시겠습니까?");
				if(deleteMsg){
					$.ajax({
						url : 'delete_event.php',
						type : 'POST',
						data :{id:val},
						success: function (data) {
							if(data == 1){
								location.reload();
							} else if(data == 0) {
								alert('삭제에 실패했습니다.');
							}
						}
					});
				}
			});*/
		});
	</script>
</head>
<body>
<div class="container">
	<table class="table table-bordered table-responsive">
		<tr class="head">
			<td>
				<a href=<?php echo 'calendar.php?year='.$pre_year.'&month='.$month . '&day=1'; ?>>◀◀</a>
			</td>
			<td>
				<a href=<?php echo 'calendar.php?year='.$prevyear.'&month='.$prevmonth . '&day=1'; ?>>◀</a>
			</td>
			<td height="50" bgcolor="#FFFFFF" colspan="3">
				<a href=<?php echo 'calendar.php?year=' . $thisyear . '&month=' . $thismonth . '&day=1'; ?>>
				<?php echo "&nbsp;&nbsp;" . $year . '년 ' . $month . '월 ' . "&nbsp;&nbsp;"; ?></a>
			</td>
			<td>
				<a href=<?php echo 'calendar.php?year='.$nextyear.'&month='.$nextmonth.'&day=1'; ?>>▶</a>
			</td>
			<td>
				<a href=<?php echo 'calendar.php?year='.$next_year.'&month='.$month.'&day=1'; ?>>▶▶</a>
			</td>
		</tr>
		<tr class="info">
			<th>일</td>
			<th>월</th>
			<th>화</th>
			<th>수</th>
			<th>목</th>
			<th>금</th>
			<th>토</th>
		</tr>
		<tr class="cellh">
			<?php
				$date = 1; // 1일
				$offset = 0;
				$ck_row = 0;
				//프레임 사이즈 조절을 위한 체크인자
				$R = array();

				while ($date <= $last_day) { // 1일 부터 해당 월의 총 일수까지
					$mday = $date;

					if ($date == '1') { // 1일이면
						// 시작 요일 구하기 : date("w", strtotime($year."-".$month."-01"));
						$offset = date('w', mktime(0, 0, 0, $month, $date, $year)); // 0: 일요일, 6: 토요일
						SkipOffset($offset, mktime(0, 0, 0, $month, $date, $year));
					}

					if ($offset == 0)
						$style = "holy"; // 일요일 빨간색으로 표기
					else if($offset == 6)
						$style = "blue"; // 토요일 빨간색 또는 파란색
					else
						$style = "black";

					// 사용자 일정 데이터
				    $dType1 = array();
					for ($i = 0; $i < count($schedule); $i++) { // 0, 1, 2, 3
						if ($schedule[$i][0] == "$month-$date") {
							$dType1[] = array(0=>$schedule[$i][2], 1=>$schedule[$i][3]);
							// 0 = 월-일, [2]  |  1 = 월-일, [3]
						}
					}

					if ($date == $today && $year == $thisyear && $month == $thismonth) { // 오늘 날짜
						echo "<td valign=top bgcolor=#99FFFF class='calcell' id='".$year."-".$month."-".$mday."'>";
					} else {
						//echo "<td valign=top class='calcell' id='calcell'>";
						echo "<td valign=top class='calcell' id='".$year."-".$month."-".$mday."'>";
					}
						CalendarPrint($style,$mday,$dType1);
						echo "</td>\n";

					$date++; // 날짜 증가
					$offset++;
					if ($offset == 7) {
						echo "</tr>";
						if ($date <= $last_day) {
							echo "<tr class='cellh'>";
							$ck_row++;
						}
						$offset = 0;
					}

				}// end of while

				if ($offset != 0) {
					SkipOffset((7 - $offset), '', mktime(0, 0, 0, $month + 1, 1, $year));
					echo "</tr>\n";
				}
				echo("</td>\n");

				function ErrorMsg($msg) {
					echo " <script>window.alert('$msg');history.go(-1);</script>";
					exit;
				}

				function CalendarPrint($style,$mday,$dType1=''){
					echo "<font class=".$style.">$mday</font><br/>";
					if(count($dType1)>0) { // 배열 출력
						for ($i = 0; $i < count($dType1); $i++) {
							echo "<font class=num uid=".$dType1[$i][1].">".$dType1[$i][0]."</font><br/>";
						}
					}
				}

				function SkipOffset($no, $sdate = '', $edate = '') {
					for ($i = 1; $i <= $no; $i++) {
						$ck = $no - $i + 1;
						if ($sdate)
							$num = date('n.j', $sdate - (3600 * 24) * $ck);
						if ($edate)
							$num = date('n.j', $edate + (3600 * 24) * ($i - 1));

						echo "<td valign=top><font class=gray>$num</font></td>";
					}
				}

				function isWeekend($date){
					// 앙력 날짜의 요일을 리턴
					// 일요일 0 토요일 6
					return date("w", strtotime($date));
				}

			?>
		</tr>
	</table>
</div>
</body>
</html>