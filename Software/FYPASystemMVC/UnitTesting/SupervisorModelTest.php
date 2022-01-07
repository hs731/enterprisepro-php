<?php
    use PHPUnit\Framework\TestCase;
    use PHPUnit\DbUnit\TestCaseTrait;
    include_once '../Models/SupervisorModel.php';

    class SupervisorModelTest extends TestCase 
    {
        protected $supervisorObj;
        protected function setUp() : void 
        {
            $this->supervisorObj
             = new SupervisorModel();
        }

        /** @test */
        public function getSupervisors()
        {
            $numOfSup = 9;
            $sup = $this->supervisorObj->getSupervisors();
            $this->assertCount($numOfSup, $sup);
            $this->assertEquals("Dhaval", $sup[0]["FirstName"]);
        }

        /** @test */
        public function getSupervisorEmail()
        {
            $supID = 2;
            $email = "s.konur@bradford.ac.uk";
            $supEmail = $this->supervisorObj->getSupervisorEmail($supID);
            $this->assertEquals($email, $supEmail);
        }

        /** @test */
        public function getSupervisorFullName()
        {
            $supID = 2;
            $supervisorName = "Savas Konur";
            $supFullName = $this->supervisorObj->getSupervisorFullName($supID);
            $this->assertEquals($supervisorName, $supFullName);
        }

        /** @test */
        public function getAllProjects()
        {
            $projCount = 23;
            $allProj = $this->supervisorObj->getAllProjects();
            $this->assertCount($projCount, $allProj);
        }

        /** @test */
        public function getOwnProjects()
        {
            $supID = 1;
            $originator = "Dhaval Thakker";
            $supOwnProj = $this->supervisorObj->getOwnProjects($supID);
            $this->assertEquals($originator, $supOwnProj[0]["OriginatorName"]);
        }

        /** @test */
        public function getAssignedProjects()
        {
            $supID = 4;
            $assignedProjCount = 5;
            $assignProj = $this->supervisorObj->getAssignedProjects($supID);
            $this->assertCount($assignedProjCount, $assignProj);
        }

        /** @test */
        // public function addNewProject()
        // {
        //     $projTitle = "";
        //     $supID = "";
        //     $projDes = "";

        //     $addProj = $this->supervisorObj();
        //     $this->assertTrue($addProj);
        // }

        /** @test */
        public function getNumberOfSupervisor()
        {
            $supCount = 9;
            $numOfSup = $this->supervisorObj->getNumberOfSupervisor();
            $this->assertEquals($supCount, $numOfSup["COUNT(SupervisorID)"]);
        }

        /** @test */
        public function getSupervisorIDs()
        {
            $supIdCount = 9;
            $supIDs = $this->supervisorObj->getSupervisorIDs();
            //var_dump($supID);
            $this->assertCount($supIdCount, $supIDs);
            $this->assertArrayHasKey("SupervisorID", $supIDs[0]);
        }

        /** @test */
        public function getNumberOfSupervisorProjects()
        {
            $supID = 4;
            $supProjCount = 7;
            $numOfsupProj = $this->supervisorObj->getNumberOfSupervisorProjects($supID);
            $this->assertEquals($supProjCount, $numOfsupProj["COUNT(OriginatorID OR AssignedSupervisor)"]);
        }

        /** @test */
        public function getProjectbyID()
        {
            $supID = 4;
            $projByID = $this->supervisorObj->getProjectbyID($supID);
            //var_dump($projByID);
            $this->assertCount(0, $projByID);
        }

        /** @test */
        public function getUnassignedProjects()
        {
            $unassginProj = $this->supervisorObj->getUnassignedProjects();
            //var_dump($unassginProj);
            $this->assertCount(0, $unassginProj);
        }

        /** @test */
        public function getAllocatedStudents()
        {
            $supID = 4;
            $stuAllocatedCount = 3;
            $stuName = "Haider Raoof";
            $allocatedStu = $this->supervisorObj->getAllocatedStudents($supID);
            $this->assertCount($stuAllocatedCount, $allocatedStu);
            $this->assertEquals($stuName, $allocatedStu[0]["StudentName"]);
        }
    }