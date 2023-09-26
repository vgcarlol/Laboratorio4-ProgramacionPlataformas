CREATE TABLE `user` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NOT NULL,
  `password` CHAR(32) NOT NULL,
  `token` TEXT NULL,
  `token_expiracy` DATE NULL,
  `nombre` VARCHAR(30) NULL,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;
INSERT INTO `user`(`username`, `password`, `token`, `token_expiracy`, `nombre`) VALUES ('maalonso@uvg.edu.gt',MD5("test1234"),null,null,'MOISES ALONSO');