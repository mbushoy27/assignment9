<?php
// Include config file
require_once 'config.php';

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = 'Please enter username.';
    } else{
        $username = trim($_POST["username"]);
    }

    // Check if password is empty
    if(empty(trim($_POST['password']))){
        $password_err = 'Please enter your password.';
    } else{
        $password = trim($_POST['password']);
    }

    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT username, password FROM users WHERE username = ?";

        if($stmt = mysqli_prepare($mysqli, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = $username;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            /* Password is correct, so start a new session and
                            save the username to the session */
                            session_start();
                            $_SESSION['username'] = $username;      
                            header("location: admin.php");
                        } else{
                            // Display an error message if password is not valid
                            $password_err = $password;
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = 'No account found with that username.';
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($myqsli);
}
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>CSC 174 | Team Juneau</title>

    </head>

    <body>   

        <!-- Start Navigation -->
        <nav class="main-menu">
            <span class="logo"><a href="#">Team Juneau: Assignment #9</a></span>
            <ul>
                <li><a class="menu-link" href="index.php">Back to Survey</a></li>
            </ul>
        </nav>
        <!-- End Navigation -->

        <section id="heading">
            <h1>University of Rochester Dining Services - Login</h1>
        </section>

        <section id="login-signup">
            <div class="row align-items-center">
                
                <div class="column col-md-12 col-sm-12 col-xs-12">
                    <h2>Login</h2>
                    <h3>Please fill in your credentials to login.</h3>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                        <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                            <label>Username:<sup>*</sup></label>
                            <input type="text" name="username"class="form-control" value="<?php echo $username; ?>">
                            <span class="help-block"><?php echo $username_err; ?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                            <label>Password:<sup>*</sup></label>
                            <input type="password" name="password" class="form-control">
                            <span class="help-block"><?php echo $password_err; ?></span>
                        </div>

                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="Submit">
                        </div>

                    </form>
                    <h4>Don't have an account? Sign up here: <a href="register.php">Sign Up</a></h4>
                </div> 
 
            </div>
        </section>

        <footer id="credits">
            <h2>Credits</h2>
            <ul id="footer-ul">
                <li>Copyright &copy; 2017 - This webpage was created by Team Juneau</li>
                <li>Here is a reference we used for assignment 9: <a href="http://www.rochester.edu/dining/learn-more/about-us/">U of R Dining Services</a></li>
                <li>Daniella Bloom, Michelle Bushoy, Jerry Dai, Philip Kallinos</li>
                <li><a href="login.php">Admin Login/Signup</a></li>
            </ul>    
        </footer>

    </body>
</html>