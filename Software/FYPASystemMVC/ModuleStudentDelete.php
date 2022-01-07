<?php

    include_once './Views/mcHeader.php';
    echo"
    <div id='editprojects'>
        <h2 id='edittitle'>Delete student</h2>
        <hr>
        <h3 id='edittitle'>Please select a student to delete from the list below</h3><br>";
            $deleteStudentObj = new ModuleView();
            $deleteStudentObj->showDeleteStudentForm();
    echo"</div>";
    include_once './Views/MCFooter.php';
