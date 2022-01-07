<?php
/**
 * The Database Handler(Dbh) Class establishes database connection
 * Other Model classes extend from this class to connect to the database
 */

 class Dbh {
    private $host = "localhost";
    private $user = "root";
    private $pwd = "";
    private $dbName = "harrydb"; //Insert the name of your db on your local server (XAMPP)

    /**
      * The connect function connect to database
      * @return Returns $pdo Returns a PHP data object which is used to access
      * the database
      */
    protected function connect(){
        try {
            $dsn = 'mysql:host='.$this->host.';dbname=' . $this->dbName;
            $pdo = new PDO($dsn, $this->user, $this->pwd);
            // Default attribute for how we pull data
            // Associative arrays
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,  PDO::FETCH_ASSOC);
            // Attribute for what PDO error information can be displayed
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e){
            echo 'Connection failed: ' . $e->getMessage();
            exit();
        }
    }
 }
