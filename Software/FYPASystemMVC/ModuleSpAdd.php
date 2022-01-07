<?php
    include_once './Views/mcHeader.php';
?>
  <!-- Start Projects Section -->
  <div id="editprojects">
      <h2 id="edittitle">Add a Supervisor</h2>
      <hr>
      <h3 id="edittitle">Fill out the form below to add a supervisor to the system</h3>
      <br>
      <?php
          $ModuleView = new ModuleView();
          $ModuleView->addSupervisorForm();
      ?>
  </div>
<?php
    include_once './Views/MCFooter.php';
