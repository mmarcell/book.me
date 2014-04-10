<!DOCTYPE html>
    
<html>
<head>
    <title>Add Time Slots</title>
    <link rel="stylesheet" href="style.css" type="text/css">
</head>

<body>
<?php require_once("class.php"); ?>
<form method="POST" id="gettime" action="" class="form">
    
    <table class="table">
    
    <tr>
    <td>Start Date</td>
    <td><input type="date" name="stdate"></td>
    </tr>
    
    <tr>
    <td>End Date</td>
    <td><input type="date" name="enddate"></td>
    </tr>
    
    <tr>
    <td>Start Time</td>
    <td><input type="time" name="sttime"></td>
    </tr>
    
    <tr>
    <td>End Time</td>
    <td><input type="time" name="endtime"></td>
    </tr>
        
    <tr>
    <td>Time (minute) Interval</td>
    <td>
    <select name="int">
        <option value="10">10</option>
        <option value="20">20</option>
        <option value="30">30</option>
        <option value="45">45</option>
        <option value="60">60</option>
        <option value="90">90</option>
        <option value="120">120</option>
    </select>
    </td>
    </tr>
    <tr>
    <td>
    <input type="submit" name="submit" />
    </td>
    </tr>
    </table>
</form>
<?php
if (isset($_POST['submit'])) {
    if (isset($_POST['stdate']) && isset($_POST['enddate']) && isset($_POST['sttime']) && isset($_POST['endtime']) && isset($_POST['int'])) {
    $stday = date("d", strtotime($_POST['stdate']));
    $stmo = date("m", strtotime($_POST['stdate']));
    $styr = date("Y", strtotime($_POST['stdate']));
    $endday = date("d", strtotime($_POST['enddate']));
    $endmo = date("m", strtotime($_POST['enddate']));
    $endyr = date("Y", strtotime($_POST['enddate']));
    $sttime = strtotime($_POST['sttime']);
    $endtime = strtotime($_POST['endtime']);
    $int = $_POST['int'];
    $time = new timeslot();
    $time->addTime($sttime, $endtime, $stday, $endday, $stmo, $endmo, $styr, $endyr, $int);
    } else {
        echo "You must fill in all fields to book a time slot";
    }
}
?>

</body>
</html>
