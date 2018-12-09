-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 09, 2018 at 02:59 AM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `simple_blog`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(10) UNSIGNED NOT NULL,
  `post_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `content` text,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(191) DEFAULT NULL,
  `content` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `title`, `content`, `created_at`, `updated_at`) VALUES
(1, 1, 'Lorem ipsum', '							<p>Lorem ipsum dolor sit amet, in pro tempor sensibus suavitate, eu eum simul malorum. Lorem probatus vim in, ex usu mutat putant, at pri munere philosophia. Per dicta inciderint id, prima error zril ne mei. Vis no volumus splendide, sed ut nonumy labitur, vel ei nihil pertinacia. Conceptam pertinacia eu eos. Id augue tempor docendi has, ex vix deleniti voluptatibus.</p><p><br></p><p>Nec ad ponderum honestatis, nisl appellantur mel at. Ei usu zril nobis tantas. Ad probo aliquam euripidis per, vel laudem melius ut. Graeco ornatus maluisset te his, sea dicant tempor eu, probatus definitionem id qui. Vix cu novum gubergren sententiae, magna saperet vocibus no sit.</p><p><br></p><p>Assum epicuri eu sed, ad postea doming imperdiet nec. Mel clita nusquam consequuntur at. Quas ferri choro ut vis, in movet noluisse conceptam has. Sed no odio simul, ex nisl atqui mei, erant graeco definitiones eos an. Has te fuisset atomorum, nisl malis te eum, sea ut alii mandamus reprimique. Mea ea posse hendrerit, eros quando evertitur mel in.</p><p><br></p><p>No quodsi tritani partiendo duo, eum fastidii repudiandae ea, te odio idque tacimates nam. Per utinam prodesset accommodare ea, nec duis essent postulant et. Pro ei cibo tritani repudiandae, ea vix platonem constituto. Imperdiet consetetur et has, ex timeam sensibus contentiones duo.</p><p><br></p><p>Nihil graeci ea vix, verear virtute eos ea. Eos omnes ceteros eu. His ex elitr semper quaerendum. Assum choro definiebas vim no. Id pri solet honestatis. Vim ea veri etiam latine.</p>						', '2018-12-09 01:56:56', '2018-12-09 01:58:35'),
(2, 1, 'Bacon Ipsum', '							<p style=\"margin-top: 0px; margin-bottom: 24px; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; border: 0px; padding: 0px; vertical-align: baseline; color: rgb(51, 51, 51); font-family: Georgia, \"Bitstream Charter\", serif; font-size: 16px;\"><img src=\"https://upload.wikimedia.org/wikipedia/commons/thumb/3/31/Made20bacon.png/220px-Made20bacon.png\"><br></p><p style=\"margin-top: 0px; margin-bottom: 24px; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; border: 0px; padding: 0px; vertical-align: baseline; color: rgb(51, 51, 51); font-family: Georgia, \"Bitstream Charter\", serif; font-size: 16px;\">Bacon ipsum dolor amet filet mignon jerky pig, spare ribs ribeye turkey porchetta. Drumstick short loin shank flank alcatra leberkas doner prosciutto ground round spare ribs sausage capicola cupim hamburger pork chop. Leberkas cupim sausage pastrami pork corned beef fatback bacon pork chop boudin andouille salami. Ham hock shank flank alcatra. Leberkas rump salami, strip steak turducken fatback brisket meatball pork belly kielbasa landjaeger beef. Prosciutto pork swine alcatra, short ribs bresaola tongue tri-tip burgdoggen spare ribs biltong t-bone pork chop.</p><p style=\"margin-top: 0px; margin-bottom: 24px; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; border: 0px; padding: 0px; vertical-align: baseline; color: rgb(51, 51, 51); font-family: Georgia, \"Bitstream Charter\", serif; font-size: 16px;\">Beef hamburger tail alcatra pancetta doner shankle ground round strip steak porchetta spare ribs tri-tip flank drumstick. Short ribs ham picanha beef tenderloin chuck rump ground round. Flank ground round frankfurter tail tenderloin, short loin doner meatball. Turkey beef burgdoggen sirloin buffalo short loin chicken brisket beef ribs cupim ham doner capicola ball tip.</p>						', '2018-12-09 01:58:08', '2018-12-09 01:58:43');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `password` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 'Jack Sparrow', 'jacksparrow@gmail.com', 'd9c3a941c9c404e06f699d90d0e8d98c', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
