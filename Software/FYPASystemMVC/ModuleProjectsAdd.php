<?php 

    include_once './Views/mcHeader.php';

       // <!-- Start Projects Section -->
        echo "<div id='editprojects'>
        <h2 id='edittitle'>Add a project</h2>
        <hr>
        <h3 id='edittitle'>Please fill out the form to add a project to the system.</h3>";
            $ModuleView = new ModuleView();
            $ModuleView->addProjectForm();

        echo "</div>
        <br><br>";  //<!-- End Projects Section -->    

    include_once './Views/MCFooter.php';
