<!--Haris, Bilal-->
<?php
    session_start();
    include_once './Views/StudentView.php';
    include_once './Controllers/UserController.php';
    include_once './Controllers/StudentController.php';

    //Only allow signed in student unto this page, redirect to loging page if session not set.
    //Therefore it's not possible for an unsigned user to type in clear
    //StudentPage.php address and access its features.
    if(!isset($_SESSION['uobnumber'])){
        header('Location: ./index.php');
        exit();
    }
    // If logout button pressed send student back to login page
    if(isset($_GET['logout'])){
        $logoutObj = new UserController();
        $logoutObj->logout();
    }

    //If viewMyProject button click, show student project info
    if(isset($_GET['viewMyProject'])){
        $showAssignedProject = new StudentView();
        $showAssignedProject->getViewMyProject($_SESSION['uobnumber']);
    }
    // Used to submit data from project proposal form
    if(isset($_POST['propose-submit'])){
        $proposeProjectObject = new StudentController();
        // for logged in student, send emails about their proposed project
        // and add the proposed project to database
        $proposeProjectObject->proposeProject($_SESSION['uobnumber']);
    }
?>

    <!DOCTYPE html>
    <html lang="en" >
    <head>
        <meta charset="UTF-8">
        <title>UNIVERSITY OF BRADFORD</title>
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css'>
        <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'>
        <link rel="stylesheet" href="Views/css/StudentInterface.css">
        <link rel="stylesheet" href="Views/css/popup.css">
        <link rel="stylesheet" href="Views/css/searchbar.css">
        <link rel="stylesheet" href="Views/css/Footer.css">
        <link rel="stylesheet" href="Views/css/pagination.css">
        <!--Table style and functions-->
        <link rel="stylesheet" href="Views/css/StudentTable.css">
        <script type="text/javascript" src="Views/js/searchTable.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    </head>
    <body>
        <!--Jquery haris - open description box for table rows-->
        <script>
            $(document).ready(function(){ //show and hide project description
                $(".showmore").on('click', function(){ //onclick of x-button do function
                    projectID = $(this).attr('name'); //get projectID
                    $("#projectdesc" + projectID).toggle(800);
                });
            });
        </script>

        <!--HARIS - ajax success action or error message-->
        <div id="message"></div>

        <!--select project Haris - ajax processing. Take project id as js parameter,
        use ajax to post to selectbutton.php which will use the project id in a db query. studentview.php, studentpage.php, selectbutton.php-->
        <?php
            //select ajax
            $uobnumber = $_SESSION['uobnumber'];//where id is from button and uobnum is from session
            echo "<script>
                function selectProject(id) {
                    $.ajax({
                        type: 'POST',
                        url: 'Controllers/selectbutton.php',
                        data: {projectID: id, uobNUM: $uobnumber},
                        success: function (msg) {
                            $('#message').html(msg);
                        },
                        error: function (req, status, error) {
                            alert(req + ' ' + status + ' ' + error);
                        }
                    });
                }
            </script>";

            //deselect ajax
            echo "<script>
                function deselectProject(id) {
                    $.ajax({
                        type: 'POST',
                        url: 'Controllers/deselectbutton.php',
                        data: {projectID: id, uobNUM: $uobnumber},
                        success: function (msg) {
                            $('#message').html(msg);
                        },
                        error: function (req, status, error) {
                            alert(req + ' ' + status + ' ' + error);
                        }
                    });
                }
            </script>";
        ?>

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
                    <header>
                        <div class="logo">University of Bradford</div>
                            <nav>
                                <ul>
                                    <li><a onclick="document.getElementById('viewMyProject').style.display='block'" href="#">View My Project</a></li>
                                    <li><a onclick="document.getElementById('modal-wrapper').style.display='block'" href="#">Propose own project</a></li>
                                    <li><a style="background-color: red" href="StudentPage.php?logout">Logout</a></li>
                                </ul>
                            </nav>
                        <div class="menu-toggle"><i class="fa fa-bars" aria-hidden="true"></i></div>
                    </header>
                    <!-- End Navbar Links -->
                </div>
            </div>
        </div>
        <!--the pop up form(shaf)-->
        <div id="modal-wrapper" class="form">
            <form class="modal-content animate" method="post" style="color:black;">
                <span onclick="document.getElementById('modal-wrapper').style.display='none'" class="close" title="Close PopUp">&times;</span>
                <!--javascript for closing the form and hiding it (shaf)-->
                <!-- Echo dynamic proposal form section - Haider -->
                <?php
                // If propose own project button is pressed come up with proposal form or
                // text prompt saying you can not propose a project
                    $studentViewObject = new StudentView();
                    $studentViewObject->showProposalForm($_SESSION['uobnumber']);
                ?>
                <!-- Echo dynamic proposal form section - Haider -->
            </form>
        </div>

        <!--viewMyProject popup-->
        <div id="viewMyProject" class="form">
            <form class="modal-content animate" method="post">
                <span onclick="document.getElementById('viewMyProject').style.display='none'" class="close" title="Close PopUp">&times;</span>
                <h1 style="text-align:center">My Project</h1><hr>
                <br>
                <?php
                    $showAssignedProject = new StudentView();
                    $showAssignedProject->getViewMyProject($_SESSION['uobnumber']);
                ?>
            </form>
        </div>
        <!-- End Navigation Bar -->
        <!-- Start Slider Section -->
        <div class="slider-section">
            <div class="container">
                <div class="col-md-6 hidden-sm hidden-xs"></div>
            </div>
        </div>
        <!-- End Slider Section -->
        <!-- Start Projects Section -->
        <br>
        <div class="desc">
            <p> Here are the following final year projects for Master/3rd year students. Please select a project, you may deselect and change your project with 7 days of your initial selection. Take careful consideration when choosing your project.<br><strong>You have 2 chances to select your desired project.</strong></p>
        </div>
        <br><br>
        <div class="wrap">
            <div class="search">
                <input type="text" class="searchTerm" id="search-input" onkeyup="searchProjectInfo(1)" placeholder="Search for a project">
                <button type="submit" class="searchButton">
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </div>
        <br><br>

        <!-- HARIS - showing project table -->
        <?php
            $usersObject = new StudentView();
            $usersObject->getProjectsTable($_SESSION['uobnumber']); //uob session var here
        ?>
        <!-- End Projects Section -->
        <!-- Start Footer Section -->
        <?php
            include_once './Views/MCFooter.php';
        ?>
    </body>
    </html>
