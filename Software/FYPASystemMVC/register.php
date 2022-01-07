<!-- Page contributors: Shafqat Ahmed and Haider Raoof -->
<!DOCTYPE html>
<?php
 include_once './Controllers/StudentController.php';
 ?>
<html lang="en" >
  <head>
      <meta charset="UTF-8">
      <title>UNIVERSITY OF BRADFORD</title>
      <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css'>
      <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'>
      <link rel="stylesheet" href="Views/css/LoginReg.css">
      <link rel="stylesheet" href="Views/css/StudentInterface.css">
      <link rel="stylesheet" href="Views/css/Footer.css">
      <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
  </head>
    <body>
    <!-- Start Navigation Bar -->
        <div class="navigation-bar">
            <div class="container">
                <div class="row">
                <header>
                    <div class="logo">University of Bradford</div>
                        <nav>
                            <ul>
                                <li><a href="index.php">Login</a></li>
                                <li><a href="#">Register</a></li>
                            </ul>
                        </nav>
                        <div class="menu-toggle"><i class="fa fa-bars" aria-hidden="true"></i></div>
                </header>
                </div>
            </div>
        </div>
        <br><br>
        <br><br>
        <h1 id="title"style="color: #000000;" >
            <strong>Welcome to the Registration Page for Students</strong></h1>
        <br>
        <div id="myTypingText" style=" display:inline-flex; " onclick="myFunction()"></div>
        <div class="login-page">
            <!-- form created for register -->
            <div id="cc"class="form">
                <img src="./Views/images/ww.png" ALT="Logo img"  align="center" width="150" height="150" style="margin-bottom: 24px">
                <?php
                    // Used to submit data from a post
                    if(isset($_POST['register-submit'])){
                        $registerStudentObject = new StudentController();
                        $registerStudentObject->registerStudent();
                    }
                ?>
                <form class="register-form" method="POST" style="padding-bottom: 10px;">
                    <p>Register with Final Year Project Allocation System</p>
                    <?php
                    //show error messages on the site using the $_GET method
                    if (isset($_GET['error'])){
                        if($_GET['error'] == "ubnumbertaken"){
                            echo '<p class="errorregisterlogin">A student has already registered with the entered UoB Number!</p>';
                        }
                        else if ($_GET['error'] == "emailtaken"){
                            echo '<p class="errorregisterlogin">A student has already registered with the entered email address!</p>';
                        }
                    }
                    //show success message if user successfully signed up
                    else if (isset($_GET["register"])) {
                        if ($_GET["register"] == "success") {
                            echo '<p class="successregisterlogin">Registered successfully</p>';
                        }
                    }
                    ?>
                    <!-- input fields for registration form -->
                    <input type="text" name="regfirstname" placeholder="First Name" required pattern="[A-Za-z]+" title="Must only be characters" maxlength="25" />
                    <input type="text" name="reglastname"placeholder="Last Name" required pattern="[A-Za-z]+" title="Must only be characters" maxlength="25"/>
                    <input type="text" name="reguobnum" placeholder="UoB Number" required pattern="[0-9]{8}" title="Must be 8 digits e.g. 00000000" minlength="8" maxlength="8" />
                    <input type="text" name="reguobemail" placeholder="UoB email" required pattern="[\w.%+-]+@bradford\.ac\.uk" title="E.g. example@bradford.ac.uk" maxlength="50" />
                    <input type="password" name="regpassword"placeholder="Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,16}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 to 16 characters"  maxlength="16">
                    <select id ="prog1" name="yearofstudy">
                        <!-- drop down menu -->
                        <option value="3rd">3rd Year Student</option>
                        <option value="MSc">Masters Student</option>
                    </select>
                    <select id ="prog" name="progofstudy">
                        <option value="Computer Science">Computer Science</option>
                        <option value="Software Engineering">Software Engineering</option>
                        <option value="Cyber Security">Computer Science for Cyber Security</option>
                        <option value="Business Computing">Business Computing</option>
                    </select>
                    <!-- submit form button -->
                    <button type="submit" name="register-submit">register</button>
                </form>
            </div>
        </div>

      <!-- Start Footer Section -->

      <footer class="site-footer">
          <div class="container">
              <div class="row">
                  <div class="col-md-8 col-sm-6 col-xs-12">
                      <p class="copyright-text">Copyright &copy; 2020 All Rights Reserved by
                          <a href="https://www.bradford.ac.uk/external/">University of Bradford</a>.
                      </p>
                  </div>
                  <div class="col-md-4 col-sm-6 col-xs-12">
                      <ul class="social-icons">
                          <li><a class="facebook" href="https://www.facebook.com/university.bradford/"><i class="fa fa-facebook"></i></a></li>
    				              <li><a class="instagram" href="https://www.instagram.com/universityofbradford/?hl=en"><i class="fa fa-instagram"></i></a></li>
                          <li><a class="twitter" href="https://twitter.com/UniofBradford?ref_src=twsrc%5Egoogle%7Ctwcamp%5Eserp%7Ctwgr%5Eauthor"><i class="fa fa-twitter"></i></a></li>
                          <li><a class="youtube" href="https://www.youtube.com/channel/UC9OybnsJdpgzsVAiWp4qL2Q"><i class="fa fa-youtube"></i></a></li>
                          <li><a class="linkedin" href="https://www.linkedin.com/school/university-of-bradford/"><i class="fa fa-linkedin"></i></a></li>
                      </ul>
                  </div>
              </div>
          </div>
    	</footer>

    <!-- End Footer Section -->

      <script src='https://cdnjs.cloudflare.com/ajax/libs/fontawesome-iconpicker/1.3.1/js/fontawesome-iconpicker.js'></script>
    <!-- shafqat -->
    <!--ghost-text javascript-->
      <script>
          var myString = "Please register to the Final Year Project Allocation System.This is for 3rd Year/Masters Students. Fill out the form correctly using the correct details and make sure all fields are completed.  "; //message to display
          var myArray = myString.split("");//split string method splits a string object to an array of strings by breaking up the string into substrings.
          var loopTimer;//variable called var loopTimer is created
          function frameLooper() {
              if(myArray.length > 0) {//length is greater than 0
                  document.getElementById("myTypingText").innerHTML += myArray.shift();//the id in the html is called here "myTypingText"
              } else {//if array length statement is false then  the timer will be cleared
                  clearTimeout(loopTimer);
                  return false;
              }
              loopTimer = setTimeout('frameLooper()',10);//loop timer method is assigned a value of 40
          }
          frameLooper();
          function myFunction() {//this function will be called in the html
              document.getElementById("myTypingText").innerHTML = "Please register to the Final Year Project Allocation System.This is for 3rdYear/Masters Students. Fill out the form correctly using the correct details and make sure all fields are completed.";
              clearTimeout(loopTimer);
            }
    </script>

    </body>
</html>
