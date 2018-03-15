-- MySQL dump 10.13  Distrib 5.7.21, for Linux (x86_64)
--
-- Host: localhost    Database: userdata
-- ------------------------------------------------------
-- Server version	5.7.21-0ubuntu0.16.04.1

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
-- Table structure for table `forummessages`
--

DROP TABLE IF EXISTS `forummessages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `forummessages` (
  `entityid` int(8) NOT NULL,
  `username` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL,
  `tournamentid` int(11) NOT NULL,
  PRIMARY KEY (`entityid`),
  KEY `tournamentid` (`tournamentid`),
  CONSTRAINT `forummessages_ibfk_1` FOREIGN KEY (`tournamentid`) REFERENCES `tournamentinfo` (`tournamentid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `forummessages`
--

LOCK TABLES `forummessages` WRITE;
/*!40000 ALTER TABLE `forummessages` DISABLE KEYS */;
/*!40000 ALTER TABLE `forummessages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `forumusers`
--

DROP TABLE IF EXISTS `forumusers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `forumusers` (
  `userid` int(8) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `userdata` datetime NOT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `forumusers`
--

LOCK TABLES `forumusers` WRITE;
/*!40000 ALTER TABLE `forumusers` DISABLE KEYS */;
/*!40000 ALTER TABLE `forumusers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `logininfo`
--

DROP TABLE IF EXISTS `logininfo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `logininfo` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `pword` varchar(255) DEFAULT NULL,
  `sessionid` varchar(255) DEFAULT NULL,
  `epochtime` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `logininfo`
--

LOCK TABLES `logininfo` WRITE;
/*!40000 ALTER TABLE `logininfo` DISABLE KEYS */;
INSERT INTO `logininfo` VALUES (1,'Beni','newbie',NULL,NULL,NULL),(2,'Robert','brickcity',NULL,NULL,NULL),(234,'Howard','sing',NULL,NULL,NULL);
/*!40000 ALTER TABLE `logininfo` ENABLE KEYS */;
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
  PRIMARY KEY (`id`),
  CONSTRAINT `playerinfo_ibfk_1` FOREIGN KEY (`id`) REFERENCES `logininfo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `playerinfo`
--

LOCK TABLES `playerinfo` WRITE;
/*!40000 ALTER TABLE `playerinfo` DISABLE KEYS */;
/*!40000 ALTER TABLE `playerinfo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `posts` (
  `postid` int(8) NOT NULL AUTO_INCREMENT,
  `postcontent` text NOT NULL,
  `postdate` datetime NOT NULL,
  `posttopic` int(8) NOT NULL,
  PRIMARY KEY (`postid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `teams`
--

DROP TABLE IF EXISTS `teams`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `teams` (
  `teamid` int(8) NOT NULL,
  `playeroneid` int(8) NOT NULL,
  `playertwoid` int(8) NOT NULL,
  `playerthreeid` int(8) NOT NULL,
  `playerfourid` int(8) NOT NULL,
  `playerfiveid` int(8) NOT NULL,
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
  `gameid` int(11) NOT NULL,
  `teamid` int(8) NOT NULL,
  `tournamentid` int(11) NOT NULL,
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
  `tournamentid` int(11) NOT NULL,
  `tournamentname` varchar(255) DEFAULT NULL,
  `hostname` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `startTimeEpoch` int(11) DEFAULT NULL,
  `game` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`tournamentid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tournamentinfo`
--

LOCK TABLES `tournamentinfo` WRITE;
/*!40000 ALTER TABLE `tournamentinfo` DISABLE KEYS */;
INSERT INTO `tournamentinfo` VALUES (1,'Firstof2018','LeagueClub','First LOL tournament for Spring 2018',1520892526,'Game1');
/*!40000 ALTER TABLE `tournamentinfo` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-03-15  4:17:08
