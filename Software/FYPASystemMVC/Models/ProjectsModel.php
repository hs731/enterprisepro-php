<?php
/**
 * The ProjectsModel class related to interactions for all projects in the database
 * Solely sql queries to manipulate project data in this class
 *
 * @author Zaka Rehman - getAllProjects, getSupervisorProject, getStudentProject,
 * changeProject, setProjectStudent, setProjectSupervisor, setStudentSupervisor,
 * setProject, editProject, deleteProject
 * @author Haris Shakil - getAllProjects, deselectStudentProject, incrementSelections, allowSelection
 */
include_once 'Dbh.php';
class ProjectsModel extends Dbh
{
    /**
     * The getAllProjects method gets all the projects in the database. Not intended for pagination usage, only general data usage.
     * @return $result an array of all the projects in the database
     */
    public function getAllProjectsNoLimit()
    {
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

    /**
     * The getAllProjects method gets all the projects in the database
     * @param $thisPageFirstResult the result of db data to diplay on the page
     * @param $numOfProjectPerPage number of project to be display per page
     * @return $result an array of all the projects in the database
     */
    public function getAllProjects($thisPageFirstResult, $numOfProjectPerPage)
    {
        $sql = "SELECT p.*,
        (SELECT CONCAT(FirstName, ' ', LastName) FROM Supervisors WHERE p.OriginatorID=SupervisorID) as 'OriginatorName',
        (SELECT CONCAT(FirstName, ' ', LastName) FROM Supervisors WHERE p.AssignedSupervisor=SupervisorID)
        as 'AssignedSupervisorName',
        (SELECT CONCAT(FirstName, ' ', LastName) FROM Students WHERE p.AssignedStudent=UoBNumber) as 'AssignedStudentName'
        FROM Projects p
        LIMIT $thisPageFirstResult, $numOfProjectPerPage";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }

    /**
     * The getSupervisorProject method to view all projects a supervisor has
     * @param int $supervisorID for the id of the supervisor
     * @return $result an array of all the projects a supervisor has
     */
    public function getSupervisorProject($supervisorID)
    {
        $sql = "SELECT * FROM Projects WHERE OriginatorID = ? OR AssignedSupervisor
        = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$supervisorID, $supervisorID]);
        $result = $stmt->fetchAll();
        return $result;
    }

