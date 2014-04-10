<?php require_once("header.php"); ?>
<form method="post" name="panel" class="form" action="">
<table class="table">
<tr><td><input type="submit" name="add" value="Add Time Slots"></td></tr>
<tr><td><input type="submit" name="book" value="Book Time Slots"></td></tr>
<tr><td><input type="submit" name="unbook" value="Unbook Time Slots"></td></tr>
<tr><td><input type="submit" name="delete" value="Delete Time Slots"></td></tr>
<tr><td><input type="submit" name="manage" value="Manage Customers"></td></tr>
</table>
</form>

<?php
if (isset($_POST['add'])) {
    header('location:addtime.php');

} elseif (isset($_POST['book'])) {
    echo "<br>";
    $times = new timeslot();
    $times->listUnbooked();
    echo "<div id='selected'>";
    echo "</div>";
} elseif (isset($_POST['unbook'])) {
    echo "<br>";
    $times = new timeslot();
    $times->listBooked();
    echo "<div id='selected'>";
    echo "</div>";
} elseif (isset($_POST['delete'])) {
     echo "<br>";
    $times = new timeslot();
    $times->listUnbooked();
    echo "<div id='selected'>";
    echo "</div>";
} elseif (isset($_POST['manage'])) {
    echo "<br>";
    $users = new users();
    $users->manage();
    echo "<div id='selected'>";
    echo "</div>";
}
?>