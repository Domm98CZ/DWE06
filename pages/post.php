<?php
if(@$_POST["delete_comment"])
{
	if(!empty($_POST["comment_id"]) && isset($_POST["comment_id"]) && is_numeric($_POST["comment_id"]) && $_SESSION["USER_ID"] > 0)
	{
		if(User_Rights($_SESSION["USER_ID"], "U")) $comment = Database_Select("POSTS", array("POST_ID" => $_POST["comment_id"], "POST_TYPE" => "comments_post"));
		else $comment = Database_Select("POSTS", array("POST_ID" => $_POST["comment_id"], "POST_TYPE" => "comments_post", "USER_ID" => $_SESSION["USER_ID"]));
	  if(!empty($comment) && isset($comment))
		{
			Database_Delete("POSTS", array("POST_ID" => $_POST["comment_id"], "POST_TYPE" => "comments_post"));
			header("location: ?page=post&post=".$comment["POST_NAME"]);	
		}
		else header("location: index.php");	
	}
	else header("location: index.php");
}

if(!empty($_GET["post"]) && isset($_GET["post"]) && is_numeric($_GET["post"]))
{
  $post_q = Database_Select("POSTS", array("POST_ID" => $_GET["post"]), "POST_NAME");
  if(!empty($post_q) && isset($post_q))
  {
    Post_ShowID($_GET["post"]);
		if(Post_CountComments($_GET["post"]) > 0 || $_SESSION["USER_ID"] > 0)
		{
			?>
			<div class="panel panel-default">
				<div class="panel-heading"><?php echo Web_GetLocale("POST_02");?></div>
				<div class="panel-body">
				<?php 
				Post_ShowAll("comments_post", $_GET["post"]); 
				Web_PostForm("comments_post", $_GET["post"]);
				?>    
				</div>
			</div>
			<?php
		}
  }
  else 
  {
    ?>
    <div class="panel panel-default">
      <div class="panel-body">
        <h1><?php echo Web_GetLocale("POST_E01");?></h1>
        <p>
          <?php echo Web_GetLocale("POST_E02");?>  
        </p>
      </div>
    </div>
    <?php
  }
}
else
{
  ?>
  <div class="panel panel-default">
    <div class="panel-body">
      <h1><?php echo Web_GetLocale("POST_E01");?></h1>
      <p>
        <?php echo Web_GetLocale("POST_E02");?>  
      </p>
    </div>
  </div>
  <?php
}
?>