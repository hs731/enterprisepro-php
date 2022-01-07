<?php
    use PHPUnit\Framework\TestCase;
    use PHPUnit\DbUnit\TestCaseTrait;
    include_once '../Models/ModuleCoordinatorModel.php';

    /** The ModuleCoordinatorModelTest  test all method
    * that returns a value.
    */
    class ModuleCoordinatorModelTest extends TestCase
    {
        protected $moduleObj;
        protected function setUp() : void 
        {
            $this->moduleObj = new ModuleCoordinatorModel();
        }

        /** @test */
        public function getModCoordEmail()
        {
            $getEmail = $this->moduleObj->getModCoordEmail();
            $email = "hraoof@bradford.ac.uk";
            $this->assertEquals($email, $getEmail);
        }

        /** @test */
        public function getAllocatedSupervisorsInfo()
        {
            $allocatedSupInfo = $this->moduleObj->getAllocatedSupervisorsInfo();
            $this->assertCount(3, $allocatedSupInfo);
            $this->assertArrayHasKey("AssignedSupervisor", $allocatedSupInfo[0]);
            $this->assertEquals("Dhaval Thakker", $allocatedSupInfo[0]["SupervisorName"]);
        }

        /** @test */
        public function getAllocatedStudents()
        {
            $supervisorID = 4;
            $allocedStuID = 3;
            $allocatedStu = $this->moduleObj->getAllocatedStudents($supervisorID);
            $this->assertCount(3, $allocatedStu);
            $this->assertEquals("Haider Raoof", $allocatedStu[0]["StudentName"]);
        }

        /** @test */
        public function getAllSupervisors()
        {
            $totalNumOfSupervisor = 9;
            $allSupervisor = $this->moduleObj->getAllSupervisors();
            $this->assertCount($totalNumOfSupervisor, $allSupervisor);
        }
        /** @test */
        public function getUnallocatedProjectCount()
        {
            $numOfUnallocatedProj = 15;
            $unallocatedProjCount = $this->moduleObj->getUnallocatedProjectCount();
            $this->assertEquals($numOfUnallocatedProj, $unallocatedProjCount);
        }

        /** @test */
        public function getUnallocatedProject()
        {
            $firstTenProj = 0;
            $NumOfProjPerPage = 10;
            $unallocatedProj = $this->moduleObj->getUnallocatedProject($firstTenProj, $NumOfProjPerPage);
            $this->assertCount($NumOfProjPerPage, $unallocatedProj);
        }

        /** @test */
        public function getStudents()
        {
            $numOfStud = 11;
            $students = $this->moduleObj->getStudents();
            $this->assertCount($numOfStud, $students);
            $this->assertArrayHasKey("FirstName", $students[0]);
            $this->assertEquals("Foluke", $students[7]["FirstName"]);
        }

        /** @test */
        public function studentWithNoprojectAllocation()
        {
            $unalloProjCount = 6;
            $noProjAlloc = $this->moduleObj->studentWithNoprojectAllocation();
            $this->assertCount($unalloProjCount, $noProjAlloc);
            //$this->assertEquals("AI", $noProjAlloc[0]["ProjectTitle"]);
        }

        /** @test */
        public function getStudentCount()
        {
            $numOfStud = 11;
            $students = $this->moduleObj->getStudentCount();
            $this->assertEquals($numOfStud, $students);
        }

        /** @test */
        public function getStudentsLimited()
        {
            $pageRes = 0;
            $numOfPages = 10;
            $studLimit = $this->moduleObj->getStudentsLimited($pageRes, $numOfPages);
            $this->assertCount($numOfPages, $studLimit);
        }

        /** @test */
        public function getSupervisorCount()
        {
            $numOfSup = 9;
            $supCount = $this->moduleObj->getSupervisorCount();
            $this->assertEquals($numOfSup, $supCount);
        }

        /** @test */
        public function getSupervisorsLimited()
        {
            $pageRes = 0;
            $numOfProjPerPage = 5; 
            $supLimit = $this->moduleObj->getSupervisorsLimited($pageRes, $numOfProjPerPage);
            $this->assertCount($numOfProjPerPage, $supLimit);
            $this->assertEquals("Vourdas", $supLimit[2]["LastName"]);
        }

        /** @test */
        public function getStudentsWithProjectCount()
        {
            $count = 5;
            $stuWithProjCount = $this->moduleObj->getStudentsWithProjectCount();
            $this->assertEquals($count, $stuWithProjCount);
        }

        /** @test */
        public function getStudentsWithProjectsLimited()
        {
            $pageRes = 0;
            $numOfPages = 5;
            $stuWithProjLimit = $this->moduleObj->getStudentsWithProjectsLimited($pageRes, $numOfPages);
            $this->assertCount(5, $stuWithProjLimit);
            $this->assertEquals("Greg", $stuWithProjLimit[4]["FirstName"]);
        }

        /** @test */
        public function getAllocatedProjects()
        {
            $allocatedProj = $this->moduleObj->getAllocatedProjects();
            $pID = 2;
            $this->assertEquals($pID, $allocatedProj[0]["ProjectID"]);
        }

        /** @test */
        public function getStudentByID()
        {
            $id = 88888888;
            $stuID = $this->moduleObj->getStudentByID($id);
            $this->assertEquals($id, $stuID[0]["UoBNumber"]);
        }

        /** @test */
        public function getProjectsWithSupervisor()
        {
            $numOfProjWithSup = 5;
            $projWithSup = $this->moduleObj->getProjectsWithSupervisor();
            $this->assertCount($numOfProjWithSup, $projWithSup);
            $this->assertEquals(NULL, $projWithSup[0]["ExternalOriginator"]);
        }

        /** @test */
        public function getSupervisorByID()
        {
            $id = 2;
            $supID = $this->moduleObj->getSupervisorByID($id);
            $this->assertEquals($id, $supID[0]["SupervisorID"]);     
        } 
    }