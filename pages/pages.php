<?php
if(!empty($_GET["p"]) && isset($_GET["p"]))
{
  $page = Database_Select("POSTS", array("POST_ID" => $_GET["p"], "POST_TYPE" => "page_post"));
  if(!empty($page) && isset($page))
  {                  
    if($page["POST_SHOW"] == 2) 
    {
      if($_SESSION["USER_ID"] > 0) 
      {
        ?>
        <div class="panel panel-primary">
          <div class="panel-heading">
            <h3 class="panel-title"><?php echo $page["POST_NAME"];?></h3>
          </div>
          <div class="panel-body">
            <p>
              <?php echo $page["POST_TEXT"];?>  
            </p>
          </div>
        </div>
        <?php
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
      
    }
    else if($page["POST_SHOW"] == 1)
    {
      ?>
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title"><?php echo $page["POST_NAME"];?></h3>
        </div>
        <div class="panel-body">
          <p>
            <?php echo $page["POST_TEXT"];?>  
          </p>
        </div>
      </div>
      <?php
    }
  }
  else header("location: index.php");
}
else header("location: index.php");
?>