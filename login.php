<?php
    session_start();

    function verify_login($email, $password){
        $con = mysqli_connect("localhost", "root", "", "aqi");

        if (!$con) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "SELECT email, pass FROM user WHERE email = '$email'";
        $result = mysqli_query($con, $sql);

        if (mysqli_num_rows($result) == 0){
            mysqli_close($con);
            return false;
        }

        $row = mysqli_fetch_assoc($result);

        if($password != $row['pass']){
            mysqli_close($con);
            return false;
        }

        mysqli_close($con);
        return true;
    }


    function verify_submit($email, $password){
        if($email == ""){
            return false;
        }else if($password == ""){
            return false;
        }
        return true;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $email = $_POST['login-email'];
        $loginpass = $_POST['login-password'];

        if (verify_submit($email, $loginpass) && verify_login($email, $loginpass)) {
            $_SESSION['email'] = $email;
            header("Location: request.php");
            exit();
        } else {
            header("Location: Index.php?error=" . urlencode("Login failed"));
            exit();
        }

    }else{
        echo "<h3 style='color:red;'>Can't be accessed. Redirecting to index page...</h3>";
        header("Refresh: 3; url=Index.php");
        exit();
    }

?>