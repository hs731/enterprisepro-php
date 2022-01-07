<?php 

  include_once './Views/mcHeader.php';
    echo "
    <h3 id='edittitle'>Students assigned to a project</h3><br>
    <!-- Display a paginate table of every student and their details -->";      
      $displayStuObj = new ModuleView();
      $displayStuObj->showStudentsWithAProject();

  include_once './Views/MCFooter.php';

