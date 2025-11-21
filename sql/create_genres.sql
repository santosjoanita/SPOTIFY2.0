-- Create genres table if it doesn't exist and insert sample rows
CREATE DATABASE IF NOT EXISTS melodb DEFAULT CHARACTER SET utf8mb4;
USE melodb;

CREATE TABLE IF NOT EXISTS `genres` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `genre` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert some sample genres
INSERT INTO `genres` (`genre`) VALUES
('Old School'),
('House'),
('Tecno'),
('Pop'),
('Rock')
ON DUPLICATE KEY UPDATE genre=VALUES(genre);
