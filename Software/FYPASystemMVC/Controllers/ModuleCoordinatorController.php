<?php
/**
* The ModuleCoordinatorController Class handles and manipulates data
* utilised by the module coordinator when operating the system
* Used for inserting, deleting, updating data in the Stundents, Supervisors
* or Projects table of the database
* @author Haider Raoof - addStudent(), deleteStudent(), checkIsRegisteredAdd()
* @author Zaka Rehman - balancing()
*/
include_once './Models/StudentModel.php';
include_once './Models/SupervisorModel.php';
include_once './Models/ProjectsModel.php';
include_once './Models/ModuleCoordinatorModel.php';

class ModuleCoordinatorController extends ModuleCoordinatorModel {

  /**
  * The balancing method automatically allocate projects to supervisors in a way that all
  * supervisors have a similar amount of projects
  */
  public function balancing(){
      $supObj = new SupervisorModel();
      $stuObj = new StudentModel();
      $projObj = new ProjectsModel();
      $projectArray = [];

      $supervisorNumber = (int) $supObj->getNumberOfSupervisor();
      $studentNumber = (int) $stuObj->getNumberOfStudents();
      $number = (float) $studentNumber / $supervisorNumber;
      $avg = floor($number);
      $supervisors = $supObj->getSupervisorIDs();
      shuffle($supervisors);

      foreach ($supervisors as $sup) {
        $projNumber = $supObj->getNumberOfSupervisorProjects($sup['SupervisorID']);
        $project = $supObj->getProjectbyID($sup['SupervisorID']);
        // check to see if the number of projects is greater than the avg number
        // of students a supervisor is meant to have
        if ($projNumber > $avg) {
          // allocate projects till he reaches the avg number of students and stop
          $count = 0;
          foreach ($project as $proj) {
            if ($count < $avg) {
              $projObj->setProjectSupervisor($sup['SupervisorID'], $proj['ProjectID']);
              $count = $count + 1;
            } else {
              // add to array the projects that are not allocated to supervisor
              // because he has too many projects
              array_push($projectArray, $proj['ProjectID']);
            }
          }
        }

        // if the number of projects is less than the avg or equal to then
        // allocate all the projects that supervisor has
        if ($projNumber <= $avg) {
          foreach ($project as $proj) {
            $projObj->setProjectSupervisor($sup['SupervisorID'], $proj['ProjectID']);
          }
        }
      }

      // add all unassigned projects to an array
      $projectArray = $supObj->getUnassignedProjects();
      shuffle($projectArray);

      // go through the supervisors to find the ones that have less projects than
      // the avg number of students and assign them projects till they have enough
      foreach ($supervisors as $sup) {
        $projNumber = $supObj->getNumberOfSupervisorProjects($sup['SupervisorID']);
        $count = $projNumber;
        if($projNumber < $avg){
          while ($count < $avg) {
            $project = array_shift($projectArray);
            $projObj->setProjectSupervisor($sup['SupervisorID'], $project['ProjectID']);
            $count = $count + 1;
            }
          }
        }

        // allocate remaining projects evenly amongst the supervisors once all
        // have enough projects
        foreach ($projectArray as $proj) {
            shuffle($supervisors);
            foreach ($supervisors as $sup) {
              $projObj->setProjectSupervisor($sup['SupervisorID'], $proj['ProjectID']);
              break;
            }
        }

        echo "<script>alert('Automatic Allocation is Complete')</script>";
    }

    /** The add student method to add a student to the system */
    public function addStudent(){
        // Take values from the form
        $firstName = $_POST['firstname'];
        $lastName = $_POST['lastname'];
        $uobNumber = $_POST['uobnum'];
        $uobEmail = $_POST['uobemail'];
        $password = $_POST['password'];
        $programmeOfStudy = $_POST['progofstudy'];
        $yearOfStudy = $_POST['yearofstudy'];
        // Make name completely lowercase
        $firstName = strtolower($firstName);
        $lastName = strtolower($lastName);
        //Make first character of both strings a capital
        $firstName = ucfirst($firstName);
        $lastName = ucfirst($lastName);
        // Check if student exists in database
        $this->checkIsRegisteredAdd($uobNumber, $uobEmail);
        // Add student to database
        $addStudentObj = new StudentModel();
        $addStudentObj->setStudent($firstName, $lastName, $uobNumber, $uobEmail,
        $programmeOfStudy, $password, $yearOfStudy);
    }

    /**
    * The checkIsRegisteredAdd function prevents adding student who has already been
    * registered
    * It calls the checkIsStudentByNum and checkStudentByEmail function to check
    * if student already exists. If it returns true then it sends the user back
    * to the ModuleStudentAdd page with an error message in url that a student
    * has already been registered with this UobNumber or UobEmail address
    * @param int $uobNumber UoBNumber number of a student
    * @param int $uobEmail UoBEmail of a student
    */
    public function checkIsRegisteredAdd($uobNumber, $uobEmail){
      $checkStudentObj = new StudentModel();
      if($checkStudentObj->checkIsStudentByNum($uobNumber) == true){
          header("Location: ./ModuleStudentAdd.php?error=ubnumbertaken");
          exit();
      }
      else if($checkStudentObj->checkIsStudentByEmail($uobEmail) == true){
          header("Location: ./ModuleStudentAdd.php?error=emailtaken");
          exit();
      } else {
          header("Location: ./ModuleStudentAdd.php?register=success");
      }
    }

