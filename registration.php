<?php session_start(); ?>
<!DOCTYPE html>
<html>
  <head>
    <title>InnerBliss</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="./style.css" rel="stylesheet">
  </head>
  <body>
    <?php
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
        // echo "Connected successfully";
        

        if(isset($_POST['first_name'])){
            // print_r($_POST);
            $sql = "INSERT INTO users (first_name, last_name, email, contact_no, password, age, address)
                VALUES ('".$_POST['first_name']."', '".$_POST['last_name']."', '".$_POST['email']."', '".$_POST['contact_no']."', '".$_POST['password']."', '".$_POST['age']."', '".$_POST['address']."')";
       
            if ($conn->query($sql) === TRUE) {
                echo "User registered successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
        else if(isset($_POST['email'])){
            // print_r($_POST);
            $sql = "SELECT * from users where email = '".$_POST['email']."' and password = '".$_POST['password']."'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $data_result = $result->fetch_assoc();
                $_SESSION['user_id'] = $data_result['user_id'];
                $_SESSION['first_name'] = $data_result['first_name'];
                $_SESSION['last_name'] = $data_result['last_name'];
                $_SESSION['email'] = $data_result['email'];
                $_SESSION['age'] = $data_result['age'];
                $_SESSION['contact_no'] = $data_result['contact_no'];
                $_SESSION['address'] = $data_result['address'];

                echo "User login successfully";
                header("Location: http://localhost/innerBliss/home.html");
                
            } else {
                echo "Email/Password incorrect";
            }
        }
    ?>
    <div class="container mt-3">
      <div class="cont">
        <form method="post">
            <div class="form sign-in">
                <h2>Welcome</h2>
                <label>
                    <span>Email</span>
                    <input type="email" name="email" required />
                </label>
                <label>
                    <span>Password</span>
                    <input type="password" name="password" required />
                </label>
                <!-- <p class="forgot-pass">Forgot password?</p> -->
                <button type="submit" class="submit">Sign In</button>
            </div>
        </form>
        <div class="sub-cont">
            <div class="img">
                <div class="img__text m--up">
                 
                    <h3>Don't have an account? Please Sign up!<h3>
                </div>
                <div class="img__text m--in">
                
                    <h3>If you already has an account, just sign in.<h3>
                </div>
                <div class="img__btn">
                    <span class="m--up">Sign Up</span>
                    <span class="m--in">Sign In</span>
                </div>
            </div>
            <form method="post">
                <div class="form sign-up" style="overflow-y: auto">
                    <h2>Create your Account</h2>  
                    <label>
                        <span>First Name</span>
                        <input type="text" name="first_name" required />
                    </label>
                    <label>
                        <span>Last Name</span>
                        <input type="text" name="last_name" required />
                    </label>
                    <label>
                        <span>Email</span>
                        <input type="email" name="email" required />
                    </label>
                    <label>
                        <span>Contact Number</span>
                        <input type="text" name="contact_no" required />
                    </label>
                    <label>
                        <span>Password</span>
                        <input type="password" name="password" required />
                    </label>
                    <label>
                        <span>Age</span>
                        <input type="number" name="age" required />
                    </label>
                    <!-- <label>
                    <span>Gender</span>
                    <input type="radio" name="gender">Male
                    <input type="radio" name="gender">Female
                    </label> -->
                    <label>
                        <span>Address</span>
                        <input type="text" name="address" required />
                    </label>
                    <button type="submit" class="submit">Sign Up</button>
                    localhost
                </div>
            </form>
        </div>
    </div>

    <script>
        document.querySelector('.img__btn').addEventListener('click', function() {
            document.querySelector('.cont').classList.toggle('s--signup');
        });
    </script>
      <!-- <h2>Stacked form</h2> -->
      <!-- <form action="/">
        <div class="mb-3 mt-3">
          <label for="first_name">First Name:</label>
          <input type="text" class="form-control" id="first_name" placeholder="Enter first name" name="first_name" required>
        </div>
        <div class="mb-3 mt-3">
          <label for="last_name">Last Name:</label>
          <input type="text" class="form-control" id="last_name" placeholder="Enter last name" name="last_name" required>
        </div>
        <div class="mb-3 mt-3">
          <label for="email">Email:</label>
          <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" required>
        </div>
        <div class="mb-3 mt-3">
          <label for="contact_no">Contact Number:</label>
          <input type="tel" class="form-control" id="contact_no" placeholder="Enter contact number" name="contact_no" required>
        </div>
        <div class="mb-3 mt-3">
          <label for="age">Age:</label>
          <input type="number" class="form-control" id="age" placeholder="Enter age" name="age" required>
        </div>
        <div class="mb-3 mt-3">
          <label for="gender">Gender:</label>
          <input type="radio" name="gender" value="male" required>Male
          <input type="radio" name="gender" value="female" required>Female
        </div>
        <div class="mb-3 mt-3">
          <label for="address">Address:</label>
          <input type="text" class="form-control" id="address" placeholder="Enter address" name="address" required>
        </div>
        <div class="mb-3">
          <label for="password">Password:</label>
          <input type="password" class="form-control" id="password" placeholder="Enter password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form> -->
    </div>
  </body>
</html>