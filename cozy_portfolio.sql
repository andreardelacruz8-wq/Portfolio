-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 25, 2026 at 01:21 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cozy_portfolio`
--

-- --------------------------------------------------------

--
-- Table structure for table `achievements`
--

CREATE TABLE `achievements` (
  `id` int(11) NOT NULL,
  `education_id` int(11) NOT NULL,
  `achievement_icon` varchar(50) DEFAULT NULL,
  `achievement_title` varchar(255) NOT NULL,
  `achievement_year` varchar(50) DEFAULT NULL,
  `achievement_description` mediumtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

-- --------------------------------------------------------

--
-- Table structure for table `certifications`
--

CREATE TABLE `certifications` (
  `id` int(11) NOT NULL,
  `title` varchar(200) DEFAULT NULL,
  `issuer` varchar(200) DEFAULT NULL,
  `rating` varchar(50) DEFAULT NULL,
  `date_released` varchar(100) DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `examinee_no` varchar(100) DEFAULT NULL,
  `pdf_path` varchar(500) DEFAULT NULL,
  `icon` varchar(50) DEFAULT '?',
  `description` text DEFAULT NULL,
  `display_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `certifications`
--

INSERT INTO `certifications` (`id`, `title`, `issuer`, `rating`, `date_released`, `expiry_date`, `examinee_no`, `pdf_path`, `icon`, `description`, `display_order`, `is_active`, `created_at`, `updated_at`) VALUES
(8, 'AI Class', 'The Association of Southeast Asian Nations (ASEAN)', 'Effective', 'March 16,2026', NULL, 'Empowering ASEAN\'s Future One AI Skill at a Time', '/assets/uploads/certifications/1774173764_26a9749b16e2bfbed94e.pdf', '📜', NULL, 0, 1, '2026-03-19 02:42:28', '2026-03-22 10:02:44'),
(9, 'CSC Certification', 'Career Service Professional Examination', '90.06%', 'May 02, 2025', NULL, 'Examinee No:311964', '/assets/uploads/certifications/1774170428_a787cddb24fa973d036b.pdf', '📜', NULL, 0, 1, '2026-03-19 02:44:56', '2026-03-22 10:50:36'),
(11, 'Cybersecurity', 'Department of Information and Communications Technology', 'Excellent', 'December 16, 2025', NULL, 'Participated in the Cybersecurity Awareness Seminar entitled \"Oplan Paskong Sigurado: Ligtas ang Iyo', '/assets/uploads/certifications/1774173449_42def4701ec226aa597c.pdf', '📜', NULL, 0, 1, '2026-03-22 08:47:10', '2026-03-22 09:59:11');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `ipaddress` varchar(32) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `email`, `message`, `ipaddress`, `created_at`) VALUES
(1, 'Andrea dela Cruz', 'andreardelacruz8@gmail.com', 'Hello, just testing.', '::1', '2026-03-13 03:44:21'),
(4, 'Steve Jobs', 'stevejobs@gmail.com', 'Very nice!', '::1', '2026-03-16 16:36:32'),
(5, 'juan dela cruz', 'juandelacuz@gmail.com', 'hello', '::1', '2026-03-16 17:36:27');

-- --------------------------------------------------------

--
-- Table structure for table `coursework`
--

