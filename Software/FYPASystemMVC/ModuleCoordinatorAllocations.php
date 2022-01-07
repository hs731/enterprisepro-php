<?php  //Haris
    session_start();
    include_once './Views/ModuleView.php';
    include_once './Controllers/UserController.php';

    //Only allow signed in module coord unto this page, redirect to loging page if session not set.
    //Therefore it's not possible for an unsigned user to type in
    //ModuleCoordinatorAllocations.php address and access its features.
    if(!isset($_SESSION['moduleCoordinatorID'])){
        header('Location: ./index.php');
        exit();
    }
    // If logout button pressed send student back to login page
    if(isset($_GET['logout'])){
        $logoutObj = new UserController();
        $logoutObj->logout();
    }
?>

<!DOCTYPE html>
<html lang="en" >
    <head>
        <meta charset="UTF-8">
        <title>University of Bradford</title>
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css'>
        <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'>
        <link rel="stylesheet" href="Views/css/StudentInterface.css">
        <link rel="stylesheet" href="Views/css/SupervisorContent.css">
        <link rel="stylesheet" href="Views/css/popup.css">
        <link rel="stylesheet" href="Views/css/searchbar.css">
        <link rel="stylesheet" href="Views/css/Footer.css">
        <!--Table style and functions-->
        <link rel="stylesheet" href="Views/css/StudentTable.css">
        <script type="text/javascript" src="Views/js/searchTable.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    </head>
    <body>

    <!--Jquery - open student information for table rows-->
        <script>
            $(document).ready(function(){ //show and hide student inforamtion
                $(".showmore").on('click', function(){ //onclick of x-button do function
                    supervisorID = $(this).attr('name'); //get supervisorID
                    $("#studentstable" + supervisorID).toggle(800);
                });
            });
        </script>

        <!-- Start Navigation Bar -->
            <div class="navigation-bar">
                <div class="container">
                    <div class="row">
                        <script>
                            $(document).ready(function() {
                                $('.menu-toggle').click(function(){
                                    $('nav').toggleClass('active');
                                    })
                                $('ul li').click(function(){
                                    $(this).siblings().removeClass('active');
                                    $(this).toggleClass('active');
                                    })
                                  })
                          </script>
                          <header>
                              <div class="logo">University of Bradford</div>
                              <nav>
                              <ul>
                                  <li><a href="ModuleCoordinatorAllocations.php">View Allocated Students</a></li>
                                  <li class="sub-menu"><a href="#">Manage Allocation</a>
                                      <ul>
                                          <li><a href="ModuleCoordinatorEdit.php">Automatic Allocation</a></li>
                                          <li><a href="MCProjectAllocation.php">Allocate Project</a></li>
                                          <li><a href="MCAllocateSupervisorStudent.php">Allocate Supervisor</a></li>
                                          <li><a href="ModuleDeProject.php">Deallocate Project</a></li>
                                          <li><a href="ModuleDeSupervisor.php">Deallocate Supervisor</a></li>
                                      </ul>
                                  </li>
                                  <li class="sub-menu"><a href="#">Manage Students</a>
                                      <ul>
                                          <li><a href="ModuleStudentAdd.php">Add Students</a></li>
                                          <li><a href="ModuleStudentUpdate.php">Edit Students</a></li>
                                          <li><a href="ModuleStudentDelete.php">Delete Students</a></li>
                                          <li><a href="ModuleStudentView.php">View Students</a></li>
                                      </ul>
                                  </li>
                                  <li class="sub-menu"><a href="#">Manage Supervisors</a>
                                      <ul>
                                          <li><a href="ModuleSpAdd.php">Add Supervisor</a></li>
                                          <li><a href="ModuleSpUpdate.php">Edit Supervisor</a></li>
                                          <li><a href="ModuleSpDelete.php">Delete Supervisor</a></li>
                                          <li><a href="ModuleSupervisorView.php">View Supervisors</a></li>
                                      </ul>
                                  </li>
                                  <li class="sub-menu"><a href="#">Manage Projects</a>
                                      <ul>
                                          <li><a href="ModuleProjectsAdd.php">Add Project</a></li>
                                          <li><a href="ModuleProjectsUpdate.php">Edit Project</a></li>
                                          <li><a href="ModuleProjectsDelete.php">Delete Project</a></li>
                                          <li><a href="ModuleCoordinatorPage.php">View Projects</a></li>
                                          <li><a href="ModuleStudentProjects.php">View Students Projects</a></li>
                                      </ul>
                                  </li>
                        		      <li><a style="background-color: red" href="ModuleCoordinatorPage.php?logout">Log out</a></li>
                              </ul>
                              </nav>
                              <div class="menu-toggle"><i class="fa fa-bars" aria-hidden="true"></i></div>
                          </header>
                        <!-- End Navbar Links -->
                    </div>
                </div>
            </div>
            <!-- End Navigation Bar -->

            <!-- Start Slider Section -->
            <div class="slider-section">
                <div class="container">
                    <p class="t1">
                        <style>
                            .t1{text-align: center;
                            color: white;
                            background-color: #989898;
                            opacity: 0.8;
                            font-size: 45px;
                            }
                        </style>
                    </p>
                    <div class="col-md-6 hidden-sm hidden-xs">
                    </div>
                </div>
            </div>
            <!-- End Slider Section -->

            <h3 id='edittitle'>View supervisors and the students they are supervising</h3><br>
            <!-- Start Projects Section -->

            <!-- Show supervisors who have been allocated students -->
            <?php
            $viewAllStudentsObj = new ModuleView();
            $viewAllStudentsObj->showEveryAllocatedStudent();
            ?>
            <!-- End Projects Section -->

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

            <!-- partial -->
            <script src='https://cdnjs.cloudflare.com/ajax/libs/fontawesome-iconpicker/1.3.1/js/fontawesome-iconpicker.js'></script>
    </body>
</html>
