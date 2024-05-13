<?php
// Database connection
$servername = "localhost"; // Change this if your MySQL server is running on a different host
$username = "root"; // Change this to your MySQL username
$password = ""; // Change this to your MySQL password
$dbname = "localvh_db"; // Change this to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Define variables and initialize with empty values
$name = $email = $phn = $password = "";
$name_err = $email_err = $phn_err = $password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate name
    if (empty(trim($_POST["name"]))) {
        $name_err = "Please enter your name.";
    } else {
        $name = trim($_POST["name"]);
    }

    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter your email.";
    } elseif (!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)) {
        $email_err = "Invalid email format.";
    } else {
        $email = trim($_POST["email"]);
    }

    // Validate mobile number
    if (empty(trim($_POST["phn"]))) {
        $phn_err = "Please enter your mobile number.";
    } elseif (!preg_match("/^[0-9]{10}$/", trim($_POST["phn"]))) {
        $phn_err = "Invalid mobile number format.";
    } else {
        $phn = trim($_POST["phn"]);
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 8) {
        $password_err = "Password must have at least 8 characters.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Check input errors before inserting into database
    if (empty($name_err) && empty($email_err) && empty($phn_err) && empty($password_err)) {

        // Prepare an insert statement
        $sql = "INSERT INTO users_acc (name, email, phn, password) VALUES (?, ?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("ssss", $param_name, $param_email, $param_mobile_number, $param_password);

            // Set parameters
            $param_name = $name;
            $param_email = $email;
            $param_mobile_number = $mobile_number;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Redirect to login page
                header("location: login.php");
                exit;
            } else {
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }

    // Close connection
    $conn->close();
}
?>