CREATE TABLE `coursework` (
  `id` int(11) NOT NULL,
  `education_id` int(11) NOT NULL,
  `course_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `education`
--

CREATE TABLE `education` (
  `id` int(11) NOT NULL,
  `degree` varchar(255) NOT NULL,
  `school` varchar(255) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `start_date` varchar(50) DEFAULT NULL,
  `end_date` varchar(50) DEFAULT NULL,
  `gpa` varchar(50) DEFAULT NULL,
  `description` mediumtext DEFAULT NULL,
  `display_order` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `education`
--

INSERT INTO `education` (`id`, `degree`, `school`, `location`, `start_date`, `end_date`, `gpa`, `description`, `display_order`, `created_at`) VALUES
(1, 'Elementary ', 'Kalibo Pilot Elementary School', 'Roxas Ave., Kalibo, Aklan', '2010', '2016                                              ', '85', 'Focused on advanced and competitive early development. ', 1, '2026-03-16 06:23:58'),
(4, 'Junior High School', 'Numancia National School of Fisheries', 'Albasan, Numancia, Aklan', '2016', '2020                                              ', '90', 'Graduated with Honors. Developed foundational skills in mathematics, science, and information technology. Active participant in school paper.', 99, '2026-03-17 00:16:54'),
(5, 'Senior High School', 'Garcia College of Technology', 'Estancia, Kalibo, Aklan', '2020', '2022                                              ', '90', 'Graduated under the STEM (Science, Technology, Engineering, and Mathematics) strand. Built strong analytical and technical skills in preparation for college. Completed specialized subjects in programming, calculus, and research.', 99, '2026-03-17 00:34:39'),
(6, 'Bachelor of Science in Computer Science', 'Garcia College of Technology', 'Estancia, Kalibo, Aklan', '2022', 'Present                                           ', '1.90', 'Currently pursuing a degree in Computer Science. Coursework includes: Data Structures, Algorithms, Database Management, Web Development, Object-Oriented Programming, and Software Engineering. Developed proficiency in Python, Java, JavaScript, and SQL. Completed academic projects involving full-stack web applications, database design, and system analysis. Expected graduation: 2026.', 99, '2026-03-19 03:33:39');

-- --------------------------------------------------------

--
-- Table structure for table `hobbies`
--

CREATE TABLE `hobbies` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `icon` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `favorite` text DEFAULT NULL,
  `display_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hobbies`
--

INSERT INTO `hobbies` (`id`, `title`, `icon`, `description`, `favorite`, `display_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Yarnholic', '🧶', 'Yarn enthusiast', 'Favourites: Crochet and Knitting', 1, 1, '2026-03-15 11:42:13', '2026-03-18 19:07:16'),
(2, 'Bibliophile', '📚', 'Fanfics & sci-fi enthusiast', 'Favourites: Passerine, Flowers from 1970', 2, 1, '2026-03-15 11:42:13', '2026-03-18 19:08:17'),
(3, 'Gamer', '🎮', 'Minecraft, Sims4, Roblox', 'Currently Playing: Webbed2', 3, 1, '2026-03-15 11:42:13', '2026-03-18 19:51:16'),
(11, 'Plantita', '🌿', 'Tomato Lover · Flower enthusiant', 'They keep me grounded 🌱', 99, 1, '2026-03-18 02:13:07', '2026-03-18 19:52:36'),
(12, 'INFJ', '🧠', 'Advocate · Creative · Idealistic', '\"The weird sister\" of the office', 99, 1, '2026-03-18 19:53:11', '2026-03-18 19:53:11');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `tags` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `challenge` text DEFAULT NULL,
  `code_link` varchar(500) DEFAULT NULL,
  `demo_link` varchar(500) DEFAULT NULL,
  `color` varchar(20) DEFAULT '#cbc3e3',
  `display_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `title`, `tags`, `description`, `challenge`, `code_link`, `demo_link`, `color`, `display_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'KUMPAS', 'Python · OpenCV · YOLO · HTML/CSS/JS', 'Sign language translator using computer vision. Real-time hand gesture recognition with YOLO-powered detection. helps bridge communication gaps.', 'Real-time inference latency on edge devices — optimised YOLO model with TensorRT for 40ms detection.', NULL, NULL, NULL, 1, 1, '2026-03-15 11:51:44', '2026-03-16 17:13:22'),
(2, 'EYA\'S CROCHET', 'HTML · CSS · JavaScript · React', 'Personal crochet portfolio showcasing handmade projects with cozy, pastel aesthetics. each stitch tells a story.', ' Dynamic image loading with lazy rendering — implemented intersection observer for smooth scroll performance.', NULL, NULL, NULL, 2, 1, '2026-03-15 11:51:44', '2026-03-18 19:37:52'),
(7, '5S SCORESHEET', 'HTML · CSS · JavaScript · Excel-like Calculations', 'Interactive 5S workplace audit form with automatic scoring, photo upload integration, and dynamic table generation for lean manufacturing compliance.', 'Complex nested calculations across multiple tables — built a custom JavaScript engine for real-time auto-scoring and validation.', NULL, NULL, NULL, 99, 1, '2026-03-15 23:45:31', '2026-03-18 19:38:39');

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

