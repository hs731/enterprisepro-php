<?php  //Haris
    session_start();
    include_once './Views/SupervisorView.php';
    include_once './Controllers/SupervisorController.php';
    include_once './Controllers/UserController.php';
    include_once './Controllers/ModuleCoordinatorController.php';
    //Only allow signed in module coordinator to this page, redirect to loging page if session not set.
    //Therefore it's not possible for an unsigned user to type in clear
    if(!isset($_SESSION['moduleCoordinatorID'])){
        header('Location: ./index.php');
        exit();
    }
    // If logout button pressed send student back to login page
    if(isset($_GET['logout'])){
        $logoutObj = new UserController();
        $logoutObj->logout();
    }
    if(isset($_POST['addproject'])){
        $supervisorCtrl = new SupervisorController();
        $supervisorCtrl->addProject($_SESSION['moduleCoordinatorID']);
    }
    if(isset($_POST['deleteproject'])){
        $supervisorCtrl = new SupervisorController();
        $supervisorCtrl->deleteProject($_POST['ProjectID']);
    }
    if(isset($_POST['autoproject'])){
        $moduleCtrl = new ModuleCoordinatorController();
        $moduleCtrl->balancing();
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>University of Bradford</title>
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css'>
        <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'>
        <link rel="stylesheet" href="Views/css/StudentInterface.css">
        <link rel="stylesheet" href="Views/css/SupervisorContent.css">
        <link rel="stylesheet" href="Views/css/searchbar.css">
    	   <link rel="stylesheet" href="Views/css/Footer.css">
        <link rel="stylesheet" href="Views/css/ModulePages.css">
        <!--Table style and functions-->
        <link rel="stylesheet" href="Views/css/StudentTable.css">
        <script type="text/javascript" src="Views/js/searchTable.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    </head>
    <body>

    <!--Jquery - open description box for table rows-->
        <script>
            $(document).ready(function(){ //show and hide project description
                $("#projectbutton").on('click', function(){ //onclick of x-button do function
                    $("#projectform").toggle(800);
                    $("#studentform").hide(800);
                    $("#supervisorform").hide(800);
                });
                $("#studentbutton").on('click', function(){ //onclick of x-button do function
                    $("#studentform").toggle(800);
                    $("#projectform").hide(800);
                    $("#supervisorform").hide(800);
                });
                $("#supervisorbutton").on('click', function(){ //onclick of x-button do function
                    $("#supervisorform").toggle(800);
                    $("#projectform").hide(800);
                    $("#studentform").hide(800);
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
                                    <li class="sub-menu"><a href="#">Manage Allocations</a>
                                        <ul>
                                            <li><a href="ModuleCoordinatorEdit.php">Automatic allocation</a></li>
                                            <li><a href="MCProjectAllocation.php">Allocate project</a></li>
                                            <li><a href="MCAllocateSupervisorStudent.php">Allocate supervisor</a></li>
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

        <!-- Start Projects Section -->
        <div id="editprojects">
            <h2 id="edittitle"><span>&#9888; </span> Automatic Allocation <span>&#9888;</span></h2><br>
            <h2 id="edittitle"><span></span>This action can be undone manually: via<span></span>
                <a href="ModuleDeSupervisor.php">De-allocate supervisor</a> page</h2><br>
            <h3 id="edittitle"><span>&#9888; </span>
                Please click the button to perform Automatic Allocation. Once clicked please go to
                    <a href=ModuleCoordinatorAllocations.php> view allocated students</a><span>&#9888; </span> </h3><br>
            <form method="POST" id="aa">
                <button type="submit" name="autoproject">Automatic Project Allocation</button>
          </form>
          <br>
          <br>
          <!-- End Projects Section -->
    <?php
        include_once './Views/MCFooter.php';
