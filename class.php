<?php
//The creation of the physical calandar system
class calendar {
    //Create the structure for the displayed month
    function mkMonth ($month) {
        $head = "<div class='fullwidth'>";
        $head .= "<div class='month'>";
        $head .= date("F", mktime(0,0,0,$month));
        $head .= "</div>";
        $head .= "<div id='jresult'>";
        $head .= "</div>";
        $head .= "<div id='week'>";
        $head .= "<table class='days'>";
        $head .= "<td>";
        $head .= "Sunday";
        $head .= "</td>";
        $head .= "</table>";
        $head .= "<table class='days'>";
        $head .= "<td>";
        $head .= "Monday";
        $head .= "</td>";
        $head .= "</table>";
        $head .= "<table class='days'>";
        $head .= "<td>";
        $head .= "Tuesday";
        $head .= "</td>";
        $head .= "</table>";
        $head .= "<table class='days'>";
        $head .= "<td>";
        $head .= "Wednesday";
        $head .= "</td>";
        $head .= "</table>";
        $head .= "<table class='days'>";
        $head .= "<td>";
        $head .= "Thursday";
        $head .= "</td>";
        $head .= "</table>";
        $head .= "<table class='days'>";
        $head .= "<td>";
        $head .= "Friday";
        $head .= "</td>";
        $head .= "</table>";
        $head .= "<table class='days'>";
        $head .= "<td>";
        $head .= "Saturday";
        $head .= "</td>";
        $head .= "</table>";
        $head .= "</div>";
        echo $head;
    }
    function mkDays ($numDays, $month, $year) {
        //Structure for days in month
        for ($i = 1; $i <= $numDays; $i++) {
            $eachDay[$i] = $i;   
        }
        foreach($eachDay as $day => &$wkday) {
            $wkday = date("w", mktime(0,0,0,$month,$day,$year));
        }
        foreach($eachDay as $day=>&$wkday) {
            echo "<table class='box' id=$day month=$month year=$year>";
            echo "<td>";
            echo $day;
            echo "</td>";
            echo "</table>";
        }
    }
    function emptyDays ($empty, $numDays, $month, $year) {
        //Fill in empty days before the beginning of the month
        for ($i = 1; $i <= $numDays; $i++) {
            $eachDay[$i] = $i;   
        }
        foreach($eachDay as $day => &$wkday) {
            $wkday = date("w", mktime(0,0,0,$month,$day,$year));
        }
        if ($eachDay[1] == 1) {
            echo $empty;
        } elseif ($eachDay[1] == 2) {
            echo $empty;
            echo $empty;
        } elseif ($eachDay[1] == 3) {
            echo $empty;
            echo $empty;
            echo $empty;
        } elseif ($eachDay[1] == 4) {
            echo $empty;
            echo $empty;
            echo $empty;
            echo $empty;
        } elseif ($eachDay[1] == 5) {
            echo $empty;
            echo $empty;
            echo $empty;
            echo $empty;
            echo $empty;
        } elseif ($eachDay[1] == 6) {
            echo $empty;
            echo $empty;
            echo $empty;
            echo $empty;
            echo $empty;
            echo $empty;
        } else {         
        }
    }
}

//The database connection
class connection {
    //Create initial database connection, and clear out expired rows from table
    var $host = "localhost";
    var $dbname = "book.me";
    var $user = "root";
    var $pass = "";
    
    function __construct() {
        $this->connect();
        $this->clear();
    }
    
    function connect() {
        try {
            $this->dbh = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->user, $this->pass);
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            //echo "you've connected to the database!";
            //var_dump($this->dbh);
            
        } catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }
    function clear () {
            $clear = $this->dbh->prepare("DELETE FROM time_slots WHERE timestamp < NOW() AND timestamp IS NOT NULL");
            $clear->execute();
    }
}
//The availability class manages the available time slots on the calandar
class availability extends connection{
    