CREATE TABLE `skills` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `display_order` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `skills`
--

INSERT INTO `skills` (`id`, `category_id`, `name`, `display_order`) VALUES
(1, 1, 'Python', 1),
(2, 1, 'Java', 2),
(3, 1, 'JavaScript', 3),
(4, 1, 'C++', 4),
(6, 2, 'React', 1),
(7, 2, 'CodeIgniter', 2),
(8, 2, 'OpenCV', 3),
(9, 3, 'MySQL', 1),
(10, 3, 'Apache Cassandra', 2),
(11, 3, 'VSCode', 3),
(33, 1, 'SQL', 99);

-- --------------------------------------------------------

--
-- Table structure for table `skill_categories`
--

CREATE TABLE `skill_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `display_order` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `skill_categories`
--

INSERT INTO `skill_categories` (`id`, `name`, `display_order`) VALUES
(1, 'Languages', 1),
(2, 'Frameworks & Libs', 2),
(3, 'Databases & Tools', 3);

-- --------------------------------------------------------

--
-- Table structure for table `soft_skills`
--

CREATE TABLE `soft_skills` (
  `id` int(11) NOT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` mediumtext NOT NULL,
  `examples` mediumtext DEFAULT NULL,
  `display_order` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `soft_skills`
--

INSERT INTO `soft_skills` (`id`, `icon`, `title`, `description`, `examples`, `display_order`, `created_at`) VALUES
(1, '💬', 'Communication', 'Ability to convey information effectively', 'Public speaking, writing, active listening', 1, '2026-03-16 07:22:44'),
(2, '🤝', 'Teamwork', 'Working collaboratively with others', 'Group projects, team meetings, collaboration', 2, '2026-03-16 07:22:44'),
(3, '🧩', 'Problem Solving', 'Finding solutions to complex issues', 'Debugging, troubleshooting, critical thinking', 3, '2026-03-16 07:22:44'),
(4, '🔄', 'Adaptability', 'Adjusting to new situations', 'Learning new technologies, remote work, flexible schedules', 4, '2026-03-16 07:22:44'),
(5, '⏰', 'Time Management', 'Organizing and planning time effectively', 'Deadline management, prioritization, scheduling', 5, '2026-03-16 07:22:44'),
(6, '👑', 'Leadership', 'Guiding and motivating teams', 'Team leadership, mentoring, project management', 6, '2026-03-16 07:22:44'),
(7, '🎨', 'Creativity', 'Thinking outside the box', 'UI/UX design, innovative solutions, brainstorming', 7, '2026-03-16 07:22:44');

-- --------------------------------------------------------

--
-- Table structure for table `special_skills`
--

CREATE TABLE `special_skills` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `icon` varchar(50) DEFAULT '?',
  `description` mediumtext DEFAULT NULL,
  `details` mediumtext DEFAULT NULL,
  `display_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `special_skills`
--

INSERT INTO `special_skills` (`id`, `title`, `icon`, `description`, `details`, `display_order`, `is_active`, `created_at`, `updated_at`) VALUES
(10, 'Data Structures & Algorithms', '📊', 'Core foundation of efficient programming.', 'Arrays • Linked Lists • Trees • Sorting • Big O Analysis • Problem Solving', 1, 1, '2026-03-15 14:46:17', '2026-03-22 04:31:01'),
(11, 'UI/UX Design', '📱', 'Web Projects', 'User Interface • User Experience • Mockups • Prototyping ', 2, 1, '2026-03-15 14:46:17', '2026-03-22 04:27:26'),
(13, 'AI & Machine Learning', '🧠', 'Effective prompt can lead to efficiency', '📸Open CV\r\n📊 Computer Vision (object detection)\r\n👀 You Only Look Once', 99, 1, '2026-03-22 04:14:40', '2026-03-22 04:33:14'),
(14, 'Database Management', '🛢️', 'Design and manage database', 'SQL ', 99, 1, '2026-03-22 04:35:26', '2026-03-22 04:35:26'),
(15, 'Software Engineering', '👩🏻‍💻', 'Apply industry-standard methodologies to build reliable, maintainable software.', 'Agile • SDLC • Git • Testing • Design Patterns', 99, 1, '2026-03-22 04:37:08', '2026-03-22 04:37:08'),
(16, 'Web Development', '🖥️', 'Experienced in frontend interactivity, backend integration.', 'HTML5 • CSS3 • JavaScript • React ', 99, 1, '2026-03-22 04:38:55', '2026-03-22 04:38:55');

-- --------------------------------------------------------

--
-- Table structure for table `viewer_users`
--

CREATE TABLE `viewer_users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `last_login` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `viewer_users`
--

