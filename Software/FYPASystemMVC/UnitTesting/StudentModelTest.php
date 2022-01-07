<?php
    use PHPUnit\Framework\TestCase;
    use PHPUnit\DbUnit\TestCaseTrait;
    include_once '../Models/StudentModel.php';

    class StudentModelTest extends TestCase
    {
        protected $studentObj;
        protected function setUp() : void 
        {
            $this->studentObj =  new StudentModel();
        }

        /** @test */
        // public function getStudents()
        // {
        //     $stud = $this->studentObj->getStudents();
        //     $numOfStud = 10;
        //     $this->assertCount($stud, $numOfStud);
        // }

        /** @test */
        public function checkIsStudentByNum()
        {
            $uob = 18010524;
            $stud = $this->studentObj->checkIsStudentByNum($uob);
            $this->assertTrue($stud);
        }

        /** @test */
        public function checkIsStudentByEmail()
        {
            $email = "rafeal@bradford.ac.uk";
            $stuEmail = $this->studentObj->checkIsStudentByEmail($email);
            $this->assertTrue($stuEmail);
        }

        /** @test */
        public function getStudentEmail()
        {
            $email = "rafeal@bradford.ac.uk";
            $uob = 10239876;
            $stuEmail = $this->studentObj->getStudentEmail($uob);
            $this->assertEquals($stuEmail, $email);
        }

        /** @test */
        // public function checkStudentHasProject()
        // {
        //     $uob = 10239876;
        //     $stuHasProj = $this->studentObj->checkStudentHasProject($uob);
        //     $this->assertTrue($stuHasProj);
        // }

        /** @test */
        public function getStudentFullName()
        {
            $uob = 10239876;
            $name = "Rafeal Nadal";
            $stuFulname = $this->studentObj->getStudentFullName($uob);
            $this->assertEquals($name, $stuFulname);
        }

        /** @test */
        public function getNumberOfStudents()
        {
            $stuCount = 1;
            $stuNum = $this->studentObj->getNumberOfStudents();
            $this->assertCount($stuCount, $stuNum);
        }

        /** @test */
        public function getProjects()
        {
            $uob = 10239876;
            $pageRes = 0;
            $numOfProjPerPage = 10;
            $projID = 12;
            $proj = $this->studentObj->getProjects($uob, $pageRes, $numOfProjPerPage);
            $this->assertEquals($projID, $proj[0]["ProjectID"]);
            $this->assertCount(10, $proj);
        }

        /** @test */
        public function getYearOfStudy()
        {
            $uob = 10239876;
            $year = "3rd";
            $yearOfStudy = $this->studentObj->getYearOfStudy($uob);
            $this->assertEquals($year, $yearOfStudy);
        }

        /** @test */
        public function getProjectIDs()
        {
            $uob = 18010524;
            $id = 35;
            $projID = $this->studentObj->getProjectIDs($uob);
            $this->assertEquals($id, $projID[9]["ProjectID"]);
            $this->assertArrayHasKey("ProjectID", $projID[0]);
        }

        /** @test */
        public function viewMyProject()
        {
            $uob = 18010524;
            $projTitle = "Programming for pricing financial derivatives";
            $proj = $this->studentObj->viewMyProject($uob);
            $this->assertArrayHasKey("ProgrammeOfWork", $proj[0]);
            $this->assertEquals($projTitle, $proj[0]["ProjectTitle"]);
        }

        /** @test */
        public function getStudentWithProjectButNoAssignSupervisor()
        {
            $stu = $this->studentObj->getStudentWithProjectButNoAssignSupervisor();
            $this->assertCount(0, $stu);
        }
        
        /** @test */
        public function getProgOfStudy()
        {
            $prog = "Computer Science";
            $uob = 18010524;
            $progOfStudy = $this->studentObj->getProgOfStudy($uob);
            $this->assertEquals($prog, $progOfStudy);
        }
    }