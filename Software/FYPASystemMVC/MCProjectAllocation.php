<?php

  include_once './Views/mcHeader.php';
  echo"
  <h3 id='edittitle'>Allocate a student to an available project</h3><br>
  <div class='wrap'>
      <br><br>
      <div class='search'>
          <input type='text' class='searchTerm' id='search-input' onkeyup='searchProjectInfo(1)' placeholder='Search for a project'>
          <button type='submit' class='searchButton'>
              <i class='fa fa-search'></i>
          </button>
      </div>
  </div>
  <br><br><br>";
      $allocateObject = new ModuleView();
      $allocateObject->allocateProjectToStudent();

  include_once './Views/MCFooter.php';
