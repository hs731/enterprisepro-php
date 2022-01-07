<?php

    include_once './Views/mcHeader.php';
    echo "

    <div id='editprojects'>
        <h2 id='edittitle'>Delete a project</h2>
        <hr>
        <h3 id='edittitle'>Please choose a project to delete from the list below:</h3><br>";
          $ModuleView = new ModuleView();
          $ModuleView->deleteProjectForm();
    echo "</div>";

    include_once './Views/MCFooter.php';
