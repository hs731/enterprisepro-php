<?php
/**
* The SupervisorController Class handles and manipulates data related to Supervisors
* Used for inserting data or updating data in the supervisor table.  This class extend the SupervisorModel
* @author Zaka Rehman addProjectForm, editProjectForm, deleteProjectForm
*/

include_once './Models/SupervisorModel.php';
include_once './Models/ProjectsModel.php';

class SupervisorController extends SupervisorModel {  

    public function addProject($supervisorID){
        $projectTitle = $_POST['title'];
        $projectDescription = $_POST['desc'];
        $programmeOfWork = $_POST['pow'];
        $deliverables = $_POST['deliverables'];
        $lOutcomes = $_POST['lOutcomes'];
        $prerequisites = $_POST['prerequisites'];
        $extOriginator = $_POST['extOriginator'];
        $yearOfStudy = $_POST['yearOfStudy'];

        $proposeProjectObj = new SupervisorModel();
        $proposeProjectObj->addNewProject($projectTitle, $supervisorID, $projectDescription, $programmeOfWork, $deliverables, $lOutcomes, $prerequisites, $extOriginator, $yearOfStudy);
        echo "<script>alert(`Added project: $projectTitle`)</script>";
    }

    public function deleteProject($pID){
        $proposeProjectObj = new SupervisorModel();
        $proposeProjectObj->deleteMyProject($pID);
        echo "<script>alert('Successfully deleted project')</script>";
    }

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


        $spmodel = new SupervisorModel();
        $spmodel->updateMyProject($oldprojectid, $newprojectid, $projecttitle, $description, $pow, $del, $lo, $prereq, $req, $yos, $exto);
        echo "<script>alert('Succesfully updated project')</script>";
    }
}