    function getTime ($day, $month, $year) {
        try {
            $data = $this->dbh->prepare("SELECT * FROM time_slots WHERE DAY(timestamp) = :day AND MONTH(timestamp) = :month AND YEAR(timestamp) = :year AND is_booked = 0");
            $data->execute(array('month' => $month,
                                 'day' => $day,
                                 'year' => $year));
            $count = $data->rowCount();

            if ($count != 0) {
                $form = "<form method='POST' name='formtime' action='book.php'>";
                $form .= "<select name='gettime'>";
                    while ($row = $data->fetch(PDO::FETCH_ASSOC)) {
                        $times[] = $row;
                    }
                    foreach ($times as $time) {
                        $value = date('h:i a', strtotime($time['timestamp']));
                        $select = $time['timestamp'];
                        $form .= "<option value='$select'>" . $value . "</option>";
                    }
                $form .= "</select>";
                $form .= "<input type='submit' name='subtime' value='book slot'></form>";
                echo $form;
            } 
        }
        catch(PDOException $e) {
                    //echo 'ERROR: ' . $e->getMessage();
                    //echo "could not return data!";
        }
    }
    
    function findTime ($day, $month, $year) {
        try {
            $data = $this->dbh->prepare("SELECT * FROM time_slots WHERE DAY(timestamp) = :day AND MONTH(timestamp) = :month AND YEAR(timestamp) = :year");
            $data->execute(array('month' => $month,
                                 'day' => $day,
                                 'year' => $year));
            $count = $data->rowCount();
        }
        catch(PDOException $e) {
                    //echo 'ERROR: ' . $e->getMessage();
                    //echo "could not return data!";
        }
    }
    
    function bookTime ($time, $user = 0){
        if (isset($_SESSION['id']) && !isset($_POST['getusers'])) {
                    $custId = $_SESSION['id'];
            try {
                $data = $this->dbh->prepare("UPDATE time_slots SET is_booked = 1, cust_id = :id WHERE timestamp = :time");
                $data->execute(array('time' => $time,
                                     'id' => $custId
                                     ));
                echo "Your time is now booked! Look forward to seeing you!";
                echo "</br>";
                echo "Return to the <a href='month.php'>calendar.</a>";
            }
            catch(PDOException $e) {
                        echo 'ERROR: ' . $e->getMessage();
                        //echo "could not return data!";
            }
        } elseif (isset($_POST['getusers'])) {
                $custId = $user;
            try {
                $data = $this->dbh->prepare("UPDATE time_slots SET is_booked = 1, cust_id = :id WHERE time_id = :time");
                $data->execute(array('time' => $time,
                                     'id' => $custId
                                     ));
                echo "Time slot booking successful!";
                echo "</br>";
                echo "Return to the <a href='panel.php'>panel.</a>";
            }
            catch(PDOException $e) {
                        echo 'ERROR: ' . $e->getMessage();
                        //echo "could not return data!";
            }
        }
    }
}

//The timeslot class manages the time slots in the database
class timeslot extends connection {
    
