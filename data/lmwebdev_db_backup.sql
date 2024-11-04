-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versione server:              10.4.32-MariaDB - mariadb.org binary distribution
-- S.O. server:                  Win64
-- HeidiSQL Versione:            12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dump della struttura del database lmwebdev
DROP DATABASE IF EXISTS `lmwebdev`;
CREATE DATABASE IF NOT EXISTS `lmwebdev` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;
USE `lmwebdev`;

-- Dump della struttura di tabella lmwebdev.aboutme
DROP TABLE IF EXISTS `aboutme`;
CREATE TABLE IF NOT EXISTS `aboutme` (
  `id` int(2) unsigned NOT NULL AUTO_INCREMENT,
  `testo` longtext DEFAULT NULL,
  `urlImmagine` varchar(45) DEFAULT NULL,
  `cancellato` tinyint(1) unsigned zerofill NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dump dei dati della tabella lmwebdev.aboutme: ~0 rows (circa)
DELETE FROM `aboutme`;
INSERT INTO `aboutme` (`id`, `testo`, `urlImmagine`, `cancellato`) VALUES
	(1, 'Mi chiamo Lorenzo Marini, ho 29 anni e vivo a Ravenna. Dal 2024 ho cominciato il mio percorso nel mondo dello sviluppo di siti e applicazioni WEB, spinto dalla mia forte passione per l\'informatica e la programmazione, grazie al corso di Full Stack Web Development erogato da Accademia CODE.\r\n\r\nHo una forte propensione al problem solving, rafforzata da un pensiero critico volto al raggiungimento degli obiettivi con percorsi ottimali. Ho un ottima capacità di team-working e difficilmente non riesco a portare a compimento gli obiettivi che mi vengono assegnati.\r\n\r\nAttualmente lavoro come operaio-tecnico presso E-Distribuzione SPA, nella quale lavoro 10 anni e che mi ha formato in tutto ciò che riguarda il mondo della distribuzione di energia elettrica, come i lavori sotto tensione BT e i lavori in elevazione, nonché alla ricerca e la risoluzione di guasti nelle linee di distribuzione dell\'energia elettrica. Dal 2023 ho cominciato ad occuparmi della programmazione dei lavori elettrici e della gestione del personale operativo, mansione che ha rafforzato enormemente le mie capacità di problem solving, di ragionamento lucido nelle situazioni di pericolo e di gestione di tempi e risorse ad ampio spettro.\r\n\r\nLa mia più grande passione, oltre l\'informatica e la tecnologia, è l\'arrampicata sportiva, che pratico da 8 anni e della quale sono anche istruttore certificato. Per diversi anni ho allenato giovani arrampicatori sia agonisti che non nelle tre discipline dell\'arrampicata sportiva, partecipando come allenatore anche a gare di livello nazionale.', './img/IO.jpg', 0);

-- Dump della struttura di tabella lmwebdev.admingroup
DROP TABLE IF EXISTS `admingroup`;
CREATE TABLE IF NOT EXISTS `admingroup` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `password` varchar(32) NOT NULL,
  `stricted` tinyint(1) unsigned zerofill NOT NULL,
  `cancellato` tinyint(1) unsigned zerofill NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username_UNIQUE` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dump dei dati della tabella lmwebdev.admingroup: ~0 rows (circa)
DELETE FROM `admingroup`;
INSERT INTO `admingroup` (`id`, `username`, `password`, `stricted`, `cancellato`) VALUES
	(1, 'admin', 'admin', 0, 0);

-- Dump della struttura di tabella lmwebdev.conoscenze
DROP TABLE IF EXISTS `conoscenze`;
CREATE TABLE IF NOT EXISTS `conoscenze` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL,
  `tipo` tinyint(1) unsigned NOT NULL DEFAULT 1 COMMENT '1 = linguaggio; 2 = framework; 3 = sistema; 4 = altro ',
  `urlLogo` varchar(45) NOT NULL,
  `descrizione` text DEFAULT NULL,
  `cancellato` tinyint(1) unsigned zerofill NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dump dei dati della tabella lmwebdev.conoscenze: ~9 rows (circa)
DELETE FROM `conoscenze`;
INSERT INTO `conoscenze` (`id`, `nome`, `tipo`, `urlLogo`, `descrizione`, `cancellato`) VALUES
	(1, 'HTML', 1, './img/icons/html.svg', 'Struttura e organizza i contenuti della pagina, creando sezioni, titoli e paragrafi per un layout web chiaro e navigabile', 0),
	(2, 'CSS', 1, './img/icons/css.svg', 'Stilizza le pagine con colori, font e layout, ottimizzando l’aspetto su dispositivi diversi per un’esperienza visiva moderna', 0),
	(3, 'PHP', 1, './img/icons/php.png', 'Linguaggio server-side per creare pagine dinamiche, generando contenuti personalizzati e gestendo i dati in tempo reale', 0),
	(4, 'MySQL', 1, './img/icons/mysql.svg', 'Gestione dei database relazionale per l’archiviazione e il recupero dei dati, ottimizzando la sicurezza e la scalabilità', 0),
	(5, 'Javascript', 1, './img/icons/javascript.svg', 'Rende il sito interattivo e dinamico con animazioni e gestione eventi, migliorando l’esperienza utente', 0),
	(6, 'GIT', 3, './img/icons/git.svg', 'Controllo di versione per gestire e condividere il codice, migliorando la collaborazione e il monitoraggio dei progetti', 0),
	(7, 'JSON', 4, './img/icons/json.svg', 'Formato di dati leggibile, utile per lo scambio dati tra client e server, facilitando integrazioni rapide', 0),
	(8, 'VSCode', 3, './img/icons/vscode.svg', 'Editor di codice versatile, con molte estensioni per vari linguaggi, aumentando la produttività del programmatore', 0),
	(9, 'Photoshop', 4, './img/icons/photoshop.svg', 'Software di editing grafico per ottimizzare immagini e layout, migliorando l\'estetica dei progetti', 0),
	(10, 'Figma', 4, './img/icons/figma.svg', 'Strumento di design collaborativo per prototipi interattivi e UI, facilitando il lavoro in team', 0);

-- Dump della struttura di tabella lmwebdev.contattiricevuti
DROP TABLE IF EXISTS `contattiricevuti`;
CREATE TABLE IF NOT EXISTS `contattiricevuti` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL,
  `cognome` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `telefono` varchar(45) DEFAULT NULL,
  `argomento` tinyint(1) unsigned NOT NULL COMMENT '0 = Informazioni; \n1 = Richieste; \n2 = Collaborazioni; \n3 = Assistenza; ',
  `titolo` varchar(45) NOT NULL,
  `messaggio` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dump dei dati della tabella lmwebdev.contattiricevuti: ~0 rows (circa)
DELETE FROM `contattiricevuti`;

-- Dump della struttura di tabella lmwebdev.formcontatti
DROP TABLE IF EXISTS `formcontatti`;
CREATE TABLE IF NOT EXISTS `formcontatti` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tipoInput` varchar(50) NOT NULL DEFAULT 'text' COMMENT 'text, email, select, option, textarea, checkbox;',
  `nomeInput` varchar(45) NOT NULL,
  `idInput` varchar(45) NOT NULL,
  `minLength` int(10) unsigned DEFAULT NULL,
  `maxLength` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nomeInput_UNIQUE` (`nomeInput`),
  UNIQUE KEY `idInput_UNIQUE` (`idInput`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dump dei dati della tabella lmwebdev.formcontatti: ~12 rows (circa)
DELETE FROM `formcontatti`;
INSERT INTO `formcontatti` (`id`, `tipoInput`, `nomeInput`, `idInput`, `minLength`, `maxLength`) VALUES
	(1, 'text', 'firstName', 'firstName', 2, 32),
	(2, 'text', 'lastName', 'lastName', 2, 32),
	(3, 'email', 'email', 'email', 10, 100),
	(4, 'text', 'phone', 'phone', NULL, 16),
	(5, 'select', 'argument', 'argument', NULL, NULL),
	(6, 'option', 'Website', 'website', NULL, NULL),
	(7, 'option', 'Backend', 'backend', NULL, NULL),
	(8, 'option', 'Database', 'database', NULL, NULL),
	(9, 'option', 'Supporto', 'supporto', NULL, NULL),
	(10, 'option', 'Consulenza', 'consulenza', NULL, NULL),
	(11, 'option', 'Informazioni', 'informazioni', NULL, NULL),
	(12, 'text', 'title', 'title', 10, 64),
	(13, 'textarea', 'message', 'message', 10, 500);

-- Dump della struttura di tabella lmwebdev.header
DROP TABLE IF EXISTS `header`;
CREATE TABLE IF NOT EXISTS `header` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL,
  `tipo` varchar(45) NOT NULL DEFAULT 'Testo' COMMENT 'Logo / Testo / Menu',
  `testo` varchar(45) DEFAULT NULL,
  `url` varchar(45) DEFAULT NULL,
  `posizione` tinyint(1) unsigned zerofill NOT NULL,
  `cancellato` tinyint(1) unsigned zerofill NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dump dei dati della tabella lmwebdev.header: ~3 rows (circa)
DELETE FROM `header`;
INSERT INTO `header` (`id`, `nome`, `tipo`, `testo`, `url`, `posizione`, `cancellato`) VALUES
	(1, 'LMWebDev Logo', 'Logo', NULL, './img/LOGO_CIRCLE_PICCOLO.png', 1, 0),
	(2, 'LMWebDev Title', 'Testo', 'Lorenzo Marini Web Developer', NULL, 2, 0),
	(3, 'LMWebDev Menu', 'Menu', 'fa-solid fa-bars', 'javacript:void(0)', 3, 0);

-- Dump della struttura di tabella lmwebdev.lmwebdev
DROP TABLE IF EXISTS `lmwebdev`;
CREATE TABLE IF NOT EXISTS `lmwebdev` (
  `idPagina` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nomePagina` varchar(45) NOT NULL DEFAULT 'nuova-pagina',
  `urlPagina` varchar(45) NOT NULL DEFAULT 'nuova-pagina.php',
  `cancellato` tinyint(1) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`idPagina`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dump dei dati della tabella lmwebdev.lmwebdev: ~5 rows (circa)
DELETE FROM `lmwebdev`;
INSERT INTO `lmwebdev` (`idPagina`, `nomePagina`, `urlPagina`, `cancellato`) VALUES
	(1, 'homepage', 'lmwebdev.ver2.local', 0),
	(2, 'portfolio', '?page=portfolio', 0),
	(3, 'contatti', '?page=contacts', 0),
	(4, 'privacy', '?page=privacy', 0),
	(5, 'cookie', '?page=cookie', 0);

-- Dump della struttura di tabella lmwebdev.menu
DROP TABLE IF EXISTS `menu`;
CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL,
  `titolo` varchar(45) NOT NULL,
  `posizione` tinyint(1) unsigned zerofill NOT NULL DEFAULT 0,
  `sezione` varchar(45) NOT NULL DEFAULT 'Menu' COMMENT 'Menu | Policy | Socials',
  `url` varchar(45) NOT NULL,
  `cancellato` tinyint(1) unsigned zerofill NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dump dei dati della tabella lmwebdev.menu: ~7 rows (circa)
DELETE FROM `menu`;
INSERT INTO `menu` (`id`, `nome`, `titolo`, `posizione`, `sezione`, `url`, `cancellato`) VALUES
	(1, 'Home', 'Home', 1, 'Menu', 'http://lmwebdev.ver2.local', 0),
	(2, 'AboutMe', 'About Me', 2, 'Menu', '#about-me', 0),
	(3, 'Portfolio', 'Portfolio', 3, 'Menu', '?page=portfolio', 0),
	(4, 'Contatti', 'Contatti', 4, 'Menu', '?page=contacts', 0),
	(5, 'Privacy Policy', 'Privacy Policy', 0, 'Policy', '?page=privacy', 0),
	(6, 'Cookie Policy', 'Cookie Policy', 0, 'Policy', '?page=cookie', 0);

-- Dump della struttura di tabella lmwebdev.progetti
DROP TABLE IF EXISTS `progetti`;
CREATE TABLE IF NOT EXISTS `progetti` (
  `idProgetto` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nomeProgetto` varchar(45) NOT NULL,
  `descrizioneProgetto` mediumtext NOT NULL,
  `dataProgetto` date NOT NULL,
  `tipologiaProgetto` tinyint(1) unsigned zerofill NOT NULL COMMENT '0 = Nessuna categoria; \n1 = Website; \n2 = Web-application; \n3 = Script/Utility; \n4 = Ambiente web; ',
  `urlImmagine` varchar(45) NOT NULL,
  `cancellato` tinyint(1) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`idProgetto`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dump dei dati della tabella lmwebdev.progetti: ~3 rows (circa)
DELETE FROM `progetti`;
INSERT INTO `progetti` (`idProgetto`, `nomeProgetto`, `descrizioneProgetto`, `dataProgetto`, `tipologiaProgetto`, `urlImmagine`, `cancellato`) VALUES
	(1, 'KnowYourBooks', 'Sito di recensioni libri (HTML-CSS-PHP)', '2024-10-08', 1, './img/KnowYourBooks.png', 0),
	(2, 'MyToDoList', 'To-Do List dinamica (HTML-CSS-JS)', '2024-09-28', 3, './img/MyToDoList.png', 0),
	(3, 'Megacorp', 'Sistema web per la gesitone aziendale (progetto fittizio)', '2024-01-01', 4, './img/appgestionale.jpg', 0);

-- Dump della struttura di tabella lmwebdev.progettidescrizione
DROP TABLE IF EXISTS `progettidescrizione`;
CREATE TABLE IF NOT EXISTS `progettidescrizione` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idProgetto` int(10) unsigned DEFAULT NULL,
  `titolo` varchar(50) NOT NULL,
  `testo` text NOT NULL,
  `cancellato` tinyint(1) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `FK_progettidescrizione_progetti` (`idProgetto`),
  CONSTRAINT `FK_progettidescrizione_progetti` FOREIGN KEY (`idProgetto`) REFERENCES `progetti` (`idProgetto`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dump dei dati della tabella lmwebdev.progettidescrizione: ~12 rows (circa)
DELETE FROM `progettidescrizione`;
INSERT INTO `progettidescrizione` (`id`, `idProgetto`, `titolo`, `testo`, `cancellato`) VALUES
	(1, 1, 'Descrizione', 'Sito web (fittizzio) per un gruppo di amanti di libri, con l\'intenzione di raccogliere recensioni e valutazioni su qualsiasi tipo di libro da parte di qualsiasi lettore.', 0),
	(2, 1, 'Dettagli', 'Sviluppato con il solo utilizzo di HTML, SASS e PHP, offre la possibilità di inserire, leggere e ricercare recensioni che vengono immagazzinate all\'interno di un file JSON. Ha un\'interfaccia minimale, voluta per valorizzare più l\'aspetto tecnico dell\'utilizzo di PHP piuttosto che quello visivo.', 0),
	(3, 1, 'Funzione di inserimento', 'La funzione di inserimento recensioni è costituita da un semplice form con vari campi compilabili, i quali vengono validati durante la fase di submit dal PHP (prima che avvenga l\'inserimento dei dati nel file JSON). Questo è stato volutamente eseguito con PHP per manternerlo come unico linguaggio di programmazione del progetto. Nella fase di inserimento dati nel file JSON, dal file viene estrapolato un array multi-dimensionale a cui è aggiunto il nuovo array contenente la nuova recensione; l\'array multi-dimensione viene poi inserito all\'interno del JSON sovrascrivendo i dati esistenti. ', 0),
	(4, 1, 'Funzione di ricerca', 'La funzione di ricerca comprende un form nella quale è possibile, a discrezione dell\'utente, inserire il nome dell\'autore, il titolo del libro o entrambi. Dopodiché, in PHP vengono validati i dati inseriti ed estrapolati i dati dal file JSON e, in base ai dati inseriti nel form, vengono mostrate a video le recensioni che soddisfano i criteri di ricerca.', 0),
	(5, 1, 'Prossime implementazioni', 'In futuro, il progetto sarà implementato di un database in cui saranno inserite le recensioni e con la quale sarà possibile interagire, modificando, eliminando o aggiungengo nuove recensioni da parte degli utenti.\r\nInoltre, potrà essere implementato anche di una funzione di registrazione e login utente, per l\'inserimento delle recensioni.', 0),
	(6, 2, 'Descrizione', 'To-do list dinamica costituita da una pagina web singola, completamente sviluppata in HTML, SASS e JAVASCRIPT.', 0),
	(7, 2, 'Dettagli', 'In questa To-do List è possibile inserire, segnare come completati, eliminare e modificare compiti che devono essere eseguiti. Ogni dato inserito viene registrato all\'interno di un oggetto JSON che ad ogni modifica viene riportato nella console. Non essendo collegata ad un database o a un file JSON esterno, i dati vengono eliminati alla chiusura o all\'aggiornamento della pagina.', 0),
	(8, 3, 'Descrizione', 'Progetto realizzato per conto di Megacorp SPA, ultimato a Milano nel Gennaio 2024, utilizzando framework Angular per lo sviluppo Front-End delle web application legate alla gestione aziendale e database MySQL per l\'archiviazione dei dati dei clienti, dei dati del personale aziendale e dei dati finanziari.', 0),
	(9, 3, 'Sito web pubblicitario', 'Creato come vetrina principale nella quale i clienti possono trovare tutte le informazioni sui prodotti e i servizi offerti dall\'azienda. Totalmente responsive per una visualizzazione ottimale sia su dispositivi fissi che mobile. Presenta anche una sezione per le richiesti di contatto e di consulenza, oltre che la possibilità di prenotare colloqui diretti con i consulenti aziendali attraverso un\'agenda aggiornata in tempo reale.', 0),
	(10, 3, 'Web application gestionale', 'Applicazione basata su framework Angular, con interfaccia completamente personalizzabile lato client in base al reparto in cui si opera, che sia gestione del personale, gestione degli appuntamenti o gestione delle prenotazioni ricevute attraverso il sito web pubblico.', 0),
	(11, 3, 'Web application per la gestione finanziaria', 'Strutturata secondo le necessità del reparto di amministrazione aziendale, permette la totale gestione dei magazzini, della fatturazione e dell\'analisi finanziaria interna.', 0),
	(12, 3, 'Web server e database', 'Corpo centrale del sistema informatico aziendale, permette la comunicazione tra i vari sistemi di gestione, nonché l\'archiviazione dei dati dei clienti e dei dati interni. Presenta anche un sistema di backup cloud automatico.', 0);

-- Dump della struttura di tabella lmwebdev.progettiimmagini
DROP TABLE IF EXISTS `progettiimmagini`;
CREATE TABLE IF NOT EXISTS `progettiimmagini` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idProgetto` int(10) unsigned DEFAULT NULL,
  `urlImmagine` varchar(50) NOT NULL,
  `titolo` varchar(50) NOT NULL,
  `cancellato` tinyint(1) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `FK_progettiimmagini_progetti` (`idProgetto`),
  CONSTRAINT `FK_progettiimmagini_progetti` FOREIGN KEY (`idProgetto`) REFERENCES `progetti` (`idProgetto`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dump dei dati della tabella lmwebdev.progettiimmagini: ~4 rows (circa)
DELETE FROM `progettiimmagini`;
INSERT INTO `progettiimmagini` (`id`, `idProgetto`, `urlImmagine`, `titolo`, `cancellato`) VALUES
	(1, 3, './img/appgestionale.jpg', 'Web Application Preview', 0),
	(2, 3, './img/appfinanziaria.jpg', 'Web Application Preview', 0),
	(3, 3, './img/vetrina.jpg', 'Website Preview', 0),
	(4, 3, './img/server.jpg', 'Server Preview', 0);

-- Dump della struttura di tabella lmwebdev.recapitiindirizzi
DROP TABLE IF EXISTS `recapitiindirizzi`;
CREATE TABLE IF NOT EXISTS `recapitiindirizzi` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tipo` varchar(45) NOT NULL DEFAULT '' COMMENT 'Contatti | Socials',
  `nome` varchar(45) NOT NULL,
  `testo` varchar(45) DEFAULT NULL,
  `url` varchar(45) DEFAULT NULL,
  `logo` varchar(50) DEFAULT NULL,
  `cancellato` tinyint(1) unsigned zerofill NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dump dei dati della tabella lmwebdev.recapitiindirizzi: ~5 rows (circa)
DELETE FROM `recapitiindirizzi`;
INSERT INTO `recapitiindirizzi` (`id`, `tipo`, `nome`, `testo`, `url`, `logo`, `cancellato`) VALUES
	(1, 'Contatti', 'Email', 'l.marini1994@gmail.com', 'mailto:l.marini1994@gmail.com', NULL, 0),
	(3, 'Socials', 'Instagram', 'Instagram', 'https://www.instagram.com/lorenzo___marini/', './img/icons/instagram.svg', 0),
	(4, 'Socials', 'Linkedin', 'Linkedin', 'https://www.linkedin.com/in/lorenzo-marini-5a', './img/icons/linkedin.svg', 0),
	(5, 'Socials', 'GitHub', 'GitHub', 'https://github.com/iLollo94/', './img/icons/github.svg', 0),
	(8, 'Socials', 'StackOverflow', 'Stack Overflow', 'https://stackoverflow.com/users/26772447/lore', './img/icons/stackoverflow.svg', 0);

-- Dump della struttura di tabella lmwebdev.servizi
DROP TABLE IF EXISTS `servizi`;
CREATE TABLE IF NOT EXISTS `servizi` (
  `idServizio` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `titolo` varchar(45) NOT NULL DEFAULT 'nuovo-servizio',
  `descrizione` mediumtext DEFAULT NULL,
  `urlImmagine` varchar(45) DEFAULT NULL,
  `cancellato` tinyint(1) unsigned zerofill NOT NULL,
  PRIMARY KEY (`idServizio`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dump dei dati della tabella lmwebdev.servizi: ~5 rows (circa)
DELETE FROM `servizi`;
INSERT INTO `servizi` (`idServizio`, `titolo`, `descrizione`, `urlImmagine`, `cancellato`) VALUES
	(1, 'Sviluppo Front-End', 'Migliora la tua presenza online con interfacce moderne e responsive che attraggono e fidelizzano i clienti.', 'https://placehold.co/400x600', 0),
	(2, 'Sviluppo Back-End', 'Ottimizza la gestione del tuo sito con un sistema robusto e scalabile, pronto a supportare la crescita del tuo business.', 'https://placehold.co/400x600', 0),
	(3, 'Sviluppo Database Relazionali', 'Ottimizza la gestione dei tuoi dati con soluzioni sicure e performanti, migliorando l\'efficienza e la gestione del tuo sito.', 'https://placehold.co/400x600', 0),
	(4, 'Consulenza Tecnica', 'Affidati alla mia esperienza per soluzioni su misura che ottimizzano i tuoi processi digitali e migliorano l\'efficienza aziendale.', 'https://placehold.co/400x600', 0),
	(5, 'Assistenza Continua', 'Supporto rapido e professionale per mantenere il tuo sito e le tue applicazioni sempre al massimo delle prestazioni.', 'https://placehold.co/400x600', 0);

-- Dump della struttura di tabella lmwebdev.sezioni
DROP TABLE IF EXISTS `sezioni`;
CREATE TABLE IF NOT EXISTS `sezioni` (
  `idSezione` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idPagina` int(10) unsigned NOT NULL,
  `nomeSezione` varchar(45) NOT NULL DEFAULT 'nuova-sezione',
  `cancellato` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`idSezione`),
  KEY `fk_sezioni_lmwebdev_idx` (`idPagina`),
  CONSTRAINT `fk_sezioni_lmwebdev` FOREIGN KEY (`idPagina`) REFERENCES `lmwebdev` (`idPagina`) ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dump dei dati della tabella lmwebdev.sezioni: ~8 rows (circa)
DELETE FROM `sezioni`;
INSERT INTO `sezioni` (`idSezione`, `idPagina`, `nomeSezione`, `cancellato`) VALUES
	(1, 1, 'services', 0),
	(2, 1, 'aboutMe', 0),
	(3, 1, 'knowledge', 0),
	(4, 2, 'projects', 0),
	(5, 3, 'contacts', 0),
	(6, 3, 'form', 0),
	(7, 4, 'privacy', 0),
	(8, 4, 'cookies', 0);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
