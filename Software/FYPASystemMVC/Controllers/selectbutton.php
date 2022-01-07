<?php 
    include_once '../Models/ProjectsModel.php';
    $uobNUM = $_REQUEST['uobNUM'];
    $projectID = $_REQUEST['projectID'];

    $projectsObject = new ProjectsModel();
    $projectsObject->setProjectStudent($uobNUM, $projectID);

    echo "<script>location.reload();</script>"; //refresh page to load new table after selection
?>