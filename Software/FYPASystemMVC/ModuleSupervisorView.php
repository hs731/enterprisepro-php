<?php

    include_once './Views/mcHeader.php';
    echo "
    <h3 id='edittitle'>View supervisors registered to the system</h3><br>
    <!-- Display a paginate table of every supervisor and their details -->";

      $displayStuObj = new ModuleView();
      $displayStuObj->showEverySupervisor();

    include_once './Views/MCFooter.php';
