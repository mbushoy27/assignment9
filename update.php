
<?php 
// Create a database connection
$mysqli = new mysqli('66.147.242.186', 'urcscon3_juneau', 'coffee1N', 'urcscon3_juneau');

$number = $_POST['id'];
$updatedName = Trim(stripslashes($_POST['name']));
$updatedEmail =  Trim(stripslashes($_POST['email']));
$updatedTelephone =  Trim(stripslashes($_POST['telephone']));

//question1
$statusselect=$_POST["status"];

//question2
$location1=$_POST["location1"];
$location2=$_POST["location2"];
$location3=$_POST["location3"];
$location4=$_POST["location4"];
$location5=$_POST["location5"];


//question3
$qualityselect=$_POST["quality"];

//question4
$purchaseselect=$_POST["suggestion"];

//question5
$eatselect=$_POST["nutrition"];

//question6
$dietaryselect=$_POST["dietary"];

//question7
$specialdietaryselect=$_POST["special-dietary"];

//question8
$cafeteriaselect=$_POST["sustainability"];

//message
$message=trim(stripslashes($_POST["message"]));

//escape all strings
$name=mysqli_real_escape_string($mysqli, $name);
$email=mysqli_real_escape_string($mysqli, $email);
$telephone=mysqli_real_escape_string($mysqli, $telephone);
$message=mysqli_real_escape_string($mysqli, $message);

//perform database query
$query  = "UPDATE 'survey_assignment_9' SET ";
$query .= "Name = '$updatedName',";
$query .="Email = '$updatedEmail',";
$query .="Telephone = '$updatedTelephone', ";
$query .="CampusStatus = '$statusselect', ";
$query .="FoodLocation = '$location1, $location2, $location3, $location4, $location5', ";
$query .="QualityRate = '$qualityselect', ";
$query .="Suggestion = '$suggestionselect', ";
$query .="Healthy = '$healthyselect', ";
$query .="DietaryNeeds = '$dietaryselect', ";
$query .="SpecialDietary = '$specialdietaryselect', ";
$query .="Sustainability = '$sustainabilityselect', ";
$query .="Message = '$message'";
$query .= "WHERE ID = {$number}";
$result = mysqli_query($mysqli, $query);

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
                <li><a class="menu-link" href="admin.php">Back to Admin</a></li>
            </ul>
        </nav>
        <!-- End Navigation -->

        <section id="heading">
            <h1>University of Rochester Dining Services - Update Confirmation</h1>
        </section>

        <section class="confirmation-message">
            <?php
            if ($result) {
            ?>
            <h2>The record of number <?php echo $_POST['id'] ?> has been updated!</h2>

            <?php
            } else {
                die("ERROR: Database query failed.");
            }
            ?>
            <a href="admin.php">Go Back to Admin Page</a>
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

<?php
//close databse connection
mysqli_close($mysqli);
?>