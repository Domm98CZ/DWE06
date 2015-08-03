<?php
if($_SESSION["USER_ID"] > 0)
{
  if(User_Rights($_SESSION["USER_ID"], "Q"))
  {
    Database_FreeSql("
    CREATE TABLE IF NOT EXISTS `".$conf["DB:PREFIX"]."CHAT_MESSAGES` (
    `MESSAGE_ID` int(11) NOT NULL AUTO_INCREMENT,
    `MESSAGE_TEXT` text COLLATE utf8_czech_ci NOT NULL,
    `USER_ID` int(11) NOT NULL,
    `MESSAGE_TIME` varchar(10) COLLATE utf8_czech_ci NOT NULL,
    `MESSAGE_SHOW` int(1) NOT NULL,
    PRIMARY KEY (`MESSAGE_ID`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=1;
    ");
  }
  else header("location: ?page=admin&admin=plugins");
}
else header("location: ?page=login");
?>