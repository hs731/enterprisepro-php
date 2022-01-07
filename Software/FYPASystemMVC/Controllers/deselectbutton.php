<?php
    include_once '../Models/ProjectsModel.php';
    $uobNUM = $_REQUEST['uobNUM'];
    $projectID = $_REQUEST['projectID'];
    $projectsObject = new ProjectsModel();
    $projectsObject->deselectStudentProject($uobNUM, $projectID);
?>