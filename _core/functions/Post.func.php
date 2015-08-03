<?php
function Post_CountComments($post_id)
{
  return Database_Count("POSTS", array("POST_NAME" => $post_id, "POST_TYPE" => "comments_post"));
}

function Post_CountUser($user_id)
{
  return Database_Count("POSTS", array("POST_TYPE" => "status_post", "POST_NAME" => $user_id, "USER_ID" => $user_id));
}

function Post_ShowAll($post_type, $id = 0)
{ 
  $count = 0;
  $post_pp = 0;          
  $link = null;
  if($post_type == "news_post")
  {
    $count = Database_Count("POSTS", array("POST_TYPE" => "news_post"));
    $post_pp = Web_GetOption("NEWS_PP");   
    $link = "?s=";
  }
  else if($post_type == "comments_post" && $id > 0)
  {
    $count = Database_Count("POSTS", array("POST_TYPE" => "comments_post", "POST_NAME" => $id));
    $post_pp = Web_GetOption("COMMENT_N_PP");   
    $link = "?page=post&post=".$id."&s=";
  }
  else if($post_type == "status_post" && $id > 0)
  {
    $count = Database_Count("POSTS", array("POST_TYPE" => "status_post", "POST_NAME" => $id));
    $post_pp = Web_GetOption("STATUS_PP");   
    $link = "?page=profile&user=".User_Name($id)."&s=";
  }
  
  $page = 0;  
  $pages = $count / $post_pp;
  $pages = round_up($pages);
     
  if(!empty($_GET["s"]) && isset($_GET["s"]) && is_numeric($_GET["s"])) 
  {
    if($_GET["s"] > $pages) $page = $pages;
    else if($_GET["s"] < 0) $page = 1;
    else $page = $_GET["s"];
  }
  else $page = 1;
    
  $start = ($page - 1)  * $post_pp; 
  $end = min(($start + $post_pp), $count); 
    
  $page_back = $page - 1;
  $page_next = $page + 1;
  
  if($post_type == "news_post") $posts = Database_Select_All("POSTS", array("POST_TYPE" => "news_post"), "POST_ID", "ORDER BY `POST_ID` DESC");
  else if($post_type == "comments_post") $posts = Database_Select_All("POSTS", array("POST_TYPE" => "comments_post", "POST_NAME" => "".$id.""), "POST_ID", "ORDER BY `POST_ID` ASC");  
  else if($post_type == "status_post") $posts = Database_Select_All("POSTS", array("POST_TYPE" => "status_post", "POST_NAME" => "".$id.""), "POST_ID", "ORDER BY `POST_ID` DESC");  

  for($i = 0;$i < count($posts);$i++) 
  {
    if($i >= $start && $i < $end) Post_ShowID($posts[$i]["POST_ID"]);   
  }
  
  if($pages > 1)
  {
    echo "<hr>";
    echo "<center>";
    echo "<ul class='pagination'>";
      
    if($page == 1 || $page == "1") echo "<li class='disabled'><a><i class='fa fa-angle-double-left'></i></a></li>";
    else echo "<li><a href='".$link."1'><i class='fa fa-angle-double-left'></i></a></li>";
      
    if($page == 1 || $page == "1") echo "<li class='disabled'><a><i class='fa fa-angle-left'></i></a></li>";
    else echo "<li><a href='".$link.$page_back."'><i class='fa fa-angle-left'></i></a></li>";
      
    for($i = 1;$i < $pages+1;$i++)
    {
      if($i == $page) echo "<li class='active'><a href='".$link.$i."'>".$i."</a></li>";
      else echo "<li><a href='".$link.$i."'>".$i."</a></li>"; 
    }
      
    if($page == $pages) echo "<li class='disabled'><a><i class='fa fa-angle-right'></i></a></li>";
    else echo "<li><a href='".$link.$page_next."'><i class='fa fa-angle-right'></i></a></li>";
      
    if($page == $pages) echo "<li class='disabled'><a><i class='fa fa-angle-double-right'></i></a></li>";
    else echo "<li><a href='".$link.$end."'><i class='fa fa-angle-double-right'></i></a></li>";
    echo "</ul>";
    echo "</center>"; 
  }
}

function Post_Create($data = array())
{ 
  Database_Insert("POSTS", $data);
  return Database_Select("POSTS", $data, "POST_ID");
}

