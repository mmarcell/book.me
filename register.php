<?php require_once("header.php"); ?>
<form method="POST" name="regform" action="" class="form">
<tr>
<td>
Please register for our booking system before logging in.
<center>Already a member? Log in <a href="login.php">here.</a></center>
</td>
</tr>
</br>

<table class="table">    
<tr>
<td>
<label name="fname">First Name:</label>
</td>
<td>
<input type="text" name="fname"></input>
</td>
</tr>

<tr>
<td>
<label name="lname">Last Name:</label>
</td>
<td>
<input type="text" name="lname"></input>
</td>
</tr>

<tr>
<td>
<label name="email">Email:</label>
</td>
<td>
<input type="text" name="email"></input>
</td>
</tr>

<tr>
<td>
<label name="fname">Username:</label>
</td>
<td>
<input type="text" name="username"></input>
</td>
</tr>

<tr>
<td>
<label name="fname">Password:</label>
</td>
<td>
<input type="password" name="password"></input>
</td>
</tr>

<tr>
<td>
<input type="submit" name="register" value="register me"></input>
</td>
</tr>

</table>
</form>

<?php
if(isset($_POST['register'])) {
    if($_POST['username'] != '' && $_POST['password'] != '' && $_POST['fname'] != '' && $_POST['lname'] != '' && $_POST['email'] != ''){
        $user = $_POST['username'];
        $pass = md5($_POST['password']);
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $entry = new users();
        $entry->register($user, $pass, $fname, $lname, $email);
    } else {
        echo "</br>";
        echo "<center>Please complete all fields to fully register for this application!</center>";
    }
}
?>
</body>
</html>
