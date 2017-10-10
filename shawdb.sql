-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 10, 2017 at 07:27 PM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 7.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shawdb`
--
CREATE DATABASE shawdb; 

USE shawdb;
-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `booking_ID` int(100) NOT NULL,
  `customer_ID` int(100) NOT NULL,
  `timing_ID` int(100) NOT NULL,
  `payment_ID` int(100) NOT NULL,
  `ticket_quantity` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cinema`
--

CREATE TABLE `cinema` (
  `cinema_ID` int(100) NOT NULL,
  `cinema_seats` int(10) NOT NULL,
  `cinema_location` varchar(45) NOT NULL,
  `cinema_image` varchar(100) NOT NULL,
  `cinema_bus` varchar(1000) NOT NULL,
  `cinema_train` varchar(1000) NOT NULL,
  `cinema_address` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cinema`
--

INSERT INTO `cinema` (`cinema_ID`, `cinema_seats`, `cinema_location`, `cinema_image`, `cinema_bus`, `cinema_train`, `cinema_address`) VALUES
(2, 100, 'Shaw Theatres Nex', '.png', 'SBS: 22, 43, 45, 53, 58, 70, 70M 81, 82, 100, 101, 103, 103M, 105, 109, 133, 135, 147, 153, 158, 315, 317, 853', '                                     Serangoon station (North East Line or Circle line)', '                                       23, Serangoon Central, #04-64, Nex, Singapore 556083<br/><br/>'),
(3, 100, 'Shaw Theatres Lido', '.jpg', 'SBS: 7, 36, 54, 105, 111, 123, 124, 132, 143, 162, 162M, 162X, 174, 174e, 181M, 502, 502A, 518, 518A, C1<br/>                                            TIBS: 77, 106, 167, 171, 190, 700', 'Orchard station (North South line)', '                                       350, Orchard Road, 5th/6th Floor, Shaw House, Singapore 238868<br/><br/>'),
(6, 100, 'Shaw Theatres JCube', '.jpg', 'SBS: 51, 52, 66, 78, 79, 97, 97e, 105, 143, 160, 183, 197, 198, 333, 335, 506, SS4<br/>                                            TIBS: 176, 178', '                                         Jurong East station (North South Line or East West line)', '                                            Shaw Theatres JCube, 2 Jurong East Central 1, JCube, #04-11, Singapore 609731<br/><br/>'),
(7, 100, 'Shaw Theatres Bugis', '.jpg', 'SBS: 2, 7, 12, 32, 33, 51, 63, 80, 130, 133, 145, 197, 197, C3<br/>                                            TIBS: 61, 851, 960, 980<br/>', '                                       Bugis station (North South line)', '200, Victoria Street, #04-02, Bugis Junction, Singapore 188021'),
(8, 100, 'Shaw Theatres Balestier', '.jpg', '                                       SBS: 21, 130, 131, 145, 186<br/>', 'Novena, Toa Payoh station (North South line)', '360, Balestier Road, Shaw Plaza, #04-04, Singapore 329783'),
(9, 100, 'Shaw Theatres Lot One', '.jpg', 'SBS: 181M<br/>                                            TIBS: 67, 172, 188, 188E, 190, 300, 302,307, 925, 925C, 927, 985, NR3', 'Choa Chu Kang station (North South line)', 'Lot 1 Shoppers\' Mall, Choa Chu Kang Ave 4, 5th/6th Floor, Singapore 689812');

-- --------------------------------------------------------

--
-- Table structure for table `confirms`
--

CREATE TABLE `confirms` (
  `id` int(11) NOT NULL,
  `tablename` varchar(50) NOT NULL,
  `numseats` int(11) NOT NULL,
  `person` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_ID` int(100) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `customer_phone` varchar(100) NOT NULL,
  `customer_email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_ID`, `customer_name`, `customer_phone`, `customer_email`) VALUES
