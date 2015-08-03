<?php
if($_SESSION["USER_ID"] > 0)
{
  ?>
  <div class="panel panel-default">
    <div class="panel-body">
      <h1><?php echo Web_GetLocale("LOGIN_01");?></h1>
      <p><?php echo Web_GetLocale("LOGIN_E04");?></p>
    </div>
  </div>
  <?php  
}
else 
{
?>
<div class="panel panel-default">
  <div class="panel-body">
    <section class="container">
      <div class="container-page">
        <h1><?php echo Web_GetLocale("LOGIN_01");?></h1>
        <?php 
        Web_LoginForm(1);
        if(@$_POST["login"])
        {
          if(!empty($_POST["user_name"]) && !empty($_POST["user_password"]))
          {
            if(strlen($_POST["user_name"]) > 2 && preg_match("/^[_a-zA-Z0-9-]+$/", $_POST["user_name"])) 
            {
              $user_id = User_ID($_POST["user_name"]);
              $data = Database_Select("USER", array("USER_NAME" => $_POST["user_name"], "USER_PASS" => User_GeneratePassword($user_id, $_POST["user_password"]))); 
              if($data > 0)
              {
                if($data["USER_RIGHTS"] != "unactive")
                {
                  User_Load($user_id);
                  Database_Update("USER", array("USER_DATE_L" => time()), array("USER_ID" => $user_id));
                  header("Location: http://".Web_GetOption("URL")."");  
                }
                else ShowNotification("warning", Web_GetLocale("LOGIN_E05"));
              } 
              else ShowNotification("warning", Web_GetLocale("LOGIN_E03"));
            } 
            else ShowNotification("warning", Web_GetLocale("LOGIN_E02"));
          }
          else ShowNotification("warning", Web_GetLocale("LOGIN_E01"));
        }
        ?>
      </div>
    </section>
  </div>
</div>
<?php
}
?>