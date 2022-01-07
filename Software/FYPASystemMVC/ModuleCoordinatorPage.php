<?php

    include_once './Views/mcHeader.php';
    echo"
    <h3 id='edittitle'>View all projects</h3><br>
    <div class='wrap'>
        <br><br>
        <div class='search'>
            <input type='text' class='searchTerm' id='search-input' onkeyup='searchProjectInfo(1)' placeholder='Search for a project'>
            <button type='submit' class='searchButton'>
                <i class='fa fa-search'></i>
            </button>
        </div>
    </div>
    <br><br><br>
    ";
        $usersObject = new ModuleView();
        $usersObject->getEveryProject(); //personal projects

    include_once './Views/MCFooter.php';
