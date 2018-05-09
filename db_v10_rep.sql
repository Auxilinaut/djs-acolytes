-- MySQL dump 10.13  Distrib 5.7.22, for Linux (x86_64)
--
-- Host: localhost    Database: userdata
-- ------------------------------------------------------
-- Server version	5.7.22-0ubuntu0.16.04.1-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `logininfo`
--

DROP TABLE IF EXISTS `logininfo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `logininfo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `pword` varchar(255) DEFAULT NULL,
  `sessionid` varchar(255) DEFAULT NULL,
  `epochtime` bigint(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=243 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `logininfo`
--

LOCK TABLES `logininfo` WRITE;
/*!40000 ALTER TABLE `logininfo` DISABLE KEYS */;
INSERT INTO `logininfo` VALUES (1,'Beni','newbie',NULL,NULL,NULL),(2,'Robert','brickcity',NULL,NULL,NULL),(234,'Howard','sing','3546f5a1dcef9da13bf4d5a8368c2261e070d945f112cdc222fdb4a54e35a065',1523306895,NULL),(235,'','justin',NULL,NULL,'justin'),(236,'','timsucks','d14d9c605fe36a96c2d42aac627a95be0ab52704d2d44bc1f7d2fff7dfd1f848',1522289912,'tim'),(237,'','timbo','49ee5196d107fce8a6768171b5c907523278ffbacce1786c2d174b2168acfb52',1522288986,'timbo'),(238,'','whatever','1591b113347de2bf641bf046eecbc69b41dbdb9967cea6e5166ede6fd21aa646',1522289830,'sure'),(239,'','timsucks','d14d9c605fe36a96c2d42aac627a95be0ab52704d2d44bc1f7d2fff7dfd1f848',1522289912,'timsucks@timsucks.com'),(240,'','tim','2b63d8361d98b83d6090c78d3be1d25d62647a2aef2a3a4af849de157d25d5aa',1522290517,'bootstrap@gmail.com'),(241,'justiniscool','justiniscool','1ccf02c93f525996b8043d92b1f28a331dfd815ff45d46401f0a9946b8e94fe5',1522292706,'justiniscool'),(242,'timiscool','timiscool','d01bd612b7c8239c03ec109a2eb3cb211742e1db1795b6033e565a540b6befa1',1522354681,'timiscool');
/*!40000 ALTER TABLE `logininfo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messages` (
  `messageid` int(11) NOT NULL AUTO_INCREMENT,
  `tournamentid` int(11) DEFAULT NULL,
  `userid` int(11) DEFAULT NULL,
  `message` text,
  `timeepoch` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`messageid`),
  KEY `tournamentid` (`tournamentid`),
  CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`tournamentid`) REFERENCES `tournamentinfo` (`tournamentid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `playerinfo`
--

DROP TABLE IF EXISTS `playerinfo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `playerinfo` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `ign` varchar(255) DEFAULT NULL,
  `toppref` int(1) DEFAULT NULL,
  `junglepref` int(1) DEFAULT NULL,
  `midpref` int(1) DEFAULT NULL,
  `adcpref` int(1) DEFAULT NULL,
  `supportpref` int(1) DEFAULT NULL,
  `mmr` varchar(255) DEFAULT NULL,
  `wincount` int(11) DEFAULT NULL,
  `losscount` int(11) DEFAULT NULL,
  `winlossratio` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `playerinfo_ibfk_1` FOREIGN KEY (`id`) REFERENCES `logininfo` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `playerinfo`
--

LOCK TABLES `playerinfo` WRITE;
/*!40000 ALTER TABLE `playerinfo` DISABLE KEYS */;
INSERT INTO `playerinfo` VALUES (237,'','nizzy2k11',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL),(238,'','nizzy2k11',NULL,NULL,NULL,NULL,NULL,'GOLDV',NULL,NULL,NULL),(239,'','nizzy2k11',NULL,NULL,NULL,NULL,NULL,'GOLDV',NULL,NULL,NULL),(240,'','nizzy2k11',NULL,NULL,NULL,NULL,NULL,'GOLDV',NULL,NULL,NULL),(241,'justiniscool','nizzy2k11',NULL,NULL,NULL,NULL,NULL,'GOLDV',NULL,NULL,NULL),(242,'timiscool','nizzy2k11',NULL,NULL,NULL,NULL,NULL,'GOLDV',NULL,NULL,NULL);
/*!40000 ALTER TABLE `playerinfo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `playersintournaments`
--

DROP TABLE IF EXISTS `playersintournaments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `playersintournaments` (
  `participantid` int(11) NOT NULL,
  `tournamentid` int(11) DEFAULT NULL,
  `id` int(11) DEFAULT NULL,
  PRIMARY KEY (`participantid`),
  KEY `tournamentid` (`tournamentid`),
  KEY `id` (`id`),
  CONSTRAINT `playersintournaments_ibfk_1` FOREIGN KEY (`tournamentid`) REFERENCES `tournamentinfo` (`tournamentid`),
  CONSTRAINT `playersintournaments_ibfk_2` FOREIGN KEY (`id`) REFERENCES `logininfo` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `playersintournaments`
--

LOCK TABLES `playersintournaments` WRITE;
/*!40000 ALTER TABLE `playersintournaments` DISABLE KEYS */;
/*!40000 ALTER TABLE `playersintournaments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profile`
--

DROP TABLE IF EXISTS `profile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `profile` (
  `id` int(11) NOT NULL,
  `championone` varchar(255) DEFAULT NULL,
  `championtwo` varchar(255) DEFAULT NULL,
  `championthree` varchar(255) DEFAULT NULL,
  `tournamentsplayed` int(11) DEFAULT NULL,
  `tournamentswon` int(11) DEFAULT NULL,
  `apiwinratio` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `profile_ibfk_1` FOREIGN KEY (`id`) REFERENCES `playerinfo` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profile`
--

LOCK TABLES `profile` WRITE;
/*!40000 ALTER TABLE `profile` DISABLE KEYS */;
/*!40000 ALTER TABLE `profile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `teams`
--

DROP TABLE IF EXISTS `teams`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `teams` (
  `teamid` int(11) NOT NULL,
  `playeroneid` int(11) DEFAULT NULL,
  `playertwoid` int(11) DEFAULT NULL,
  `playerthreeid` int(11) DEFAULT NULL,
  `playerfourid` int(11) DEFAULT NULL,
  `playerfiveid` int(11) DEFAULT NULL,
  PRIMARY KEY (`teamid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teams`
--

LOCK TABLES `teams` WRITE;
/*!40000 ALTER TABLE `teams` DISABLE KEYS */;
/*!40000 ALTER TABLE `teams` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `teamsintournaments`
--

DROP TABLE IF EXISTS `teamsintournaments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `teamsintournaments` (
  `gameid` int(11) NOT NULL AUTO_INCREMENT,
  `teamid` int(11) DEFAULT NULL,
  `tournamentid` int(11) DEFAULT NULL,
  PRIMARY KEY (`gameid`),
  KEY `teamid` (`teamid`),
  KEY `tournamentid` (`tournamentid`),
  CONSTRAINT `teamsintournaments_ibfk_1` FOREIGN KEY (`teamid`) REFERENCES `teams` (`teamid`),
  CONSTRAINT `teamsintournaments_ibfk_2` FOREIGN KEY (`tournamentid`) REFERENCES `tournamentinfo` (`tournamentid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teamsintournaments`
--

LOCK TABLES `teamsintournaments` WRITE;
/*!40000 ALTER TABLE `teamsintournaments` DISABLE KEYS */;
/*!40000 ALTER TABLE `teamsintournaments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `topics`
--

DROP TABLE IF EXISTS `topics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `topics` (
  `topicid` int(8) NOT NULL AUTO_INCREMENT,
  `topicsubject` varchar(255) NOT NULL,
  `topicdate` datetime NOT NULL,
  PRIMARY KEY (`topicid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `topics`
--

LOCK TABLES `topics` WRITE;
/*!40000 ALTER TABLE `topics` DISABLE KEYS */;
/*!40000 ALTER TABLE `topics` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tournamentinfo`
--

DROP TABLE IF EXISTS `tournamentinfo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tournamentinfo` (
  `tournamentid` int(11) NOT NULL AUTO_INCREMENT,
  `tournamentname` varchar(255) DEFAULT NULL,
  `hostname` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `startTimeEpoch` bigint(20) DEFAULT NULL,
  `game` varchar(255) DEFAULT NULL,
  `winningteamid` int(11) DEFAULT NULL,
  PRIMARY KEY (`tournamentid`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tournamentinfo`
--

LOCK TABLES `tournamentinfo` WRITE;
/*!40000 ALTER TABLE `tournamentinfo` DISABLE KEYS */;
INSERT INTO `tournamentinfo` VALUES (1,'Firstof2018','LeagueClub','First LOL tournament for Spring 2018',1520892526,'Game1',NULL),(2,'thisdoesntwork','','thisdoesntwork',12345,NULL,NULL),(3,'hellodj','','thistourneyisfake',1234567890,NULL,NULL),(4,'topi','','tpoiett',12345,NULL,NULL),(5,'anthonysucks','','bigtime',1234567890,NULL,NULL);
/*!40000 ALTER TABLE `tournamentinfo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tournamentrounds`
--

DROP TABLE IF EXISTS `tournamentrounds`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tournamentrounds` (
  `roundid` int(11) NOT NULL AUTO_INCREMENT,
  `tournamentid` int(11) DEFAULT NULL,
  `teamoneid` int(11) DEFAULT NULL,
  `teamtwoid` int(11) DEFAULT NULL,
  `winnerid` int(11) DEFAULT NULL,
  PRIMARY KEY (`roundid`),
  KEY `tournamentid` (`tournamentid`),
  CONSTRAINT `tournamentrounds_ibfk_1` FOREIGN KEY (`tournamentid`) REFERENCES `tournamentinfo` (`tournamentid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tournamentrounds`
--

LOCK TABLES `tournamentrounds` WRITE;
/*!40000 ALTER TABLE `tournamentrounds` DISABLE KEYS */;
/*!40000 ALTER TABLE `tournamentrounds` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-05-08 23:15:54
