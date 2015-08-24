<?php
if(Web_GetOption("HOME_PAGE") == "news_posts") Post_ShowAll("news_post");
else 
{
  $p = explode("#", Web_GetOption("HOME_PAGE")); 
  if($p[0] == "page_post" && is_numeric($p[1]))
  {
    $page = Database_Select("POSTS", array("POST_ID" => $p[1], "POST_TYPE" => "page_post"));
    if(!empty($page) && isset($page))
    {
      ?>
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title"><?php echo $page["POST_NAME"];?></h3>
        </div>
        <div class="panel-body">
          <p><?php echo $page["POST_TEXT"];?></p>
        </div>
      </div>
      <?php
    }
    else
    {
      Database_Update("OPTIONS", array("OPTION_VALUE" => "news_posts"), array("OPTION_KEY" => "HOME_PAGE"));
      header("location: index.php");
    }
  }
  else 
  {
    Database_Update("OPTIONS", array("OPTION_VALUE" => "news_posts"), array("OPTION_KEY" => "HOME_PAGE"));
    header("location: index.php");
  } 
}
?>