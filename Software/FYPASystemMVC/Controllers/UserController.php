<?php
/**
 * The UserController class logs all user into the system and logs the user out of the system.
 * It extends the UserModel class.
 * It calls the authenticateStudent, authenticateModuleCoordinator, authenticateModuleCoordinator function 
 */
include_once './Models/UserModel.php';
class UserController extends UserModel {

    public function login(){
        if($_SERVER["REQUEST_METHOD"] == "POST"){
        // Check if username or UoBnumber is not empty and sanitize username or uobnumber
            if(!empty(trim($_POST['username']))){
                $sanitizeUoBNumber = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_NUMBER_INT);
                $sanitizeUsername = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
                $UoBNumber = $sanitizeUoBNumber;
                $username = $sanitizeUsername;
            }
        //check password field is not empty and strip whitespace
            if(!empty(trim($_POST['password']))){
                $password = trim($_POST['password']);
            }

        //check which user, student, surpervisor or module coordinator
            preg_match('/[0-9]{8}/', $username, $matches, PREG_OFFSET_CAPTURE); //check if username is 8 digit in length
            preg_match('/[0-9]{6}/', $username, $moduleCoordinatorMatches, PREG_OFFSET_CAPTURE); //check if username is 6 digits in length
            $logObj = new UserModel();
            if($matches){//if true assume it is a student in the database
                $logObj->authenticateStudent($UoBNumber, $password);
            }elseif($moduleCoordinatorMatches) { //If true check if it is module coordinator in the dataabase
                $logObj->authenticateModuleCoordinator($UoBNumber, $password);
            }
            else{//If false assume it is a supervisor and check if it is in database
                $logObj->authenticateSurpervisor($username, $password);
            }

        }

    }

    /**
     * The logout function logs all user out of the system 
     * and destroy all session and cookies
     */
    public function logout(){
        //php script that runs when a user clicks the log out button it signs them out
        setcookie("PHPSESSID", "", time() - 3600); //set session to past time 
        session_unset();
        session_destroy();      //deletes all the session variables
        session_write_close(); //it saves changes to session, close stream
        //sends the user back to the index page/login page after clicking log out
        header("Location: ./index.php");
    }
}
