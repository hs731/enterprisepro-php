-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 01, 2020 at 06:02 PM
-- Server version: 5.5.21-log
-- PHP Version: 5.6.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;



-- --------------------------------------------------------

--
-- Table structure for table `ModuleCoordinator`
--

DROP TABLE IF EXISTS `ModuleCoordinator`;
CREATE TABLE `ModuleCoordinator` (
  `ModuleCoordinatorID` int(6) NOT NULL,
  `FirstName` varchar(25) NOT NULL,
  `LastName` varchar(25) NOT NULL,
  `Password` varchar(16) NOT NULL,
  `UoBEmail` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ModuleCoordinator`
--

INSERT INTO `ModuleCoordinator` (`ModuleCoordinatorID`, `FirstName`, `LastName`, `Password`, `UoBEmail`) VALUES
(240220, 'Module', 'Coordinator', 'Coordinator1', 'a.sadik@bradford.ac.uk');

-- --------------------------------------------------------

--
-- Table structure for table `Projects`
--

DROP TABLE IF EXISTS `Projects`;
CREATE TABLE `Projects` (
  `ProjectID` int(11) NOT NULL,
  `ProjectTitle` varchar(100) NOT NULL,
  `OriginatorID` int(11) DEFAULT NULL,
  `Description` text NOT NULL,
  `ProgrammeOfWork` text,
  `Deliverables` text,
  `LearningOutcomes` text,
  `Prerequisites` text,
  `Requirements` text,
  `YearOfStudy` varchar(3) NOT NULL,
  `Availability` tinyint(4) NOT NULL DEFAULT '1',
  `SelfProposed` tinyint(4) NOT NULL DEFAULT '0',
  `AssignedStudent` int(8) DEFAULT NULL,
  `AssignedSupervisor` int(11) DEFAULT NULL,
  `ExternalOriginator` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Projects`
--

INSERT INTO `Projects` (`ProjectID`, `ProjectTitle`, `OriginatorID`, `Description`, `ProgrammeOfWork`, `Deliverables`, `LearningOutcomes`, `Prerequisites`, `Requirements`, `YearOfStudy`, `Availability`, `SelfProposed`, `AssignedStudent`, `AssignedSupervisor`, `ExternalOriginator`) VALUES
(1, 'Internet of Things (IoT) and Data Analytics based Flood monitoring for a Smart City ', 1, 'University of Bradford (UoB) and Bradford City Council are working together, along with eight other European cities, on an ambitious European Commission funded smart city project. As part of this project, UoB and Council are looking to utilise sensor and LoRaWAN technologies to measure various elements related to water and rain sensing in key locations in Bradford Metropolitan area and building a floor monitoring system using big data analytics. As part of this project, there is an excellent opportunity for a group of two to three final year or masters computer science students to work on the key aspects of the project as subprojects. These aspects include sensor technologies, data engineering, flood modelling, and data analytics. Students will have an opportunity to discuss and select their subproject based on their key strengths and interests with the supervisors.\r\n<br>\r\n<br> \r\nA portfolio of software resolutions that will adequately address the current and on-going business challenges.\r\n', NULL, NULL, NULL, NULL, NULL, '3rd', 1, 0, NULL, NULL, NULL),
(2, 'Detection of Brain Tumour Using Image Processing and Machine Learning', 2, 'A brain tumour is an abnormal and uncontrollable growth of brain cells. There are more than 9,000 brain tumour cases in the UK each year. Brain tumour has two types: cancerous (malignant) or non-cancerous (benign). NHS states that benign brain tumours are low grade (grade 1 or 2), which means they grow slowly and are less likely to return after treatment; while malignant brain tumours are high grade (grade 3 or 4) and either start in the brain (primary tumours) or spread into the brain from elsewhere (secondary tumours); they\'re more likely to grow back after treatment. Early detection of malignant tumour is difficult to detect as MRI imaging is associated with some noise factor. In this project, you will develop a machine learning algorithm, which will detect malignant tumour cancer by scanning MRI images. Your algorithm will be trained using a pool of images, and will predict the tumour development in new images using the model generated in the training phase. To improve the accuracy of the method you are expected to use image processing techniques, e.g. filtering methods to remove noise and environmental interference from images, and image segmentation to detect the edges of images.', NULL, 'The student is expected to deliver\r\n<br>\r\n<br>\r\n1. A machine algorithm predicting malignant tumour from MRI images\r\n<br>\r\n<br>\r\n2. Image processing algorithms, e.g. filtering methods, image segmentation, etc.\r\n<br>\r\n<br>\r\n3. A project report, including a review of existing methods.', NULL, 'Essential: Software Development, Object-oriented languages (Java, C++ or C#)\r\n<br>\r\n<br>\r\nDesirable: Machine Learning tools (e.g. Matlab ML Toolbox, WEKA, KNIME), Image Processing Tools (e.g. Matlab Image Processign Toolbox)', NULL, '3rd', 1, 0, NULL, NULL, NULL),
(3, 'Time-frequency analysis of signals using Wigner functions', 3, 'The project is at the boundary between Communications and Computing. A signal is usually represented as a function of time; or through Fourier transform as a function of frequency. Time-frequency methods represent the signal as a function of both time and frequency. One way to do this is with the so-called Wigner function. Numerical calculation of the Wigner function for an arbitrary signal will be performed. The effect of noise in a signal, on its Wigner function, will be studied. Software engineering students who choose this project are required to produce software taking into account the software engineering rules. ', 'Mathematical/Computational work.', 'Software which calculates the Wigner function. ', NULL, 'Some mathematical background is desirable.', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s', '3rd', 1, 0, NULL, NULL, NULL),
(4, 'Ambiguity functions for Radar signal analysis', 3, 'The project is at the boundary between Communications and Computing. The uncertainty principle will be studied in the context of Radar Signal analysis. Numerical calculation of the so-called Ambiguity function for an arbitrary signal will be performed. The properties and practical significance of the Ambiguity function will be studied. Software engineering students who choose this project are required to produce software taking into account the software engineering rules. ', 'Mathematical/Computational work.', 'Software that calculates the Ambiguity function.', NULL, 'Some mathematical background is desirable.', NULL, '3rd', 1, 0, NULL, NULL, NULL),
(5, 'Information theory calculations for quantum communications', 3, 'The project is in the developing area of quantum communications and quantum computing. Simple quantum communication channels will be considered and information theory and signal to noise ratio calculations will be performed', 'Mathematical/Computational work.', 'Software that performs information theory and signal to noise ratio calculations.', NULL, 'Some mathematical background is desirable.', NULL, '3rd', 1, 0, NULL, NULL, NULL),
(6, 'Quantum superpositions, Wigner functions and their applications to Quantum Computing', 3, 'The project is in the developing area of quantum computing and quantum communications. Quantum superpositions of macroscopically distinguishable quantum states (`Schrodinger cats\') will be studied using the so-called Wigner functions. Applications to Quantum Computing will be considered. Software engineering students who choose this project are required to produce software taking into account the software engineering rules. ', 'Mathematical/Computational work.', 'Software that calculates the Wigner function of macroscopically distinguisable quantum states. ', NULL, 'Some mathematical background is desirable.', NULL, '3rd', 1, 0, NULL, NULL, NULL),
(7, 'Modelling of Nano-Scale Electronic Devices', 4, 'Description: The objective of this project is to build a modelling and simulation platform for nano-scale electronic devices, which is critical for the continuing miniaturisation in CMOS technology. The project will investigate current technologies in VLSI of circuits, study main characterises of several new components and construct a simulation framework to capture behaviours of these components. The key activities of the project involve (1) review the relevant work in the literature, (2) establish a systematic approach for analysing nano-scale devices, (3) develop numerical methods and/or tools for quantifying digital behaviour of nano-scale devices.', NULL, NULL, NULL, NULL, NULL, '3rd', 1, 0, NULL, NULL, NULL),
(8, 'Programming for pricing financial derivatives', 4, 'Description: An option on an asset in a financial market is the right to buy (call) or to sell (put) a particular asset for an agreed amount (strike) at a specified time in the future. The price of an option depends on both the underlying stock price and time. The objective of this project is to study numerical solutions for the Black-Scholes equation which is a continuous-time model for pricing options and is broadly considered today the classical model of mathematical finance. The project falls into the broad context of applied partial differential equations. The key activities of the project involve (1) study the terms in the Black-Scholes equation and analytic solutions, (2) establish boundary and initial conditions, (3) develop numerical methods and/or tools for solving the Black-Scholes equation.', NULL, NULL, NULL, NULL, NULL, '3rd', 1, 0, NULL, NULL, NULL),
(9, 'Line segment intersection detection with OpenGL', 4, 'Description: In this project, we are interested in finding all intersections between any given set of line segments in a 2D/3D space. This is called the line segment intersection problem and has applications in areas such as geographic information system. The objective of this project is to study the solution algorithms for the line segment intersection problem, implement and visualize the solution algorithms using OpenGL. The key activities of the project involve (1) study of the solution algorithms for the line segment intersection problem, (2) development of a visualization tool for the line segment intersection problem using OpenGL.', NULL, NULL, NULL, NULL, NULL, '3rd', 1, 0, NULL, NULL, NULL),
(10, 'Path planning using polygon triangulation', 4, 'Description: Polygon triangulation decomposes complex shapes to collection of simpler shapes and is the first step of many advanced algorithms. In this project, polygon triangulation algorithms are applied to solve path planning problems which have been extensively studied in many scientific disciplines. The objective of this project is to study the polygon triangulation algorithms for the path planning problem, implement and visualize the solution algorithms using programming languages preferred. The key activities of the project involve (1) study of the polygon triangulation algorithms for the path planning problem, (2) development of a visualization tool for the path planning problem.', NULL, NULL, NULL, NULL, NULL, '3rd', 1, 0, NULL, NULL, NULL),
(11, 'Visualization of quantum states evolution', 4, 'Description: There has been significant progress in the development of quantum computers in recent years. Quantum bits are the fundamental building blocks of quantum computers and they can be in superpositions of two independent quantum states. Substantial research has been devoted to study quantum states. Visualizations can be a helpful tool to provide additional understanding of quantum states and how the states are evolved as a function of a set of parameters. The objective of this project is to study the basics of quantum bits and quantum states and implement a tool to visualize the quantum states evolution using programming languages preferred. The key activities of the project involve (1) study of the basics of quantum bits and quantum states, (2) development of a visualization tool for the quantum states evolution.', NULL, NULL, NULL, NULL, NULL, '3rd', 1, 0, NULL, NULL, NULL),
(12, 'Network Security Management Systems for Quantum Key Distributions ', 5, 'Quantum Key Distributions (QKDs), based on quantum cryptography, are being developed to improve network security during key exchange. Although the implementation of QKDs has brought some notable success, nevertheless they are mostly limited to point-to-point use. Moreover, such security operations have an adverse effect on network performance due to the associated overheads in terms of bandwidth and processing times. It is desirable, therefore, to design and develop secure quantum cryptography based multi-user networks with acceptable performance vs. security trade-offs.', 'To carry out a literature review on network management systems (NMSs) for QKDs, transmission capacity of quantum networks and performance vs. security implications of quantum technologies; To consider queueing network models (QNMs) of QKD networks and apply analytic as well as simulation techniques, as appropriate, for their quantitative analysis and evaluation. To carry out a comparative study on the performance-quantum security trade-offs by considering different traffic profiles, communication protocols and network configurations.', 'i) A comprehensive review on the performance related security issues in QKD networks ii) The design and development of algorithms, based on suitable analytic / simulation models and solution methodologies and tools and ii) The implementation of a comparative evaluation study focusing on network performance vs. QKD security trade-offs, based on numerical experiments employing different traffic models and network configurations.', NULL, NULL, NULL, '3rd', 1, 0, NULL, NULL, NULL),
(13, 'Quality-of-Service (QoS) in VANETs and RANETs', 5, 'Vehicular Communication Networks (VCNs) has recently emerged as a key technology for the next-generation wireless networks that supports a platform for multimedia and data services as well as Intelligent Transportation System (ITS) services providing special quality-of-service (QoS) requirements for active safety and multimedia applications. The VCNs characteristics, however, create new QoS issues and challenges, particularly for vehicles travelling at high speeds. Moreover, some of the VCNs protocols may be of relevance to the smooth and efficient operation of robotic mobile wireless ad hoc networks (RANETs), which are currently in need of further refinements and enhancements.', 'To undertake a literature review on the provision of QoS in VCNs, including RANETs; To address these QoS issues roadside networks and Vehicular Ad hoc (unplanned) NETtworks (VANETs), including vehicle-to-vehicle (V2V) and vehicle-to-roadside (V2R) communications; To classify and discuss different QoS solutions, such as those based on medium access and routing protocols, for provisioning QoS in roadside networks and VANETs and their applications to RANETs; To implement a comparative performance evaluation study on VANETs and RANETs based on different traffic profiles, protocols and QoS solutions.', 'A comprehensive review on QoS issues in VANETs, including connections with performance vs. security aspects and related links with RANETs ii) The design and development of algorithms, based on suitable analytic and simulation methodologies and tools and iii) The implementation of a comparative evaluation study focusing on QoS solutions for VANETs and their applicability into RANETs, based on numerical experiments employing different traffic models and VCN ad hoc configurations.', NULL, NULL, NULL, '3rd', 1, 0, NULL, NULL, NULL),
(14, 'Performance vs. Security Trade-offs in RANETs', 5, 'A robotic mobile wireless ad hoc network (RANET) with low operational cost, mobility and decentralized control seems to be a most suitable architectural platform to support the dynamic nature of robotic applications. However, security mechanisms, such as encryption or security protocols, come at a cost of extra computing resources and therefore, have an adverse effect of RANET? performance. Thus, it is vital to develop quantitative models and techniques, based on both performance and security metrics, for the analysis of suitable queueing network models (QNMs) of RANETs. ', 'To perform a literature review on the combined analysis and evaluation of performance and security in networks; To study some of the generic trade-offs between performance and security in RANETs by analysing open gated queueing network models (G-QNMs as well as generalised stochastic Petri nets (GSPNs), as appropriate, based either implicitly on the mean security and transmission delays or, more explicitly, on cost and combined performance-security trade-off measures; To apply analytic as well as simulation techniques, as appropriate, for the quantitative analysis of these models and optimisation of the adopted metrics; To carry out a comparative study on the performance vs. security trade-offs by considering different traffic profiles and network configurations.', 'A comprehensive review on performance vs. security trade-offs in computer networks, in general and RANETs, in particular ii) The design and development of analytic and/or simulation algorithms for the performance-security modelling and analysis of RANETs and iii) The implementation of a comparative evaluation study focusing on performance vs. security trade-offs, based on numerical experiments employing different traffic models and network configurations.', NULL, NULL, NULL, '3rd', 1, 0, NULL, NULL, NULL),
(15, 'Energy-Aware Security and QoS Routing Trade-offs in Wireless Networks', 5, 'Energy (power) is becoming a most critical resource not only for quality-of-service (QoS) routing in wireless networks but also for large-scale distributed systems such as web servers, clouds and grids. However, existing energy-aware protocols mostly address power reduction in specific computing systems with adverse implications on security and QoS routing. Thus, saving power in the presence of ever increasing number of users with acceptable levels of security and QoS routing has become a crucial issue. Hence, modelling and analysis of energy-aware vs. security and QoS routing is required for the efficient operation of wireless networks and computing systems. ', 'To undertake a literature review on the energy limitations of security protocols (e.g., IEEE 802.11)1 and QoS routing algorithms in wireless networks and distributed computing systems; To consider the analysis of suitable models to assess the security vs. energy trade-offs as well as the performance of  QoS and energy-aware routing algorithms in wireless networks; To carry out a comparative numerical  evaluation study on the impact of existing protocols on the security vs. energy-aware & QoS routing in wireless networks. ', 'i) A comprehensive review on energy-aware trade-offs with security and QoS routing algorithms in wireless networks ii) The formulation of energy-aware network models and their critical evaluation using quantitative techniques iii) The implementation of a comparative study focusing on the performance evaluation of energy vs. security protocols and iv) The development of energy-aware QoS routing algorithms, based on numerical experiments employing different traffic models and network configurations.', NULL, NULL, NULL, '3rd', 1, 0, NULL, NULL, NULL),
(16, 'Group Communication Protocols for RANETS', 5, 'Broadcasting/multicasting in robotic mobile wireless ad hoc networks (RANETs), whose robots can move around freely, provides a bandwidth efficient information dissemination process of sending a message from a source robot node to all/a sub-group of, respectively, other robot nodes of the network. They are designed to reduce the high number of redundant control packets, which wastefully are retransmitted and rebroadcasted by most protocols using ?looding? for the transmission of data packets, causing the collision of packets as well as congestion affecting the overall network performance. In many applications, such group communication may be used for flexible control, organisation and management of mobile robots. RANET? medium, however, has variable and unpredictable characteristics and the signal strength and propagation fluctuate with respect to time and environment. Thus, such group communications in a RANET poses more challenging problems than those in wired networks. Moreover, robot node mobility creates progressively a continuously changing topology, where routing paths break and new ones form dynamically. Thus, it is of vital importance that RANETs have efficient control mechanisms and comprehensive routing information in support of an efficient group communication.', 'To study the suitability of existing group multicast communication protocols for their employment in RANETs and their potential applications; To employ simulation/analysis and associated tools, as appropriate, in order to implement these protocols; To undertake a comparative experimental study to evaluate the effects of mobility and group size of robot nodes on their control overhead, forwarding efficiency and performance optimisation of RANETs', 'A comprehensive review of current group multicast/broadcast communication protocols for mobile ad hoc networks (MANETs) and RANETS and ii) The implementation of a comparative modelling study on the performance and efficiency of multicast protocols for RANETs, including the on-demand multicast routing (ODMR) and mobile robot mesh multicast (MRMM) protocols. ', NULL, NULL, NULL, '3rd', 1, 0, NULL, NULL, NULL),
(17, 'Overlay Networks and Graph Theoretic Concepts', 5, 'Overlay networks have shown to be very suitable platforms towards the support and enhancement of the performance and availability of new applications and protocols without affecting the design of the underlying networks. The effectiveness of the overlay networks depends on the diversity of the overlay paths between the source and destination nodes in terms of administration, linkage and geographical distribution. One of the most challenging problems in overlay networks is paths overlapping. In this context, as overlay paths may share the same physical link, the ability of overlay networks to quickly recover from congestion and path failures is severely affected. ', 'To carry out a literature review on overlay networks and examine the relationship between paths overlapping and the underlying network topology (when overlay nodes are selected); To employ some graph theoretic based methods for the selection of a set of topological diverse routers; To carry out a comparative performance evaluation study of related protocols in terms of the provision of dependent paths for better availability and performance of overlay networks.', 'i) A comprehensive review on overlay networks, including a narrative on the adverse effect of paths overlapping ii) The development and implementation of efficient graph theoretic-based decomposition algorithms and iii) A comparative performance evaluation study of related protocols in terms of the provision of independent paths.', NULL, NULL, NULL, '3rd', 1, 0, NULL, NULL, NULL),
(18, 'Queueing based Intrusion Detection and Elimination Systems in Wireless Sensor Networks ', 5, 'A computer virus (an autonomous malicious, self-propagating piece of code) propagates by exploiting the vulnerabilities of computer networks such as insecure network connections, unprotected shared storage, faulty email protocols etc. Following a number of actual virus outbreaks by mid-2000, works on devising new modelling techniques for detecting and eliminating viruses? propagation has significantly increased to date. However, there is still a great need to formulate and analyse robust theoretical models in order to predict the propagation of viruses, network congestion and associated delays. Moreover, malicious attackers may, generally, exploit a broadcast storm or a Distributed Denial-of-Service (DDoS) to paralyse a remote distribution sensor network. In this context, queueing theoretic models and related quantitative algorithms are most appropriate tools to detect if the network encounters malicious attacks, which may be manifested with a jammed traffic remaining anomalous for long periods.', 'To carry out a literature review on modelling techniques relating to intrusion detection and elimination mechanisms in computer networks; To formulate suitable queueing network models (QNMs) with multiple servers in order to analyse the co-evolution of populations of virus and antivirus software modules and also utilise delay times to determine that the service is seriously jammed or not; To discuss the properties and assess the suitability of queues and QNMs as applied, respectively, to computer networks and remote distribution sensor networks, respectively; To investigate the performance impact of mobile wireless networks and associated handover issues, as appropriate; To carry out a comparative performance  evaluation study based on analytic/simulation methodologies using different traffic models and topologies.', 'i) A comprehensive review on queueing modelling techniques relating to intrusion detection and elimination in computer networks, in general and remote distribution wireless sensor networks, in particular ii) To analyse QNMs for remote sensor networks and formulate associated algorithms, as appropriate and iii) To perform numerical analytic/simulation experiments by employing different traffic models and queueing network configuration.', NULL, NULL, NULL, '3rd', 1, 0, NULL, NULL, NULL),
(19, 'Performance Related Security Issues in Cognitive Radio Networks (CRNs) with Dynamic Spectrum Access', 5, 'Performance related security modelling and evaluation is a fundamental aspect for the design, development, tuning and upgrading of Cognitive Radio Networks (CRNs) with Dynamic Spectrum Access (DSA) protocols, aiming to optimise the quality-of-service (QoS) of secondary users. It is desirable, therefore, to reduce data flow and/or offer adaptive security protocols such as switch off encryption in the face of network performance deterioration.', 'To carry out a literature review on performance vs. security modelling and evaluation issues and mechanisms in cooperative CRNs with DSA, based on analytic concepts and related protocols; To undertake an investigation  to ascertain  the  adverse impact of voluminous traffic on the network performance due to the enabling  of various security applications. ', 'i) A comprehensive review on CRNs with DSA protocols and heterogeneous co-operative CRNs ii) The implementation of simulation programs and queueing analytic methods, as appropriate,  subject to First-Come-First-Served (FCFS) and Priority Queueing (PQ) service  disciplines of QNMs of CRNs iii) The undertaking of a comparative performance vs. security modelling and evaluation study to  analyse  congestion in QNMs of CRNs with different specification and iv) To discuss the synergy between Cognitive Radio Ad Hoc Networks (CRAHNs) and RANETs.', NULL, NULL, NULL, 'MSc', 1, 0, NULL, NULL, NULL),
(20, 'Cognitive Radio Networks (CRNs) over Cloud Computing Platforms', 5, 'A Cognitive Radio Networks (CRN) over a cloud is a combination of energy efficient cognitive mobile communication technologies and cloud computing. The goal is to achieve an optimal cloud platform performance versus security trade-offs to support more effectively mobile applications of large-scale CRNs in terms of bandwidth, energy consumption, hardware utilization and cost. ', 'To apply cognitive and virtualization concepts in combination with re-configurable cognitive radio systems ii) To target an increase of the efficiency of network management and resource utilization and iii) To reduce the power consumption and the cost while supporting the expected Quality-of-Service/Quality of Energy (QoS/QoE) for secure communications. ', 'i) A comprehensive literature review on the state-of the-art on CRNs over cloud computing platforms ii) The presentation and interpretation cognitive and virtualization concepts in the context of re-configurable cognitive radio systems iii) The implementation of simulation programs and analytic methods, as appropriate, for the quantitative analysis of hybrid generalised stochastic Petri nets (GSPNs) and QNMs towards the establishment of optimal trade-offs between performance and security in CRNs and iv) The undertaking of a numerical comparative modelling and evaluation study, based on combined performance and security metrics.', NULL, NULL, NULL, 'MSc', 1, 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `Students`
--

DROP TABLE IF EXISTS `Students`;
CREATE TABLE `Students` (
  `FirstName` varchar(25) NOT NULL,
  `LastName` varchar(25) NOT NULL,
  `UoBNumber` int(8) NOT NULL,
  `UoBEmail` varchar(50) NOT NULL,
  `ProgrammeOfStudy` varchar(50) NOT NULL,
  `Password` varchar(16) NOT NULL,
  `YearOfStudy` varchar(3) NOT NULL,
  `DateProjSelected` datetime DEFAULT NULL,
  `DateProjConfirmed` datetime DEFAULT NULL,
  `NumberOfSelections` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Students`
--

INSERT INTO `Students` (`FirstName`, `LastName`, `UoBNumber`, `UoBEmail`, `ProgrammeOfStudy`, `Password`, `YearOfStudy`, `DateProjSelected`, `DateProjConfirmed`, `NumberOfSelections`) VALUES
('Haider', 'Raoof', 17004364, 'hraoof@bradford.ac.uk', 'Computer Science', '22Lights', '3rd', NULL, NULL, 0),
('Hamaad', 'Raoof', 17004365, 'hamaadraoof@bradford.ac.uk', 'Computer Science', '22Lights', '3rd', NULL, NULL, 0),
('Harry', 'S', 17008904, 'hshakil@bradford.ac.uk', 'Computer Science', 'Password-123', '3rd', NULL, NULL, 0),
('Bob', 'Bob', 18008904, 'bob@bradford.ac.uk', 'Computer Science', 'Password-123', 'MSc', NULL, NULL, 0),
('Foluke', 'Agbede', 18010524, 'faagbede@bradford.ac.uk', 'Computer Science', 'Avengers2020', '3rd', NULL, NULL, 0),
('Zaka', 'Raoof', 19023418, 'zrehma12@bradford.ac.uk', 'Computer Science', 'Password123', '3rd', NULL, NULL, 0),
('Greg', 'Okay', 88888888, 'greg@bradford.ac.uk', 'Computer Science', 'Password-123', '3rd', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `Supervisors`
--

DROP TABLE IF EXISTS `Supervisors`;
CREATE TABLE `Supervisors` (
  `SupervisorID` int(11) NOT NULL,
  `FirstName` varchar(25) NOT NULL,
  `LastName` varchar(25) NOT NULL,
  `Username` varchar(25) NOT NULL,
  `Password` varchar(16) NOT NULL,
  `UoBEmail` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Supervisors`
--

INSERT INTO `Supervisors` (`SupervisorID`, `FirstName`, `LastName`, `Username`, `Password`, `UoBEmail`) VALUES
(1, 'Dhaval', 'Thakker', 'Dhaval', 'Dhaval', 'd.thakker@bradford.ac.uk'),
(2, 'Savas', 'Konur', 'Savas', 'Savas', 's.konur@bradford.ac.uk'),
(3, 'Apostolos', 'Vourdas', 'Apostolos', 'Apostolos', 'a.vourdas@bradford.ac.uk'),
(4, 'Ci', 'Lei', 'Ci', 'Ci', 'c.lei1@bradford.ac.uk'),
(5, 'Demetres', 'Kouvatsos', 'Demetrus', 'Demetrus', 'd.kouvatsos@bradford.ac.uk'),
(6, 'Haider', 'Raoof', 'Haider', 'Haider', 'hraoof@bradford.ac.uk'),
(7, 'Shaf', 'Ahmed', 'Shaf', 'Shaf', 'S.Ahmed210@bradford.ac.uk'),
(8, 'Zaka', 'Rehman', 'Zaka', 'Zaka', 'zakarehman12@bradford.ac.uk');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ModuleCoordinator`
--
ALTER TABLE `ModuleCoordinator`
  ADD PRIMARY KEY (`ModuleCoordinatorID`);

--
-- Indexes for table `Projects`
--
ALTER TABLE `Projects`
  ADD PRIMARY KEY (`ProjectID`),
  ADD KEY `OriginatorID` (`OriginatorID`),
  ADD KEY `AssignedSupervisor` (`AssignedSupervisor`),
  ADD KEY `AssignedStudent` (`AssignedStudent`);

--
-- Indexes for table `Students`
--
ALTER TABLE `Students`
  ADD PRIMARY KEY (`UoBNumber`);

--
-- Indexes for table `Supervisors`
--
ALTER TABLE `Supervisors`
  ADD PRIMARY KEY (`SupervisorID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Projects`
--
ALTER TABLE `Projects`
  MODIFY `ProjectID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `Supervisors`
--
ALTER TABLE `Supervisors`
  MODIFY `SupervisorID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Projects`
--
ALTER TABLE `Projects`
  ADD CONSTRAINT `Projects_ibfk_1` FOREIGN KEY (`OriginatorID`) REFERENCES `Supervisors` (`SupervisorID`),
  ADD CONSTRAINT `Projects_ibfk_2` FOREIGN KEY (`AssignedSupervisor`) REFERENCES `Supervisors` (`SupervisorID`),
  ADD CONSTRAINT `Projects_ibfk_3` FOREIGN KEY (`AssignedStudent`) REFERENCES `Students` (`UoBNumber`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