    function addTime($start, $end, $strtday, $endday, $strtmonth, $endmonth, $strtyear, $endyear, $intvnum) {
        //set variables
        //converts dates to julian for comparison
        $datestrt = gregoriantojd($strtmonth, $strtday, $strtyear);
        $dateend = gregoriantojd($endmonth, $endday, $endyear);
        $srttime = date("H:i:s", $start);
        $endtime = date("H:i:s", $end);
        $intv = $intvnum;
        //iterate through each day as specified by user
        for ($i = $datestrt; $i <= $dateend; $i++) {
            $atime = date("d", strtotime(jdtogregorian($i)));
            $nwstrtday = date("Y-m-d", mktime(0,0,0,$strtmonth,$atime,$strtyear));
            $nwendday = date("Y-m-d", mktime(0,0,0,$endmonth,$atime,$endyear));
            //create objects to store day/time information
            $startdate    = new DateTime($nwstrtday . ' ' . $srttime);
            $enddate      = new DateTime($nwendday . ' ' . $endtime);
            //set the interval
            $interval = new DateInterval('PT' . $intv . 'M');
            //store set of times for day
            $period   = new DatePeriod($startdate, $interval, $enddate);
            
            //iterate through time blocks
            foreach ($period as $dt)
            {
                $nwyear = $dt->format('Y');
                $nwmonth = $dt->format('m');
                $nwdate = $dt->format('d');
                $nwtime = $dt->format('H:i:s');
                // convert for mysql timestamp
                $newFormat = date("Y-m-d H:i:s", strtotime($nwyear . "-" . $nwmonth . "-" . $nwdate . " " . $nwtime));
                //echo $newFormat;
                //echo "<br/>";
                try {
                    $data = $this->dbh->prepare('INSERT INTO time_slots (timestamp) VALUES (:stamp)');
                    $exec = $data->execute(array('stamp'=>$newFormat));
                    }
                    catch(PDOException $e) {
                        //echo 'ERROR: ' . $e->getMessage();
                    }
            }
        }
        if ($exec) {
            echo "Time slots added!";
            echo "<input type='button' value='Back to Panel'>";
        } else {
            echo "Unable to add time slots!";
            echo "<input type='button' value='Back to Panel'>";
        }
    }
    function listBooked() {
        
    try {
            $data = $this->dbh->prepare("SELECT t2.l_name, t2.f_name, t1.time_id, t1.timestamp, t1.cust_id FROM time_slots t1 INNER JOIN customers t2 ON t1.cust_id = t2.cust_id");
            $data->execute();
            $count = $data->rowCount();

            if ($count != 0) {
                $form = "<form method='POST' name='formtime' action=''>";
                $form .= "<div id='listtable' name='listtime'>";
                $form .= "<table>";
                    while ($row = $data->fetch(PDO::FETCH_ASSOC)) {
                        $times[] = $row;
                    }
                    foreach ($times as $time) {
                        $value = "<span class='rowelmnt'><p>";
                        $value .= implode(" </p></span><span class='rowelmnt'><p> ", $time) . "</p></span>";
                        $select = $time['time_id'];
                        $form .= "<tr><div class='bookedrow' id='$select'>" . $value . "</div></tr>";
                    }
                $form .= "</table>";
                $form .= "</div>";
                echo $form;
            } 
        }
        catch(PDOException $e) {
                    //echo 'ERROR: ' . $e->getMessage();
                    //echo "could not return data!";
        }
    }
    
    function listUnbooked() {
    
    try {
            $data = $this->dbh->prepare("SELECT time_id, timestamp FROM time_slots WHERE is_booked = 0");
            $data->execute();
            $count = $data->rowCount();

            if ($count != 0) {
                $form = "<form method='POST' name='formtime' action=''>";
                $form .= "<div id='listtable' name='listtime'>";
                $form .= "<table>";
                    while ($row = $data->fetch(PDO::FETCH_ASSOC)) {
                        $times[] = $row;
                    }
                    foreach ($times as $time) {
                        $value = "<span class='rowelmnt'><p>";
                        $value .= implode(" </p></span><span class='rowelmnt'><p> ", $time) . "</p></span>";
                        $select = $time['time_id'];
                        if (isset($_POST['book'])) {
                        $form .= "<tr><div class='unbookedrow' id='$select'>" . $value . "</div></tr>";
                        } elseif (isset($_POST['delete'])){
                        $form .= "<tr><div class='deletablerow' id='$select'>" . $value . "</div></tr>";
                        }
                    }
                $form .= "</table>";
                $form .= "</div>";
                echo $form;
            }
        }
        catch(PDOException $e) {
                    //echo 'ERROR: ' . $e->getMessage();
                    //echo "could not return data!";
        }
    }
    
    function bookTime($id) {
        try {
            $data = $this->dbh->prepare("SELECT * FROM time_slots WHERE time_id = :id");
            $data->execute(array(
                                 'id' => $id
                                 ));
            $count = $data->rowCount();
            echo $count;
            if ($count == 1) {
                $users = new users();
                $users->listUsers($id);
            }
        
        } catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }
    
    function unbookTime($id) {
        echo "function called";
        try {
            $data = $this->dbh->prepare("UPDATE time_slots SET is_booked = 0, cust_id = NULL WHERE time_id = :id");
            $data->execute(array(
                                 'id' => $id
                                 ));
            if ($data) {
                echo "Session successfully unbooked!";
            } else {
                echo "Unable to unbook selected session!";
            }
        }
        catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }
    
