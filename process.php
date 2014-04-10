<?php require_once("header.php"); ?>
<?php
if(isset($_GET['bookid'])) {
    $id = $_GET['bookid'];
    echo $id;
    $time = new timeslot();
    $time->unbookTime($id);
} elseif(isset($_GET['unbkid'])) {
    $id = $_GET['unbkid'];
    echo $id;
    $time = new timeslot();
    $time->bookTime($id);
} elseif(isset($_GET['delid'])) {
    $id = $_GET['delid'];
    echo $id;
    $time = new timeslot();
    $time->deleteTime($id);
} elseif(isset($_POST['getusers'])){
    $user = $_POST['getusers'];
    $slot = $_POST['timeslot'];
    //echo $user;
    //echo $slot;
    //echo $_SESSION['id'];
    $time = new availability();
    $time ->bookTime($slot, $user);  
}
?>