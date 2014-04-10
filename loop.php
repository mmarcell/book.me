<?php require_once("header.php"); ?>
<?php
$month = $_POST['getmonth'];
$year = date("Y");
$numDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
$empty = "<table class='box'><td>&nbsp</td></table>";
$cal = new calendar();
$cal->mkMonth($month);
$cal->emptyDays($empty, $numDays, $month, $year);
$cal->mkDays($numDays, $month, $year);
echo "<br>";
?>
</body>
</html>


