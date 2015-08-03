<?php
if($_SESSION["USER_ID"] > 0)
{
  ?>
  <div class="panel panel-default">
    <div class="panel-body">
      <h1><?php echo Web_GetLocale("ACTIVATE_01");?></h1>
      <p><?php echo Web_GetLocale("ACTIVATE_E01");?></p>
    </div>
  </div>

  <?php  
}
else 
{
  ?>
  <div class="panel panel-default">
    <div class="panel-body">
      <h1><?php echo Web_GetLocale("ACTIVATE_01");?></h1>
      <?php
      if(!empty($_GET["user"]) && !empty($_GET["key"])) 
      {
        $name_query = Database_Select("USER", array("USER_NAME" => $_GET["user"])); 
        if($name_query > 0)
        {
          $key_query = Database_Select("KEYS", array("KEY" => $_GET["key"], "USER_ID" => User_ID($_GET["user"]), "KEY_TYPE" => "REGISTER"), "KEY_TIME");
          if($key_query > 0)
          {
            Database_Update("USER", array("USER_RIGHTS" => "A"), array("USER_ID" => User_ID($_GET["user"])));
            Database_Delete("KEYS", array("KEY" => $_GET["key"]));
            ShowNotification("success", Web_GetLocale("ACTIVATE_EOK")); 
            Web_LoginForm();
            Message_Create(
              array(
                "MESSAGE_TOPIC" => Web_GetLocale("MSG_T01"),
                "MESSAGE_TEXT" => Web_GetLocale("MSG_T02"),
                "MESSAGE_TYPE" => "ADMIN",
                "SEND_USER_ID" => 1,
                "READ_USER_ID" => User_ID($_GET["user"]),
                "MESSAGE_DATE" => time(),
                "MESSAGE_SHOWED" => "NONE"
              )
            );
          }
          else ShowNotification("warning", Web_GetLocale("ACTIVATE_E04"));
        }
        else ShowNotification("warning", Web_GetLocale("ACTIVATE_E03"));
      }
      else ShowNotification("warning", Web_GetLocale("ACTIVATE_E02"));
      ?>
    </div>
  </div>
  <?php
}
?>