<?php

    include_once './Views/mcHeader.php';
    echo"
    <h3 id='edittitle'>View students registered to the system</h3><br>
    <!-- Display a paginated table of every student and their details -->";
    
        $displayStuObj = new ModuleView();
        $displayStuObj->showEveryStudent();

    include_once './Views/MCFooter.php';
