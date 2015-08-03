<?php
if($_SESSION["USER_ID"] > 0) header("location: index.php");
else 
{
  if(!empty($_GET["user"]) && !empty($_GET["key"])) 
  {
    $user = Database_Select("USER", array("USER_NAME" => $_GET["user"]));
    if($user != "N/A")
    {  
      $key = Database_Select("KEYS", array("USER_ID" => $user["USER_ID"], "KEY_TYPE" => "PASSWORD"));
      if($key != "N/A")
      {
        ?>
        <div class="panel panel-default">
          <div class="panel-body">  
            <h1><?php echo Web_GetLocale("PASS_01");?></h1>
            <section class="container">
              <div class="container-page">
                <p><?php echo Web_GetLocale("PASS_07");?></p>
                
                <form method="post">
                  <div class="form-group col-lg-12">
                    <label><?php echo Web_GetLocale("REGISTER_04");?></label>
                    <input type="password" name="user_pass_01" class="form-control">
                  </div>
                  <div class="form-group col-lg-12">
                    <label><?php echo Web_GetLocale("REGISTER_05");?></label>
                    <input type="password" name="user_pass_02" class="form-control">
                  </div>
                  <div style="float:right;text-align:right;">
                    <input type="submit" value="<?php echo Web_GetLocale("PASS_04");?>" name="set_pass" class="btn btn-primary">
                  </div>
                </form>
        
              </div>
            </section>
            <br>
            <?php
            if(@$_POST["set_pass"])
            {
              if(!empty($_POST["user_pass_01"]) && !empty($_POST["user_pass_02"]))
              {
                if($_POST["user_pass_01"] == $_POST["user_pass_02"])
                {
                  Database_Update("USER", array("USER_SALT" => User_GeneratePasswordSalt()), array("USER_ID" => $user["USER_ID"]));
                  Database_Update("USER", array("USER_PASS" => User_GeneratePassword($user["USER_ID"], $_POST["user_pass_01"])), array("USER_ID" => $user["USER_ID"]));
                  Database_Delete("KEYS", array("KEY" => $_GET["key"]));
                  Message_Create(
                    array(
                      "MESSAGE_TOPIC" => Web_GetLocale("PASS_M01"),
                      "MESSAGE_TEXT" => Web_GetLocale("PASS_M02"),
                      "MESSAGE_TYPE" => "ADMIN",
                      "SEND_USER_ID" => 1,
                      "READ_USER_ID" => $user["USER_ID"],
                      "MESSAGE_DATE" => time(),
                      "MESSAGE_SHOWED" => "NONE"
                    )
                  );
                  header("location: ?page=login");
                }
                else ShowNotification("warning", Web_GetLocale("REGISTER_E03"));
              }
              else echo ShowNotification("warning", Web_GetLocale("ADMIN_E03"));
            }
            ?>
          </div>
        </div>
        <?php
      }
      else header("location: index.php");
    }
    else header("location: index.php");
  }
  else
  {
    ?>
    <div class="panel panel-default">
      <div class="panel-body">  
        <h1><?php echo Web_GetLocale("PASS_01");?></h1>
        <section class="container">
          <div class="container-page">
            <p><?php echo Web_GetLocale("PASS_02");?></p>
            
            <form method="post">
              <div class="form-group col-lg-12">
                <label><?php echo Web_GetLocale("REGISTER_02");?></label>
                <input type="text" name="user_name" class="form-control">
              </div>
              
              <div class="form-group col-lg-12">
                <strong><?php echo Web_GetLocale("PASS_03");?></strong>
              </div>
              
              <div class="form-group col-lg-12">
                <label><?php echo Web_GetLocale("REGISTER_06");?></label>
                <input type="text" name="user_email" class="form-control">
              </div>
            
              <div style="float:right;text-align:right;">
                <p class="text-primary"><?php echo Web_GetLocale("PASS_05");?></p>
                <input type="submit" value="<?php echo Web_GetLocale("PASS_04");?>" name="send_pass" class="btn btn-primary">
              </div>
            </form>
          </div>
        </section>
        <br>
        <?php
        if(@$_POST["send_pass"])
        {
          if(!empty($_POST["user_name"]) || !empty($_POST["user_email"]))
          {
            $userbyname = Database_Select("USER", array("USER_NAME" => $_POST["user_name"]));
            $userbyemail = Database_Select("USER", array("USER_EMAIL" => $_POST["user_email"]));
            if($userbyname != "N/A" && !empty($_POST["user_name"]))
            {    
              $user = $userbyname;
              $key = User_GenerateKey();
              $link = "http://".Web_GetOption("URL")."/?page=password&user=".$user["USER_NAME"]."&key=".$key;
              User_CreateKey($user["USER_ID"], $key, "PASSWORD");
              
              Web_Email($user["USER_EMAIL"], Web_GetOption("NAME")." - ".Web_GetLocale("REGISTER_01"), "
              <h1>".Web_GetOption("NAME")." - ".Web_GetLocale("PASS_01")."</h1>
                 <p>
                  ".Web_GetLocale("PASS_06")."
                  <a href='".$link."'>".$link."</a><br>
                  <br>
                  <b>".Web_GetLocale("REGISTER_02").":</b> ".$user["USER_NAME"]."<br>
                  <b>".Web_GetLocale("REGISTER_06").":</b> ".$user["USER_EMAIL"]."<br>
                  ".Web_GetLocale("EMAIL_02")."
                 </p>
              ");
              ShowNotification("success", Web_GetLocale("PASS_EOK"));
            }
            else if($userbyemail != "N/A" && !empty($_POST["user_email"]) && filter_var($_POST["user_email"], FILTER_VALIDATE_EMAIL)) 
            {
              $user = $userbyemail;
              $key = User_GenerateKey();
              $link = "http://".Web_GetOption("URL")."/?page=password&user=".$user["USER_NAME"]."&key=".$key;
              User_CreateKey($user["USER_ID"], $key, "PASSWORD");
              
              Web_Email($user["USER_EMAIL"], Web_GetOption("NAME")." - ".Web_GetLocale("REGISTER_01"), "
              <h1>".Web_GetOption("NAME")." - ".Web_GetLocale("PASS_01")."</h1>
                 <p>
                  ".Web_GetLocale("PASS_06")."
                  <a href='".$link."'>".$link."</a><br>
                  <br>
                  <b>".Web_GetLocale("REGISTER_02").":</b> ".$user["USER_NAME"]."<br>
                  <b>".Web_GetLocale("REGISTER_06").":</b> ".$user["USER_EMAIL"]."<br>
                  ".Web_GetLocale("EMAIL_02")."
                 </p>
              ");
              ShowNotification("success", Web_GetLocale("PASS_EOK"));  
            }
            else echo ShowNotification("warning", Web_GetLocale("PASS_E02"));     
          }
          else echo ShowNotification("warning", Web_GetLocale("PASS_E01")); 
        }
        ?> 
      </div>
    </div>
    <?php
  }
}
?>