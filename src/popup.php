<?php
include "connect.php";

print_r($_GET);
$start = date("Y-m-d", mktime(0, 0, 0, $_GET['m'], $_GET['d'], $_GET['y']));


echo $start;
?>
<script>
//var id = opener.$(".calcell").val(); //부모창에서 id가 parent인 태그의 val()
//$("#child").val(id);
</script>
<body>
	<form method="post" action="add_event.php">
		<div>
			<div>
			<input type="hidden" name="date" value="<?= $start ?>">
			날짜 | <?= $start ?></div>
			<div><input type="text" name="title"></div>
			<div><textarea name="memo"></textarea></div>
		</div>
		<input type="submit" value="저장">
	</form>
</body>