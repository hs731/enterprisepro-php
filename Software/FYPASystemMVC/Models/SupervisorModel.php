<?php
/**
* Class related to all the interactions supervisor related within the database
* Solely sql queries to manipulate supervisor data in this class
* Handles all database interactions regrarding supervisors
* @author Haider Raoof - getSupervisors(), getSupervisorEmail()
* and getSupervisorFullName() methods. getAllocatedStudents() method
*/
include_once 'Dbh.php';

class SupervisorModel extends Dbh {

    /**
    * Method to get the supervisor ID, first name and last name of every
    * supervisor stored in the Supervisors table of the database
    * @return $results Returns an associative array of supervisor information for
    * each student in the Superviors table of database
    */
    public function getSupervisors(){
        $sql = "SELECT SupervisorID, FirstName, LastName FROM Supervisors";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll();
        return $results;
    }

    /**
    * Method to get the UoB email address of a supervisor
    * @param int $supervisorID Supervisor ID of a supervisor
    * @return $uobEmail a string which is the UoB email of a supervisor
    */
    public function getSupervisorEmail($supervisorID){
        $sql = "SELECT UoBEmail FROM Supervisors WHERE SupervisorID=$supervisorID";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $uobEmail = null;
        foreach ($result as $row) {
            $uobEmail = $row["UoBEmail"];
        }
        return $uobEmail;
    }

    /**
    * Method to get the full name of a supervisor
    * @param int $supervisorID Supervisor ID of a supervisor
    * @return $studentName Returns a string which is the full name of a
    * supervisor
    */
    public function getSupervisorFullName($supervisorID){
        $sql = "SELECT CONCAT(FirstName, ' ',LastName) AS SupervisorName
        FROM Supervisors Where SupervisorID = $supervisorID";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $supervisorName = null;
        foreach ($result as $row) {
            $supervisorName = $row["SupervisorName"];
        }
        return $supervisorName;
    }

