-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         5.7.19 - MySQL Community Server (GPL)
-- SO del servidor:              Win64
-- HeidiSQL Versión:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Volcando estructura de base de datos para db_ci
USE `taxisxalapa_1`;


SET FOREIGN_KEY_CHECKS = 0;
-- Truncar las tablas necesarias
-- TRUNCATE cat_municipios;



-- Volcando estructura para tabla db_ci.cat_municipios
CREATE TABLE IF NOT EXISTS `cat_municipios` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cve_ent` bigint(20) unsigned NOT NULL,
  `cve_mun` bigint(20) unsigned NOT NULL,
  `cve_bus` bigint(20) unsigned NOT NULL,
  `nombre` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mun_director` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_distrito` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cat_municipios_cve_ent_foreign` (`cve_ent`),
  CONSTRAINT `cat_municipios_cve_ent_foreign` FOREIGN KEY (`cve_ent`) REFERENCES `cat_estados` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5028 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla db_ci.cat_municipios: ~2,499 rows (aproximadamente)
/*!40000 ALTER TABLE `cat_municipios` DISABLE KEYS */;
INSERT INTO `cat_municipios` (`id`, `cve_ent`, `cve_mun`, `cve_bus`, `nombre`, `mun_director`, `id_distrito`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(4618, 30, 1, 1, 'Acajete', 'Acajete', 11, NULL, NULL, NULL),
	(4619, 30, 2, 2, 'Acatlán', 'Acatlán', 11, NULL, NULL, NULL),
	(4620, 30, 3, 3, 'Acayucan', 'Acayucan', 20, NULL, NULL, NULL),
	(4621, 30, 4, 4, 'Actopan', 'Actopan', 11, NULL, NULL, NULL),
	(4622, 30, 5, 5, 'Acula', 'Acula', 18, NULL, NULL, NULL),
	(4623, 30, 6, 6, 'Acultzingo', 'Acultzingo', 15, NULL, NULL, NULL),
	(4624, 30, 7, 7, 'Camarón de Tejeda', 'Camarón de Tejeda', 14, NULL, NULL, NULL),
	(4625, 30, 8, 8, 'Alpatláhuac', 'Alpatláhuac', 13, NULL, NULL, NULL),
	(4626, 30, 9, 9, 'Alto Lucero de Gutiérrez Barrios', 'Alto Lucero de Gutiérrez Barrios', 11, NULL, NULL, NULL),
	(4627, 30, 10, 10, 'Altotonga', 'Altotonga', 10, NULL, NULL, NULL),
	(4628, 30, 11, 11, 'Alvarado', 'Alvarado', 17, NULL, NULL, NULL),
	(4629, 30, 12, 12, 'Amatitlán', 'Amatitlán', 18, NULL, NULL, NULL),
	(4630, 30, 13, 13, 'Naranjos Amatlán', 'Naranjos Amatlán', 2, NULL, NULL, NULL),
	(4631, 30, 14, 14, 'Amatlán de los Reyes', 'Amatlán de los Reyes', 14, NULL, NULL, NULL),
	(4632, 30, 15, 15, 'Angel R. Cabada', 'Angel R. Cabada', 19, NULL, NULL, NULL),
	(4633, 30, 16, 16, 'La Antigua', 'La Antigua', 17, NULL, NULL, NULL),
	(4634, 30, 17, 17, 'Apazapan', 'Apazapan', 12, NULL, NULL, NULL),
	(4635, 30, 18, 18, 'Aquila', 'Aquila', 15, NULL, NULL, NULL),
	(4636, 30, 19, 19, 'Astacinga', 'Astacinga', 16, NULL, NULL, NULL),
	(4637, 30, 20, 20, 'Atlahuilco', 'Atlahuilco', 16, NULL, NULL, NULL),
	(4638, 30, 21, 21, 'Atoyac', 'Atoyac', 14, NULL, NULL, NULL),
	(4639, 30, 22, 22, 'Atzacan', 'Atzacan', 15, NULL, NULL, NULL),
	(4640, 30, 23, 23, 'Atzalan', 'Atzalan', 10, NULL, NULL, NULL),
	(4641, 30, 24, 24, 'Tlaltetela', 'Tlaltetela', 13, NULL, NULL, NULL),
	(4642, 30, 25, 25, 'Ayahualulco', 'Ayahualulco', 12, NULL, NULL, NULL),
	(4643, 30, 26, 26, 'Banderilla', 'Banderilla', 11, NULL, NULL, NULL),
	(4644, 30, 27, 27, 'Benito Juárez', 'Benito Juárez', 5, NULL, NULL, NULL),
	(4645, 30, 28, 28, 'Boca del Río', 'Boca del Río', 17, NULL, NULL, NULL),
	(4646, 30, 29, 29, 'Calcahualco', 'Calcahualco', 13, NULL, NULL, NULL),
	(4647, 30, 30, 30, 'Camerino Z. Mendoza', 'Camerino Z. Mendoza', 15, NULL, NULL, NULL),
	(4648, 30, 31, 31, 'Carrillo Puerto', 'Carrillo Puerto', 14, NULL, NULL, NULL),
	(4649, 30, 32, 32, 'Catemaco', 'Catemaco', 19, NULL, NULL, NULL),
	(4650, 30, 33, 33, 'Cazones de Herrera', 'Cazones de Herrera', 7, NULL, NULL, NULL),
	(4651, 30, 34, 34, 'Cerro Azul', 'Cerro Azul', 6, NULL, NULL, NULL),
	(4652, 30, 35, 35, 'Citlaltépetl', 'Citlaltépetl', 2, NULL, NULL, NULL),
	(4653, 30, 36, 36, 'Coacoatzintla', 'Coacoatzintla', 11, NULL, NULL, NULL),
	(4654, 30, 37, 37, 'Coahuitlán', 'Coahuitlán', 8, NULL, NULL, NULL),
	(4655, 30, 38, 38, 'Coatepec', 'Coatepec', 12, NULL, NULL, NULL),
	(4656, 30, 39, 39, 'Coatzacoalcos', 'Coatzacoalcos', 21, NULL, NULL, NULL),
	(4657, 30, 40, 40, 'Coatzintla', 'Coatzintla', 7, NULL, NULL, NULL),
	(4658, 30, 41, 41, 'Coetzala', 'Coetzala', 14, NULL, NULL, NULL),
	(4659, 30, 42, 42, 'Colipa', 'Colipa', 9, NULL, NULL, NULL),
	(4660, 30, 43, 43, 'Comapa', 'Comapa', 13, NULL, NULL, NULL),
	(4661, 30, 44, 44, 'Córdoba', 'Córdoba', 14, NULL, NULL, NULL),
	(4662, 30, 45, 45, 'Cosamaloapan de Carpio', 'Cosamaloapan de Carpio', 18, NULL, NULL, NULL),
	(4663, 30, 46, 46, 'Cosautlán de Carvajal', 'Cosautlán de Carvajal', 12, NULL, NULL, NULL),
	(4664, 30, 47, 47, 'Coscomatepec', 'Coscomatepec', 13, NULL, NULL, NULL),
	(4665, 30, 48, 48, 'Cosoleacaque', 'Cosoleacaque', 21, NULL, NULL, NULL),
	(4666, 30, 49, 49, 'Cotaxtla', 'Cotaxtla', 17, NULL, NULL, NULL),
	(4667, 30, 50, 50, 'Coxquihui', 'Coxquihui', 8, NULL, NULL, NULL),
	(4668, 30, 51, 51, 'Coyutla', 'Coyutla', 8, NULL, NULL, NULL),
	(4669, 30, 52, 52, 'Cuichapa', 'Cuichapa', 14, NULL, NULL, NULL),
	(4670, 30, 53, 53, 'Cuitláhuac', 'Cuitláhuac', 14, NULL, NULL, NULL),
	(4671, 30, 54, 54, 'Chacaltianguis', 'Chacaltianguis', 18, NULL, NULL, NULL),
	(4672, 30, 55, 55, 'Chalma', 'Chalma', 3, NULL, NULL, NULL),
	(4673, 30, 56, 56, 'Chiconamel', 'Chiconamel', 3, NULL, NULL, NULL),
	(4674, 30, 57, 57, 'Chiconquiaco', 'Chiconquiaco', 11, NULL, NULL, NULL),
	(4675, 30, 58, 58, 'Chicontepec', 'Chicontepec', 5, NULL, NULL, NULL),
	(4676, 30, 59, 59, 'Chinameca', 'Chinameca', 21, NULL, NULL, NULL),
	(4677, 30, 60, 60, 'Chinampa de Gorostiza', 'Chinampa de Gorostiza', 2, NULL, NULL, NULL),
	(4678, 30, 61, 61, 'Las Choapas', 'Las Choapas', 21, NULL, NULL, NULL),
	(4679, 30, 62, 62, 'Chocamán', 'Chocamán', 14, NULL, NULL, NULL),
	(4680, 30, 63, 63, 'Chontla', 'Chontla', 3, NULL, NULL, NULL),
	(4681, 30, 64, 64, 'Chumatlán', 'Chumatlán', 8, NULL, NULL, NULL),
	(4682, 30, 65, 65, 'Emiliano Zapata', 'Emiliano Zapata', 11, NULL, NULL, NULL),
	(4683, 30, 66, 66, 'Espinal', 'Espinal', 8, NULL, NULL, NULL),
	(4684, 30, 67, 67, 'Filomeno Mata', 'Filomeno Mata', 8, NULL, NULL, NULL),
	(4685, 30, 68, 68, 'Fortín', 'Fortín', 14, NULL, NULL, NULL),
	(4686, 30, 69, 69, 'Gutiérrez Zamora', 'Gutiérrez Zamora', 8, NULL, NULL, NULL),
	(4687, 30, 70, 70, 'Hidalgotitlán', 'Hidalgotitlán', 21, NULL, NULL, NULL),
	(4688, 30, 71, 71, 'Huatusco', 'Huatusco', 13, NULL, NULL, NULL),
	(4689, 30, 72, 72, 'Huayacocotla', 'Huayacocotla', 4, NULL, NULL, NULL),
	(4690, 30, 73, 73, 'Hueyapan de Ocampo', 'Hueyapan de Ocampo', 19, NULL, NULL, NULL),
	(4691, 30, 74, 74, 'Huiloapan de Cuauhtémoc', 'Huiloapan de Cuauhtémoc', 15, NULL, NULL, NULL),
	(4692, 30, 75, 75, 'Ignacio de la Llave', 'Ignacio de la Llave', 17, NULL, NULL, NULL),
	(4693, 30, 76, 76, 'Ilamatlán', 'Ilamatlán', 4, NULL, NULL, NULL),
	(4694, 30, 77, 77, 'Isla', 'Isla', 19, NULL, NULL, NULL),
	(4695, 30, 78, 78, 'Ixcatepec', 'Ixcatepec', 3, NULL, NULL, NULL),
	(4696, 30, 79, 79, 'Ixhuacán de los Reyes', 'Ixhuacán de los Reyes', 12, NULL, NULL, NULL),
	(4697, 30, 80, 80, 'Ixhuatlán del Café', 'Ixhuatlán del Café', 13, NULL, NULL, NULL),
	(4698, 30, 81, 81, 'Ixhuatlancillo', 'Ixhuatlancillo', 15, NULL, NULL, NULL),
	(4699, 30, 82, 82, 'Ixhuatlán del Sureste', 'Ixhuatlán del Sureste', 21, NULL, NULL, NULL),
	(4700, 30, 83, 83, 'Ixhuatlán de Madero', 'Ixhuatlán de Madero', 5, NULL, NULL, NULL),
	(4701, 30, 84, 84, 'Ixmatlahuacan', 'Ixmatlahuacan', 18, NULL, NULL, NULL),
	(4702, 30, 85, 85, 'Ixtaczoquitlán', 'Ixtaczoquitlán', 15, NULL, NULL, NULL),
	(4703, 30, 86, 86, 'Jalacingo', 'Jalacingo', 10, NULL, NULL, NULL),
	(4704, 30, 87, 87, 'Xalapa', 'Xalapa', 11, NULL, NULL, NULL),
	(4705, 30, 88, 88, 'Jalcomulco', 'Jalcomulco', 12, NULL, NULL, NULL),
	(4706, 30, 89, 89, 'Jáltipan', 'Jáltipan', 20, NULL, NULL, NULL),
	(4707, 30, 90, 90, 'Jamapa', 'Jamapa', 17, NULL, NULL, NULL),
	(4708, 30, 91, 91, 'Jesús Carranza', 'Jesús Carranza', 20, NULL, NULL, NULL),
	(4709, 30, 92, 92, 'Xico', 'Xico', 12, NULL, NULL, NULL),
	(4710, 30, 93, 93, 'Jilotepec', 'Jilotepec', 11, NULL, NULL, NULL),
	(4711, 30, 94, 94, 'Juan Rodríguez Clara', 'Juan Rodríguez Clara', 19, NULL, NULL, NULL),
	(4712, 30, 95, 95, 'Juchique de Ferrer', 'Juchique de Ferrer', 9, NULL, NULL, NULL),
	(4713, 30, 96, 96, 'Landero y Coss', 'Landero y Coss', 11, NULL, NULL, NULL),
	(4714, 30, 97, 97, 'Lerdo de Tejada', 'Lerdo de Tejada', 19, NULL, NULL, NULL),
	(4715, 30, 98, 98, 'Magdalena', 'Magdalena', 16, NULL, NULL, NULL),
	(4716, 30, 99, 99, 'Maltrata', 'Maltrata', 15, NULL, NULL, NULL),
	(4717, 30, 100, 100, 'Manlio Fabio Altamirano', 'Manlio Fabio Altamirano', 17, NULL, NULL, NULL),
	(4718, 30, 101, 101, 'Mariano Escobedo', 'Mariano Escobedo', 15, NULL, NULL, NULL),
	(4719, 30, 102, 102, 'Martínez de la Torre', 'Martínez de la Torre', 9, NULL, NULL, NULL),
	(4720, 30, 103, 103, 'Mecatlán', 'Mecatlán', 8, NULL, NULL, NULL),
	(4721, 30, 104, 104, 'Mecayapan', 'Mecayapan', 20, NULL, NULL, NULL),
	(4722, 30, 105, 105, 'Medellín de Bravo', 'Medellín de Bravo', 17, NULL, NULL, NULL),
	(4723, 30, 106, 106, 'Miahuatlán', 'Miahuatlán', 11, NULL, NULL, NULL),
	(4724, 30, 107, 107, 'Las Minas', 'Las Minas', 10, NULL, NULL, NULL),
	(4725, 30, 108, 108, 'Minatitlán', 'Minatitlán', 21, NULL, NULL, NULL),
	(4726, 30, 109, 109, 'Misantla', 'Misantla', 9, NULL, NULL, NULL),
	(4727, 30, 110, 110, 'Mixtla de Altamirano', 'Mixtla de Altamirano', 16, NULL, NULL, NULL),
	(4728, 30, 111, 111, 'Moloacán', 'Moloacán', 21, NULL, NULL, NULL),
	(4729, 30, 112, 112, 'Naolinco', 'Naolinco', 11, NULL, NULL, NULL),
	(4730, 30, 113, 113, 'Naranjal', 'Naranjal', 14, NULL, NULL, NULL),
	(4731, 30, 114, 114, 'Nautla', 'Nautla', 9, NULL, NULL, NULL),
	(4732, 30, 115, 115, 'Nogales', 'Nogales', 15, NULL, NULL, NULL),
	(4733, 30, 116, 116, 'Oluta', 'Oluta', 20, NULL, NULL, NULL),
	(4734, 30, 117, 117, 'Omealca', 'Omealca', 14, NULL, NULL, NULL),
	(4735, 30, 118, 118, 'Orizaba', 'Orizaba', 15, NULL, NULL, NULL),
	(4736, 30, 119, 119, 'Otatitlán', 'Otatitlán', 18, NULL, NULL, NULL),
	(4737, 30, 120, 120, 'Oteapan', 'Oteapan', 21, NULL, NULL, NULL),
	(4738, 30, 121, 121, 'Ozuluama de Mascareñas', 'Ozuluama de Mascareñas', 2, NULL, NULL, NULL),
	(4739, 30, 122, 122, 'Pajapan', 'Pajapan', 21, NULL, NULL, NULL),
	(4740, 30, 123, 123, 'Pánuco', 'Pánuco', 1, NULL, NULL, NULL),
	(4741, 30, 124, 124, 'Papantla', 'Papantla', 8, NULL, NULL, NULL),
	(4742, 30, 125, 125, 'Paso del Macho', 'Paso del Macho', 14, NULL, NULL, NULL),
	(4743, 30, 126, 126, 'Paso de Ovejas', 'Paso de Ovejas', 17, NULL, NULL, NULL),
	(4744, 30, 127, 127, 'La Perla', 'La Perla', 15, NULL, NULL, NULL),
	(4745, 30, 128, 128, 'Perote', 'Perote', 10, NULL, NULL, NULL),
	(4746, 30, 129, 129, 'Platón Sánchez', 'Platón Sánchez', 3, NULL, NULL, NULL),
	(4747, 30, 130, 130, 'Playa Vicente', 'Playa Vicente', 18, NULL, NULL, NULL),
	(4748, 30, 131, 131, 'Poza Rica de Hidalgo', 'Poza Rica de Hidalgo', 7, NULL, NULL, NULL),
	(4749, 30, 132, 132, 'Las Vigas de Ramírez', 'Las Vigas de Ramírez', 11, NULL, NULL, NULL),
	(4750, 30, 133, 133, 'Pueblo Viejo', 'Pueblo Viejo', 1, NULL, NULL, NULL),
	(4751, 30, 134, 134, 'Puente Nacional', 'Puente Nacional', 17, NULL, NULL, NULL),
	(4752, 30, 135, 135, 'Rafael Delgado', 'Rafael Delgado', 15, NULL, NULL, NULL),
	(4753, 30, 136, 136, 'Rafael Lucio', 'Rafael Lucio', 11, NULL, NULL, NULL),
	(4754, 30, 137, 137, 'Los Reyes', 'Los Reyes', 16, NULL, NULL, NULL),
	(4755, 30, 138, 138, 'Río Blanco', 'Río Blanco', 15, NULL, NULL, NULL),
	(4756, 30, 139, 139, 'Saltabarranca', 'Saltabarranca', 19, NULL, NULL, NULL),
	(4757, 30, 140, 140, 'San Andrés Tenejapan', 'San Andrés Tenejapan', 15, NULL, NULL, NULL),
	(4758, 30, 141, 141, 'San Andrés Tuxtla', 'San Andrés Tuxtla', 19, NULL, NULL, NULL),
	(4759, 30, 142, 142, 'San Juan Evangelista', 'San Juan Evangelista', 20, NULL, NULL, NULL),
	(4760, 30, 143, 143, 'Santiago Tuxtla', 'Santiago Tuxtla', 19, NULL, NULL, NULL),
	(4761, 30, 144, 144, 'Sayula de Alemán', 'Sayula de Alemán', 20, NULL, NULL, NULL),
	(4762, 30, 145, 145, 'Soconusco', 'Soconusco', 20, NULL, NULL, NULL),
	(4763, 30, 146, 146, 'Sochiapa', 'Sochiapa', 13, NULL, NULL, NULL),
	(4764, 30, 147, 147, 'Soledad Atzompa', 'Soledad Atzompa', 15, NULL, NULL, NULL),
	(4765, 30, 148, 148, 'Soledad de Doblado', 'Soledad de Doblado', 17, NULL, NULL, NULL),
	(4766, 30, 149, 149, 'Soteapan', 'Soteapan', 20, NULL, NULL, NULL),
	(4767, 30, 150, 150, 'Tamalín', 'Tamalín', 2, NULL, NULL, NULL),
	(4768, 30, 151, 151, 'Tamiahua', 'Tamiahua', 6, NULL, NULL, NULL),
	(4769, 30, 152, 152, 'Tampico Alto', 'Tampico Alto', 1, NULL, NULL, NULL),
	(4770, 30, 153, 153, 'Tancoco', 'Tancoco', 2, NULL, NULL, NULL),
	(4771, 30, 154, 154, 'Tantima', 'Tantima', 2, NULL, NULL, NULL),
	(4772, 30, 155, 155, 'Tantoyuca', 'Tantoyuca', 3, NULL, NULL, NULL),
	(4773, 30, 156, 156, 'Tatatila', 'Tatatila', 11, NULL, NULL, NULL),
	(4774, 30, 157, 157, 'Castillo de Teayo', 'Castillo de Teayo', 7, NULL, NULL, NULL),
	(4775, 30, 158, 158, 'Tecolutla', 'Tecolutla', 8, NULL, NULL, NULL),
	(4776, 30, 159, 159, 'Tehuipango', 'Tehuipango', 16, NULL, NULL, NULL),
	(4777, 30, 160, 160, 'Álamo Temapache', 'Álamo Temapache', 6, NULL, NULL, NULL),
	(4778, 30, 161, 161, 'Tempoal', 'Tempoal', 3, NULL, NULL, NULL),
	(4779, 30, 162, 162, 'Tenampa', 'Tenampa', 13, NULL, NULL, NULL),
	(4780, 30, 163, 163, 'Tenochtitlán', 'Tenochtitlán', 9, NULL, NULL, NULL),
	(4781, 30, 164, 164, 'Teocelo', 'Teocelo', 12, NULL, NULL, NULL),
	(4782, 30, 165, 165, 'Tepatlaxco', 'Tepatlaxco', 13, NULL, NULL, NULL),
	(4783, 30, 166, 166, 'Tepetlán', 'Tepetlán', 11, NULL, NULL, NULL),
	(4784, 30, 167, 167, 'Tepetzintla', 'Tepetzintla', 6, NULL, NULL, NULL),
	(4785, 30, 168, 168, 'Tequila', 'Tequila', 16, NULL, NULL, NULL),
	(4786, 30, 169, 169, 'José Azueta', 'José Azueta', 18, NULL, NULL, NULL),
	(4787, 30, 170, 170, 'Texcatepec', 'Texcatepec', 4, NULL, NULL, NULL),
	(4788, 30, 171, 171, 'Texhuacán', 'Texhuacán', 16, NULL, NULL, NULL),
	(4789, 30, 172, 172, 'Texistepec', 'Texistepec', 20, NULL, NULL, NULL),
	(4790, 30, 173, 173, 'Tezonapa', 'Tezonapa', 14, NULL, NULL, NULL),
	(4791, 30, 174, 174, 'Tierra Blanca', 'Tierra Blanca', 18, NULL, NULL, NULL),
	(4792, 30, 175, 175, 'Tihuatlán', 'Tihuatlán', 7, NULL, NULL, NULL),
	(4793, 30, 176, 176, 'Tlacojalpan', 'Tlacojalpan', 18, NULL, NULL, NULL),
	(4794, 30, 177, 177, 'Tlacolulan', 'Tlacolulan', 11, NULL, NULL, NULL),
	(4795, 30, 178, 178, 'Tlacotalpan', 'Tlacotalpan', 18, NULL, NULL, NULL),
	(4796, 30, 179, 179, 'Tlacotepec de Mejía', 'Tlacotepec de Mejía', 13, NULL, NULL, NULL),
	(4797, 30, 180, 180, 'Tlachichilco', 'Tlachichilco', 5, NULL, NULL, NULL),
	(4798, 30, 181, 181, 'Tlalixcoyan', 'Tlalixcoyan', 17, NULL, NULL, NULL),
	(4799, 30, 182, 182, 'Tlalnelhuayocan', 'Tlalnelhuayocan', 11, NULL, NULL, NULL),
	(4800, 30, 183, 183, 'Tlapacoyan', 'Tlapacoyan', 10, NULL, NULL, NULL),
	(4801, 30, 184, 184, 'Tlaquilpa', 'Tlaquilpa', 16, NULL, NULL, NULL),
	(4802, 30, 185, 185, 'Tlilapan', 'Tlilapan', 15, NULL, NULL, NULL),
	(4803, 30, 186, 186, 'Tomatlán', 'Tomatlán', 14, NULL, NULL, NULL),
	(4804, 30, 187, 187, 'Tonayán', 'Tonayán', 11, NULL, NULL, NULL),
	(4805, 30, 188, 188, 'Totutla', 'Totutla', 13, NULL, NULL, NULL),
	(4806, 30, 189, 189, 'Tuxpan', 'Tuxpan', 6, NULL, NULL, NULL),
	(4807, 30, 190, 190, 'Tuxtilla', 'Tuxtilla', 18, NULL, NULL, NULL),
	(4808, 30, 191, 191, 'Ursulo Galván', 'Ursulo Galván', 17, NULL, NULL, NULL),
	(4809, 30, 192, 192, 'Vega de Alatorre', 'Vega de Alatorre', 9, NULL, NULL, NULL),
	(4810, 30, 193, 193, 'Veracruz', 'Veracruz', 17, NULL, NULL, NULL),
	(4811, 30, 194, 194, 'Villa Aldama', 'Villa Aldama', 10, NULL, NULL, NULL),
	(4812, 30, 195, 195, 'Xoxocotla', 'Xoxocotla', 16, NULL, NULL, NULL),
	(4813, 30, 196, 196, 'Yanga', 'Yanga', 14, NULL, NULL, NULL),
	(4814, 30, 197, 197, 'Yecuatla', 'Yecuatla', 9, NULL, NULL, NULL),
	(4815, 30, 198, 198, 'Zacualpan', 'Zacualpan', 4, NULL, NULL, NULL),
	(4816, 30, 199, 199, 'Zaragoza', 'Zaragoza', 21, NULL, NULL, NULL),
	(4817, 30, 200, 200, 'Zentla', 'Zentla', 13, NULL, NULL, NULL),
	(4818, 30, 201, 201, 'Zongolica', 'Zongolica', 16, NULL, NULL, NULL),
	(4819, 30, 202, 202, 'Zontecomatlán de López y Fuentes', 'Zontecomatlán de López y Fuentes', 5, NULL, NULL, NULL),
	(4820, 30, 203, 203, 'Zozocolco de Hidalgo', 'Zozocolco de Hidalgo', 8, NULL, NULL, NULL),
	(4821, 30, 204, 204, 'Agua Dulce', 'Agua Dulce', 21, NULL, NULL, NULL),
	(4822, 30, 205, 205, 'El Higo', 'El Higo', 1, NULL, NULL, NULL),
	(4823, 30, 206, 206, 'Nanchital de Lázaro Cárdenas del Río', 'Nanchital de Lázaro Cárdenas del Río', 21, NULL, NULL, NULL),
	(4824, 30, 207, 207, 'Tres Valles', 'Tres Valles', 18, NULL, NULL, NULL),
	(4825, 30, 208, 208, 'Carlos A. Carrillo', 'Carlos A. Carrillo', 18, NULL, NULL, NULL),
	(4826, 30, 209, 210, 'Tatahuicapan de Juárez', 'Tatahuicapan de Juárez', 21, NULL, NULL, NULL),
	(4827, 30, 210, 209, 'Uxpanapa', 'Uxpanapa', 21, NULL, NULL, NULL),
	(4828, 30, 211, 211, 'San Rafael', 'San Rafael', 9, NULL, NULL, NULL),
	(4829, 30, 212, 212, 'Santiago Sochiapan', 'Santiago Sochiapan', 18, NULL, NULL, NULL);
	
/*!40000 ALTER TABLE `cat_municipios` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
