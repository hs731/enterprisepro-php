<?php
    use PHPUnit\Framework\TestCase;
    use PHPUnit\DbUnit\TestCaseTrait;
    include_once '../Models/ProjectsModel.php';

    /**
     * The ProjectModelTest class tests all method in the ProjectModel class
     * that returns a value or an array
     */
    class ProjectModelTest extends TestCase
    {
        protected  $projectObj;
        protected function setUp() : void 
        {
            $this->projectObj =  new ProjectsModel();
        }

        /** @test */
        public function getAllProjectsNoLimit()
        {
            $projNoLimit = $this->projectObj->getAllProjectsNoLimit();
            $this->assertCount(23, $projNoLimit);
        }

        /** @test */
        public function getAllProjects()
        {
            $getProjWithLimit = $this->projectObj->getAllProjects(0, 10);//get first ten project
            $testFailMsg = "could not get first 10 project";
            $projTitle = "Detection of Brain Tumour Using Image Processing and Machine Learning";
            $this->assertEquals($projTitle, $getProjWithLimit[1]["ProjectTitle"]);
            $this->assertCount(10, $getProjWithLimit, $testFailMsg);
        }

        /** @test */
        public function getSupervisorProject()
        {
            $supervisorId = 2;
            $supervisorProj = $this->projectObj->getSupervisorProject($supervisorId);
            $testFailMsg = "OriginatorID do not match supervisorID";
            $this->assertEquals($supervisorId, $supervisorProj[0]["OriginatorID"], $testFailMsg);
        }

        /** @test */
        public function getStudentProject()
        {
            $stuProj = $this->projectObj->getStudentProject(18010524);
            $projTitle = "Internet of Things (IoT) and Data Analytics based Flood monitoring for a Smart City ";
            $this->assertEquals("1", $stuProj[0]["ProjectID"]);
            $this->assertEquals($projTitle, $stuProj[0]["ProjectTitle"]);
        }

        /** @test */
        public function allowSelection()
        {
            $uob = "18010524";
            $allow = $this->projectObj->allowSelection($uob);
            $this->assertArrayHasKey("AssignedStudent", $allow[0]);
            $this->assertEquals($uob, $allow[0]["AssignedStudent"]);
        }

        /** @test */
        public function getNumberOfSelections()
        {
            $numOfSelection = $this->projectObj->getNumberOfSelections(88888888);
            $this->assertArrayHasKey("NumberOfSelections", $numOfSelection);
            $this->assertEquals(2, $numOfSelection["NumberOfSelections"]);
        }

        /** @test */
        public function getTotalNumOfProject()
        {
            $thirdYear = "3rd";
            $master = "MSc";
            $thirdYearTotalNumOfProj = $this->projectObj->getTotalNumOfProject($thirdYear);
            $masterTotalNumOfProj = $this->projectObj->getTotalNumOfProject($master);
            $this->assertEquals(18, $thirdYearTotalNumOfProj);
            $this->assertEquals(2, $masterTotalNumOfProj);
        }
    
        /** @test */
        public function getProjectCount()
        {
            $projectCount = $this->projectObj->getProjectCount();
            $failTestMsg = "The total number of project is not correct";//if the test fails a display this massage.
            $this->assertEquals(20, $projectCount, $failTestMsg);
        }
    }


?>