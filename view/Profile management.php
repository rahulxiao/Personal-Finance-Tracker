<?php
$errors = [];
$fname = $lname = $age = $gender = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   if (empty(trim($_POST["fname"]))) {
        $errors[] = "First name is required.";
    } else {
        $fname = htmlspecialchars(trim($_POST["fname"]));
    }

    if (empty(trim($_POST["lname"]))) {
        $errors[] = "Last name is required.";
    } else {
        $lname = htmlspecialchars(trim($_POST["lname"]));
    }

    if (empty(trim($_POST["age"]))) {
        $errors[] = "Age is required.";
    } elseif (!is_numeric(trim($_POST["age"])) || (int)$_POST["age"] <= 0) {
        $errors[] = "Please enter a valid age.";
    } else {
        $age = htmlspecialchars(trim($_POST["age"]));
    }


    if (empty($_POST["gender"])) {
        $errors[] = "Gender is required.";
    } else {
        $gender = htmlspecialchars(trim($_POST["gender"]));
    }

    
    if (empty($errors)) {
        
        echo "<h3>Profile Updated Successfully!</h3>";
        echo "<p>First Name: $fname</p>";
        echo "<p>Last Name: $lname</p>";
        echo "<p>Age: $age</p>";
        echo "<p>Gender: $gender</p>";
    } else {
    
        echo "<h3>Errors:</h3>";
        foreach ($errors as $error) {
            echo "<p style='color:red;'>$error</p>";
        }
    }
}
// Start the session
    session_start();
    if(isset($_SESSION['status'])){

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Profile Management</title>
    <link rel="stylesheet" href="css/login.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap"
      rel="stylesheet"
    />
</head>
<body>
    <h1>Edit Profile</h1>
    <div class="main-container">
        <div class="profile management-container">
            <div class="login-card">
                <form action="update_profile.php" method="POST">
                    <div class="input-group">
                        <label for="fname">First Name</label>
                        <div class="input-box">
                            <input
                                type="text"
                                name="fname"
                                id="fname"
                                placeholder="Enter your First name"
                                required
                            />
                        </div>
                    </div>

                    <div class="input-group">
                        <label for="lname">Last Name</label>
                        <div class="input-box">
                            <input
                                type="text"
                                name="lname"
                                id="lname"
                                placeholder="Enter your Last name"
                                required
                            />
                        </div>
                    </div>

                    <div class="input-group">
                        <label for="age">Age</label>
                        <div class="input-box">
                            <input
                                type="number"
                                name="age"
                                id="age"
                                placeholder="Enter your Age"
                                required
                            />
                        </div>
                    </div>

                    <div class="input-group">
                        <label for="gender">Gender</label>
                        <div class="input-box">
                            <input type="radio" id="male" name="gender" value="Male" required />
                            <label for="male">Male</label>
                            <input type="radio" id="female" name="gender" value="Female" required />
                            <label for="female">Female</label><br />
                        </div>
                    </div>

                    <button type="submit" class="btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Ionicons for icons -->
    <script
      type="module"
      src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"
    ></script>
    <script
      nomodule
      src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"
    ></script>
    <!-- Custom JavaScript -->
    <script src="js/profileupdate.js"></script>
</body>
</html>
<?php
    }else{
        header('location: login.html');
    }

?>