    /**
    * deleteStudent method delete a student from the system
    */
    public function deleteStudent(){
        $uobNumber = $_POST['UoBNumber'];
        $this->removeStudent($uobNumber);
        // Show alert that student has been deleted
        echo "<script>alert('Student deleted')</script>";
    }

    /**
    * updateStudent method to update a student in the database
    */
    public function updateStudent(){
        $olduobnum = $_POST['olduob'];
        $newuobnum = $_POST['newuob'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $programme = $_POST['programme'];
        $password = $_POST['password'];
        $year = $_POST['year'];
        $noselect = $_POST['noselect'];

        $this->updateStudentDetails($olduobnum, $newuobnum, $firstname, $lastname, $email, $programme, $password, $year, $noselect);
        echo "<script>alert('Succesfully updated student')</script>";
    }

    /**
    * addProject method add new project to the db
    */
    public function addProject(){
        $projectTitle = $_POST['title'];
        $projectDescription = $_POST['desc'];
        $programmeOfWork = $_POST['pow'];
        $deliverables = $_POST['deliverables'];
        $lOutcomes = $_POST['lOutcomes'];
        $prerequisites = $_POST['prerequisites'];
        $extOriginator = $_POST['extOriginator'];
        $yearOfStudy = $_POST['yearOfStudy'];

        $this->addNewProject($projectTitle, $projectDescription, $programmeOfWork, $deliverables, $lOutcomes, $prerequisites, $extOriginator, $yearOfStudy);
        echo "<script>alert(`Added project: $projectTitle`)</script>";
    }

    /**
     * deleteProject method delete project from the db
     * @param $pID project id
     */
    public function deleteProject($pID){
        $this->deleteMyProject($pID);
    }

    /**
    * updateProject method update a project in the database
    */
    public function updateProject(){
        $oldprojectid = $_POST['oldprojectid'];
        $newprojectid = $_POST['ProjectID'];
        $projecttitle = $_POST['ProjectTitle'];
        $description = $_POST['Description'];
        $pow = $_POST['ProgrammeOfWork'];
        $del = $_POST['Deliverables'];
        $lo = $_POST['LearningOutcomes'];
        $prereq = $_POST['Prerequisites'];
        $req = $_POST['Requirements'];
        $yos = $_POST['YearOfStudy'];
        $exto = $_POST['ExternalOriginator'];

        $this->updateProjectDetails($oldprojectid, $newprojectid, $projecttitle, $description, $pow, $del, $lo, $prereq, $req, $yos, $exto);
        echo "<script>alert('Succesfully updated project')</script>";
    }


    /**
    * addSupervisor method add new supervisor to the db
    */
    public function addSupervisor(){
        $firstname = $_POST['firstName'];
        $lastname = $_POST['lastName'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];

        $this->addNewSupervisor($firstname, $lastname, $username, $password, $email);
        echo "<script>alert(`Added supervisor: $firstname $lastname`)</script>";
    }

    /**
    * Method to check if Supervisor ID is not taken
    */
    public function supervisoridAllowed($supervisorID){
    }

    /**
    * deleteSupervisor method delete supervisor
    * @param $supervisorID supervisor id
    */
    public function deleteSupervisor($supervisorID){
        $this->deleteSupervisorRow($supervisorID);
        echo "<script>alert('Deleted Supervisor: $supervisorID')</script>";
    }

    /**
    * updateSupervisor method update a supervisor in the database
    */
    public function updateSupervisor(){
        $oldsupervisorid = $_POST['oldsupervisorid'];
        $newsupervisorid = $_POST['supervisorID'];
        $fname = $_POST['firstName'];
        $lname = $_POST['lastName'];
        $uname = $_POST['username'];
        $pword = $_POST['password'];
        $em = $_POST['email'];

        $this->updateSupervisorDetails($oldsupervisorid, $newsupervisorid, $fname, $lname, $uname, $pword, $em);
        echo "<script>alert('Succesfully updated supervisor')</script>";
    }

    /**
     * allocateStudent method allocate project to a student 
     */
    public function allocateStudent(){
        $uob = $_POST['UoBNumber'];
        $pid = $_POST['projectid'];

        if ($uob != "") {
            $projectsObject = new ProjectsModel();
            $projectsObject->studentProjectAllocate($uob, $pid);
            echo "<script>alert('Allocated student $uob to project $pid')</script>";
        }
        else{
            echo "<script>alert('No student selected')</script>";
        }
    }

    /**
     * allocatesupervisor method
     */
    public function allocatesupervisor(){
        $uob = $_POST['uob'];
        $supID= $_POST['SupervisorID'];

        if($uob != "" && $supID != ''){
            $projectsObject = new ProjectsModel();
            $projectsObject->assingStudentSupervisor($supID, $uob);
            echo "<script>alert('Allocated student $uob to supervisor $supID')</script>";
        }else{
            echo "<script>alert('No Supervisor selected')</script>";
        }
    }

    /**
     * deallProject() will deallocate a project for a student via project id
     */
    public function deallProject(){
        $id = $_POST['projectid'];
        $this->deallocateProjectByID($id);

        echo "<script>alert('Deallocated project $id')</script>";
    }

    /**
     * deallSupervisor() will deallocate an assigned supervisor from a project
     */
    public function deallSupervisor(){
        $id = $_POST['projectid'];
        $this->deallocateAssignedSupervisorByID($id);

        echo "<script>alert('Deallocated assigned supervisor from Project $id. Project $id now available for selection again.')</script>";
    }
}
 ?>
