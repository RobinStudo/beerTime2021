SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


INSERT INTO `category` (`id`, `name`, `icon`) VALUES
(1, 'Festival', 'music'),
(2, 'Salon', 'users'),
(3, 'Dégustation', 'beer'),
(4, 'Lancement', 'rocket');

INSERT INTO `event` (`id`, `name`, `picture`, `description`, `start_at`, `end_at`, `price`, `capacity`, `category_id`, `place_id`, `owner_id`) VALUES
(1, 'Festival des brasseurs indépendants', 'https://lille.citycrunch.fr/wp-content/uploads/sites/6/2021/09/bal.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '2021-12-16 14:00:00', '2021-12-18 22:00:00', 12, 3000, 1, 1, 2),
(2, 'Dégustation d\'IPA', 'https://uploads.lebonbon.fr/source/2021/june/2020084/istock-1062727318_2_1200.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '2021-12-23 19:00:00', '2021-12-23 23:00:00', 25, 50, 3, 3, 1),
(3, 'Soirée de lancement de la Paix Dieu', 'https://lh3.googleusercontent.com/proxy/9Yk2rfB-nfiItV2Lssxlo6Af1FTqIJyi6MrdOdkVLpZcFfLyQ4CpPNPia-_nGasvwFQtoOS0mdpdM4V5kUopboUYwxrv', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '2021-11-02 13:00:00', '2021-11-02 23:00:00', NULL, 500, 4, 2, 3),
(4, 'Cours de brassage', 'https://upload.wikimedia.org/wikipedia/commons/1/19/Anchor_Brewing_Company_brewhouse.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '2021-12-01 09:00:00', '2021-12-10 20:00:00', 200, NULL, 2, NULL, 1);

INSERT INTO `event_rule` (`event_id`, `rule_id`) VALUES
(1, 1),
(1, 4),
(2, 1),
(3, 1),
(3, 2),
(3, 3);

INSERT INTO `place` (`id`, `name`, `street`, `zipcode`, `city`, `country`) VALUES
(1, 'Lille Grand Palais', '1 Bd des Cités Unies', '59777', 'Lille', 'FR'),
(2, 'L\'Atomic', '138 Rue Solférino', '59000', 'Lille', 'FR'),
(3, 'Le Bistrot du Romarin', ' 104 Av. de la République', '59110 ', 'La Madeleine', 'FR'),
(4, 'Die Goldene Bar', 'Prinzregentenstraße 1', '80538', 'München', 'DE');

INSERT INTO `rule` (`id`, `label`) VALUES
(1, 'Pass sanitaire obligatoire'),
(2, 'Port du masque obligatoire'),
(3, 'Contrôle des cartes d\'identités'),
(4, 'Verre non fourni');

INSERT INTO `user` (`id`, `username`, `email`, `password`, `roles`, `birthdate`) VALUES
(1, 'BeerLover', 'beerlover@gmail.com', '$2y$13$XxMJRvWrYV0qQ9uYyiaiQOBLDW.rSfMh1QWD3lW5pHJDIvIZCyFbS', '[]', '1992-10-14'),
(2, 'HansGruber', 'hans@nakatomi.jp', '$2y$13$XxMJRvWrYV0qQ9uYyiaiQOBLDW.rSfMh1QWD3lW5pHJDIvIZCyFbS', '[]', '1984-07-01'),
(3, 'BBPForever', 'bbpforever@gmail.com', '$2y$13$XxMJRvWrYV0qQ9uYyiaiQOBLDW.rSfMh1QWD3lW5pHJDIvIZCyFbS', '[]', '2002-12-01');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