(1, 'admin', '12345678', 'asd@asd.qwe'),
(2, 'little', '87654321', 'zxc@vbn.asd'),
(3, 'q', '88888888', 'q@gmail.com'),
(4, 'q', '88888888', 'wan@chofhoiw.comm'),
(5, 'q', '88888888', 'wan@chofhoiw.comm'),
(6, 'w', '88888888', 'wangchingpin94@gmail.com'),
(7, 'w', '88888888', 'wangchingpin94@gmail.com'),
(8, 'Cp', '82345678', 'yixuan.ong95@gmail.com'),
(9, 'wang', '88888888', 'wangchingpin94@gmail.com'),
(10, 'wang', '88888888', 'wangchingpin94@gmail.com'),
(11, 'wang', '88888888', 'wangchingpin94@gmail.com'),
(12, 'wang', '88888888', 'wangchingpin94@gmail.com'),
(13, 'q', '88888888', 'wangchingpin94@gmail.com'),
(14, 'wang', '88888888', 'wangchingpin94@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `movies`
--

CREATE TABLE `movies` (
  `movie_ID` int(11) NOT NULL,
  `movie_image` varchar(100) NOT NULL,
  `movie_name` varchar(45) NOT NULL,
  `movie_cast` varchar(1000) NOT NULL,
  `movie_director` varchar(1000) NOT NULL,
  `movie_synopsis` varchar(2000) NOT NULL,
  `movie_runningtime` varchar(100) NOT NULL,
  `movie_screeningdate` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `movies`
--

INSERT INTO `movies` (`movie_ID`, `movie_image`, `movie_name`, `movie_cast`, `movie_director`, `movie_synopsis`, `movie_runningtime`, `movie_screeningdate`) VALUES
(1, '.jpg', 'Thor : The Dark World (PG13)', 'Chris Hemsworth, Natalie Portman, Tom Hiddleston, Anthony Hopkins', 'Alan Taylor', 'In ancient times, the gods of Asgard fought and won a war against an evil race known as the Dark Elves. The survivors were neutralized, and their ultimate weapon -- the Aether -- was buried in a secret location. Hundreds of years later, Jane Foster (Natalie Portman) finds the Aether and becomes its host, forcing Thor (Chris Hemsworth) to bring her to Asgard before Dark Elf Malekith (Christopher Eccleston) captures her and uses the weapon to destroy the Nine Realms -- including Earth.<br>', '112 Minutes', 'October 22, 2013'),
(2, '.jpg', 'Iron Man 4', 'Robert Downey Jr., Guy Pearce, Gwyneth Paltrow', 'Shane Black', 'Plagued with worry and insomnia since saving New York from destruction, Tony Stark (Robert Downey Jr.), now, is more dependent on the suits that give him his Iron Man persona -- so much so that every aspect of his life is affected, including his relationship with Pepper (Gwyneth Paltrow). After a malevolent enemy known as the Mandarin (Ben Kingsley) reduces his personal world to rubble, Tony must rely solely on instinct and ingenuity to avenge his losses and protect the people he loves.', '130 minutes', 'April 25, 2013'),
(3, '.jpg', 'Captain America : The Winter Soldier', 'Chris Evans, Scarlett Johansson, Robert Redford, Samuel L. Jackson', 'Anthony Russo, Joe Russo', 'After the cataclysmic events in New York with his fellow Avengers, Steve Rogers, aka Captain America (Chris Evans), lives in the nation\'s capital as he tries to adjust to modern times. An attack on a S.H.I.E.L.D. colleague throws Rogers into a web of intrigue that places the whole world at risk. Joining forces with the Black Widow (Scarlett Johansson) and a new ally, the Falcon, Rogers struggles to expose an ever-widening conspiracy, but he and his team soon come up against an unexpected enemy.', '136 Minutes', 'March 27, 2014'),
(4, '.png', 'Guardians of the Galaxy2', 'Chris Pratt, Zoe Saldana, Dave Bautista, Vin Diesel, Bradley Cooper', 'James Gunn', 'Brash space adventurer Peter Quill (Chris Pratt) finds himself the quarry of relentless bounty hunters after he steals an orb coveted by Ronan, a powerful villain. To evade Ronan, Quill is forced into an uneasy truce with four disparate misfits: gun-toting Rocket Raccoon, treelike-humanoid Groot, enigmatic Gamora, and vengeance-driven Drax the Destroyer. But when he discovers the orb\'s true power and the cosmic threat it poses, Quill must rally his ragtag group to save the universe.', '122 Minutes', 'July 21, 2014'),
(5, '.jpg', 'Avengers : Age of Despair', 'Robert Downey, Jr., Chris Hemsworth, Mark Ruffalo, Chris Evans, Scarlett Johansson, Samuel L. Jackson', 'Kevin Feige', 'When Tony Stark (Robert Downey Jr.) jump-starts a dormant peacekeeping program, things go terribly awry, forcing him, Thor (Chris Hemsworth), the Incredible Hulk (Mark Ruffalo) and the rest of the Avengers to reassemble. As the fate of Earth hangs in the balance, the team is put to the ultimate test as they battle Ultron, a technological terror hell-bent on human extinction. Along the way, they encounter two mysterious and powerful newcomers, Pietro and Wanda Maximoff.', '141 minutes', 'April 13, 2015'),
(6, '.jpg', 'Avengers', 'Robert Downey, Jr., Chris Hemsworth, Mark Ruffalo, Chris Evans, Scarlett Johansson, Samuel L. Jackson', 'Joss Whedon', 'When Thor\'s evil brother, Loki (Tom Hiddleston), gains access to the unlimited power of the energy cube called the Tesseract, Nick Fury (Samuel L. Jackson), director of S.H.I.E.L.D., initiates a superhero recruitment effort to defeat the unprecedented threat to Earth. Joining Fury\'s \"dream team\" are Iron Man (Robert Downey Jr.), Captain America (Chris Evans), the Hulk (Mark Ruffalo), Thor (Chris Hemsworth), the Black Widow (Scarlett Johansson) and Hawkeye (Jeremy Renner).', '143 minutes', 'May 1, 2012');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_ID` int(100) NOT NULL,
  `creditCardName` varchar(255) NOT NULL,
  `payment_number` varchar(16) NOT NULL,
  `payment_expiry` varchar(4) NOT NULL,
  `payment_cvv` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`payment_ID`, `creditCardName`, `payment_number`, `payment_expiry`, `payment_cvv`) VALUES
(1, '', '4966157046708890', '0000', '209'),
(2, '', '4966157046708890', '0000', '209'),
(3, '', '4966157046708890', '0000', '209'),
(4, '', '4966157046708890', '0000', '209'),
(5, 'wang', '4966157046708890', '0818', '209'),
(6, 'wang', '4966157046708890', '0818', '209'),
(7, 'wang', '4966157046708890', '0818', '209');

-- --------------------------------------------------------

--
-- Table structure for table `promotion`
--

CREATE TABLE `promotion` (
  `promotion_ID` int(11) NOT NULL,
  `promotion_name` varchar(1000) NOT NULL,
  `promotion_subname` varchar(1000) NOT NULL,
  `promotion_description` varchar(1000) NOT NULL,
  `promotion_image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `promotion`
--

INSERT INTO `promotion` (`promotion_ID`, `promotion_name`, `promotion_subname`, `promotion_description`, `promotion_image`) VALUES
(1, 'M1 Promotion', 'M1 Movie Sundays', 'With M1 Movie Sundays, treat a friend to catch the latest blockbuster or cuddle up with your loved one over a romantic comedy!\r\n                                                   Just present your latest M1 bill or show the M1 logo on your phone when buying movie tickets at Shaw Theatres to get the second ticket FREE. \r\n                                                   Offer is limited to the first 450 customers every weekend! So be the first to be there!', '.jpg'),
(2, 'Safra Weekly Promotion', 'Red hot weekend', 'For just $8 (U.P. $12) per ticket, you and your friends can enjoy a movie together at Shaw Theatres.\r\n                                                   Members must purchase ticket in person with valid SAFRA card and NRIC for verification. \r\n                                                   Valid for the first 2,000 discounted tickets per day (Sat and Sun).', '.jpg'),
(3, 'OCBC Promotion', 'Movie Packages', 'Get $1 off for your movie tickets!(Terms and conditions apply)</br>Get 2x Regular tickets, two 32 OZ Drinks and a 85 OZ Popcorn for only $26.00!', '.jpg'),
(4, 'Kiddos Promotion', 'Promotion for Juniors', 'Free admission for 6 years old and below</br>Special Ribena Popcorn combo at only $5.90</br>Terms and Conditions Apply', '.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `seats`
--

CREATE TABLE `seats` (
  `rowId` varchar(1) NOT NULL,
  `columnId` int(11) NOT NULL,
  `timing_ID` int(11) NOT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `seats`
--

INSERT INTO `seats` (`rowId`, `columnId`, `timing_ID`, `status`) VALUES
('A', 1, 1, 1),
('A', 1, 2, 1),
('A', 2, 1, 0),
('A', 2, 2, 0),
('A', 3, 1, 0),
('A', 3, 2, 0),
('A', 4, 1, 1),
('A', 4, 2, 0),
('A', 5, 1, 1),
('A', 5, 2, 0),
('A', 6, 1, 1),
('A', 6, 2, 0),
('A', 7, 1, 1),
('A', 7, 2, 0),
('A', 8, 1, 1),
('A', 8, 2, 0),
('A', 9, 1, 1),
('A', 9, 2, 0),
('A', 10, 1, 1),
('A', 10, 2, 0),
('A', 11, 1, 1),
('A', 12, 1, 1),
('A', 13, 1, 1),
('A', 14, 1, 1),
('A', 15, 1, 1),
('A', 16, 1, 1),
('A', 17, 1, 1),
('A', 18, 1, 1),
('A', 19, 1, 1),
('A', 20, 1, 1),
('B', 1, 1, 1),
('B', 1, 2, 0),
('B', 2, 1, 1),
('B', 2, 2, 1),
('B', 3, 1, 1),
('B', 3, 2, 0),
('B', 4, 1, 1),
('B', 4, 2, 0),
('B', 5, 1, 1),
('B', 5, 2, 0),
('B', 6, 1, 1),
('B', 6, 2, 1),
('B', 7, 1, 1),
('B', 7, 2, 0),
('B', 8, 1, 1),
('B', 8, 2, 0),
('B', 9, 1, 1),
('B', 9, 2, 0),
('B', 10, 1, 1),
('B', 10, 2, 0),
('B', 11, 1, 2),
('B', 12, 1, 1),
('B', 13, 1, 1),
('C', 1, 2, 1),
('C', 2, 2, 1),
('C', 3, 1, 1),
('C', 3, 2, 1),
('C', 4, 2, 1),
('C', 5, 2, 1),
('C', 6, 2, 1),
('C', 7, 2, 1),
('C', 8, 2, 1),
('C', 9, 2, 1),
('C', 10, 2, 1),
('D', 9, 1, 1),
('E', 9, 1, 1),
('F', 9, 1, 1),
('G', 7, 1, 1),
('H', 9, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `timeslots`
--

CREATE TABLE `timeslots` (
  `timing_ID` int(11) NOT NULL,
  `timing_date` date NOT NULL,
  `timing_timing` varchar(4) NOT NULL,
  `movie_ID` int(11) NOT NULL,
  `cinema_ID` int(100) NOT NULL,
  `ticket_price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `timeslots`
--

INSERT INTO `timeslots` (`timing_ID`, `timing_date`, `timing_timing`, `movie_ID`, `cinema_ID`, `ticket_price`) VALUES
(1, '2015-11-24', '1900', 2, 3, 8),
(2, '2015-11-18', '1400', 1, 3, 8),
(3, '2015-12-02', '1730', 2, 6, 8),
(4, '2015-11-24', '1300', 1, 3, 8),
(5, '2015-12-01', '2000', 1, 3, 8),
(6, '2015-12-02', '1200', 1, 2, 8),
(7, '2015-12-02', '1800', 1, 2, 8),
(8, '2015-12-05', '1800', 1, 6, 8),
(9, '2015-11-17', '1700', 1, 6, 8),
(10, '2015-11-24', '1730', 1, 3, 8),
(11, '2015-12-09', '1730', 3, 7, 8),
(12, '2015-11-08', '1630', 1, 7, 8),
(13, '2015-11-16', '1545', 2, 2, 8),
(14, '2015-12-22', '1640', 2, 3, 8),
(15, '2015-11-29', '1620', 1, 8, 8),
(16, '2015-12-10', '1220', 1, 8, 8),
(17, '2015-11-26', '1230', 1, 9, 8),
(18, '2015-11-08', '0900', 1, 9, 8),
(19, '2015-11-17', '2000', 2, 7, 8),
(20, '2015-11-17', '2100', 2, 7, 8),
(21, '2015-11-23', '1400', 2, 9, 8),
(22, '2015-12-01', '1830', 2, 9, 8),
(23, '2015-11-30', '0940', 2, 8, 8),
(24, '2015-11-05', '1440', 2, 8, 8),
(25, '2015-11-22', '1200', 3, 2, 8),
(26, '2015-11-09', '1900', 3, 2, 8),
(27, '2015-12-22', '2030', 3, 3, 8),
(28, '2015-12-22', '2050', 3, 3, 8),
(29, '2015-11-27', '2340', 4, 2, 8),
(30, '2015-11-10', '1330', 4, 2, 8),
(31, '2015-11-12', '1350', 4, 2, 8),
(32, '2015-11-12', '1420', 4, 2, 8),
(33, '2015-11-13', '1700', 4, 3, 8),
(34, '2015-11-14', '1800', 4, 3, 8),
(35, '2015-11-20', '1120', 4, 6, 8),
(36, '2015-11-30', '1500', 4, 6, 8),
(37, '2015-11-10', '1655', 4, 6, 8),
(38, '2015-12-01', '1200', 4, 6, 8);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_ID`);

--
-- Indexes for table `cinema`
--
ALTER TABLE `cinema`
  ADD PRIMARY KEY (`cinema_ID`);

--
-- Indexes for table `confirms`
--
ALTER TABLE `confirms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_ID`);

--
-- Indexes for table `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`movie_ID`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_ID`);

--
-- Indexes for table `promotion`
--
ALTER TABLE `promotion`
  ADD PRIMARY KEY (`promotion_ID`);

--
-- Indexes for table `seats`
--
ALTER TABLE `seats`
  ADD PRIMARY KEY (`rowId`,`columnId`,`timing_ID`);

--
-- Indexes for table `timeslots`
--
ALTER TABLE `timeslots`
  ADD PRIMARY KEY (`timing_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_ID` int(100) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cinema`
--
ALTER TABLE `cinema`
  MODIFY `cinema_ID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `confirms`
--
ALTER TABLE `confirms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_ID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `movies`
--
ALTER TABLE `movies`
  MODIFY `movie_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_ID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `promotion`
--
ALTER TABLE `promotion`
  MODIFY `promotion_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `timeslots`
--
ALTER TABLE `timeslots`
  MODIFY `timing_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

GRANT ALL PRIVILEGES ON *.* TO 'shawread'@'localhost' IDENTIFIED BY PASSWORD '*84AAC12F54AB666ECFC2A83C676908C8BBC381B1' WITH GRANT OPTION;
