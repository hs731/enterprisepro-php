<?php
/**
 * The UserModel extends the database handler for connection to the database
 */
include_once 'Dbh.php';
class UserModel extends Dbh{

    /**
     * The authenticateStudent function checks to see if the student is a registered member
     * @param $UoBNumber the student uob number
     * @param $password the student password
     */
    public function authenticateStudent($UoBNumber, $password){
        $sql = "SELECT UoBNumber, Password FROM Students WHERE UoBNumber = ? AND Password= ? ";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$UoBNumber, $password]);
        $row = $stmt->fetch();
        if($row > 0){
          //Start a session
          session_start();
          // Set UobNumber session for student
          $_SESSION['uobnumber'] = $UoBNumber;
          //redirect to the student home page
          header("Location: ./StudentPage.php");
          exit();
        }else{
            echo '<p class="errorregisterlogin">Invalid value entered!</p>';
        }
    }

    /**
     * The authenticateSurpervisor function check is the supervisor exit in the db
     * @param $username the supervisor username
     * @param $password the supervisor password
     */
    public function authenticateSurpervisor($username, $password){
        $sql = "SELECT * FROM Supervisors WHERE Username = ? AND Password= ? ";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$username, $password]);
        $row = $stmt->fetch();
        if($row > 0){
          //Starts a session
          session_start();
          // Set UobNumber session for student
          $_SESSION['supervisorID'] = $row['SupervisorID'];
          //redirect to the student home page
          header("Location: ./SupervisorOwnProjects.php");
        }else{
            echo '<p class="errorregisterlogin">Invalid value entered!</p>';
        }
    }

    /**
     * The authenticateModuleCoordinator function checks to see if module coordinator is in the db
     * @param $modCoordID the module coordinator id
     * @param $password the module coordinator password
     */
    public function authenticateModuleCoordinator($modCoordID, $password){
        $sql = "SELECT ModuleCoordinatorID, Password FROM ModuleCoordinator WHERE ModuleCoordinatorID = ? AND Password = ? ";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$modCoordID, $password]);
        $row = $stmt->fetch();
        if($row > 0){
          //Start a session
          session_start();
          // Set UobNumber session for student
          $_SESSION['moduleCoordinatorID'] = $modCoordID;
          // Redirect to the module coordinator page
          header("Location: ./ModuleCoordinatorPage.php");
          exit();
        }else{
            echo '<p class="errorregisterlogin">Invalid value entered!</p>';
        }
    }
}
