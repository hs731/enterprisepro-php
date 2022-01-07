<?php  //Haris
    session_start();
    include_once './Views/SupervisorView.php';
    include_once './Controllers/SupervisorController.php';
    include_once './Controllers/UserController.php';

    //Only allow signed in student unto this page, redirect to loging page if session not set.
    //Therefore it's not possible for an unsigned user to type in clear
    //StudentPage.php address and access its features.
    if(!isset($_SESSION['supervisorID'])){
        header('Location: ./index.php');
        exit();
    }
    // If logout button pressed send student back to login page
    if(isset($_GET['logout'])){
        $logoutObj = new UserController();
        $logoutObj->logout();
    }
    if(isset($_POST['deleteproject'])){
        $supervisorCtrl = new SupervisorController();
        $supervisorCtrl->deleteProject($_POST['ProjectID']);
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
    <!--Jquery - open description box for table rows-->
    <script>
        $(document).ready(function(){ //show and hide project description
            $(".showmore").on('click', function(){ //onclick of x-button do function
                projectID = $(this).attr('name'); //get projectID
                $("#projectdesc" + projectID).toggle(800);
            });
        });
    </script>
    <!-- partial:index.partial.html -->
    <!-- End Screen Size Labels -->
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
                <!-- Start Navbar Logo -->
                <header>
                    <div class="logo">University of Bradford</div>
                    <nav>
                        <ul>
                            <li><a onclick="document.getElementById('viewMyStudents').style.display='block'" href="#">View Allocated Students</a></li>
                            <li class="sub-menu"><a href="#">View Projects</a>
                                <ul>
                                    <li><a href="SupervisorOwnProjects.php">View Own Projects</a></li>
                                    <li><a href="SupervisorAllProjects.php">View All Projects</a></li>
                                </ul>
                            </li>
                            <li class="sub-menu"><a href="#">Manage Projects</a>
                                <ul>
                                    <li><a href="SupervisorAdd.php">Add Project</a></li>
                                    <li><a href="SupervisorUpdate.php">Edit Project</a></li>
                                    <li><a href="SupervisorDelete.php">Delete Project</a></li>
                                </ul>
                            </li>
                            <li><a style="background-color: red" href="SupervisorAllProjects.php?logout">Log out</a></li>
                        </ul>
                    </nav>
                    <div class="menu-toggle"><i class="fa fa-bars" aria-hidden="true"></i></div>
                </header><!-- End Navbar Links -->
                </div>
            </div>
        </div>
        <!-- End Navigation Bar -->
        <!-- Start Slider Section -->
        <div class="slider-section">
            <div class="container"><p class="t1">
                <style>
                    .t1{text-align: center;
                    color: white;
                    background-color: black;
                    font-size: 45px;
                    display: inline;
                    margin:460px;
                    top: 500px;
                    }
                </style>
                </p>
                <div class="col-md-6 hidden-sm hidden-xs"></div>
            </div>
        </div>
        <!-- End Slider Section -->
        <!-- Start Projects Section -->
        <div id="editprojects">
            <h1 id="edittitle">Delete a project</h1><br>
            <?php
                $supervisorView= new SupervisorView();
                //delete project form
                $supervisorView->deleteProjectForm($_SESSION['supervisorID']);
                echo "<hr>";
            ?>
        </div>
        <!-- End Projects Section -->
        <!-- Show a supervisors allocated students in a pop -->
        <div id="viewMyStudents" class="form">
            <form class="modal-content animate" method="post" style="color:black;">
                <span onclick="document.getElementById('viewMyStudents').style.display='none'" class="close" title="Close PopUp">&times;</span>
                    <h1 style="text-align:center">My Students</h1><hr>
                    <br>
                    <!--javascript for closing the form and hiding it (shaf)-->
                    <!-- Echo dynamic table of students- Haider -->
                    <?php
                        $viewMyStudentsObj = new SupervisorView();
                        $viewMyStudentsObj->showAllocatedStudents($_SESSION['supervisorID']); //personal projects
                    ?>
            </form>
        </div>
        <!-- Start Footer Section -->
        <?php
            include_once './Views/MCFooter.php';
        ?>
</body>
</html>
