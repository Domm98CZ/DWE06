<?php
if($_SESSION["USER_ID"] > 0)
{
  if(User_Rights($_SESSION["USER_ID"], "Q"))
  {
    Database_FreeSql("DROP TABLE ".$conf["DB:PREFIX"]."CHAT_MESSAGES");
  }
  else header("location: ?page=admin&admin=plugins");
}
else header("location: ?page=login");
?>