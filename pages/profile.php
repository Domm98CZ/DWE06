<?php
$user_id = null;
if(!empty($_GET["user"]) && isset($_GET["user"]) && strlen($_GET["user"]) > 2) 
{
  $user_id = User_ID($_GET["user"]);  
}
else if($_SESSION["USER_ID"] > 0) $user_id = $_SESSION["USER_ID"];
else $user_id = null;

if(!empty($user_id))
{
  ?>
  <div class="panel panel-primary">
    <div class="panel-heading">
      <h3 class="panel-title"><?php echo Web_GetLocale("PROFILE_01")." - ".User_Data($user_id, "USER_DISPLAY_NAME");?></h3>
    </div>
    <div class="panel-body">
      <div class="row">
        <div class="col-md-3 col-lg-3" align="center">
          <img width="200px" height="200px" alt="<?php echo User_Data($user_id, "USER_DISPLAY_NAME");?>" src="<?php echo User_Data($user_id, "USER_AVATAR");?>" class="img-rounded img-responsive">
        </div>
        <div class=" col-md-9 col-lg-9"> 
          <table class="table table-user-information">
            <tbody>
              <tr>
                <td><?php echo Web_GetLocale("PROFILE_02");?></td>
                <td><?php echo User_Data($user_id, "USER_NAME");?></td>
              </tr>
              <tr>
                <td><?php echo Web_GetLocale("PROFILE_03");?></td>
                <td><?php echo User_Data($user_id, "USER_DISPLAY_NAME");?></td>
              </tr>
              <tr>
                <td><?php echo Web_GetLocale("PROFILE_04");?></td>
                <td><a href="mailto:<?php echo User_Data($user_id, "USER_EMAIL");?>"><?php echo User_Data($user_id, "USER_EMAIL");?></a></td>
              </tr>
              <tr>
                <td><?php echo Web_GetLocale("PROFILE_05");?></td>
                <td><?php echo ShowTime(User_Data($user_id, "USER_DATE_R"));?></td>
              </tr>
              <tr>
                <td><?php echo Web_GetLocale("PROFILE_06");?></td>
                <td><?php echo ShowTime(User_Data($user_id, "USER_DATE_L"));?></td>
              </tr>
              <tr>
                <td><?php echo Web_GetLocale("PROFILE_07");?></td>
                <td><?php echo ShowTime(User_Data($user_id, "USER_DATE_A"));?></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <?php
    if($user_id != $_SESSION["USER_ID"])
    {
      ?>
      <div class="panel-footer">
        <a href="?page=messages&action=new&user=<?php echo User_Data($user_id, "USER_NAME");?>" type="button" class="btn btn-sm btn-primary"><i class="fa fa-envelope"></i> <?php echo Web_GetLocale("PROFILE_08");?></a> 
        <a href="?page=report&user=<?php echo User_Data($user_id, "USER_NAME");?>" type="button" class="btn btn-sm btn-danger"><i class="fa fa-flag"></i> <?php echo Web_GetLocale("PROFILE_12");?></a>
      </div>
      <?php
    }
    ?>
  </div>
  <?php
  $c = Post_CountUser($user_id);
  if($c > 0 || $user_id == $_SESSION["USER_ID"])
  {
    ?>
    <div class="panel panel-primary">
      <div class="panel-body">
      <?php
      if($user_id == $_SESSION["USER_ID"]) Web_PostForm("status_post", $user_id, "PROFILE_09", "PROFILE_10");
      Post_ShowAll("status_post", $user_id); 
      ?>
      </div>
    </div>
    <?php 
		if(@$_POST["delete_status"])
		{
			if(!empty($_POST["status_id"]) && isset($_POST["status_id"]) && is_numeric($_POST["status_id"]) && $_SESSION["USER_ID"] > 0)
			{
				if(User_Rights($_SESSION["USER_ID"], "V")) $status = Database_Select("POSTS", array("POST_ID" => $_POST["status_id"], "POST_TYPE" => "status_post"));
				else $status = Database_Select("POSTS", array("POST_ID" => $_POST["status_id"], "POST_TYPE" => "status_post", "USER_ID" => $_SESSION["USER_ID"]));
				if(!empty($status) && isset($status))
				{
					Database_Delete("POSTS", array("POST_ID" => $_POST["status_id"], "POST_TYPE" => "status_post"));
					header("location: ?page=profile&user=".User_Name($status["USER_ID"]));	
				}
				else header("location: ?page=profile");	
			}
			else header("location: ?page=profile");
		}
  }
}
else
{
  ?>
  <div class="panel panel-default">
    <div class="panel-body">
      <h1><?php echo Web_GetLocale("PROFILE_E01");?></h1>
      <p>
        <?php echo Web_GetLocale("PROFILE_E02");?>  
      </p>
    </div>
  </div>
  <?php
}
?>