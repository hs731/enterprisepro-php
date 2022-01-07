<!DOCTYPE html> <!-- Page contributors: Shafqat and Foluke -->
<?php
    include_once './Controllers/UserController.php';
?>

<!DOCTYPE html>
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
      <div class="navigation-bar">
          <div class="container">
              <div class="row">
                  <header>
                  <div class="logo">University of Bradford</div>
                      <nav>
                          <ul>
                            <li><a href="#">Login</a></li>
                            <li><a href="register.php">Register</a></li>
                          </ul>
                      </nav>
                  <div class="menu-toggle"><i class="fa fa-bars" aria-hidden="true"></i></div>
                </header>
              </div>
          </div>
      </div>
      <br><br>
      <br><br>
      <h1 id="title" style="color: #000000; "><strong>Welcome to the final year project allocation system</strong></h1>
      <br>
      <div id="myTypingText" style=" display:inline-flex; " onclick="myFunction()"></div>
          <br><br>
          <div class="login-page">
              <div class="form">
                  <img src="./Views/images/ww.png" ALT="Logo img"  align="center" width="150" height="150" style="margin-bottom: 24px">
                  <p>Login to the Final Year Project Allocation System</p>
                  <?php
                      // Used to submit data for the login
                      if(isset($_POST['login-submit'])){
                          $userLogin = new UserController();
                          $userLogin->login();
                      }
                  ?>
                  <form class="login-form" method="post">
                      <input type="text" placeholder="UoB Number: (Student) | Username: (Supervisor) | ID: (Module Coordinator)" required="" name="username"/>
                      <input type="password" placeholder="Password" required="" name="password"/>
                      <button name="login-submit">login</button>
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
          var myString = "This system has been built for the University of Bradford's Department of Computer Science. Students have the ability to select a project, deselect their project, propose their own project and view their chosen project. Supervisors can view their allocated students and edit their projects. The Module Coordinator has an admin panel with the ability to edit students, projects and supervisors."; //message to display
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
              document.getElementById("myTypingText").innerHTML = "This system has been built for the University of Bradford, Department of Computer Science. Students have the ability to select a project,deselect their project, propose own project and view their chosen project. Supervisors can view their allocated students and edit their projects. The module coordinator has an admin panel with the ability to edit the students, projects and supervisors.";
              clearTimeout(loopTimer);// clears the loop timer
          }
    </script>
    </body>
</html>
