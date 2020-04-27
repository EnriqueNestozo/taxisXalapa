USE `taxisxalapa_1`;


SET FOREIGN_KEY_CHECKS = 0;
-- Truncar las tablas necesarias



-- Volcando estructura para tabla db_ci.cat_municipios
CREATE TABLE IF NOT EXISTS `cat_estados` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abreviatura` varchar(6) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5028 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



INSERT INTO `cat_estados` (`id`, `nombre`, `abreviatura`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'Aguascalientes', 'Ags.', NULL, NULL, NULL),
	(2, 'Baja California', 'BC', NULL, NULL, NULL),
	(3, 'Baja California Sur', 'BCS', NULL, NULL, NULL),
	(4, 'Campeche', 'Camp.', NULL, NULL, NULL),
	(5, 'Coahuila de Zaragoza', 'Coah.', NULL, NULL, NULL),
	(6, 'Colima', 'Col.', NULL, NULL, NULL),
	(7, 'Chiapas', 'Chis.', NULL, NULL, NULL),
	(8, 'Chihuahua', 'Chih.', NULL, NULL, NULL),
	(9, 'Ciudad de México', 'CDMX', NULL, NULL, NULL),
	(10, 'Durango', 'Dgo.', NULL, NULL, NULL),
	(11, 'Guanajuato', 'Gto.', NULL, NULL, NULL),
	(12, 'Guerrero', 'Gro.', NULL, NULL, NULL),
	(13, 'Hidalgo', 'Hgo.', NULL, NULL, NULL),
	(14, 'Jalisco', 'Jal.', NULL, NULL, NULL),
	(15, 'México', 'Mex.', NULL, NULL, NULL),
	(16, 'Michoacán de Ocampo', 'Mich.', NULL, NULL, NULL),
	(17, 'Morelos', 'Mor.', NULL, NULL, NULL),
	(18, 'Nayarit', 'Nay.', NULL, NULL, NULL),
	(19, 'Nuevo León', 'NL', NULL, NULL, NULL),
	(20, 'Oaxaca', 'Oax.', NULL, NULL, NULL),
	(21, 'Puebla', 'Pue.', NULL, NULL, NULL),
	(22, 'Querétaro', 'Qro.', NULL, NULL, NULL),
	(23, 'Quintana Roo', 'Q. Roo', NULL, NULL, NULL),
	(24, 'San Luis Potosí', 'SLP', NULL, NULL, NULL),
	(25, 'Sinaloa', 'Sin.', NULL, NULL, NULL),
	(26, 'Sonora', 'Son.', NULL, NULL, NULL),
	(27, 'Tabasco', 'Tab.', NULL, NULL, NULL),
	(28, 'Tamaulipas', 'Tamps.', NULL, NULL, NULL),
	(29, 'Tlaxcala', 'Tlax.', NULL, NULL, NULL),
	(30, 'Veracruz de Ignacio de la Llave', 'Ver.', NULL, NULL, NULL),
	(31, 'Yucatán', 'Yuc.', NULL, NULL, NULL),
	(32, 'Zacatecas', 'Zac.', NULL, NULL, NULL);
/*!40000 ALTER TABLE `cat_estados` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