    function deleteTime($id) {
        try {
            $data = $this->dbh->prepare("DELETE FROM time_slots WHERE time_id = :id");
            $data->execute(array(
                                 'id' => $id
                                 ));
        }
        catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }
}

//The users class manages users and administrators
class users extends connection {
    function register ($username, $password, $fname, $lname, $email) {
        try {
                    $data = $this->dbh->prepare('INSERT INTO customers (username, password, f_name, l_name, email) VALUES (:user, :pass, :fname, :lname, :email)');
                    $exec = $data->execute(array('user'=>$username,
                                                 'pass'=>$password,
                                                 'fname'=>$fname,
                                                 'lname'=>$lname,
                                                 'email'=>$email
                                                 ));
                    header("location:login.php");
        }
        catch(PDOException $e) {
                        echo 'ERROR: ' . $e->getMessage();
        }
    }
    function login ($user, $pass) {
        try {
                    $pass = md5($pass);
                    $data = $this->dbh->prepare('SELECT * FROM customers WHERE username = :user AND password = :pass');
                    $exec = $data->execute(array('user'=>$user,
                                                 'pass'=>$pass
                                                 ));
                    $count = $data->rowCount();
                        if ($count != 0) {
                            while ($row = $data->fetch(PDO::FETCH_ASSOC)) {
                                $users[] = $row;
                            }
                            foreach($users as $user) {
                                $_SESSION['fname'] = $user['f_name'];
                                $_SESSION['lname'] = $user['l_name'];
                                $_SESSION['user'] = $user['username'];
                                $_SESSION['id'] = $user['cust_id'];
                            }
                            header("location:month.php");
                        } else {
                            echo "<center>Sorry, your login credentials are incorrect. Not registered? <a href='register.php'>Register here.</a></center>";
                            echo "</br><center>Or, if you forgot your password/username, you can recover your information <a href=''>here.</a></center>";
                        }
            } 
                    catch(PDOException $e) {
                        //echo 'ERROR: ' . $e->getMessage();
        }
                
    }
    function listUsers ($slot) {
        try {
            $form = "<form method='POST' name='formusers' action='process.php'>";
            $form .= "SELECT A USER TO BOOK:";
            $form .= "<input type='hidden' name='timeslot' value='" . $slot . "'>";
            $form .= "<select name='getusers'>";
            $data = $this->dbh->prepare("SELECT * FROM customers");
            $data->execute();
            while ($row = $data->fetch(PDO::FETCH_ASSOC)) {
                $users[] = $row;
            }
        
            foreach ($users as $user) {
                $value = $user['username'];
                $user_id = $user['cust_id'];
                $form .= "<option value='$user_id'>" . $value . "</option>";
            }
            $form .= "</select>";
            $form .= "<input type='submit' name='book_user_sub' value='Book User'></input>";
            $form .= "</form>";
            echo $form;
        } catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }
    function manage() {
        try {
            $data = $this->dbh->prepare("SELECT cust_id, username FROM customers WHERE is_admin = 0");
            $data->execute();
            $count = $data->rowCount();
            if ($count != 0) {
                $form = "<form method='POST' name='formtime' action=''>";
                $form .= "<div id='listtable' name='listtime'>";
                $form .= "<table>";
                    while ($row = $data->fetch(PDO::FETCH_ASSOC)) {
                        $users[] = $row;
                    }
                    foreach ($users as $user) {
                        print_r($user);
                        $value = "<span class='rowelmnt'><p>";
                        $value .= implode(" </p></span><span class='rowelmnt'><p> ", $user) . "</p></span>";
                        $select = $user['cust_id'];
                        if (isset($_POST['manage'])) {
                        $form .= "<tr><div class='unbookedrow' id='$select'>" . $value . "</div></tr>";
                        }
                        //} elseif (isset($_POST['delete'])){
                        //$form .= "<tr><div class='deletablerow' id='$select'>" . $value . "</div></tr>";
                        //}
                    }
                $form .= "</table>";
                $form .= "</div>";
                echo $form;
            }
        }
        catch(PDOException $e) {
                    //echo 'ERROR: ' . $e->getMessage();
                    //echo "could not return data!";
        }
    }
    
}
?>