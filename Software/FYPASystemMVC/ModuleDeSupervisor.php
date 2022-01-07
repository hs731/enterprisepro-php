<?php

    include_once './Views/mcHeader.php';
    echo "
    <div id='editprojects'>
        <h2 id='edittitle'>Deallocate Assigned Supervisor</h2>
        <hr>
        <h3 id='edittitle'>Please select a project to deallocate it's assigned supervisor</h3>";

            $ModuleView = new ModuleView();
            $ModuleView->deallocateSupervisorForm();

        echo"</div>";

     include_once './Views/MCFooter.php';
