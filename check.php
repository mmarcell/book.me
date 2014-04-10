<?php require_once("header.php"); ?>
<?php
if($_GET['date'] && $_GET['month'] && $_GET['year']) {
$id = $_GET['date'];
$month = $_GET['month'];
$year = $_GET['year'];
$avail = new availability();
$avail->findTime($id, $month, $year);
}
?>