    /**
     * The getStudentProject method gets all projects a student has
     * @param int $uobNumber for the uobNumber of the student
     * @return $result an array of the project a student has
     */
    public function getStudentProject($uobNumber)
    {
        $sql = "SELECT * FROM Projects WHERE AssignedStudent
        = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$uobNumber]);
        $result = $stmt->fetchAll();
        return $result;
    }

    /**
     * The changeProject method change project a student has picked
     * @param int $uobNumber for the uobNumber of the student
     * @param int $projectID for the id of the project the student changes to
     */
    public function changeProject($uobNumber, $projectID)
    {
        $sql = "UPDATE Projects SET AssignedStudent = NULL, Availability = 1 WHERE AssignedStudent = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute($uoBNumber);
        $sql1 = "UPDATE Projects SET AssignedStudent = ?, Availability = 0 WHERE ProjectID =?";
        $stmt1 = $this->connect()->prepare($sql1);
        $stmt1->execute([$uobNumber, $projectID]);
    }

    /**
     * The incrementSelections method increment number of selections
     * @param int $uobNumber for the uobNumber of the student
     */
    public function incrementSelections($uoBNumber)
    {
        $sql = "UPDATE Students SET NumberOfSelections = NumberOfSelections + 1 WHERE UoBNumber=$uoBNumber";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
    }

    /**
     * The allowSelection method check if student has already selected a project
     * @param int $uobNumber for the uobNumber of the student
     * @return $result of assignedStudent value from the projects table
     */
    public function allowSelection($uoBNumber)
    {
        $sql = "SELECT AssignedStudent FROM Projects WHERE AssignedStudent=$uoBNumber";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }

    /**
     * The getNumberOfSelections method check if student has already selected a project
     * @param int $uobNumber for the uobNumber of the student
     * @return $result of the number of selections a student has made
     */
    public function getNumberOfSelections($uoBNumber){
        $sql = "SELECT NumberOfSelections FROM Students WHERE UoBNumber=$uoBNumber";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result;
    }

    /**
     * The setProjectStudent method assign student to project
     * @param int $uobNumber for the uobNumber of the student
     * @param int $projectID for the id of the project the student chooses
     */
    public function setProjectStudent($uoBNumber, $projectID)
    {
        $selected = $this->allowSelection($uoBNumber); //get current projects
        $selectionAmount = $this->getNumberOfSelections($uoBNumber); //get amount of selections
        $selectionAmount = $selectionAmount["NumberOfSelections"];

        if(empty($selected) AND $selectionAmount<2){ //allow selection only if not already selected
            $sql = "UPDATE Projects SET AssignedStudent = ?, Availability = 0
            WHERE ProjectID = ? AND AssignedStudent IS NULL";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$uoBNumber, $projectID]);
            $this->incrementSelections($uoBNumber); //increase number of selections
            $this->setDateSelected($uoBNumber); //save date of selection
            echo "<script>alert('Project allocation successful')</script>";
        }
        else{ // message when not allowed selection
            echo "<script>alert('Not allowed! Already selected project or have reached limit of two selections')</script>";
        }
    }

    /**
    * method to save the date the project was selected
    * @param $uob the uobnumber of the student who selected a project
    */
    public function setDateSelected($uob){ //save date of selection
        $sql = "UPDATE Students SET DateProjSelected = CURDATE() WHERE UoBNumber = $uob";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
    }

    /**
    * method to get the number of days since the project was selected
    * @param $uob the uobNumber of the student who is selecting a project
    * @return $days the number of days it has been since the student selected the project
    */
    public function getSelectDateDiff($uob){ //return diff of current date and last selected project date
        $sql = "SELECT DATEDIFF(CURDATE(), DateProjSelected) as 'days' FROM Students WHERE UoBNumber = $uob";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch();
        $days = $result["days"];
        return $days;
    }

    /**
     * The studentProjectAllocate method assign student to project - used by module co
     * @param int $uobNumber for the uobNumber of the student
     * @param int $projectID for the id of the project the student chooses
     */
    public function studentProjectAllocate($uoBNumber, $projectID)
    {
        $sql = "UPDATE Projects SET AssignedStudent = ?, Availability = 0
        WHERE ProjectID = ? AND AssignedStudent IS NULL";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$uoBNumber, $projectID]);
        $this->setDateSelected($uoBNumber); //save date of selection
    }

    /**
      * The deselectStudentProject Deselect project for student by updating project availability to 1 and assigned student to null
      * @param integer $projectID id of project to deselect
    */
    public function deselectStudentProject($uoBNumber,$projectID)
    {
        $selectionAmount = $this->getNumberOfSelections($uoBNumber); //get amount of selections
        $selectionAmount = $selectionAmount["NumberOfSelections"];
        $dayDiff = $this->getSelectDateDiff($uoBNumber);

        if ($selectionAmount < 2 AND $dayDiff <= 7) {
            $sql = "UPDATE Projects SET Availability = 1, AssignedStudent = null WHERE ProjectID = $projectID;";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute();
        }
        elseif ($selectionAmount < 2 AND $dayDiff > 7) {
            echo "<script>alert('Not allowed! Current project has been selected for longer than 7 days.')</script>";
        }
        elseif($selectionAmount >= 2 AND $dayDiff <= 7){
            echo "<script>alert('Not allowed! Reached limit of 2 project selections.')</script>";
        }
        else{
            echo "<script>alert('Not allowed! Reached limit of 2 project selections or project has been selected for longer than 7 days.')</script>";
        }
    }

    /**
     * The setProjectSupervisor method assign supervisor to project
     * @param int $supervisorID for the id of the supervisor
     * @param int $projectID for the id of the project the supervisor supervises
     */
    public function setProjectSupervisor($supervisorID, $projectID)
    {
        $sql = "UPDATE Projects SET AssignedSupervisor = ? WHERE ProjectID = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$supervisorID, $projectID]);
    }

    /**
     * The setStudentSupervisor method assign supervisor and student to project
     * @param int $uobNumber for the uobNumber of the student
     * @param int $projectID for the id of the project the student chooses
     * @param int $supervisorID for the id of the supervisor assigned to project
    */
    public function setStudentSupervisor($supervisorID, $projectID, $uoBNumber)
    {
        $sql = "UPDATE Projects SET AssignedSupervisor = ?, AssignedStudent = ? WHERE ProjectID = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$supervisorID, $uoBNumber, $projectID]);
    }

    /**
     * The assingStudentSupervisor method assign student with an project to a supervisor
     * @param int $uobNumber the uobNumber of the student
     * @param int $supervisorID id of the supervisor to be assign to student
    */
    public function assingStudentSupervisor($supervisorID, $uoBNumber)
    {
        $sql = "UPDATE Projects SET AssignedSupervisor = ?  WHERE AssignedStudent = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$supervisorID, $uoBNumber]);
    }

    /**
     * The setProject method add project to the database
     * @param string $projectTitle for the title of the project
     * @param int $originator for the id of the Originator
     * @param string $description for the description of the project
     * @param string $programmeOfWork for the programme of work for the project
     * @param string $deliverables for the deliverables of the project
     * @param string $learningOutcomes for the learning outcomes of the project
     * @param string $prerequisites for the prerequisites of the project
     * @param string $requirements for the hardware and software requirements of the project
     * @param string $yearOfStudy for the year of study (3rd or MSc) a project is for
     * @param int $selfProposed for whether a project was proposed by a student or not
     */
    public function setProject($projectTitle, $originator, $description,
    $programmeOfWork, $deliverables, $learningOutcomes, $prerequisites,
    $requirements, $yearOfStudy, $selfProposed)
    {
        $sql = "INSERT INTO Projects(ProjectTitle, OriginatorID, Description,
          ProgrammeOfWork, Deliverables, LearningOutcomes, Prerequisites,
          Requirements, YearOfStudy, Availability, SelfProposed) VALUES(?, ?, ?, ?,
          ?, ?, ?, ?, ?, False, ?)";

        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$projectTitle, $originator, $description, $programmeOfWork,
        $deliverables, $learningOutcomes, $prerequisites, $requirements,
        $yearOfStudy, $selfProposed]);
    }

    /**
     * The editProject method edit project details in the database
     * @param int $projectID for the id of the project
     * @param string $projectTitle for the title of the project
     * @param string $description for the description of the project
     * @param string $programmeOfWork for the programme of work for the project
     * @param string $deliverables for the deliverables of the project
     * @param string $learningOutcomes for the learning outcomes of the project
     * @param string $prerequisites for the prerequisites of the project
     * @param string $requirements for the hardware and software requirements of the project
     * @param string $yearOfStudy for the year of study (3rd or MSc) a project is for
     */
    public function editProject($projectID, $projectTitle, $description,
    $programmeOfWork, $deliverables, $learningOutcomes, $prerequisites,
    $requirements, $yearOfStudy)
    {
        $sql = "UPDATE Projects SET ProjectTitle = ?, Description
        = ?, ProgrammeOfWork = ?, Deliverables = ?, LearningOutcomes = ?,
        Prerequisites = ?, Requirements = ?, YearOfStudy = ? WHERE ProjectID = ?";

        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$projectTitle, $description, $programmeOfWork,
        $deliverables, $learningOutcomes, $prerequisites, $requirements,
        $yearOfStudy, $availability, $selfProposed, $projectID]);
    }

    /**
     * The deleteProject method delete project from database by projectID
     * @param integer $projectID for the id of the project that is to be deleted in
     * the database
     */
    public function deleteProject($projectID)
    {
        $sql = "DELETE FROM Projects WHERE ? = ProjectID";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$projectID]);
    }

    /**
    * The setStudentProposedProject method add a student proposed project to the projects table of the database
    * @param string $projectTitle Project title
    * @param string $description Project description
    * @param string $programmeOfWork Project's programme of work
    * @param string $deliverables Project's deliverables
    * @param int $assignedStudent UoBNumber of student proposing project
    * @param int $assignedSupervisor Supervisor ID of supervisor supervising project
    */
    public function setStudentProposedProject($projectTitle, $description,
        $programmeOfWork, $deliverables, $yearOfStudy, $availability, $selfProposed,
        $assignedStudent, $assignedSupervisor){
        $sql = "INSERT INTO Projects (ProjectTitle, Description, ProgrammeOfWork, Deliverables,
          YearOfStudy, Availability, SelfProposed, AssignedStudent,
          AssignedSupervisor) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$projectTitle, $description, $programmeOfWork,
        $deliverables, $yearOfStudy, $availability, $selfProposed,
        $assignedStudent, $assignedSupervisor]);
    }


    /**
     * The function to get total number of project
     * The totalNumOfProject function finds out the number of projects stores in the database
     * @return $totalNumOfProjects total number of project
     */
    public function getTotalNumOfProject($yearOfStudy){
        $sql = "SELECT * FROM Projects WHERE YearOfStudy = '$yearOfStudy'";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $totalNumOfProjects = $stmt->rowCount();
        return $totalNumOfProjects;
    }

    /**
     * The getProjectCount method gets the total number of projects in the db
     * @return $totalNumOfProjects the number of projects in the db 
     */
    public function getProjectCount(){
        $sql = "SELECT * FROM Projects";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $totalNumOfProjects = $stmt->rowCount();
        return $totalNumOfProjects;
    }
}
