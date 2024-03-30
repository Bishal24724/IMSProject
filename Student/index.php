
<?php
session_start();
include("php/dbconnect.php");

$error = '';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Input validation (you can customize these rules)
    if (empty($username) || empty($password)) {
        $error = 'Both username and password are required.';
    } else {
        // Use prepared statement to prevent SQL injection
        $stmt = $conn->prepare("SELECT * FROM student WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        
        if ($user) {
            $db_password = $user['password']; // Assuming passwords are stored in plain text

            if ($password === $db_password) { // Compare plain text passwords
                // Set session variable
                $_SESSION['username'] = $user['username'];
              
                // Redirect to dashboard.php
                header("Location: dashboard.php");
                exit(); // Make sure to exit after redirection
            } else {
                $error = 'Invalid username or password';
            }
        } else {
            $error = 'Invalid username';
        }
        
        $stmt->close();
    }
}
?>

 

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Insititute Management System</title>

    <!-- BOOTSTRAP STYLES-->
    <link href="css/bootstrap.css" rel="stylesheet" />
    <!-- FONTAWESOME STYLES-->
    <link href="css/font-awesome.css" rel="stylesheet" />
    <!-- GOOGLE FONTS-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
<style>
    @font-face {
  font-family: Poppins;
  src: url("fonts/Poppins-Regular.ttf");
}

html * {
  font-family: "Poppins", sans-serif;
  
}
.myhead{
margin-top:0px;
margin-bottom:0px;
text-align:center;
}
.logo img {
    max-width: 50%;
    height: auto;
    display: block;
    margin: 0 auto;
}
body{
    background-color:#27374D;
}


</style>

</head>
<body>
    <div class="container">
    <div class="row">
    <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1 ">
    <div class="logo">
            <img src="logo/logo.png" alt="logo">
        </div>
</div>
</div>  
         <div class="row ">
               
                <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
                          
                            <div class="panel-body bg-primary" style="margin-top:70px; box-shadow: 5px 10px #888888;">
							  <h3 class="myhead">Insititute Management System</h3>
                                <form role="form" action="index.php" method="post">
                                    <hr />
									<?php
									if($error!='')
									{									
									echo '<h5 class="text-danger text-center">'.$error.'</h5>';
									}
									?>
									
                                   
                                     <div class="form-group input-group">
                                            <span class="input-group-addon"><i class="fa fa-user"  ></i></span>
                                            <input type="text" class="form-control" placeholder="Username " name="username" required />
                                        </div>
                                        
									<div class="form-group input-group">
                                            <span class="input-group-addon"><i class="fa fa-lock"  ></i></span>
                                            <input type="password" class="form-control"  placeholder="Password" name="password" required />
                                        </div>
										
                                   
                                     
                                     <button class="btn btn-success" style="border-radius:0%" type= "submit" name="login">Login</button>
                                     <input type="button" onclick="window.location.href = '/.../index.php'"value="Switch Admin Login" style="background-color:red">

                                    </form>
                            </div>
                           
                        </div>
                
                
        </div>
    </div>

</body>
</html>