    /**
     * getAllProjects method fetch all project in the db
     * @return $result all the project in the db
     */
    public function getAllProjects() {
        $sql = "SELECT p.*,
      (SELECT CONCAT(FirstName, ' ', LastName) FROM Supervisors WHERE p.OriginatorID=SupervisorID) as 'OriginatorName',
      (SELECT CONCAT(FirstName, ' ', LastName) FROM Supervisors WHERE p.AssignedSupervisor=SupervisorID) as 'AssignedSupervisorName',
      (SELECT CONCAT(FirstName, ' ', LastName) FROM Students WHERE p.AssignedStudent=UoBNumber) as 'AssignedStudentName'
      FROM Projects p";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }

    public function getOwnProjects($supervisorID) {
        $sql = "SELECT p.*,
      (SELECT CONCAT(FirstName, ' ', LastName) FROM Supervisors
          WHERE p.OriginatorID=SupervisorID) as 'OriginatorName',
      (SELECT CONCAT(FirstName, ' ', LastName) FROM Supervisors
          WHERE p.AssignedSupervisor=SupervisorID) as 'AssignedSupervisorName',
      (SELECT CONCAT(FirstName, ' ', LastName) FROM Students
          WHERE p.AssignedStudent=UoBNumber) as 'AssignedStudentName'
      FROM Projects p WHERE p.AssignedSupervisor=$supervisorID";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }

    /**
    * method to get projects assinged to a supervisor
    * @param $supervisorID the id of the supervisor
    * @return $result an array of projects assinged to supervisor
    */
    public function getAssignedProjects($supervisorID) {
        $sql = "SELECT p.*,
      (SELECT CONCAT(FirstName, ' ', LastName) FROM Supervisors
          WHERE p.OriginatorID=SupervisorID) as 'OriginatorName',
      (SELECT CONCAT(FirstName, ' ', LastName) FROM Supervisors
          WHERE p.AssignedSupervisor=SupervisorID) as 'AssignedSupervisorName',
      (SELECT CONCAT(FirstName, ' ', LastName) FROM Students
          WHERE p.AssignedStudent=UoBNumber) as 'AssignedStudentName'
      FROM Projects p WHERE p.OriginatorID=$supervisorID";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }

    /**
     * addNewProject method to add a project
     * @param $projectTitle the title of the project
     * @param $supervisorID the id of the originator
     * @param $projectDescription the description of the project
     * @param $programmeOfWork the programme of work of the project
     * @param $deliverables the deliverables of the project
     * @param $lOutcomes the learning outcomes of the project
     * @param $prerequisites the prerequisites of the project
     * @param $extOriginator the external originator (if any) of the project
     * @param $yearOfStudy the year of study the project is for
     */
    public function addNewProject($projectTitle, $supervisorID, $projectDescription,
    $programmeOfWork, $deliverables, $lOutcomes, $prerequisites, $extOriginator, $yearOfStudy){
        $sql = "INSERT INTO Projects
        (ProjectTitle, OriginatorID, Description, ProgrammeOfWork, Deliverables, LearningOutcomes, Prerequisites, ExternalOriginator, YearOfStudy)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$projectTitle, $supervisorID, $projectDescription,
        $programmeOfWork, $deliverables, $lOutcomes, $prerequisites, $extOriginator, $yearOfStudy]);
    }

    /**
    * method to delete project
    * @param $pID the id of the project to be deleted
    */
    public function deleteMyProject($pID)
    {
        $sql = "DELETE FROM Projects WHERE ProjectID = $pID;";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
    }

    /**
     * method to update a project
     * @param $oldprojectid the current id of project to be updated
     * @param $newprojectid the new id of the project
     * @param $projectTitle the title of the project
     * @param $description the description of the project
     * @param $pow the programme of work of the project
     * @param $del the deliverables of the project
     * @param $lo the learning outcomes of the project
     * @param $prereq the prerequisites of the project
     * @param $req the requirements of the project
     * @param $yos the year of study the project is for
     * @param $exto the external originator (if any) of the project
     */
    public function updateMyProject($oldprojectid, $newprojectid, $projecttitle, $description, $pow, $del, $lo, $prereq, $req, $yos, $exto){
        $sql = "UPDATE Projects
        SET ProjectID=?, ProjectTitle=?, Description=?, ProgrammeOfWork=?, Deliverables = ?, LearningOutcomes = ?, Prerequisites=?, Requirements=?, YearOfStudy = ?, ExternalOriginator = ?
        WHERE ProjectID = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$newprojectid, $projecttitle, $description, $pow, $del, $lo, $prereq, $req, $yos, $exto, $oldprojectid]);
    }

    /**
     * getNumberOfSupervisor method get the number of supervisors in the supervisor table
     * @return $results number of supervisor
     */
    public function getNumberOfSupervisor(){
        $sql = "SELECT COUNT(SupervisorID) FROM Supervisors";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetch();
        return $results;
    }

    /**
     * getSupervisorIDs method get all supervisor ids in the supervisor table
     * @return $results an array containing all the supervisorIDs
     */
    public function getSupervisorIDs(){
        $sql = "SELECT SupervisorID FROM Supervisors";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll();
        return $results;
    }

    /**
     * getNumberOfSupervisorProjects method get the number of projects a supervisor has been
     * assigned or originated
     * @param $supervisorID the id of the supervisors
     * @return $results the number of projects that supervisor has
     */
    public function getNumberOfSupervisorProjects($supervisorID){
        $sql = "SELECT COUNT(OriginatorID OR AssignedSupervisor)
        FROM Projects
        WHERE AssignedSupervisor = ? OR OriginatorID = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$supervisorID, $supervisorID]);
        $results = $stmt->fetch();
        return $results;
    }

    /**
     * getProjectbyID method get the  projects a supervisor has been assigned or originated
     * @param $supervisorID the id of the supervisors
     * @return $results an array of projects that supervisor has been assigned or originated
     */
    public function getProjectbyID($supervisorID){
        $sql = "SELECT OriginatorID, ProjectID FROM Projects WHERE OriginatorID = ? AND
        AssignedSupervisor IS NULL AND SelfProposed = 0 AND AssignedStudent IS NOT
        NULL";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$supervisorID]);
        $results = $stmt->fetchAll();
        return $results;
    }

    /**
     * getUnassignedProjects method get all projects with a student but no supervisor and is not
     *  student proposed
     * @return $results an array of projects with originatorID and ProjectID given
     */
    public function getUnassignedProjects(){
        $sql = "SELECT OriginatorID, ProjectID FROM Projects WHERE
        AssignedSupervisor IS NULL AND SelfProposed = 0 AND AssignedStudent IS NOT
        NULL";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll();
        return $results;
    }

    /**
    * getAllocatedStudents method get the students allocated to a supervisor and
    * the project details of each student's project
    * @param int $supervisorID Supervisor ID of a supervisor
    * @return $results Returns an associative array of student information for
    * each student assigned to the supervisor and the project id and title of their projects
    */
    public function getAllocatedStudents($supervisorID){
        $sql = "SELECT p.ProjectID, p.ProjectTitle,
        CONCAT(s.FirstName, ' ',s.LastName) AS 'StudentName', s.UoBNumber,
        s.UoBEmail, p.YearOfStudy FROM Projects p, Students s
        WHERE s.UoBNumber = p.AssignedStudent AND AssignedSupervisor = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$supervisorID]);
        $result = $stmt->fetchAll();
        return $result;
    }

    /**
     * getAssignedProjectsLimit method get supervisor projects
     * that origanted from the supervisor who is the originator of the project
     * gets 10 project at a time
     * @param $supervisorID
     * @param $thisPageFirstResult result of the limit
     * @param $numOfProjectPerPage number of project per page
     * @return $result projects which originated from the supervisor
     * who proppose the project.
     */
    public function getSupervisorOwnProjectLimit($supervisorID, $thisPageFirstResult, $numOfProjectPerPage) {
        $sql = "SELECT p.*,
          (SELECT CONCAT(FirstName, ' ', LastName) FROM Supervisors
              WHERE p.OriginatorID=SupervisorID) as 'OriginatorName',
          (SELECT CONCAT(FirstName, ' ', LastName) FROM Supervisors
              WHERE p.AssignedSupervisor=SupervisorID) as 'AssignedSupervisorName',
          (SELECT CONCAT(FirstName, ' ', LastName) FROM Students
              WHERE p.AssignedStudent=UoBNumber) as 'AssignedStudentName'
        FROM Projects p
          WHERE p.OriginatorID=$supervisorID
        LIMIT $thisPageFirstResult, $numOfProjectPerPage";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }

    /**
     * getSupervisorProjectCount get the number of project a supervisors has
     * @param $supervisorID id of supervisor
     * @return $result number of project origanted from the supervisor
     */
    public function getSupervisorProjectCount($supervisorID){
        $sql = "SELECT * FROM Projects p WHERE p.OriginatorID = $supervisorID";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $result = $stmt->rowCount();
        return $result;
    }
}