INSERT INTO `viewer_users` (`id`, `username`, `email`, `password_hash`, `full_name`, `bio`, `avatar`, `is_active`, `last_login`, `created_at`, `updated_at`) VALUES
(1, 'TestUser', 'testing@gmail.com', '$2y$10$FCNu90MWexnWCw4q0Ytbiu9/UxfEYmr1J18o3LdROYTBvQMb6QNtC', 'User Testing', NULL, NULL, 1, '2026-03-22 13:12:11', '2026-03-15 02:26:44', '2026-03-22 05:12:11'),

-- --------------------------------------------------------

--
-- Table structure for table `work_experience`
--

CREATE TABLE `work_experience` (
  `id` int(11) NOT NULL,
  `position` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `start_date` varchar(50) DEFAULT NULL,
  `end_date` varchar(50) DEFAULT NULL,
  `current_job` tinyint(1) DEFAULT 0,
  `description` mediumtext DEFAULT NULL,
  `technologies` mediumtext DEFAULT NULL,
  `display_order` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `work_experience`
--

INSERT INTO `work_experience` (`id`, `position`, `company`, `location`, `start_date`, `end_date`, `current_job`, `description`, `technologies`, `display_order`, `created_at`) VALUES
(2, 'Freelance Web Developer', 'Self-Employed', 'Work from home', '2022', '2023', 0, 'Designed and developed websites using WordPress for small businesses and personal projects. Customized themes, managed plugins, and ensured responsive layouts for optimal user experience. Collaborated with clients to understand requirements and delivered functional, visually appealing websites.', NULL, 2, '2026-03-16 07:21:01'),
(4, 'SPES', 'Special Program for Employment of Students', 'Numancia Aklan LGU', 'June 2024', 'July 2024', 0, 'Assisted in managing office supplies and inventory to ensure efficient operations. Performed encoding tasks, organized documents, and maintained accurate records for the General Services Office.', NULL, 99, '2026-03-16 00:02:53');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `achievements`
--
ALTER TABLE `achievements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `education_id` (`education_id`);

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `certifications`
--
ALTER TABLE `certifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coursework`
--
ALTER TABLE `coursework`
  ADD PRIMARY KEY (`id`),
  ADD KEY `education_id` (`education_id`);

--
-- Indexes for table `education`
--
ALTER TABLE `education`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hobbies`
--
ALTER TABLE `hobbies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `skill_categories`
--
ALTER TABLE `skill_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `soft_skills`
--
ALTER TABLE `soft_skills`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `special_skills`
--
ALTER TABLE `special_skills`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `viewer_users`
--
ALTER TABLE `viewer_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `work_experience`
--
ALTER TABLE `work_experience`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `achievements`
--
ALTER TABLE `achievements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `certifications`
--
ALTER TABLE `certifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `coursework`
--
ALTER TABLE `coursework`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `education`
--
ALTER TABLE `education`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `hobbies`
--
ALTER TABLE `hobbies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `skills`
--
ALTER TABLE `skills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `skill_categories`
--
ALTER TABLE `skill_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `soft_skills`
--
ALTER TABLE `soft_skills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `special_skills`
--
ALTER TABLE `special_skills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `viewer_users`
--
ALTER TABLE `viewer_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `work_experience`
--
ALTER TABLE `work_experience`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `achievements`
--
ALTER TABLE `achievements`
  ADD CONSTRAINT `achievements_ibfk_1` FOREIGN KEY (`education_id`) REFERENCES `education` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `coursework`
--
ALTER TABLE `coursework`
  ADD CONSTRAINT `coursework_ibfk_1` FOREIGN KEY (`education_id`) REFERENCES `education` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `skills`
--
ALTER TABLE `skills`
  ADD CONSTRAINT `skills_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `skill_categories` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
