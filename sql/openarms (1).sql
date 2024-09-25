-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Dec 15, 2023 at 11:05 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `openarms`
--

-- --------------------------------------------------------

--
-- Table structure for table `campaign`
--

CREATE TABLE `campaign` (
  `campaignid` int(11) NOT NULL,
  `campaignName` varchar(255) NOT NULL,
  `campaignDetails` mediumtext NOT NULL,
  `goal` double NOT NULL,
  `picture` varchar(255) NOT NULL,
  `organizer` int(11) DEFAULT NULL,
  `dateApproved` date DEFAULT NULL,
  `dateRequested` date NOT NULL,
  `approvalStatus` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `campaign`
--

INSERT INTO `campaign` (`campaignid`, `campaignName`, `campaignDetails`, `goal`, `picture`, `organizer`, `dateApproved`, `dateRequested`, `approvalStatus`, `category`, `state`, `country`) VALUES
(7, 'Save the Elephants', 'Working towards the conservation of elephants and their habitats.', 10000, 'wolfgang-hasselmann-P7L5011nD5s-unsplash.jpg', 1, NULL, '2023-11-27', 'Closed', 'Animal Welfare', 'NairobiCapital', 'Kenya'),
(8, 'Art for All', 'Promoting arts and culture by supporting local artists and art events.', 5000, 'daria-tumanova-mmYyzczxvdo-unsplash.jpg', 1, NULL, '2023-11-27', 'Approved', 'Arts and Culture', 'California', 'United States'),
(9, 'Community Garden Project', 'Creating a community garden to foster local food production and community engagement.', 8000, 'mio-ito-DaGIjXNl5oA-unsplash.jpg', 2, NULL, '2023-11-27', 'Approved', 'Community Development', 'Ontario', 'Canada'),
(10, 'Crisis Helpline Expansion', 'Expanding a crisis intervention helpline to reach more people in need.', 12000, 'arlington-research-kN_kViDchA0-unsplash.jpg', 2, NULL, '2023-11-27', 'Closed', 'Crisis Intervention', 'Maharashtra', 'India'),
(11, 'Disaster Relief for Flood Victims', 'Providing relief to victims of recent floods by supplying essential items.', 15000, 'chris-gallagher-4zxp5vlmvnI-unsplash.jpg', 5, NULL, '2023-11-27', 'Approved', 'Disaster Relief', 'Dhaka', 'Bangladesh'),
(12, 'Elderly Care Assistance Program', 'Supporting elderly individuals by providing healthcare services and companionship.', 6000, 'andrew-rivera-GgRlUhPrCPw-unsplash.jpg', 5, NULL, '2023-11-27', 'Approved', 'Elderly Care', 'New York', 'United States'),
(13, 'Emergency Shelter Fund', 'Establishing emergency shelters for individuals in crisis situations.', 20000, 'SHELTER_SQUARED_-_BLEACHER_RENDER.jpg', 6, NULL, '2023-11-27', 'Approved', 'Emergency Assistance', 'Victoria', 'Australia'),
(14, 'Green Earth Initiative', 'Promoting environmental conservation through tree planting and waste reduction initiatives.', 18000, 'noah-buscher-x8ZStukS2PM-unsplash.jpg', 6, NULL, '2023-11-27', 'Approved', 'Environmental Conservation', 'Sao Paulo', 'Brazil'),
(15, 'Healthcare for All', 'Providing accessible healthcare services to underserved communities.', 25000, 'cdc-vt7iAyiwpf0-unsplash.jpg', 7, NULL, '2023-11-27', 'Approved', 'Healthcare', 'Lagos', 'Nigeria'),
(16, 'Human Rights Advocacy', 'Advocating for human rights and supporting organizations working in this field.', 15000, 'Zehra-Mirza-transformative-advocacy-592x333.jpg', 7, NULL, '2023-11-27', 'Approved', 'Human Rights', 'Gauteng', 'South Africa'),
(17, 'Poverty Alleviation Project', 'Implementing projects to alleviate poverty and empower communities.', 30000, 'Poverty-Alleviation-Community-Empowerment-Project.jpg', 8, NULL, '2023-11-27', 'Approved', 'Poverty Alleviation', 'Mexico City', 'Mexico'),
(18, 'Refugee Support Initiative', 'Providing support and resources to refugees and displaced individuals.', 22000, 'RF2257467_DSCF2276.jpg', 8, NULL, '2023-11-27', 'Approved', 'Refugee Support', 'Istanbul', 'Turkey'),
(19, 'Tech for Education', 'Introducing technology in education to enhance learning opportunities for students.', 14000, 'J-PAL-summary-126-ed-tech-studies-MIT-00_0.jpg', 9, NULL, '2023-11-27', 'Approved', 'Technology', 'Tokyo', 'Japan'),
(20, 'Urban Revitalization Project', 'Revitalizing urban areas through infrastructure development and community programs.', 28000, 'brighton-boulevard-redevelopment-161804.jpg', 9, NULL, '2023-11-27', 'Approved', 'Urban Revitalization', 'Paris', 'France'),
(21, 'Youth Empowerment Program', 'Empowering youth through skill development and mentorship programs.', 10000, 'YouthEmpowerPgm.jpg', 10, NULL, '2023-11-27', 'Approved', 'Youth Empowerment', 'London', 'United Kingdom'),
(22, 'Clean Water for All', 'Ensuring access to clean water in remote communities.', 12000, 'joshua-lanzarini-JQwzKcHLHoc-unsplash-scaled-1.jpg', 10, NULL, '2023-11-27', 'Approved', 'Community Development', 'Kampala', 'Uganda'),
(23, 'Solar Energy Initiative', 'Promoting the use of solar energy for sustainable and clean power sources.', 15000, 'Untitled-design-2022-02-10T124016.253.jpg', 11, NULL, '2023-11-27', 'Approved', 'Environmental Conservation', 'Gujarat', 'India'),
(24, 'Mental Health Awareness', 'Raising awareness about mental health and providing resources for mental health support.', 8000, 'sincerely-media-dGxOgeXAXm8-unsplash.jpg', 11, NULL, '2023-11-27', 'Approved', 'Healthcare', 'New South Wales', 'Australia'),
(25, 'Women\'s Empowerment Project', 'Empowering women through education, vocational training, and support programs.', 20000, '01wk_1525071653.jpg', 12, NULL, '2023-11-27', 'Approved', 'Human Rights', 'Mombasa', 'Kenya'),
(26, 'Tech for Rural Development', 'Introducing technology in rural areas to enhance development opportunities.', 25000, 'India_iStock.com_by_Bartosz_Hadyniak_1-1hh5dvs.jpg', 12, NULL, '2023-11-27', 'Approved', 'Technology', 'Bahia', 'Brazil'),
(29, 'Disaster Relief For Refugees', 'Hello', 5000, 'IMG-657c104590c8f4.25219523.jpg', NULL, NULL, '2023-12-15', 'Closed', 'Disaster Relief', 'No States', 'Vatican City'),
(30, 'asdasd', 'asdasd', 123123, 'IMG-657c15b0252601.27590088.jpg', 1, NULL, '2023-12-15', 'Closed', 'Animal Welfare', 'Homyel’ Voblasc’', 'Belarus');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cartid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `productid` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cartid`, `userid`, `productid`, `quantity`) VALUES
(24, 1, 11, 1);

-- --------------------------------------------------------

--
-- Table structure for table `donation`
--

CREATE TABLE `donation` (
  `campaignid` int(11) NOT NULL,
  `donorid` int(11) DEFAULT NULL,
  `amount` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `donationid` int(11) NOT NULL,
  `anonymous` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `donation`
--

INSERT INTO `donation` (`campaignid`, `donorid`, `amount`, `date`, `donationid`, `anonymous`) VALUES
(7, 1, 250, '2023-12-01 19:52:12', 10, 0),
(7, 2, 200, '2023-12-07 19:54:29', 20, 0),
(7, 2, 500, '2023-11-29 08:32:42', 30, 0),
(7, 2, 500, '2023-11-29 08:32:42', 39, 0),
(7, 5, 300, '2023-11-29 08:34:35', 40, 0),
(7, 6, 400, '2023-12-10 08:08:42', 41, 1),
(7, 7, 30, '2023-12-11 10:46:31', 42, 0),
(7, 8, 60, '2023-12-11 10:47:13', 43, 0),
(7, 9, 30, '2023-12-11 10:47:19', 44, 0),
(7, 13, 90, '2023-12-11 10:48:05', 45, 0),
(7, 14, 25, '2023-12-12 08:54:12', 46, 0),
(7, 10, 25, '2023-12-10 09:32:12', 47, 0),
(8, 1, 500, '2023-12-01 20:27:26', 48, 0),
(8, 1, 500, '2023-12-01 20:27:26', 49, 0),
(8, 2, 1500, '2023-12-02 20:27:26', 50, 0),
(8, 5, 300, '2023-12-05 20:27:26', 51, 0),
(8, 6, 400, '2023-12-03 20:27:26', 52, 0),
(8, 9, 200, '2023-11-01 20:27:26', 53, 0),
(8, 10, 100, '2023-11-15 20:27:26', 54, 0),
(8, 11, 800, '2023-11-03 20:27:26', 55, 0),
(9, 1, 500, '2023-12-01 20:27:26', 56, 0),
(9, 2, 1000, '2023-12-02 20:27:26', 57, 0),
(9, 5, 200, '2023-12-05 20:27:26', 58, 0),
(9, 6, 600, '2023-12-03 20:27:26', 59, 0),
(9, 9, 100, '2023-11-01 20:27:26', 60, 0),
(9, 10, 50, '2023-11-15 20:27:26', 61, 0),
(9, 11, 400, '2023-11-03 20:27:26', 62, 0),
(10, 1, 500, '2023-05-10 14:35:42', 63, 0),
(10, 2, 1000, '2023-08-22 18:45:11', 64, 0),
(10, 5, 200, '2023-03-17 12:10:34', 65, 0),
(10, 6, 600, '2023-07-01 09:23:56', 66, 0),
(10, 7, 150, '2023-09-05 16:58:20', 67, 0),
(10, 8, 300, '2023-01-29 21:07:45', 68, 0),
(10, 11, 400, '2023-11-14 08:30:15', 69, 0),
(11, 1, 750, '2023-06-18 17:42:30', 70, 0),
(11, 2, 1200, '2023-09-02 11:15:28', 71, 0),
(11, 5, 250, '2023-04-25 14:55:09', 72, 0),
(11, 6, 800, '2023-07-30 10:37:51', 73, 0),
(11, 7, 180, '2023-10-12 22:08:47', 74, 0),
(11, 8, 400, '2023-02-14 08:20:33', 75, 0),
(11, 12, 550, '2023-12-09 19:30:04', 76, 0),
(12, 1, 600, '2023-06-18 17:42:30', 77, 0),
(12, 2, 900, '2023-09-02 11:15:28', 78, 0),
(12, 5, 180, '2023-04-25 14:55:09', 79, 0),
(12, 6, 750, '2023-07-30 10:37:51', 80, 0),
(12, 7, 300, '2023-10-12 22:08:47', 81, 0),
(12, 8, 450, '2023-02-14 08:20:33', 82, 0),
(12, 12, 700, '2023-12-09 19:30:04', 83, 0),
(13, 1, 550, '2023-07-10 14:20:15', 84, 0),
(13, 2, 800, '2023-09-25 09:45:22', 85, 0),
(13, 5, 120, '2023-05-03 12:35:07', 86, 0),
(13, 6, 700, '2023-08-18 18:53:49', 87, 0),
(13, 7, 350, '2023-11-02 21:24:44', 88, 0),
(13, 8, 500, '2023-03-05 07:36:30', 89, 0),
(13, 13, 600, '2023-12-20 16:10:55', 90, 0),
(14, 1, 800, '2023-08-15 13:05:29', 91, 0),
(14, 2, 1100, '2023-10-30 10:28:37', 92, 0),
(14, 5, 220, '2023-06-08 16:40:23', 93, 0),
(14, 6, 850, '2023-09-23 19:11:18', 94, 0),
(14, 7, 400, '2023-12-07 22:42:14', 95, 0),
(14, 8, 600, '2023-04-10 08:54:09', 96, 0),
(14, 14, 750, '2023-01-15 18:25:04', 97, 0),
(14, 1, 800, '2023-08-15 13:05:29', 105, 0),
(14, 2, 1100, '2023-10-30 10:28:37', 106, 0),
(14, 5, 220, '2023-06-08 16:40:23', 107, 0),
(14, 6, 850, '2023-09-23 19:11:18', 108, 0),
(14, 7, 400, '2023-12-07 22:42:14', 109, 0),
(14, 8, 600, '2023-04-10 08:54:09', 110, 0),
(14, 14, 750, '2023-01-15 18:25:04', 111, 0),
(14, 1, 800, '2023-08-15 13:05:29', 119, 0),
(14, 2, 1100, '2023-10-30 10:28:37', 120, 0),
(14, 5, 220, '2023-06-08 16:40:23', 121, 0),
(14, 6, 850, '2023-09-23 19:11:18', 122, 0),
(14, 7, 400, '2023-12-07 22:42:14', 123, 0),
(14, 8, 600, '2023-04-10 08:54:09', 124, 0),
(14, 14, 750, '2023-01-15 18:25:04', 125, 0),
(15, 1, 700, '2023-09-20 09:50:56', 126, 0),
(15, 2, 1000, '2023-11-04 15:13:04', 127, 0),
(15, 5, 180, '2023-07-13 17:43:59', 128, 0),
(15, 6, 800, '2023-10-28 20:14:54', 129, 0),
(15, 7, 350, '2023-01-12 23:45:50', 130, 0),
(15, 8, 550, '2023-05-16 07:07:46', 131, 0),
(15, 14, 600, '2023-02-28 12:38:41', 132, 0),
(16, 1, 900, '2023-10-05 12:23:32', 133, 0),
(16, 2, 1200, '2023-11-20 15:54:27', 134, 0),
(16, 5, 250, '2023-07-28 19:25:23', 135, 0),
(16, 6, 900, '2023-11-12 21:56:18', 136, 0),
(16, 7, 450, '2023-03-17 00:27:13', 137, 0),
(16, 8, 700, '2023-05-30 05:58:09', 138, 0),
(16, 12, 800, '2023-02-03 11:29:04', 139, 0),
(17, 1, 850, '2023-11-10 11:14:56', 140, 0),
(17, 2, 1100, '2023-12-25 14:45:51', 141, 0),
(17, 5, 200, '2023-08-03 18:17:46', 142, 0),
(17, 6, 950, '2023-12-18 20:48:41', 143, 0),
(17, 7, 400, '2023-04-23 00:19:36', 144, 0),
(17, 8, 600, '2023-06-05 05:50:32', 145, 0),
(17, 13, 750, '2023-02-09 11:21:27', 146, 0),
(18, 1, 800, '2023-12-15 10:05:29', 147, 0),
(18, 2, 1000, '2023-12-31 13:36:24', 148, 0),
(18, 5, 180, '2023-08-23 17:08:19', 149, 0),
(18, 6, 900, '2023-11-07 19:39:15', 150, 0),
(18, 7, 350, '2023-03-14 23:10:10', 151, 0),
(18, 8, 550, '2023-05-27 04:41:06', 152, 0),
(18, 11, 600, '2023-02-01 10:11:01', 153, 0),
(19, 1, 750, '2023-12-20 08:45:56', 154, 0),
(19, 2, 900, '2023-12-31 11:16:51', 155, 0),
(19, 5, 200, '2023-09-05 14:17:46', 156, 0),
(19, 6, 850, '2023-12-27 16:48:41', 157, 0),
(19, 7, 400, '2023-04-04 20:19:36', 158, 0),
(19, 8, 600, '2023-06-17 01:50:32', 159, 0),
(19, 10, 750, '2023-02-22 07:21:27', 160, 0),
(20, 1, 700, '2023-12-25 10:05:29', 161, 0),
(20, 2, 1100, '2023-12-31 13:36:24', 162, 0),
(20, 5, 180, '2023-09-10 17:08:19', 163, 0),
(20, 6, 800, '2023-12-31 19:39:15', 164, 0),
(20, 7, 350, '2023-04-16 23:10:10', 165, 0),
(20, 8, 550, '2023-07-01 04:41:06', 166, 0),
(20, 9, 600, '2023-03-06 10:11:01', 167, 0),
(16, 1, 900, '2023-10-05 12:23:32', 175, 0),
(16, 2, 1200, '2023-11-20 15:54:27', 176, 0),
(16, 5, 250, '2023-07-28 19:25:23', 177, 0),
(16, 6, 900, '2023-11-12 21:56:18', 178, 0),
(16, 7, 450, '2023-03-17 00:27:13', 179, 0),
(16, 8, 700, '2023-05-30 05:58:09', 180, 0),
(16, 12, 800, '2023-02-03 11:29:04', 181, 0),
(17, 1, 850, '2023-11-10 11:14:56', 182, 0),
(17, 2, 1100, '2023-12-25 14:45:51', 183, 0),
(17, 5, 200, '2023-08-03 18:17:46', 184, 0),
(17, 6, 950, '2023-12-18 20:48:41', 185, 0),
(17, 7, 400, '2023-04-23 00:19:36', 186, 0),
(17, 8, 600, '2023-06-05 05:50:32', 187, 0),
(17, 13, 750, '2023-02-09 11:21:27', 188, 0),
(18, 1, 800, '2023-12-15 10:05:29', 189, 0),
(18, 2, 1000, '2023-12-31 13:36:24', 190, 0),
(18, 5, 180, '2023-08-23 17:08:19', 191, 0),
(18, 6, 900, '2023-11-07 19:39:15', 192, 0),
(18, 7, 350, '2023-03-14 23:10:10', 193, 0),
(18, 8, 550, '2023-05-27 04:41:06', 194, 0),
(18, 11, 600, '2023-02-01 10:11:01', 195, 0),
(19, 1, 750, '2023-12-20 08:45:56', 196, 0),
(19, 2, 900, '2023-12-31 11:16:51', 197, 0),
(19, 5, 200, '2023-09-05 14:17:46', 198, 0),
(19, 6, 850, '2023-12-27 16:48:41', 199, 0),
(19, 7, 400, '2023-04-04 20:19:36', 200, 0),
(19, 8, 600, '2023-06-17 01:50:32', 201, 0),
(19, 10, 750, '2023-02-22 07:21:27', 202, 0),
(20, 1, 700, '2023-12-25 10:05:29', 203, 0),
(20, 2, 1100, '2023-12-31 13:36:24', 204, 0),
(20, 5, 180, '2023-09-10 17:08:19', 205, 0),
(20, 6, 800, '2023-12-31 19:39:15', 206, 0),
(20, 7, 350, '2023-04-16 23:10:10', 207, 0),
(20, 8, 550, '2023-07-01 04:41:06', 208, 0),
(20, 9, 600, '2023-03-06 10:11:01', 209, 0),
(21, 1, 800, '2023-12-30 08:45:56', 210, 0),
(21, 2, 900, '2023-12-31 11:16:51', 211, 0),
(21, 5, 200, '2023-10-15 14:17:46', 212, 0),
(21, 6, 850, '2023-12-31 16:48:41', 213, 0),
(21, 7, 400, '2023-04-30 20:19:36', 214, 0),
(21, 8, 600, '2023-07-13 01:50:32', 215, 0),
(21, 10, 750, '2023-03-20 07:21:27', 216, 0),
(22, 1, 700, '2023-12-31 10:05:29', 217, 0),
(22, 2, 1100, '2023-12-31 13:36:24', 218, 0),
(22, 5, 180, '2023-10-20 17:08:19', 219, 0),
(22, 6, 800, '2023-12-31 19:39:15', 220, 0),
(22, 7, 350, '2023-05-05 23:10:10', 221, 0),
(22, 8, 550, '2023-07-18 04:41:06', 222, 0),
(22, 9, 600, '2023-03-11 10:11:01', 223, 0),
(23, 1, 800, '2023-12-31 08:45:56', 224, 0),
(23, 2, 900, '2023-12-31 11:16:51', 225, 0),
(23, 5, 200, '2023-10-25 14:17:46', 226, 0),
(23, 6, 850, '2023-12-31 16:48:41', 227, 0),
(23, 7, 400, '2023-05-10 20:19:36', 228, 0),
(23, 8, 600, '2023-07-23 01:50:32', 229, 0),
(23, 10, 750, '2023-03-26 07:21:27', 230, 0),
(24, 1, 700, '2023-12-31 10:05:29', 231, 0),
(24, 2, 1100, '2023-12-31 13:36:24', 232, 0),
(24, 5, 180, '2023-11-01 17:08:19', 233, 0),
(24, 6, 800, '2023-12-31 19:39:15', 234, 0),
(24, 7, 350, '2023-06-15 23:10:10', 235, 0),
(24, 8, 550, '2023-07-28 04:41:06', 236, 0),
(24, 12, 600, '2023-04-03 10:11:01', 237, 0),
(25, 1, 800, '2023-12-31 08:45:56', 238, 0),
(25, 2, 900, '2023-12-31 11:16:51', 239, 0),
(25, 5, 200, '2023-11-06 14:17:46', 240, 0),
(25, 6, 850, '2023-12-31 16:48:41', 241, 0),
(25, 7, 400, '2023-06-20 20:19:36', 242, 0),
(25, 8, 600, '2023-08-02 01:50:32', 243, 0),
(25, 13, 750, '2023-04-10 07:21:27', 244, 0),
(26, 1, 700, '2023-12-31 10:05:29', 245, 0),
(26, 2, 1100, '2023-12-31 13:36:24', 246, 0),
(26, 5, 180, '2023-11-11 17:08:19', 247, 0),
(26, 6, 800, '2023-12-31 19:39:15', 248, 0),
(26, 7, 350, '2023-06-25 23:10:10', 249, 0),
(26, 8, 550, '2023-08-08 04:41:06', 250, 0),
(26, 14, 600, '2023-04-17 10:11:01', 251, 0),
(7, 1, 500, '2023-12-12 15:44:18', 252, 0),
(12, 1, 1000, '2023-12-13 10:58:02', 253, 1),
(12, 1, 500, '2023-12-13 11:16:46', 254, 0),
(9, 0, 6000, '2023-12-15 09:10:20', 255, 1),
(8, 0, 50, '2023-12-15 09:48:35', 256, 0),
(8, 0, 500, '2023-12-15 09:49:21', 257, 0);

-- --------------------------------------------------------

--
-- Table structure for table `mailer`
--

CREATE TABLE `mailer` (
  `email` varchar(1000) NOT NULL,
  `password` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mailer`
--

INSERT INTO `mailer` (`email`, `password`) VALUES
('webdevbruv@gmail.com', 'duao xxdy ivzl kudm');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `productid` int(11) NOT NULL,
  `productName` varchar(255) NOT NULL,
  `productDetails` varchar(1000) NOT NULL,
  `price` int(11) NOT NULL,
  `productPicture` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`productid`, `productName`, `productDetails`, `price`, `productPicture`) VALUES
