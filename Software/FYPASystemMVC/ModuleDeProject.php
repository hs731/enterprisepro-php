<?php

    include_once './Views/mcHeader.php';
    echo "
    <div id='editprojects'>
        <h2 id='edittitle'>Deallocate Project</h2>
        <hr>
        <h3 id='edittitle'>Please select a project to deallocate for a student</h3>";
            $ModuleView = new ModuleView();
            $ModuleView->deallocateProjectForm();
    echo"</div>";

    include_once './Views/MCFooter.php';
