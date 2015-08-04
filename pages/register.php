<?php
if($_SESSION["USER_ID"] > 0)
{
  ?>
  <div class="panel panel-default">
    <div class="panel-body">
      <h1><?php echo Web_GetLocale("REGISTER_01");?></h1>
      <p><?php echo Web_GetLocale("REGISTER_E09");?></p>
    </div>
  </div>
  <?php  
}
else 
{
?>
<div class="panel panel-default">
  <div class="panel-body">
    <h1><?php echo Web_GetLocale("REGISTER_01");?></h1>
      <section>
        <div>
          <form method="post">
            <div class="form-group col-lg-12">
              <label><?php echo Web_GetLocale("REGISTER_02");?></label>
              <input type="text" name="user_name" class="form-control" id="" value="">
            </div>
                      
            <div class="form-group col-lg-12">
              <label><?php echo Web_GetLocale("REGISTER_03");?></label>
              <input type="text" name="user_full_name" class="form-control" id="" value="">
            </div>
              				
            <div class="form-group col-lg-6">
              <label><?php echo Web_GetLocale("REGISTER_04");?></label>
              <input type="password" name="user_pass" class="form-control" id="" value="">
            </div>
              				
            <div class="form-group col-lg-6">
              <label><?php echo Web_GetLocale("REGISTER_05");?></label>
              <input type="password" name="user_pass_r" class="form-control" id="" value="">
            </div>
              								
            <div class="form-group col-lg-6">
              <label><?php echo Web_GetLocale("REGISTER_06");?></label>
              <input type="text" name="user_email" class="form-control" id="" value="">
            </div>
              				
            <div class="form-group col-lg-6">
              <label><?php echo Web_GetLocale("REGISTER_07");?></label>
              <input type="text" name="user_email_r" class="form-control" id="" value="">
            </div>
            
            <div style="float:right;text-align:right;">
              <a href="?page=login" class="btn btn-primary"><?php echo Web_GetLocale("LOGIN_07");?></a>
              <input type="submit" name="register" value="<?php echo Web_GetLocale("REGISTER_09");?>" class="btn btn-primary">
              <p class="text-primary"><?php echo Web_GetLocale("REGISTER_08");?></p>
            </div>
          </form>
        </div>
      </section>
    
    <br>
    <?php
    if(@$_POST["register"])
    {
      if(!empty($_POST["user_name"]) && !empty($_POST["user_full_name"]) && !empty($_POST["user_pass"]) && !empty($_POST["user_pass_r"]) && !empty($_POST["user_email"]) && !empty($_POST["user_email_r"]))
      {
        if(strlen($_POST["user_name"]) > 2 && preg_match("/^[_a-zA-Z0-9-]+$/", $_POST["user_name"])) 
        {
          if($_POST["user_pass"] == $_POST["user_pass_r"])
          {
            if(filter_var($_POST["user_email"], FILTER_VALIDATE_EMAIL)) 
            {
              if($_POST["user_email"] == $_POST["user_email_r"])
              {
                $name_query = Database_Select("USER", array("USER_NAME" => $_POST["user_name"])); 
                if($name_query == 0)
                {
                  $display_name1 = Database_Select("USER", array("USER_DISPLAY_NAME" => $_POST["user_full_name"])); 
                  $display_name2 = Database_Select("USER", array("USER_NAME" => $_POST["user_full_name"])); 
                  if($display_name1 == 0 && $display_name2 == 0)
                  {
                    $email_query = Database_Select("USER", array("USER_EMAIL" => $_POST["user_email"]));
                    if($email_query == 0)
                    {                  
                      $user_id = User_Create(
                        array(
                          "USER_NAME" => $_POST["user_name"],
                          "USER_PASS" => "NONE",
                          "USER_SALT" => User_GeneratePasswordSalt(),
                          "USER_DISPLAY_NAME" => $_POST["user_full_name"],
                          "USER_EMAIL" => $_POST["user_email"],
                          "USER_IP" => User_IP(1),
                          "USER_AVATAR" => "assets/images/noav.png",
                          "USER_DATE_R" => time(),
                          "USER_DATE_L" => time(),
                          "USER_DATE_A" => time(), 
                          "USER_RIGHTS" => "unactive" 
                        )
                      );
                      
                      Database_Update("USER", array("USER_PASS" => User_GeneratePassword($user_id, $_POST["user_pass"])), array("USER_ID" => $user_id));
                      
                      $key = User_GenerateKey();
                      $link = "http://".Web_GetOption("URL")."/?page=activate&user=".$_POST["user_name"]."&key=".$key;
                      User_CreateKey($user_id, $key, "REGISTER");
                      
                      $censored_pass = null;
                      $chars = strlen($_POST["user_pass"]);
                      for($i = 0;$i<$chars;$i++) $censored_pass .= "*";
                      
                      Web_Email($_POST["user_email"], Web_GetOption("NAME")." - ".Web_GetLocale("REGISTER_01"), "
                      <h1>".Web_GetOption("NAME")." - ".Web_GetLocale("REGISTER_01")."</h1>
                      <p>
                        ".Web_GetLocale("EMAIL_01")."
                        <a href='".$link."'>".$link."</a><br>
                        <br>
                        <b>".Web_GetLocale("LOGIN_02").":</b> ".$_POST["user_name"]."<br>
                        <b>".Web_GetLocale("LOGIN_03").":</b> ".$censored_pass."<br>
                        ".Web_GetLocale("EMAIL_02")."
                      </p>
                      ");
                      echo Web_GetLocale("REGISTER_OK");
                    } 
                    else echo Web_GetLocale("REGISTER_E07");
                  } 
                  else echo Web_GetLocale("REGISTER_E08");
                }
                else echo Web_GetLocale("REGISTER_E06");
              }
              else echo Web_GetLocale("REGISTER_E05");
            }
            else echo Web_GetLocale("REGISTER_E04"); 
          }
          else echo Web_GetLocale("REGISTER_E03");
        }
        else echo Web_GetLocale("REGISTER_E02");
      }
      else echo Web_GetLocale("REGISTER_E01");
    }
    ?>
  </div>
</div>
<?php
}
?>