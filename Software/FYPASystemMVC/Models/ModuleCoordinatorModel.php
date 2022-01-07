<?php
/**
* The ModuleCoordinatorModel Class related to all the interactions module coordinator related within the database
* Solely sql queries to manipulate module coordinator data in this class
* Handles all database interactions regrarding the module coordinator
* @author Haider Raoof - getModCoordEmail() method, getAllocatedSupervisorsInfo()
* getAllocatedStudents(), getStudents(), removeStudent(), getStudentCount(),
* getStudentsLimited(), getSupervisorCount(), getSupervisorsLimited(),
* getStudentsWithProjectCount() and getStudentsWithProjectsLimited()
*/
include_once 'Dbh.php';

class ModuleCoordinatorModel extends Dbh {
  /**
  * The getModCoordEmail Method get the UoB email address of the module coordinator
  * @return $uobEmail Returns a string which is the UoB email of a supervisor
  */
    public function getModCoordEmail(){
        $sql = "SELECT UoBEmail FROM ModuleCoordinator";
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
    * getAllocatedSupervisorsInfo Method get every supervisor that has been allocated a student
    * @return $results Returns an associative array of supervisor
    * information regarding a supervisors ID number, name and email
    * for those supervisors that have been assigned students
    */
    public function getAllocatedSupervisorsInfo(){
        $sql = "SELECT p.AssignedSupervisor, CONCAT(su.FirstName, ' ',su.LastName)
        AS 'SupervisorName', su.UoBEmail AS 'SupervisorEmail' FROM Projects p,
        Supervisors su WHERE p.AssignedSupervisor = su.SupervisorID
        GROUP BY p.AssignedSupervisor ORDER BY p.AssignedSupervisor ASC";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }

    /**
    * getAllocatedStudents Method get the students allocated to a supervisor and
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
     *  Method to get all data about supervisors
     *  @return $result all rows in supervisor table as array
     */
    public function getAllSupervisors(){
        $sql = "SELECT * FROM Supervisors";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }

    /**
     * getUnallocatedProjectCount counts the number of project that has not be assign to any student
     * @return $NumOfProjectsAvailable number of project that is not assigned to any student
     */
    public function getUnallocatedProjectCount(){
        $sql = "SELECT * FROM Projects WHERE Projects.AssignedStudent IS NULL
        AND Projects.Availability = 1";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $NumOfProjectsAvailable = $stmt->rowCount();
        return $NumOfProjectsAvailable;
    }
    /**
     * The getUnallocatedProject gets all the project that has not be assign to any student
     * @param $thisPageFirstResult
     * @param $numOfProjectPerPage number of project per page
     * @return $unallocateProj  array of all unallocated project
     */
    public function getUnallocatedProject($thisPageFirstResult, $numOfProjectPerPage){
        $sql = "SELECT p.ProjectID, p.ProjectTitle, CONCAT(s.FirstName, ' ' , s.LastName) AS 'Originator',
        p.Description, p.ProgrammeOfWork, p.Deliverables, p.LearningOutcomes, p.Prerequisites, p.Requirements, p.ExternalOriginator
        FROM Projects p LEFT JOIN Supervisors s
        ON p.OriginatorID = s.SupervisorID
        WHERE p.AssignedStudent IS NULL
        AND p.Availability = 1
        LIMIT $thisPageFirstResult, $numOfProjectPerPage";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $unallocateProj = $stmt->fetchAll();
        return $unallocateProj;
    }

    /**
     * The getStudents method get all information about all students in the Students table of database
    * @return $results an associative array of student information for each
    * student in the Students table of database
    */
    public function getStudents(){
        $sql = "SELECT * FROM Students";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll();
        return $results;
    }

    /**
    * Method to remove a student from the system
    * @param int $uobNumber UoBNumber number of a student
    */
    public function removeStudent($uobNumber){
        // Set the ability of the project to available if the student to be deleted
        // has selected a project
        $sql = "UPDATE Projects SET Availability = 1 WHERE AssignedStudent = ?;";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$uobNumber]);
        // If the student to be deleted has selected a project which has been
        // assigned a supervisor, unassign the supervisor
        $sql = "UPDATE Projects SET AssignedSupervisor = NULL WHERE AssignedStudent = ?;";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$uobNumber]);
        // Now unassign the student from the project
        $sql = "UPDATE Projects SET AssignedStudent = NULL WHERE AssignedStudent = ?;";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$uobNumber]);
        // Delete the student
        $sql = "DELETE FROM Students WHERE UoBNumber = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$uobNumber]);
    }

    /**
    * Method to update information about a student
    * @param $olduobnum the old uobNumber of the student
    * @param $newuobnum the new uobNumber of the student
    * @param $firstname the new first name of the student
    * @param $lastname the nww last name of the student
    * @param $email the new email of the student
    * @param $programme the new programme of the student
    * @param $password the new password of the student
    * @param $year the new year of study of the student
    * @param $noselect the new number of selections of the student
    */
    public function updateStudentDetails($olduobnum, $newuobnum, $firstname, $lastname, $email, $programme, $password, $year, $noselect){
        $sql = "UPDATE Students
        SET UoBNumber = ?, FirstName = ?, LastName = ?, UoBEmail = ?, ProgrammeOfStudy = ?, Password = ?, YearOfStudy = ?, NumberOfSelections = ?
        WHERE UoBNumber = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$newuobnum, $firstname, $lastname, $email, $programme, $password, $year, $noselect, $olduobnum]);
    }

    /**
    * method to add new project to the Database
    * @param $projectTitle the title of the project added
    * @param $projectDescription the description of the project added
    * @param $programmeOfWork the programme of work the project is for
    * @param $deliverables the deliverables of the project added
    * @param $lOutcomes the learning outcomes of the project added
    * @param $prerequisites the Prerequisites of the project added
    * @param $extOriginator the external Originator if any of the project added
    * @param $yearOfStudy the year of study the project added is for
    */
    public function addNewProject($projectTitle, $projectDescription, $programmeOfWork, $deliverables, $lOutcomes, $prerequisites, $extOriginator, $yearOfStudy)
    {
        $sql = "INSERT INTO Projects
        (ProjectTitle, Description, ProgrammeOfWork, Deliverables, LearningOutcomes, Prerequisites, ExternalOriginator, YearOfStudy)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?);";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$projectTitle, $projectDescription, $programmeOfWork, $deliverables, $lOutcomes, $prerequisites, $extOriginator, $yearOfStudy]);
    }

    /**
    * method to delete project given a project id
    * @param $pID the id of the project to be deleted
    */
    public function deleteMyProject($pID){
        $sql = "DELETE FROM Projects WHERE ProjectID = $pID;";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
    }

    /**
    * Method to update information about a project
    * @param $oldprojectid the old id of the project
    * @param $newprojectid the new id of the project
    * @param $projectTitle the new title of the project
    * @param $description the new description of the project
    * @param $pow the new programme of work of the project
    * @param $del the new deliverables of the project
    * @param $lo the new learning outcomes of the project
    * @param $prereq the new prerequisites of the project
    * @param $req the new requirements of the project
    * @param $yos the new year of study of the project
    * @param $exto the new external originator of the project
    */
    public function updateProjectDetails($oldprojectid, $newprojectid, $projecttitle, $description, $pow, $del, $lo, $prereq, $req, $yos, $exto){
        $sql = "UPDATE Projects
        SET ProjectID=?, ProjectTitle=?, Description=?, ProgrammeOfWork=?, Deliverables = ?, LearningOutcomes = ?, Prerequisites=?, Requirements=?, YearOfStudy = ?, ExternalOriginator = ?
        WHERE ProjectID = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$newprojectid, $projecttitle, $description, $pow, $del, $lo, $prereq, $req, $yos, $exto, $oldprojectid]);
    }

    /**
    * method to add new supervsior to the Database
    * @param $firstname the first name of the supervisor added
    * @param $lastname the last name of the supervisor added
    * @param $username the username of the supervisor added
    * @param $password the password of the supervisor added
    * @param $email the email of the supervisor added
    */
    public function addNewSupervisor($firstname, $lastname, $username, $password, $email){
        $sql = "INSERT INTO Supervisors(FirstName, LastName, Username, Password, UoBEmail)
        VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$firstname, $lastname, $username, $password, $email]);
    }

    /**
    * method to delete supervisor from database
    * @param $supervisorID the id of the supervisor that is going to be deleted
    */
    public function deleteSupervisorRow($supervisorID)
    {
        $this->nullOringatorAndSupervisor($supervisorID); //null where key constraint before deletion
        $sql = "DELETE FROM Supervisors WHERE SupervisorID = $supervisorID;";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
    }

    /**
    * Method to update information about a supervisor
    * @param $oldsupervisorid the current supervisor id that is going to be updated
    * @param $newsupervisorid the new supervisor id of the supervisor
    * @param $fname the new first name of the supervisor
    * @param $lname the new last name of the supervisor
    * @param $uname the new username of the supervisor
    * @param $pword the new password of the supervisor
    * @param $em the new email of the supervisor
    */
    public function updateSupervisorDetails($oldsupervisorid, $newsupervisorid, $fname, $lname, $uname, $pword, $em){
        $sql = "UPDATE Supervisors
        SET SupervisorID = ?, FirstName = ?, LastName = ?, Username = ?, Password = ?, UoBEmail = ?
        WHERE SupervisorID = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$newsupervisorid, $fname, $lname, $uname, $pword, $em, $oldsupervisorid]);
    }

    /**
    * method to set originator and Assigned Supervisor to null of supervisor who
    * is going to be deleted
    * @param $supervisorID the id of the supervisor to be deleted
    */
    public function nullOringatorAndSupervisor($supervisorID){
        $sql = "UPDATE Projects SET OriginatorID=null AND AssignedSupervisor=null WHERE OriginatorID=$supervisorID OR AssignedSupervisor=$supervisorID";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
    }

    /**
     * The getStudentWithNoprojectAllocation method gets all the student that does not
     * have a project allocated to them
     * @return $result array of student with no allocated project
     */
    public function studentWithNoprojectAllocation(){
        $sql = "SELECT s.FirstName, s.LastName, s.UoBNumber
        FROM Students s
        WHERE NOT EXISTS (SELECT p.AssignedStudent FROM Projects p WHERE s.UoBNumber=p.AssignedStudent)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll();
        return $results;
    }

    /**
     * The getStudentCount method returns the total number of students in the Database
     * @return $totalNumOfStudents an integer value represeting the number
     * of students in the Students table of the database
     */
    public function getStudentCount(){
        $sql = "SELECT * FROM Students";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $totalNumOfStudents = $stmt->rowCount();
        return $totalNumOfStudents;
    }

    /**
     * The getStudentsLimited method gets all the students in the database
     * @param int $thisPageFirstResult the result of db data to diplay on the page
     * @param int $numOfProjectPerPage number of project to be display per page
     * @return $result an array of all the students in the database
     */
    public function getStudentsLimited($thisPageFirstResult, $numOfProjectPerPage) {
        $sql = "SELECT * FROM Students
        LIMIT $thisPageFirstResult, $numOfProjectPerPage";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }

    /**
     * The getSupervisorCount method returns the total number of supervisors in the Database
     * @return $totalNumOfSupervisors an integer value represeting the number
     * of supervisors in the Supervisors table of the database
     */
    public function getSupervisorCount(){
        $sql = "SELECT * FROM Supervisors";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $totalNumOfSupervisors = $stmt->rowCount();
        return $totalNumOfSupervisors;
    }

    /**
     * The getSupervisorsLimited method gets all the supervisors in the database
     * @param int $thisPageFirstResult the result of db data to diplay on the page
     * @param int $numOfProjectPerPage number of project to be display per page
     * @return $result an array of all the supervisors in the database
     */
    public function getSupervisorsLimited($thisPageFirstResult, $numOfProjectPerPage) {
        $sql = "SELECT * FROM Supervisors
        LIMIT $thisPageFirstResult, $numOfProjectPerPage";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }

    /**
     * The getStudentsWithProjectCount method returns the total number of students
     * who have selected a project
     * @return $totalNumOfStudents an integer value represeting the number
     * of students who have selected a project in the Projects table of database
     */
    public function getStudentsWithProjectCount(){
        $sql = "SELECT * FROM Projects WHERE AssignedStudent IS NOT NULL";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $totalNumOfStudents = $stmt->rowCount();
        return $totalNumOfStudents;
    }

    /**
     * The getStudentsWithProjectsLimited method gets all the students in the database
     * who have selected a project
     * @param int $thisPageFirstResult the result of db data to diplay on the page
     * @param int $numOfProjectPerPage number of project to be display per page
     * @return $result an array of all the students in the database who have seletced
     * a project and their project id and title
     */
    public function getStudentsWithProjectsLimited($thisPageFirstResult, $numOfProjectPerPage) {
        $sql = "SELECT s.FirstName, s.LastName, s.UoBNumber, s.UoBEmail, s.ProgrammeOfStudy, s.YearOfStudy, p.ProjectID, p.ProjectTitle, CONCAT(su.FirstName, ' ',su.LastName) AS 'Supervisor'
        FROM Projects p
        LEFT JOIN Supervisors su ON p.AssignedSupervisor = su.SupervisorID
        INNER JOIN Students s ON p.AssignedStudent = s.UoBNumber
        LIMIT $thisPageFirstResult, $numOfProjectPerPage";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }

    /**
     * getAllocatedProjects method returns projects which are
     * allocated to a student
     * @return $result project allocated to student
     */
    public function getAllocatedProjects(){
        $sql = "SELECT * FROM Projects WHERE AssignedStudent IS NOT NULL";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }

    /**
     * getStudentByID returns a student row via uobnumber passed as parameter
     * @param $id the UoBNumber of the student who' details are returned
     * @return $resuslt an array of the student details given by the param
     */
    public function getStudentByID($id){
        $sql = "SELECT * FROM Students WHERE UoBNumber = $id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }

    /**
    * deallocate assigned student from project and make project available to everyone again
    * @param $id the id of the project to be deallocated
    */
    public function deallocateProjectByID($id){
        $sql = "UPDATE Projects SET AssignedStudent = null, Availability = 1 WHERE ProjectID=$id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        // $result = $stmt->fetchAll();
        // return $result;
    }

    /**
     * getProjectsWithSupervisor method returns projects where assigned supervisor is not null
     * @return $result an array of projects that have a supervisor
     */
    public function getProjectsWithSupervisor(){
        $sql = "SELECT * FROM Projects WHERE AssignedSupervisor IS NOT NULL";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }

    /**
     * getSupervisorByID returns a superisor row via supervisorid passed as parameter
     * @param $supervisorID the id of the supervisor who' details are returned
     * @return $result an array of the supervisor details
     */
    public function getSupervisorByID($supervisorid){
        $sql = "SELECT * FROM Supervisors WHERE SupervisorID = $supervisorid";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }

    /**
    * deallocate assigned supervisor from project
    * @param $id the id of the project 
    */
    public function deallocateAssignedSupervisorByID($id){
        $sql = "UPDATE Projects SET AssignedSupervisor = null WHERE ProjectID=$id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
    }
}
