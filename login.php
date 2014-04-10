<?php require_once("header.php"); ?>
 
<form method="POST" name="loginform" action="" class="form">
        <table class="table">
            
            <tr>
                <td>
                    Please log in to use our booking system.
                </td>
            </tr>
            
            <tr>
                <td>
                    <label name="fname">Username:</label>
                    <input type="text" name="user"></input>
                </td>
            </tr>
        
            <tr>
                <td>
                    <label name="lname">Password:</label>
                    <input type="password" name="pass"></input>
                </td>
            </tr>
        
            <tr>
                <td>
                    <input type="submit" name="login" value="Log In"></input>
                </td>
            </tr>
        
        </table>
</form>

<?php
if(isset($_POST['login'])) {
    if(isset($_POST['user']) && isset($_POST['pass'])){
        $user = $_POST['user'];
        $pass = $_POST['pass'];
        $login = new users();
        $login->login($user, $pass);
    }
}
?>
</body>
</html>
