<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
    body {
    font-family: 'Arial', sans-serif;
    background-color: #f4f7f9;
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0;
    padding: 0;
}

.form-box {
    background-color: #ffffff;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
    width: 450px;
    text-align: center;
    animation: fadeIn 0.5s ease-in-out;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

#details {
    color: #2c3e50;
    margin-bottom: 20px;
}

.label {
    display: inline-block;
    width: 150px;
    text-align: right;
    color: #34495e;
    font-weight: 500;
    margin-right: 15px;
    vertical-align: top;
}

.button {
    padding: 12px 25px;
    margin: 10px 5px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 16px;
    font-weight: 600;
    transition: transform 0.2s, background-color 0.2s;
    display: inline-block; /* Remove box confinement */
}

#first_btn {
    background-color: #3498db;
    color: #ffffff;
}

#sec_btn {
    background-color: #e74c3c;
    color: #ffffff;
}

.button:hover {
    transform: scale(1.05);
}

#first_btn:hover {
    background-color: #2980b9;
}

#sec_btn:hover {
    background-color: #c0392b;
}

br {
    line-height: 1.5;
}
    </style>
</head>
<body>
<?php
function verify($email, $con) {
    $stmt = $con->prepare("SELECT email FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows > 0; // Returns true if email exists, false otherwise
}

function add_to_db($city, $email, $zip, $loc, $color, $pass) {
    $con = mysqli_connect("localhost", "root", "", "aqi");

    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Use prepared statements to prevent SQL injection
    $stmt = $con->prepare("INSERT INTO user (email, pass, division, city, zip, color) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $email, $pass, $city, $loc, $zip, $color);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "<h3 style='color:green;'>Registration successful!</h3>";
    } else {
        echo "<h3 style='color:red;'>Error registering user.</h3>";
    }

    $stmt->close();
    mysqli_close($con);
}

function add_cookie($color) {
    // Example cookie-setting function (modify as needed)
    setcookie("user_color", $color, time() + (86400 * 30), "/"); // Cookie lasts 30 days
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['submit'])) {
        session_start();
        $_SESSION['uemail'] = $_POST['uemail'];
        $_SESSION['pass'] = $_POST['pass'];
        $_SESSION['loc'] = $_POST['loc'];
        $_SESSION['zip'] = $_POST['zip'];
        $_SESSION['color'] = $_POST['color'];
        $_SESSION['city'] = $_POST['city'];

        echo "<div class='form-box'>";
        echo "<div id='details'><h2>User Details</h2></div>";
        echo "<div class='label'>Email: </div>" . htmlspecialchars($_POST['uemail']) . "<br><br>";
        echo "<div class='label'>Password: </div>" . htmlspecialchars($_POST['pass']) . "<br><br>";
        echo "<div class='label'>Location: </div>" . htmlspecialchars($_POST['loc']) . "<br><br>";
        echo "<div class='label'>Zipcode: </div>" . htmlspecialchars($_POST['zip']) . "<br><br>";
        echo "<div class='label'>Division: </div>" . htmlspecialchars($_POST['city']) . "<br><br>";
        echo "<div class='label'>Favourite Color: </div>" . htmlspecialchars($_POST['color']) . "<br><br>";

        echo "<form method='post' class='form-box'>";
        echo "<input type='hidden' name='uemail' value='" . htmlspecialchars($_POST['uemail']) . "'>";
        echo "<input type='hidden' name='pass' value='" . htmlspecialchars($_POST['pass']) . "'>";
        echo "<input type='hidden' name='loc' value='" . htmlspecialchars($_POST['loc']) . "'>";
        echo "<input type='hidden' name='zip' value='" . htmlspecialchars($_POST['zip']) . "'>";
        echo "<input type='hidden' name='color' value='" . htmlspecialchars($_POST['color']) . "'>";
        echo "<input type='hidden' name='city' value='" . htmlspecialchars($_POST['city']) . "'>";
        echo "<input type='submit' class='button' id='sec_btn' name='cancel' value='Cancel'>";
        echo "<input type='submit' class='button' id='first_btn' name='confirm' value='Confirm'>";
        echo "</form>";
        echo "</div>";
        exit();
    } elseif (isset($_POST['confirm'])) {
        $con = mysqli_connect("localhost", "root", "", "aqi");
        if (!$con) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $email = $_POST['uemail'];
        if (verify($email, $con)) {
            echo "<h3 style='color:red;'>This email is already registered. Please use a different email.</h3>";
            header("Refresh: 2; url=Index.php");
            mysqli_close($con);
            exit();
        }

        add_to_db($_POST['city'], $_POST['uemail'], $_POST['zip'], $_POST['loc'], $_POST['color'], $_POST['pass']);
        add_cookie($_POST['color']);
        header("Refresh: 2; url=Index.php");
        mysqli_close($con);
        exit();
    } elseif (isset($_POST['cancel'])) {
        header("Location: Index.php");
        exit();
    }
} else {
    echo "No data is showing";
}
?>
</body>
</html>