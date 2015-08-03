<?php
function Forum_ShowAll($data, $what)
{     
  $forum_posts = array();
  $forum_pp = 0;   
  $link = null;
  if($what == "threads")
  {
    $forum_pp = 10;  
    $link = "?page=forum&topic=".$data."&s=";
    $count = Database_Count("FORUM_THREADS", array("TOPIC_ID" => $data));
    $forum_posts = Database_Select_All("FORUM_THREADS", array("TOPIC_ID" => $data), "array", "ORDER BY `THREAD_ID` DESC"); 
  }
  else if($what == "posts")
  {
    $forum_pp = 5;  
    $link = "?page=forum&thread=".$data."&s=";
    $count = Database_Count("FORUM_REPLIES", array("THREAD_ID" => $data));
    $forum_posts = Database_Select_All("FORUM_REPLIES", array("THREAD_ID" => $data), "array", "ORDER BY `REPLY_ID` ASC"); 
  }
  
  $page = 0;  
  $pages = $count / $forum_pp;
  $pages = round_up($pages);
     
  if(!empty($_GET["s"]) && isset($_GET["s"]) && is_numeric($_GET["s"])) 
  {
    if($_GET["s"] > $pages) $page = $pages;
    else if($_GET["s"] < 0) $page = 1;
    else $page = $_GET["s"];
  }
  else $page = 1;
    
  $start = ($page - 1)  * $forum_pp; 
  $end = min(($start + $forum_pp), $count); 
    
  $page_back = $page - 1;
  $page_next = $page + 1;
  
  $showcount = 0;
  
  if($what == "threads")
  {
    echo "<div class='table-responsive'>";
    echo "<table class='table table-striped table-bordered'>";
  
    for($i = 0;$i < count($forum_posts);$i++) 
    {
      if($i >= $start && $i < $end) 
      {
        $showcount ++;
                   
        $u = User_Data($forum_posts[$i]["USER_ID"]);
        $c = Database_Count("FORUM_REPLIES", array("THREAD_ID" => $forum_posts[$i]["THREAD_ID"]));
        echo "<tr>";
        echo "<td width='70%'>";
        echo "<div class='media'>";
        echo "<div class='media-body'>";
        echo "<h4 class='media-heading'><a href='?page=plugin&plugin=forum&thread=".$forum_posts[$i]["THREAD_ID"]."'>".$forum_posts[$i]["THREAD_NAME"]."</a></h4>";
        echo Plugin_GetLocale("forum", "FORUM_07")." <a href='?page=profile&user=".$u["USER_NAME"]."'>".$u["USER_DISPLAY_NAME"]."</a>, ".ShowTime($forum_posts[$i]["THREAD_DATE"])."";
        echo "</div>";
        echo "</div>";
        echo "</td>";
        echo "<td width='10%' style='text-align:center;'>".$c."<br>".Plugin_GetLocale("forum", "FORUM_04")."</td>";
        echo "<td width='20%'>";
        
        echo "<div class='media'>";
        if($c > 0)
        {
          $replies = Database_Select_All("FORUM_REPLIES", array("THREAD_ID" => $forum_posts[$i]["THREAD_ID"]), "array", "ORDER BY `REPLY_ID` DESC");
          $u2 = User_Data($replies[0]["USER_ID"]); 
          
          echo "<div class='media-left'>";
          echo "<a href='?page=profile&user=".$u2["USER_NAME"]."'><img class='media-object' src='".$u2["USER_AVATAR"]."' alt='".$u2["USER_DISPLAY_NAME"]."' width='48px' height='48px'></a>";
          echo "</div>";
          echo "<div class='media-body'>";
        
          echo "<h4 class='media-heading'><a href='?page=profile&user=".$u2["USER_NAME"]."'>".$u2["USER_DISPLAY_NAME"]."</a></h4>";               
          echo ShowTime($replies[0]["REPLY_DATE"]);
        }
        else
        {
          echo "<div class='media-body'>";
          echo "<h4 class='media-heading'>---</h4>";
          echo Plugin_GetLocale("forum", "FORUM_09");
        }
        echo "</div>";
        echo "</div>";
        echo "</td>";
        echo "</tr>";
      }
    }  
    if($showcount == 0) echo "<tr><td colspan='3'><center>".Plugin_GetLocale("forum", "FORUM_06")."</center></td></tr>";

    if($_SESSION["USER_ID"] > 0) echo "<tr><td colspan='3' align='right'><a href='?page=plugin&plugin=forum&topic=".$_GET["topic"]."&thread=new' class='btn btn-primary'>".Plugin_GetLocale("forum", "FORUM_13")."</a></td></tr>";
    echo "</table>";
    echo "</div>"; 
  }
  else if($what == "posts")
  {
    if(empty($_GET["s"]) || !isset($_GET["s"]) || $_GET["s"] < 1) 
    {
      $thread = Database_Select("FORUM_THREADS", array("THREAD_ID" => $data));
      $u = User_Data($thread["USER_ID"]);
      echo "<div class='panel panel-primary'>";
      echo "<div class='panel-heading'>";
      echo "<h3 class='panel-title'>".$thread["THREAD_NAME"]."</h3>";
      echo "</div>";
      echo "<div class='panel-body'>";
      echo "<div class='row'>";
      echo "<div class='col-sm-3 col-md-2'>"; 
      echo "<center><a href='?page=profile&user=".$u["USER_NAME"]."'><img src='".$u["USER_AVATAR"]."' alt='".$u["USER_DISPLAY_NAME"]."' class='img-rounded' width='100px' height='100px'></a></center>";
      echo "<hr>";
      echo "<a href='?page=profile&user=".$u["USER_NAME"]."' class='btn btn-primary btn-block'>".$u["USER_DISPLAY_NAME"]."</a>";   
      echo "<ul class='list-unstyled'>";
      echo "<li>".Plugin_GetLocale("forum", "FORUM_10").": <span class='label label-default'>".ShowTime($thread["THREAD_DATE"])."</span></li>";
      echo "<li>".Plugin_GetLocale("forum", "FORUM_11").": <span class='label label-primary'>".Database_Count("FORUM_THREADS", array("USER_ID" => $u["USER_ID"]))."</span></li>";
      echo "<li>".Plugin_GetLocale("forum", "FORUM_12").": <span class='label label-success'>".Database_Count("FORUM_REPLIES", array("USER_ID" => $u["USER_ID"]))."</span></li>";
      echo "</ul>";
      echo "</div>"; 
      echo "<div class='col-sm-9 col-md-10'>"; 
      echo StrMagic($thread["THREAD_CONTENT"]);
      echo "</div>"; 
      echo "</div>";
      echo "</div>";
      echo "</div>";  
    }
      
    for($i = 0;$i < count($forum_posts);$i++) 
    {
      if($i >= $start && $i < $end) 
      {   
        $u2 = User_Data($forum_posts[$i]["USER_ID"]); 
        echo "<div class='panel panel-primary'>";
        echo "<div class='panel-body'>";
        echo "<div class='row'>";
        echo "<div class='col-sm-3 col-md-2'>"; 
        echo "<center><img src='".$u2["USER_AVATAR"]."' alt='".$u2["USER_DISPLAY_NAME"]."' class='img-rounded' width='100px' height='100px'></center>";
        echo "<hr>";
        echo "<a href='?page=profile&user=".$u2["USER_NAME"]."' class='btn btn-primary btn-block'>".$u2["USER_DISPLAY_NAME"]."</a>";   
        echo "<ul class='list-unstyled'>";
        echo "<li>".Plugin_GetLocale("forum", "FORUM_21").": <span class='label label-default'>".ShowTime($forum_posts[$i]["REPLY_DATE"])."</span></li>";
        echo "<li>".Plugin_GetLocale("forum", "FORUM_11").": <span class='label label-primary'>".Database_Count("FORUM_THREADS", array("USER_ID" => $u2["USER_ID"]))."</span></li>";
        echo "<li>".Plugin_GetLocale("forum", "FORUM_12").": <span class='label label-success'>".Database_Count("FORUM_REPLIES", array("USER_ID" => $u2["USER_ID"]))."</span></li>";
        echo "</ul>";
        echo "</div>"; 
        echo "<div class='col-sm-9 col-md-10'>"; 
        echo StrMagic($forum_posts[$i]["REPLY_TEXT"]);
        echo "</div>"; 
        echo "</div>";
        echo "</div>"; 
        echo "</div>";
      }
    }       
  }

  
  if($pages > 1)
  {
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

function Forum_ShowPath($path, $data = null)
{
  $string = null;
  $string .= "<ol class='breadcrumb'>";
  if($path == "none") $string .= "<li><a class='active'>".Web_GetOption("NAME")." - ".Plugin_GetLocale("forum", "FORUM_01")."</a></li>";  
  else if($path == "category") 
  {
    $cat_data = Database_Select("FORUM_CATS", array("CAT_ID" => $data));
    if($cat_data > 0)
    {
      $string .= "<li><a href='?page=plugin&plugin=forum'>".Web_GetOption("NAME")." - ".Plugin_GetLocale("forum", "FORUM_01")."</a></li>";
      $string .= "<li><a class='active'>".$cat_data["CAT_NAME"]."</a></li>"; 
    }
    else header("location: ?page=plugin&plugin=forum");
  }
  else if($path == "topic")
  {
    $topic_data = Database_Select("FORUM_TOPICS", array("TOPIC_ID" => $data));
    if($topic_data > 0)
    {
      $string .= "<li><a href='?page=plugin&plugin=forum'>".Web_GetOption("NAME")." - ".Plugin_GetLocale("forum", "FORUM_01")."</a></li>";
      $string .= "<li><a href='?page=plugin&plugin=forum&category=".$topic_data["CAT_ID"]."'>".Forum_CatName($topic_data["CAT_ID"])."</a></li>";   
      $string .= "<li><a class='active'>".$topic_data["TOPIC_NAME"]."</a></li>"; 
    }
    else header("location: ?page=plugin&plugin=forum");
  } 
  else if($path == "thread")
  {
    $thread_data = Database_Select("FORUM_THREADS", array("THREAD_ID" => $data));
    if($thread_data > 0)
    {
      $cat_id = Database_Select("FORUM_TOPICS", array("TOPIC_ID" => $thread_data["TOPIC_ID"]), "CAT_ID");
      $string .= "<li><a href='?page=plugin&plugin=forum'>".Web_GetOption("NAME")." - ".Plugin_GetLocale("forum", "FORUM_01")."</a></li>";
      $string .= "<li><a href='?page=plugin&plugin=forum&category=".$cat_id."'>".Forum_CatName($cat_id)."</a></li>";   
      $string .= "<li><a href='?page=plugin&plugin=forum&topic=".$thread_data["TOPIC_ID"]."'>".Forum_TopicName($thread_data["TOPIC_ID"])."</a></li>";
      $string .= "<li><a class='active'>".Forum_ThreadName($thread_data["THREAD_ID"])."</a></li>"; 
    }
    else header("location: ?page=plugin&plugin=forum");
  } 
  else if($path == "thread_new")
  {
    $topic_data = Database_Select("FORUM_TOPICS", array("TOPIC_ID" => $data));
    if($topic_data > 0)
    {
      $cat_id = Database_Select("FORUM_TOPICS", array("TOPIC_ID" => $thread_data["TOPIC_ID"]), "CAT_ID");
      $string .= "<li><a href='?page=plugin&plugin=forum'>".Web_GetOption("NAME")." - ".Plugin_GetLocale("forum", "FORUM_01")."</a></li>";
      $string .= "<li><a href='?page=plugin&plugin=forum&category=".$topic_data["CAT_ID"]."'>".Forum_CatName($topic_data["CAT_ID"])."</a></li>";   
      $string .= "<li><a href='?page=plugin&plugin=forum&topic=".$topic_data["TOPIC_ID"]."'>".$topic_data["TOPIC_NAME"]."</a></li>"; 
      $string .= "<li><a class='active'>".Plugin_GetLocale("forum", "FORUM_05")."</a></li>"; 
    }
    else header("location: ?page=plugin&plugin=forum");
  }  
  $string .= "</ol>";
  echo $string;
}

function Forum_CatName($category_id)
{
  return Database_Select("FORUM_CATS", array("CAT_ID" => $category_id), "CAT_NAME");
}

function Forum_ThreadName($thead_id)
{
  return Database_Select("FORUM_THREADS", array("THREAD_ID" => $thead_id), "THREAD_NAME");
}

function Forum_TopicName($topic_id)
{
  return Database_Select("FORUM_TOPICS", array("TOPIC_ID" => $topic_id), "TOPIC_NAME");
}

function Forum_CreateCat($data = array())
{
  Database_Insert("FORUM_CATS", $data);
  return Database_Select("FORUM_CATS", $data, "CAT_ID");
}

function Forum_CreateReply($data = array())
{
  Database_Insert("FORUM_REPLIES", $data);
  return Database_Select("FORUM_REPLIES", $data, "REPLY_ID");
}

function Forum_CreateTopic($data = array())
{
  Database_Insert("FORUM_TOPICS", $data);
  return Database_Select("FORUM_TOPICS", $data, "TOPIC_ID");
}

function Forum_CreateThread($data = array())
{
  Database_Insert("FORUM_THREADS", $data);
  return Database_Select("FORUM_THREADS", $data, "THREAD_ID");
}

function Forum_ShowCats()
{
  $cats = Database_Select_All("FORUM_CATS", array("NONE" => "NONE"), "CAT_ID", "ORDER BY `CAT_ID` ASC");
  for($i = 0;$i < count($cats);$i++) 
  {
    Forum_ShowCat($cats[$i]["CAT_ID"]);  
  }
}

function Forum_ShowCat($category_id)
{
  $string = null;
  $cat_data = Database_Select("FORUM_CATS", array("CAT_ID" => $category_id));
  if($cat_data > 0)
  {
    ?>
    <div class='panel panel-<?php echo $cat_data["CAT_COLOR"];?>'>
      <div class='panel-heading'>
        <h3 class='panel-title'><a href="?page=plugin&plugin=forum&category=<?php echo $cat_data["CAT_ID"];?>"><?php echo $cat_data["CAT_NAME"];?></a></h3>
      </div>
      <div class='panel-body'>
        <p><?php echo $cat_data["CAT_INFO"];?></p>
        <div class='table-responsive'>
          <table class='table table-striped table-bordered'>
          <?php
          $topic = Database_Select_All("FORUM_TOPICS", array("CAT_ID" => $category_id), "TOPIC_ID", "ORDER BY `TOPIC_ID` ASC");
          for($i = 0;$i < count($topic);$i++) 
          {
            Forum_ShowTopicInCat($topic[$i]["TOPIC_ID"]);  
          }
          ?>
          </table>
        </div>
      </div>
    </div>
    <?php
  }
  else echo "Error - Category ".$category_id." doesn't exists.";
}

function Forum_ShowTopicInCat($topic_id)
{
  $str = null;
  $topic_data = Database_Select("FORUM_TOPICS", array("TOPIC_ID" => $topic_id));
  if($topic_data > 0)
  {
    ?>
    <tr>
      <td width="80%">
        <div class='media'>
          <div class='media-left'>
            <a href='?page=plugin&plugin=forum&topic=<?php echo $topic_data["TOPIC_ID"];?>'><img class='media-object' src='<?php echo $topic_data["TOPIC_IMG"];?>' alt='<?php echo $topic_data["TOPIC_NAME"];?>' width='48px' height='48px'></a>
          </div>
          <div class='media-body'>
            <a href='?page=plugin&plugin=forum&topic=<?php echo $topic_data["TOPIC_ID"];?>'><h4 class='media-heading'><?php echo $topic_data["TOPIC_NAME"];?></h4></a>
            <p><?php echo $topic_data["TOPIC_INFO"];?></p>
          </div>
        </div>
      </td>
      <td style='text-align:center;' width="10%">
        <?php
        echo Database_Count("FORUM_THREADS", array("TOPIC_ID" => $topic_id));
        echo "<br>".Plugin_GetLocale("forum", "FORUM_02");
        ?>
      </td>
      <td style='text-align:center;' width="10%">
        <?php
        $count = 0;
        $topics_id = Database_Select_All("FORUM_TOPICS", array("CAT_ID" => $topic_data["CAT_ID"]), "TOPIC_ID");
        for($y = 0;$y < count($topics_id);$y ++)
        {
          $threads_id = Database_Select_All("FORUM_THREADS", array("TOPIC_ID" => $topics_id[$y]["TOPIC_ID"]), "THREAD_ID"); 
          for($i = 0;$i < count($threads_id);$i ++)
          {
            $count_this = Database_Count("FORUM_REPLIES", array("THREAD_ID" => $threads_id[$i]["THREAD_ID"]));
            $count = $count + $count_this; 
          }
        }
        echo $count;
        echo "<br>".Plugin_GetLocale("forum", "FORUM_04");
        ?>
      </td>
    </tr>
    <?php
  }
  else echo "Error - Topic ".$topic." doesnt' exists.";
}
?>