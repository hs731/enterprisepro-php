<?php

include_once './Views/mcHeader.php';
?>

<!-- Start Projects Section -->
<div id="editprojects">
    <h2 id="edittitle">Add a student</h2>
    <hr>
    <h3 id="edittitle">Fill out the form below to add a student to the system</h3>
    <br>
    <!-- Form to add a student -->
    <form method="post" id="addForm">
        <?php
        //show error messages on the site using the $_GET method
        if (isset($_GET['error'])){
            if($_GET['error'] == "ubnumbertaken"){
                echo '<p class="errorregisterlogin">A student has already been registered with the entered UoB Number!</p>';
            }
            else if ($_GET['error'] == "emailtaken"){
                echo '<p class="errorregisterlogin">A student has already been registered with the entered email address!</p>';
            }
        }
        //show success message if student added successfully
        else if (isset($_GET["register"])) {
            if ($_GET["register"] == "success") {
                echo '<p class="successregisterlogin">Added successfully</p>';
            }
        }
        ?>
        <!-- input fields for student add form -->
        <input style="height: 50px"type="text" name="firstname" placeholder="First Name" required pattern="[A-Za-z]+" title="Must only be characters" maxlength="25" />
        <input style="height: 50px"type="text" name="lastname"placeholder="Last Name" required pattern="[A-Za-z]+" title="Must only be characters" maxlength="25"/>
        <input style="height: 50px"type="text" name="uobnum" placeholder="UoB Number" required pattern="[0-9]{8}" title="Must be 8 digits e.g. 00000000" minlength="8" maxlength="8" />
        <input style="height: 50px"type="text" name="uobemail" placeholder="UoB email" required pattern="[\w.%+-]+@bradford\.ac\.uk" title="E.g. example@bradford.ac.uk" maxlength="50" />
        <input style="height: 50px" type="password" name="password"placeholder="Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,16}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 to 16 characters"  maxlength="16">
        <select id ="prog1" name="yearofstudy">
            <!-- drop down menu -->
            <option value="3rd">3rd Year Student</option>
            <option value="MSc">Masters Student</option>
        </select>
        <select id ="prog" name="progofstudy">
            <option value="Computer Science">Computer Science</option>
            <option value="Software Engineering">Software Engineering</option>
            <option value="Cyber Security">Computer Science for Cyber Security</option>
            <option value="Business Computing">Business Computing</option>
        </select>
        <!-- submit form button -->
        <button type="submit" name="addstudent">Add a student </button>
        <br><br>
      </form>
</div>
<!-- End Projects Section -->
<?php
    include_once './Views/MCFooter.php';
