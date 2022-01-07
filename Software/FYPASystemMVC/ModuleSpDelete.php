<?php
      include_once './Views/mcHeader.php';
?>

        <div id="editprojects">
        <h2 id="edittitle">Delete a supervisor</h2>
        <hr>
        <h3 id="edittitle">Please select a supervisor to delete from the list below</h3><br>
        <?php
            $ModuleView = new ModuleView();
            $ModuleView->deleteSupervisorForm();
        ?>

        </div>

        <!-- End Projects Section -->
<?php
    include_once './Views/MCFooter.php';
