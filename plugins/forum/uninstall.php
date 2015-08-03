<?php
if($_SESSION["USER_ID"] > 0)
{
  if(User_Rights($_SESSION["USER_ID"], "Q"))
  {
    Database_FreeSql("DROP TABLE ".$conf["DB:PREFIX"]."FORUM_CATS");
    Database_FreeSql("DROP TABLE ".$conf["DB:PREFIX"]."FORUM_REPLIES");
    Database_FreeSql("DROP TABLE ".$conf["DB:PREFIX"]."FORUM_THREADS");
    Database_FreeSql("DROP TABLE ".$conf["DB:PREFIX"]."FORUM_TOPICS");
  }
  else header("location: ?page=admin&admin=plugins");
}
else header("location: ?page=login");
?>