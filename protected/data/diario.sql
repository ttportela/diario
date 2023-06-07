CREATE TABLE `aluno` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Nome` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `RA` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `email` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `instituicao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Nome` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `professor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `SIAPE` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `Nome` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `Email` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
