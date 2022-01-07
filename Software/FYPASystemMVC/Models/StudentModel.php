<?php
/**
* The StudentModel Class related to all the interactions a student will have with the database
* Solely sql queries to manipulate student data in this class
* Handles all database interactions regrarding students
* @author Haider Raoof -- setStudent(), getStudents(), checkIsStudentByNum() and
*  checkIsStudentByEmail(), getStudentFullName(), getStudentEmail(), getProgOfStudy()
* - Foluke Agbede viewMyProject()
*/
include_once 'Dbh.php';

class StudentModel extends Dbh {

    /**
    * The setStudent method set the values for a student by running the sql query to add the
    * student to the students table in the database
    * @param string $firstName First name of a student
    * @param string $lastName Last name of a student
    * @param int $uobNumber UoBNumber of a student
    * @param string $uobEmail UoBEmail address of a student
    * @param string $programmeOfStudy Programme of study of a student
    * @param string $password Password of a student
    * @param string $yearOfStudy Year of study either 3rd or MSc of a student
    */
    public function setStudent($firstName, $lastName, $uobNumber, $uobEmail,
    $programmeOfStudy, $password, $yearOfStudy){
        $sql = "INSERT INTO Students(FirstName, LastName, UoBNumber, UoBEmail, ProgrammeOfStudy, Password, YearOfStudy) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$firstName, $lastName, $uobNumber,
        $uobEmail, $programmeOfStudy, $password,
        $yearOfStudy]);
      }

    /**
    * The getStudents method get all information about all students in the Students table of
    * database
    * @return $results Returns an associative array of student information for each
    * student in the Students table of database
    */
    protected function getStudents(){
        $sql = "SELECT * FROM Students";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll();
        return $results;
    }

    /**
    * The checkIsStudentByNum method check if the UoB Number a student is trying to register
    * with is already stored and found within the database
    * @param int $uobNumber UoBNumber of student trying to register
    * @return true if student with matching UoBNumber exists in students
    * table, false otherwise
    */
    public function checkIsStudentByNum($uobNumber){
        $sql = "SELECT UoBNumber FROM Students WHERE UoBNumber = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$uobNumber]);
        $row = $stmt->fetch();
        if($row['UoBNumber'] > 0){
            return true;
        } else {
            return false;
        }
    }

    /**
    * The checkIsStudentByEmail method check if the UoBEmail address a student is trying to register
    * with is already stored and found within the database
    * @param int $uobEmail UoBEmail of student trying to register
    * @return true if student with matching UoBEmail address exists
    * in students table, false otherwise
    */
    public function checkIsStudentByEmail($uobEmail){
        $sql = "SELECT COUNT(UoBEmail) AS num FROM Students WHERE UoBEmail = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$uobEmail]);
        $row = $stmt->fetch();
        if($row['num'] > 0){
            return true;
        } else {
            return false;
        }
    }

    /**
    * The getStudentEmail method get the UoB email address of a student
    * @param int $uobNumber UoBNumber of a student
    * @return $uobEmail a string which is the UoB email of a student
    */
    public function getStudentEmail($uobNumber){
        $sql = "SELECT UoBEmail FROM Students WHERE UoBNumber=$uobNumber";
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
     * The checkStudentHasProject method check if a student has selected or proposed a project added to thesystem
     * @param int $uobNumber UoB Number of student
     * @return true if student has selected a project or proposed a project, false otherwise
     */
    protected function checkStudentHasProject($uobNumber){
        $sql = "SELECT COUNT(ProjectID) AS num FROM Projects WHERE AssignedStudent = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$uobNumber]);
        $row = $stmt->fetch();
        if($row['num'] > 0){
            return false;
        } else {
            return true;
        }
    }

    /**
     * The getStudentFullName method to get the full name of a student
     * @param int $uobNum UoBNumber of a student
     * @return $studentName Returns a string which is the full name of astudent
     */
    public function getStudentFullName($uobNumber){
        $sql = "SELECT CONCAT(FirstName, ' ',LastName) AS StudentName
        FROM Students Where UoBNumber = $uobNumber";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $studentName = null;
        foreach ($result as $row) {
            $studentName = $row["StudentName"];
        }
        return $studentName;
    }

    /**
    * method to get the total number of students in the database
    * @return $results the number of students in the database
    */
    public function getNumberOfStudents(){
        $sql = "SELECT COUNT(UoBNumber) FROM Students";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll();
        return $results;
    }


    /**
     *  The getProjects method returns projects based on student's year of study
     *  Master students only see projects for master students
     *  It retrieve a range of records.  The $thisPageFirstResult argument is used to identify the starting point to return rows from a result set
     *  @param $uobNUM the student uob number
     *  @param $thisPageFirstResult result of limit place on number of project to be retrive from the db.
     *  @param $numOfProjectPerPage number of project per page
     *  @return $results array of project details
     *  note change hard coded year of study on line 164
     */

    public function getProjects($uobNUM, $thisPageFirstResult, $numOfProjectPerPage){
        $yearOfStudy = $this->getYearOfStudy($uobNUM);
        $sql = "SELECT p.ProjectID, p.ProjectTitle, CONCAT(s.FirstName, ' ' , s.LastName) AS 'Originator', p.Description, p.ProgrammeOfWork,
        p.Deliverables, p.LearningOutcomes, p.Prerequisites, p.Requirements, p.ExternalOriginator
        FROM Projects p LEFT JOIN Supervisors s
        ON p.OriginatorID = s.SupervisorID
        WHERE p.YearOfStudy='$yearOfStudy'
        AND p.Availability = 1
        AND p.SelfProposed=0
        LIMIT $thisPageFirstResult, $numOfProjectPerPage";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll();
        return $results;
    }

    /**
     * The getYearOfStudy method get student year of study
     * @param $uobNUM the student uob number
     * @return $yearOfStudy of the student
     */
    public function getYearOfStudy($uobNUM){
        $sql = "SELECT YearOfStudy FROM Students WHERE UoBNumber=$uobNUM";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $yearOfStudy = null;
        foreach ($result as $row) {
            $yearOfStudy = $row["YearOfStudy"];
        }
        return $yearOfStudy;
    }

    /**
     * The getProjectIDs method gets the project IDs
     * @param $uobNUM the student uob number
     * @return $results the project id of the student
     */
    public function getProjectIDs($uobNUM){ //Get project IDs
        $yearOfStudy = $this->getYearOfStudy($uobNUM);
        $sql = "SELECT p.ProjectID FROM Projects p LEFT JOIN Supervisors s ON p.OriginatorID = s.SupervisorID
        WHERE p.YearOfStudy='$yearOfStudy' AND p.Availability=1 AND p.SelfProposed=0";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll();
        return $results;
    }

    /**
     * The viewMyProject method display project that has been selected by the student
     * if project has not been previously selected a massage will be display prompting the user to select project first
     * show project with allocated supervisor if one is allocated
     * otherwise shows without allocated supervisor
     * @param $uobnumber
     * @return $result project details
     */
    public function viewMyProject($uobNumber){
        $sql = "SELECT p.ProjectID, p.ProjectTitle, p.Description, p.ProgrammeOfWork, p.Deliverables, p.LearningOutcomes,
        p.Prerequisites, p.Requirements, p.SelfProposed, p.ExternalOriginator, p.ExternalOriginator,
        (SELECT CONCAT(FirstName, ' ', LastName) FROM Supervisors WHERE SupervisorID=p.AssignedSupervisor) as 'SupervisorName',
        (SELECT UoBEmail FROM Supervisors WHERE SupervisorID=p.AssignedSupervisor) as 'UoBEmail'
        FROM Projects p
        WHERE p.AssignedStudent=$uobNumber";//query can show projects with names whether supervisor assigned or not

        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }

    /**
     * getStudentWithProjectButNoAssignSupervisor method get all student with assigned project
     * but has not been assigned a supervisor yet
     * @return $result array of all student with assigned project
     * but not assigned a supervisor.
     */
    public function getStudentWithProjectButNoAssignSupervisor(){
        $sql = "SELECT s.FirstName, s.LastName, s.UoBNumber, s.UoBEmail, s.ProgrammeOfStudy
        FROM Students s
        WHERE EXISTS (SELECT p.AssignedStudent FROM Projects p WHERE s.UoBNumber = p.AssignedStudent
                    AND p.AssignedSupervisor IS NULL)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }

    /**
    * The getProgOfStudy method gets the programme of study of a student
    * @param int $uobNumber UoBNumber of a student
    * @return $progOfStudy Returns a string which is the programme of study of a student
    */
    public function getProgOfStudy($uobNumber){
        $sql = "SELECT ProgrammeOfStudy FROM Students WHERE UoBNumber=$uobNumber";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $progOfStudy = null;
        foreach ($result as $row) {
          $progOfStudy = $row["ProgrammeOfStudy"];
        }
        return $progOfStudy;
    }
}