function Post_ShowID($post_id)
{                                                                        
  $post_string = null;
  $post = Database_Select("POSTS", array("POST_ID" => $post_id));
  
  if($post["POST_SHOW"] == "1" || $post["POST_SHOW"] == 1)
  {
    if($post["POST_TYPE"] == "news_post")
    {
      $post_string .= "<div class='panel panel-primary'>\n";
      if($post["POST_NAME"] != "NONE")
      {
        $post_string .= "<div class='panel-heading'>\n";
        $post_string .= "<h3 class='panel-title'><a href='?page=post&post=".$post["POST_ID"]."'>".$post["POST_NAME"]."</a></h3>\n";
        $post_string .= "</div>";
      }
      $post_string .= "<div class='panel-body'>\n";
      $post_string .= "<div class='media'>\n";
      if($post["POST_IMG"] != "NONE")
      {
				$post_string .= "<div class='media-left'>\n";
        $post_string .= "<a href='?page=post&post=".$post["POST_ID"]."'>\n";
        $post_string .= "<img class='media-object' src='".$post["POST_IMG"]."'>\n";
        $post_string .= "</a>\n";
				$post_string .= "</div>\n";
      }
      $post_string .= "<div class='media-body'>\n";
      $post_string .= "<p>".StrMagic($post["POST_TEXT"])."</p>\n";
      $post_string .= "<div style='float:right;text-align:right;'>";
      $post_string .= "<div class='btn-group' role='group'>";
      $post_string .= "<a href='?page=profile&user=".User_Data($post["USER_ID"], "USER_NAME")."' class='btn btn-sm btn-primary'><i class='fa fa-user'></i> ".Web_GetLocale("POST_03")." ".User_Data($post["USER_ID"], "USER_DISPLAY_NAME")."</a>";
      $post_string .= "<a class='btn btn-sm btn-primary'><i class='fa fa-date'></i> ".Web_GetLocale("POST_04")." ".ShowTime($post["POST_DATE"])."</a>";
      if($_GET["page"] != "post") 
      {
        $post_string .= "<a href='?page=post&post=".$post["POST_ID"]."' class='btn btn-sm btn-primary'><i class='fa fa-comments'></i> ".Web_GetLocale("POST_02")." ";
        if(Post_CountComments($post["POST_ID"]) > 0) $post_string .= " <span class='badge'>".Post_CountComments($post["POST_ID"])."</span>";
        $post_string .= "</a>";
      }
      $post_string .= "</div>";
      $post_string .= "</div>";
      $post_string .= "</div>\n";
      $post_string .= "</div>\n";
      $post_string .= "</div>\n";
      $post_string .= "</div>\n";
    }
    else if($post["POST_TYPE"] == "comments_post")
    {
      $post_string .= "<div class='media'>\n";
      $post_string .= "<div class='media-left'>\n";
      $post_string .= "<a href='?page=profile&user=".User_Data($post["USER_ID"], "USER_NAME")."'><img class='media-object' width='64px' height='64px' src='".User_Data($post["USER_ID"], "USER_AVATAR")."' alt='".User_Data($post["USER_ID"], "USER_DISPLAY_NAME")."'></a>\n";
      $post_string .= "</div>\n";
      $post_string .= "<div class='media-body'>\n";
      $post_string .= "<h4 class='media-heading'>\n";
      $post_string .= "<a href='?page=profile&user=".User_Data($post["USER_ID"], "USER_NAME")."'>".User_Data($post["USER_ID"], "USER_DISPLAY_NAME")."</a> ".Web_GetLocale("COMM_03")."\n";
      $post_string .= "</h4>\n";
			if($post["USER_ID"] == $_SESSION["USER_ID"] && $_SESSION["USER_ID"] > 0 || User_Rights($_SESSION["USER_ID"], "U") && $_SESSION["USER_ID"] > 0)
			{
				$post_string .= "<form method='post' action='?page=post'>";
				$post_string .= "<input type='hidden' name='comment_id' value='".$post["POST_ID"]."'>";
				$post_string .= "<input type='submit' name='delete_comment' class='btn btn-danger btn-xs' value='".Web_GetLocale("USER_07")."'>";
				$post_string .= "</form>";
			}
      $post_string .= "<small>".ShowTime($post["POST_DATE"])."</small>\n";
      $post_string .= "<p>".StrMagic($post["POST_TEXT"])."</p>\n";
      $post_string .= "</div>\n";
      $post_string .= "</div>\n";
    }
    else if($post["POST_TYPE"] == "status_post")
    {
      $post_string .= "<div class='media'>\n";
      $post_string .= "<div class='media-left'>\n";
      $post_string .= "<a href='?page=profile&user=".User_Data($post["USER_ID"], "USER_NAME")."'><img class='media-object' width='64px' height='64px' src='".User_Data($post["USER_ID"], "USER_AVATAR")."' alt='".User_Data($post["USER_ID"], "USER_DISPLAY_NAME")."'></a>\n";
      $post_string .= "</div>\n";
      $post_string .= "<div class='media-body'>\n";
      $post_string .= "<h4 class='media-heading'>\n";
      $post_string .= "<a href='?page=profile&user=".User_Data($post["USER_ID"], "USER_NAME")."'>".User_Data($post["USER_ID"], "USER_DISPLAY_NAME")."</a> ".Web_GetLocale("PROFILE_11")."\n";
			$post_string .= "</h4>\n";
			if($post["USER_ID"] == $_SESSION["USER_ID"] && $_SESSION["USER_ID"] > 0 || User_Rights($_SESSION["USER_ID"], "V") && $_SESSION["USER_ID"] > 0)
			{
				$post_string .= "<form method='post' action='?page=profile'>";
				$post_string .= "<input type='hidden' name='status_id' value='".$post["POST_ID"]."'>";
				$post_string .= "<input type='submit' name='delete_status' class='btn btn-danger btn-xs' value='".Web_GetLocale("USER_06")."'>";
				$post_string .= "</form>";
			}
			$post_string .= "<small>".ShowTime($post["POST_DATE"])."</small>\n";
      $post_string .= "<p>".StrMagic($post["POST_TEXT"])."</p>\n";
      $post_string .= "</div>\n";
      $post_string .= "</div>\n";      
    }
    echo $post_string;
  }
}
?>