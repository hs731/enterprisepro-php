<?php
  /**
  * The StudentController Class handles and manipulates data related to students
  * Used for inserting data or updating data in the stundents table
  * @author Haider Raoof - registerStudent(), sanitizeNames(), checkIsRegistered() and proposeProject()
  */
  include_once './Models/StudentModel.php';
  include_once './Models/ProjectsModel.php';
  include_once './Models/SupervisorModel.php';
  include_once './Models/ModuleCoordinatorModel.php';

class StudentController extends StudentModel {

    /** Properties of a student*/
    protected $firstName;
    protected $lastName;
    protected $uobEmail;
    protected $password;
    protected $uobNumber;
    protected $programmeOfStudy;
    protected $yearOfStudy;
    protected $dateProjectSelected;
    protected $dateProjectConfirmed;
    protected $numberOfSelections;

    /** The registerStudent method register a student to the system */
    public function registerStudent(){
        $this->firstName = $_POST['regfirstname'];
        $this->lastName = $_POST['reglastname'];
        $this->uobNumber = $_POST['reguobnum'];
        $this->uobEmail = $_POST['reguobemail'];
        $this->password = $_POST['regpassword'];
        $this->programmeOfStudy = $_POST['progofstudy'];
        $this->yearOfStudy = $_POST['yearofstudy'];
        $this->sanitizeNames($this->firstName, $this->lastName);
        $this->checkIsRegistered($this->uobNumber, $this->uobEmail);
        $this->setStudent($this->firstName, $this->lastName, $this->uobNumber,
        $this->uobEmail, $this->programmeOfStudy, $this->password,
        $this->yearOfStudy);
    }

    /**
    * The sanitizeNames Method sanitize a name to have the correct structure of a capital letter
    * for first character and all characters after as lower case
    * @param string $firstName First name of a student
    * @param string $lastName Last name of a student
    */
    public function sanitizeNames($firstName, $lastName){
        $firstName = strtolower($firstName);
        $lastName = strtolower($lastName);
        //Make first character of both strings a capital
        $firstName = ucfirst($firstName);
        $lastName = ucfirst($lastName);
        // Assign class properties of firstName and lastName the santitized strings
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    /**
    * The checkIsRegistered function prevent a student who has already registered to register again
    * It calls the checkIsStudentByNum and checkStudentByEmail function to check if student already exit. if it returns true then send user back to register page
    * with error message in url that someone has already registered with this UobNumber or UobEmail address
    * @param int $uobNumber UoBNumber number of a student
    * @param int $uobEmail UoBEmail of a student
    */
    public function checkIsRegistered($uobNumber, $uobEmail){
        if($this->checkIsStudentByNum($uobNumber) == true){
            header("Location: ./register.php?error=ubnumbertaken");
            exit();
        }
        else if($this->checkIsStudentByEmail($uobEmail) == true){
            header("Location: ./register.php?error=emailtaken");
            exit();
        } else {
            // Change to correct page to redirect students to
            header("Location: ./register.php?register=success");
        }
    }

    /**
    * The proposeProject function send an email regarding a student proposed project to the agreed
    * supervisor and the module coordinator and add the proposed project to the database
    * @param int $uobNumber UoBNumber number of student
    */
    public function proposeProject($uobNumber){
        //UoB Number of student proposing project
        $studentUobNum = $uobNumber;
        // UoB Email of student proposing project
        $studentUobEmail = $this->getStudentEmail($uobNumber);
        // Name of student proposing project
        $studentFullName = $this->getStudentFullName($uobNumber);
        // Year of study of student
        $studentYearOfStudy = $this->getYearOfStudy($uobNumber);
        // Programme of study of student
        $programmeOfStudy = $this->getProgOfStudy($uobNumber);
        // Information about the project that will be added to the Projects table
        $projectTitle = $_POST['projecttitle'];
        $projectDescription = $_POST['description'];
        $programmeOfWork = $_POST['programmeofwork'];
        $deliverables = $_POST['deliverables'];

        // SupervisorID value of supervisor student has agreed the proposed project
        $supervisorID = $_POST['supervisor'];
        // Use of object to get information about a supervisor
        $supervisorDetailsObj = new SupervisorModel();
        // Supervisor email that this email is cc'd to
        $supervisorEmail = $supervisorDetailsObj->getSupervisorEmail($supervisorID);
        // Supervisor full name
        $supervisorName = $supervisorDetailsObj->getSupervisorFullName($supervisorID);
        // Use of object to get information about a supervisor
        $modCoordDetailsObj = new ModuleCoordinatorModel();
        // Module Coordinator email that the project is sent to;
        $moduleCoordinatorEmail = $modCoordDetailsObj->getModCoordEmail();

        //Add student proposed project to the database
        $proposeProjectObj = new ProjectsModel();
        $proposeProjectObj->setStudentProposedProject($projectTitle, $projectDescription,
        $programmeOfWork, $deliverables, $studentYearOfStudy, 0, 1, $studentUobNum, $supervisorID);
        $proposeProjectObj->incrementSelections($studentUobNum);

        // Email address that the email is sent to i.e. the module coordinator
        $mailTo = $moduleCoordinatorEmail;
        //Subject of the email
        $subject = "Student Proposed Project Added to FYPA System";
        // Extra information about the email i.e. who it's from and a cc
        // From the students email address and cc'd the supervisor they agreed the project with
        $headers = "From: ".$studentUobEmail."\r\n"."CC: ".$supervisorEmail;
        // Message recieved from the users
        $txt = "This is an automated email.".
        "\n\nA project proposed by student ".$studentFullName.", UoB Number ".$studentUobNum." has been added to the Final Year Project Allocation system.".
        "\nThe student's UoB email address is: ".$studentUobEmail.
        "\nThe student's Programme of Study is: ".$programmeOfStudy.
        "\n\n"."The supervisor that has agreed the contents of the proposal and to supervise the project is: ".$supervisorName.", UoB Email ".$supervisorEmail.
        "\n\nThe contents of the proposed project are described below.".
        "\n\nProject Title: ".$projectTitle.
        "\n\nProject Description: ".$projectDescription.
        "\n\nProgramme of Work: ".$programmeOfWork.
        "\n\nDeliverables: ".$deliverables.
        "\n\n"."Please review the contents of the proposed project and if it is unsuitable, the Module Coordinator (".$moduleCoordinatorEmail.") can delete or edit the project using the Final Year Project Allocation system.";
        // Send email to module coordinator and supervisor
        mail($mailTo, $subject, $txt, $headers);
        header("Location: StudentPage.php?emailsent");
    }

}
?>
