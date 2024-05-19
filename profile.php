<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "innerbliss"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle form submission and update the database with new values
    // You should sanitize and validate user input before updating the database to prevent SQL injection and other security vulnerabilities
    
    // Example of updating the session data with new values (replace with your database update logic)
    $_SESSION['first_name'] = $_POST['newFirstName'];
    $_SESSION['last_name'] = $_POST['newLastName'];
    $_SESSION['email'] = $_POST['newEmail'];
    $_SESSION['age'] = $_POST['newAge'];
    $_SESSION['contact_no'] = $_POST['newContact'];
    $_SESSION['address'] = $_POST['newAddress'];

    // Update query
    $sql = "UPDATE users 
            SET first_name = '".$_POST['newFirstName']."', 
                last_name = '".$_POST['newLastName']."', 
                email = '".$_POST['newEmail']."', 
                age = '".$_POST['newAge']."', 
                contact_no = '".$_POST['newContact']."', 
                address = '".$_POST['newAddress']."'
            WHERE email = '".$_SESSION['email']."'";

    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";

        // Update session variables with new values
        $_SESSION['first_name'] = $_POST['newFirstName'];
        $_SESSION['last_name'] = $_POST['newLastName'];
        $_SESSION['email'] = $_POST['newEmail'];
        $_SESSION['age'] = $_POST['newAge'];
        $_SESSION['contact_no'] = $_POST['newContact'];
        $_SESSION['address'] = $_POST['newAddress'];
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .profile-info {
            margin-bottom: 20px;
        }
        .profile-info label {
            font-weight: bold;
        }
        .profile-info p {
            margin: 5px 0;
        }
        .button-container {
            text-align: center;
        }
        .logout-button {
            background-color: #ff6347;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s;
        }
        .logout-button:hover {
            background-color: #e74c3c;
        }
        .edit-profile-form {
            display: none;
        }
        .edit-profile-form.show {
            display: block;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>User Profile</h1>
        <div class="profile-info">
            <label for="username">Name: </label><span id="username"><?php echo $_SESSION['first_name'].' '.$_SESSION['last_name']; ?></span>
        </div>
        <div class="profile-info">
            <label for="email">Email: </label><span id="email"><?php echo $_SESSION['email']; ?></span>
        </div>
        <div class="profile-info">
            <label for="age">Age: </label><span id="age"><?php echo $_SESSION['age']; ?></span>
        </div>
        <div class="profile-info">
            <label for="contact">Contact Number: </label><span id="contact"><?php echo $_SESSION['contact_no']; ?></span>
        </div>
        <div class="profile-info">
            <label for="address">Address: </label><span id="address"><?php echo $_SESSION['address']; ?></span>
        </div>
        <div class="button-container">
            <button id="editButton" class="logout-button" onclick="toggleEdit()">Edit Profile</button>
            <form id="editForm" class="edit-profile-form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="profile-info">
                    <label for="newFirstName">First Name: </label>
                    <input type="text" id="newFirstName" name="newFirstName" value="<?php echo $_SESSION['first_name']; ?>">
                </div>
                <div class="profile-info">
                    <label for="newLastName">Last Name: </label>
                    <input type="text" id="newLastName" name="newLastName" value="<?php echo $_SESSION['last_name']; ?>">
                </div>
                <div class="profile-info">
                    <label for="newEmail">Email: </label>
                    <input type="email" id="newEmail" name="newEmail" value="<?php echo $_SESSION['email']; ?>" readonly>
                </div>
                <div class="profile-info">
                    <label for="newAge">Age: </label>
                    <input type="number" id="newAge" name="newAge" value="<?php echo $_SESSION['age']; ?>">
                </div>
                <div class="profile-info">
                    <label for="newContact">Contact Number: </label>
                    <input type="text" id="newContact" name="newContact" value="<?php echo $_SESSION['contact_no']; ?>">
                </div>
                <div class="profile-info">
                    <label for="newAddress">Address: </label>
                    <input type="text" id="newAddress" name="newAddress" value="<?php echo $_SESSION['address']; ?>">
                </div>
                <button type="submit">Save Changes</button>
            </form>
        </div>
    </div>

    <script>
        function toggleEdit() {
            var editForm = document.getElementById("editForm");
            editForm.classList.toggle("show");
        }
    </script>
</body>
</html>
