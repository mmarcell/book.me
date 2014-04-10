<?php
require_once("header.php");
if (isset($_POST['subtime'])) {
$time = $_POST['gettime'];
$book = new availability();
$book->bookTime($time);
}
?>