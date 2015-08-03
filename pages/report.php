<?php
if($_SESSION["USER_ID"] > 0)
{
  if(!empty($_GET["user"]) && isset($_GET["user"]) && strlen($_GET["user"]) > 2)
  {
    $user = User_Data(User_ID($_GET["user"]));
    if($user)
    {
      ?>
      <div class="panel panel-default">
        <div class="panel-body">
          <h1><?php echo Web_GetLocale("REPORT_01");?> <b><?php echo $_GET["user"];?></b></h1>
          <p>
            <?php echo Web_GetLocale("REPORT_01");?>  
          </p>
          <form method="post">
            <div class="form-group col-lg-12">
              <label><?php echo Web_GetLocale("PROFILE_02");?></label>
              <input type="text" class="form-control" name="report_user" value="<?php echo $_GET["user"];?>" readonly>
            </div>
            <div class="form-group col-lg-12">
              <label><?php echo Web_GetLocale("REPORT_03");?></label>
              <textarea class="form-control" name="report_content" rows="5" style="resize: vertical; overflow: auto; margin-top: 0px; margin-bottom: 0px;" placeholder="<?php echo Web_GetLocale("REPORT_04");?>"></textarea>
            </div>
            <input type="submit" name="create_report" class="btn btn-danger" value="<?php echo Web_GetLocale("PROFILE_12");?>">
            <a href="?page=profile&user=<?php echo $_GET["user"];?>" class="btn btn-warning">Nenahlašovat uživatele <?php echo $_GET["user"];?></a>
          </form>
          <?php
          if(@$_POST["create_report"])
          {
            if(!empty($_POST["report_content"]))
            {
              Database_Insert("REPORTS",
                array(
                "REPORT_USER_ID" => $user["USER_ID"],
                "USER_ID" => $_SESSION["USER_ID"],
                "REPORT_CONTENT" => $_POST["report_content"],
                "REPORT_DATE" => time(),
                "REPORT_SHOW" => "NONE",
                "REPORT_ADMIN" => "NONE"
              ));
              echo ShowNotification("success", Web_GetLocale("REPORT_05"));
            }
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
else header("location: index.php");
?>