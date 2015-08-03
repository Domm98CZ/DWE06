<?php
if($_SESSION["USER_ID"] > 0)
{
  if(User_Rights($_SESSION["USER_ID"], "Q"))
  {
    Database_FreeSql("
    CREATE TABLE IF NOT EXISTS `".$conf["DB:PREFIX"]."FORUM_CATS` (
      `CAT_ID` int(11) NOT NULL AUTO_INCREMENT,
      `CAT_NAME` text COLLATE utf8_czech_ci NOT NULL,
      `CAT_INFO` text COLLATE utf8_czech_ci NOT NULL,
      `CAT_COLOR` varchar(10) COLLATE utf8_czech_ci NOT NULL,
      PRIMARY KEY (`CAT_ID`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=1;
    
    CREATE TABLE IF NOT EXISTS `".$conf["DB:PREFIX"]."FORUM_REPLIES` (
      `REPLY_ID` int(11) NOT NULL AUTO_INCREMENT,
      `REPLY_TEXT` text COLLATE utf8_czech_ci NOT NULL,
      `REPLY_DATE` int(10) NOT NULL,
      `USER_ID` int(11) NOT NULL,
      `THREAD_ID` int(11) NOT NULL,
      PRIMARY KEY (`REPLY_ID`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=1;
    
    CREATE TABLE IF NOT EXISTS `".$conf["DB:PREFIX"]."FORUM_THREADS` (
      `THREAD_ID` int(11) NOT NULL AUTO_INCREMENT,
      `THREAD_NAME` text COLLATE utf8_czech_ci NOT NULL,
      `THREAD_CONTENT` text COLLATE utf8_czech_ci NOT NULL,
      `THREAD_DATE` int(10) NOT NULL,
      `USER_ID` int(11) NOT NULL,
      `TOPIC_ID` int(11) NOT NULL,
      `THREAD_LOCK` int(1) NOT NULL DEFAULT '0',
      PRIMARY KEY (`THREAD_ID`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=1;
    
    CREATE TABLE IF NOT EXISTS `".$conf["DB:PREFIX"]."FORUM_TOPICS` (
      `TOPIC_ID` int(11) NOT NULL AUTO_INCREMENT,
      `TOPIC_NAME` text COLLATE utf8_czech_ci NOT NULL,
      `TOPIC_INFO` text COLLATE utf8_czech_ci NOT NULL,
      `TOPIC_IMG` text COLLATE utf8_czech_ci NOT NULL,
      `CAT_ID` int(11) NOT NULL,
      PRIMARY KEY (`TOPIC_ID`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=1;
    ");
  }
  else header("location: ?page=admin&admin=plugins");
}
else header("location: ?page=login");
?>