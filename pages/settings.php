<?php
if($_SESSION["USER_ID"] > 0)
{
  ?>
  <div class="panel panel-primary">
    <div class="panel-heading">
      <h3 class="panel-title"><?php echo Web_GetLocale("SETTINGS_01");?></h3>
    </div>
    <div class="panel-body">
    
      <section>

    			<div class="col-md-12">		  
    				<div class="panel panel-default">
    					<div class="panel-body">
              
              <ul class='nav nav-tabs' role='tablist'>  
                <li<?php echo (empty($_GET["s"])) ? " class='active'" : "";?> role='presentation'><a href='?page=settings'><?php echo Web_GetLocale("SETTINGS_T1");?></a></li>
                <li<?php echo ($_GET["s"] == "pass") ? " class='active'" : "";?> role='presentation'><a href='?page=settings&s=pass'><?php echo Web_GetLocale("SETTINGS_T2");?></a></li>
						    <li<?php echo ($_GET["s"] == "avatar") ? " class='active'" : "";?> role='presentation'><a href='?page=settings&s=avatar'><?php echo Web_GetLocale("SETTINGS_T3");?></a></li>
              </ul>
              
              <br />
             
              <?php
              if(!empty($_GET["s"]) && isset($_GET["s"]) && $_GET["s"] == "pass")
              {
                ?>
                <form method="post">
                  <div class="form-group col-lg-12">
        						<label><?php echo Web_GetLocale("SETTINGS_06");?></label>
        						<input type="password" class="form-control" name="user_pass">
      						</div>
      						<div class="form-group col-lg-12">
            						<label><?php echo Web_GetLocale("SETTINGS_07");?></label>
            						<input type="password" class="form-control" name="new_pass_01">
      						</div>	
      
      						<div class="form-group col-lg-12">
      							<label><?php echo Web_GetLocale("SETTINGS_08");?></label>
      							<input type="password" class="form-control" name="new_pass_02">
      						</div>
                  
                  <input type="submit" class="btn btn-primary btn-block" name="update_pass" value="<?php echo Web_GetLocale("SETTINGS_05");?>">
                </form>
                <?php
                if(@$_POST["update_pass"])
                {
                  if(!empty($_POST["user_pass"]) && !empty($_POST["new_pass_01"]) && !empty($_POST["new_pass_02"]))
                  {
                    if($_POST["new_pass_01"] == $_POST["new_pass_02"])
                    {
                      $data = Database_Select("USER", array("USER_ID" => $_SESSION["USER_ID"], "USER_PASS" => User_GeneratePassword($_SESSION["USER_ID"], $_POST["user_pass"]))); 
                      if(!empty($data) && isset($data))
                      {
                        User_CreatePasswordSalt($_SESSION["USER_ID"]);
                        Database_Update("USER", array("USER_PASS" => User_GeneratePassword($_SESSION["USER_ID"], $_POST["new_pass_01"])), array("USER_ID" => $_SESSION["USER_ID"])); 
                        ShowNotification("success", Web_GetLocale("SETTINGS_EOK"));    
                      }
                    }
                    else ShowNotification("warning", Web_GetLocale("SETTINGS_E04"));  
                  }
                  else ShowNotification("warning", Web_GetLocale("SETTINGS_E01"));  
                }
              }
              else if(!empty($_GET["s"]) && isset($_GET["s"]) && $_GET["s"] == "avatar")
              {
                ?>
                <div class="row">
                  <div class="col-md-3 col-lg-3" align="center">
                    <h3>Aktuální</h3>
                    <img width="129px" height="129px" alt="<?php echo User_Data($_SESSION["USER_ID"], "USER_DISPLAY_NAME");?>" src="<?php echo User_Data($_SESSION["USER_ID"], "USER_AVATAR");?>" class="img-rounded img-responsive">
                    <form method="post">
                      <input type="submit" class="btn btn-danger" name="avatar_del" value="<?php echo Web_GetLocale("SETTINGS_09");?>">
                    </form>
                  </div>
                  <div class="col-md-9 col-lg-9"> 
                    <h3>Nastavit nový</h3>
                    <form method="post" enctype="multipart/form-data">
                      <div class="form-group col-lg-12">
          							<label><?php echo Web_GetLocale("SETTINGS_10");?></label>
          							<input type="text" class="form-control" name="avatar_url">
          						</div>  
                      
                      <div class="form-group col-lg-12">
          							<label><?php echo Web_GetLocale("SETTINGS_11");?></label>
          						  <input type="file" class="form-control" name="avatar_file" id="avatar_file">
          						</div>  
                      <input type="submit" class="btn btn-primary btn-block" name="update_avatar" value="<?php echo Web_GetLocale("SETTINGS_05");?>">
                    </form>
                  </div>
                </div>
                <?php
                if(@$_POST["avatar_del"])
                {
                  Database_Update("USER", array("USER_AVATAR" => "assets/images/noav.png"), array("USER_ID" => $_SESSION["USER_ID"]));
                  header("location: ?page=settings&s=avatar");
                }
                if(@$_POST["update_avatar"])
                {               
                  if(!empty($_POST["avatar_url"]))
                  {
                    //URL
                    if(filter_var($_POST["avatar_url"], FILTER_VALIDATE_URL)) 
                    {
                      Database_Update("USER", array("USER_AVATAR" => $_POST["avatar_url"]), array("USER_ID" => $_SESSION["USER_ID"]));
                      header("location: ?page=settings&s=avatar");   
                    }
                    else ShowNotification("warning", Web_GetLocale("SETTINGS_E05"));
                  }
                  else
                  {
                    //File
                    $avatar_dir = "uploads/avatars/";
                    $avatar_path = $avatar_dir.$_SESSION["USER_NAME"].".".pathinfo($_FILES["avatar_file"]["name"], PATHINFO_EXTENSION);
                    if (file_exists($avatar_path)) unlink($avatar_path);  
                    if ($_FILES["avatar_file"]["size"] < 10000000)  
                    {
                      if ($_FILES["avatar_file"]["error"] > 0)
                      {
                        echo "Error Code: ".$_FILES["avatar_file"]["error"]."<br />";
                      }
                      else
                      {
                        $allowedTypes = array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF);
                        $detectedType = exif_imagetype($_FILES['avatar_file']['tmp_name']);
                        $typeok = in_array($detectedType, $allowedTypes);
                        if($typeok)
                        {
                          move_uploaded_file($_FILES["avatar_file"]["tmp_name"], $avatar_path);
                          Database_Update("USER", array("USER_AVATAR" => $avatar_path), array("USER_ID" => $_SESSION["USER_ID"]));
                          header("location: ?page=settings&s=avatar");
                        }
                      }
                    }      
                  }
                }
              }
              else
              {
                ?> 
                <form method="post">
                  <div class="form-group col-lg-12">
          					<label><?php echo Web_GetLocale("SETTINGS_02");?></label>
          					<input type="text" class="form-control" name="user_name" value="<?php echo User_Data($_SESSION["USER_ID"], "USER_NAME");?>" disabled>
          				</div>
    						
    					    <div class="form-group col-lg-12">
          				  <label><?php echo Web_GetLocale("SETTINGS_03");?></label>
          					<input type="text" class="form-control" name="user_display_name" value="<?php echo User_Data($_SESSION["USER_ID"], "USER_DISPLAY_NAME");?>">
          				</div>	
    						
    					    <div class="form-group col-lg-12">
          					<label><?php echo Web_GetLocale("SETTINGS_04");?></label>
          					<input type="text" class="form-control" name="user_email" value="<?php echo User_Data($_SESSION["USER_ID"], "USER_EMAIL");?>">
          				</div>
                  
                  <input type="submit" class="btn btn-primary btn-block" name="update_main" value="<?php echo Web_GetLocale("SETTINGS_05");?>">
                </form>
                <?php
                if(@$_POST["update_main"])
                {
                  if(!empty($_POST["user_display_name"]) && !empty($_POST["user_email"]))
                  {
                    $email_query = Database_Select("USER", array("USER_EMAIL" => $_POST["user_email"]));
                    if($email_query == 0 || $_SESSION["USER_EMAIL"] == $_POST["user_email"])
                    {
                      if(filter_var($_POST["user_email"], FILTER_VALIDATE_EMAIL)) 
                      {
                        $display_name1 = Database_Select("USER", array("USER_DISPLAY_NAME" => $_POST["user_display_name"])); 
                        $display_name2 = Database_Select("USER", array("USER_NAME" => $_POST["user_display_name"])); 
                        if($display_name1 == 0 && $display_name2 == 0 || $_SESSION["USER_DISPLAY_NAME"] == $_POST["user_display_name"])
                        {
                          Database_Update("USER", array("USER_EMAIL" => $_POST["user_email"], "USER_DISPLAY_NAME" => $_POST["user_display_name"]), array("USER_ID" => $_SESSION["USER_ID"]));
                          ShowNotification("success", Web_GetLocale("SETTINGS_EOK"));     
                        }
                        else ShowNotification("warning", Web_GetLocale("REGISTER_E08")); 
                      }
                      else ShowNotification("warning", Web_GetLocale("SETTINGS_E03"));
                    }
                    else ShowNotification("warning", Web_GetLocale("SETTINGS_E02"));  
                  }
                  else ShowNotification("warning", Web_GetLocale("SETTINGS_E01"));  
                }
              }
              ?>            
              </div>
            </div>
          </div>
      </section>   
    
    </div>
  </div>
  <?php
}
else
{
  ?>
  <div class="panel panel-default">
    <div class="panel-body">
      <h1><?php echo Web_GetLocale("USER_E01");?></h1>
      <p>
        <?php echo Web_GetLocale("USER_E02");?>  
      </p>
    </div>
  </div>
  <?php
}
?>