(1, 'T-Shirt', 'Classic T-shirt with OpenArms Logo', 500, 'anomaly-WWesmHEgXDs-unsplash.jpg'),
(2, 'Cups', 'Fancy Cup', 250, 'samantha-ram-Ha5_JcYArf0-unsplash.jpg'),
(7, 'Jeans', 'Classic denim jeans with a comfortable fit', 80, 'mnz-m1m2EZOZVwA-unsplash.jpg'),
(8, 'Sneakers', 'Sporty sneakers for everyday use', 120, 'ox-street-Na5ZudYCQAs-unsplash.jpg'),
(9, 'Watch', 'Elegant wristwatch with leather strap', 350, 'jaelynn-castillo-xfNeB1stZ_0-unsplash.jpg'),
(10, 'Backpack', 'Durable backpack with multiple compartments', 60, 'tamara-bellis-kGvBLcBGZpI-unsplash.jpg'),
(11, 'Smartphone', 'Latest smartphone with high-resolution camera', 5000, 'mockup-free-NcmG1X1DWrI-unsplash.jpg'),
(12, 'Coffee Maker', 'Automatic coffee maker for a perfect brew', 200, 'mostafa-mahmoudi-DTgF0jbl89o-unsplash.jpg'),
(13, 'Gaming Laptop', 'Powerful laptop for gaming enthusiasts', 1500, 'joshua-woroniecki-lzh3hPtJz9c-unsplash.jpg'),
(14, 'Fitness Tracker', 'Track your fitness with this advanced wearable', 90, 'onur-binay-bwFW9PTJZx8-unsplash.jpg'),
(15, 'Headphones', 'High-quality over-ear headphones for immersive sound', 180, 'c-d-x-PDX_a_82obo-unsplash.jpg'),
(16, 'Desk Chair', 'Ergonomic office chair for comfortable seating', 250, 'willian-justen-de-vasconcellos-CKLF34baCTQ-unsplash.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `purchase`
--

CREATE TABLE `purchase` (
  `purchaseid` int(11) NOT NULL,
  `userid` int(11) DEFAULT NULL,
  `items` varchar(1000) NOT NULL,
  `date` datetime NOT NULL,
  `shippingAddress` varchar(1000) NOT NULL,
  `total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `purchase`
--

INSERT INTO `purchase` (`purchaseid`, `userid`, `items`, `date`, `shippingAddress`, `total`) VALUES
(7, 1, '[{\"productName\":\"T-Shirts\",\"quantity\":\"3\",\"pricePP\":\"500\"},{\"productName\":\"Cups\",\"quantity\":\"3\",\"pricePP\":\"250\"},{\"productName\":\"asdasd\",\"quantity\":\"1\",\"pricePP\":\"1231\"}]', '2023-12-10 07:08:19', 'asd', 3481),
(8, 1, '[{\"productName\":\"T-Shirts\",\"quantity\":\"1\",\"pricePP\":\"500\"}]', '2023-12-10 07:32:43', 'hello', 500),
(9, 1, '[{\"productName\":\"Sneakers\",\"quantity\":\"2\",\"pricePP\":\"120\"},{\"productName\":\"Backpack\",\"quantity\":\"1\",\"pricePP\":\"60\"}]', '2023-12-14 20:09:15', 'Bandar Utama', 300),
(10, NULL, '[{\"productName\":\"Backpack\",\"quantity\":\"3\",\"pricePP\":\"60\"}]', '2023-12-15 09:47:44', 'Sunway University', 180),
(11, NULL, '[{\"productName\":\"Jeans\",\"quantity\":\"3\",\"pricePP\":\"80\"},{\"productName\":\"Sneakers\",\"quantity\":\"1\",\"pricePP\":\"120\"}]', '2023-12-15 09:55:48', 'Sunway', 360);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userid` int(11) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `profilepicture` varchar(255) NOT NULL,
  `points` int(11) NOT NULL,
  `address` varchar(1000) NOT NULL,
  `birthday` date DEFAULT NULL,
  `contact` varchar(255) DEFAULT NULL,
  `rank` varchar(255) NOT NULL,
  `referralCode` varchar(255) NOT NULL,
  `referrer` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userid`, `firstName`, `lastName`, `email`, `password`, `token`, `profilepicture`, `points`, `address`, `birthday`, `contact`, `rank`, `referralCode`, `referrer`) VALUES
(1, 'JohnH', 'Smith', 'test@mail.com', '25d55ad283aa400af464c76d713c07ad', 'bc3d476321e535fda81d8a6b455ff069', 'IMG-65796cbe61d388.70345178.jpg', 4700, 'Sunway Uni', '2000-04-23', '+12389742', 'Admin', '6e5f0522b631cf73225fbef138cb1628', ''),
(2, 'Tan', 'Boon Seng', 'test2@mail.com', '098f6bcd4621d373cade4e832627b4f6', 'fab7832e5d5d42490d8dcf69fc75e00f', 'profileicon.png', 2000, 'Taylors Uni', '1994-11-01', '+1234567890', 'User', '431ad6137498c7fb72e054ecefdaf2c7', ''),
(5, 'Rajveer', 'Singh', 'rajveersingh@mail.com', '098f6bcd4621d373cade4e832627b4f6', '5cacf836b4c8d78420af170c328d504b', 'IMG-6576dfb0e6baa3.84701687.jpg', 0, '55 Jalan Puncak Budi\r\nTaman Budi Indah\r\n75450 Melaka', '1994-03-04', '+6048320485', 'Admin', '0518bd0361ef97f32bd0b3ee852c31c0', ''),
(6, 'Ali', 'Kumar', 'alikumar@mail.com', '098f6bcd4621d373cade4e832627b4f6', '5bb05a89747223bfc25e0894ab0ee5b1', 'IMG-6576df85136994.42014268.jpg', 0, '3 Jalan Damai\r\nTaman Damai\r\n83000 Batu Pahat\r\nJohor', '1992-03-13', '+604832494', 'User', '7100d132ba5c16499a81297f6e43ba97', ''),
(7, 'Casey', 'Loung', 'caseyloung@mail.com', '098f6bcd4621d373cade4e832627b4f6', '15c042d4df0dfea11546430210674bca', 'IMG-6576df55945507.18502520.jpg', 0, '14 Lorong Bakti\r\nTaman Cemerlang\r\n80000 Johor Bahru\r\nJohor', '1999-03-11', '+604830248234', 'User', '3286494e3d14526d6c7d8d22b69e187c', ''),
(8, 'Gabriel', 'Kwan', 'gabrielkwan@mail.com', '098f6bcd4621d373cade4e832627b4f6', '98ec36222325f73ac08c3f81406468dc', 'IMG-6576df1ca11439.01654724.jpg', 0, '30 Jalan Jernang Indah\r\nTaman Jernang\r\n40100 Shah Alam\r\nSelangor', '1999-03-14', '+602873946123', 'User', '7c4dd982f3d87ac35d74b7a83d9bb7c9', ''),
(9, 'Neshan', 'Shuresh', 'neshansuresh@mail.com', '098f6bcd4621d373cade4e832627b4f6', '651eed9344b97f641f10ba70e6b78299', 'IMG-6576ded9476545.29018596.jpg', 0, '7 Persiaran Delima\r\nBandar Baru Ampang\r\n68000 Ampang\r\nSelangor', '1997-01-15', '+6047863745', 'User', '584c03af27426dfe5837b64ed04291a4', ''),
(10, 'Daniel', 'Kim', 'danielkim@mail.com', '098f6bcd4621d373cade4e832627b4f6', 'bf5f2a0b9fdb846605cecc633f13acaa', 'IMG-6576deabd20f87.68804481.jpg', 0, '18 Jalan Sejahtera\r\nTaman Harmoni\r\n70000 Seremban\r\nNegeri Sembilan', '2002-08-09', '+60347920123', 'Admin', '444e114d904a2bf479aa694e3cee934e', ''),
(11, 'Sarah', 'Lee', 'sarahlee@mail.com', '098f6bcd4621d373cade4e832627b4f6', 'b56927c45b1ef26825f7593df1d52e51', 'IMG-6576de66b64eb9.98180096.jpg', 0, '45 Lorong Bunga Raya\r\nTaman Sentosa\r\n56100 Kuala Lumpur', '1996-05-20', '+6087523478', 'User', 'db9fda08e403d3881226c4fff7c097a0', ''),
(12, 'Kristin', 'Wu', 'kristinwu@mail.com', '098f6bcd4621d373cade4e832627b4f6', '87bcedeca2d73aa7ab35c929288ef93d', 'IMG-6576de38c857d1.14599194.jpg', 0, '22 Jalan Seri Makmur\r\nTaman Permai\r\n43000 Kajang\r\nSelangor', '1997-06-20', '+6057234902', 'User', 'df0c36d8d2aae7e59962ce3b70bcad48', ''),
(13, 'Emily', 'Johnson', 'emily.johnson@mail.com', '25d55ad283aa400af464c76d713c07ad', 'f6e46e385dd19c8bf0590263c9cdd39d', 'profileicon.png', 655, '', NULL, NULL, 'User', '0102edb6fa7f17567c3468e0336c3fb9', ''),
(14, 'Alexander', 'Rodriguez', 'alexander.rodriguez@mail.com', '25d55ad283aa400af464c76d713c07ad', '678720953b9113f1d61de5b6e92216a6', 'profileicon.png', 10000, '', NULL, NULL, 'User', 'f2f63fbd60d41a36d538344199c68d47', '431ad6137498c7fb72e054ecefdaf2c7');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `campaign`
--
ALTER TABLE `campaign`
  ADD PRIMARY KEY (`campaignid`),
  ADD KEY `campaign_organizer` (`organizer`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cartid`),
  ADD KEY `cart_user` (`userid`),
  ADD KEY `cart_product` (`productid`);

--
-- Indexes for table `donation`
--
ALTER TABLE `donation`
  ADD PRIMARY KEY (`donationid`),
  ADD KEY `donation campaign` (`campaignid`),
  ADD KEY `donation donor` (`donorid`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`productid`);

--
-- Indexes for table `purchase`
--
ALTER TABLE `purchase`
  ADD PRIMARY KEY (`purchaseid`),
  ADD KEY `uid_purchase` (`userid`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `campaign`
--
ALTER TABLE `campaign`
  MODIFY `campaignid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cartid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `donation`
--
ALTER TABLE `donation`
  MODIFY `donationid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=258;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `productid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `purchase`
--
ALTER TABLE `purchase`
  MODIFY `purchaseid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `campaign`
--
ALTER TABLE `campaign`
  ADD CONSTRAINT `campaign_organizer` FOREIGN KEY (`organizer`) REFERENCES `user` (`userid`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_product` FOREIGN KEY (`productid`) REFERENCES `product` (`productid`),
  ADD CONSTRAINT `cart_user` FOREIGN KEY (`userid`) REFERENCES `user` (`userid`);

--
-- Constraints for table `donation`
--
ALTER TABLE `donation`
  ADD CONSTRAINT `donation campaign` FOREIGN KEY (`campaignid`) REFERENCES `campaign` (`campaignid`);

--
-- Constraints for table `purchase`
--
ALTER TABLE `purchase`
  ADD CONSTRAINT `uid_purchase` FOREIGN KEY (`userid`) REFERENCES `user` (`userid`) ON DELETE SET NULL ON UPDATE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
