<?php
function Message_Count($user_id, $type = 'unread')
{
  if($type == "unread") return Database_Count("MESSAGES", array("READ_USER_ID" => $user_id, "MESSAGE_SHOWED" => "NONE"));
  else if($type == "all") return Database_Count("MESSAGES", array("READ_USER_ID" => $user_id));
}

function Message_Create($data = array())
{ 
  Database_Insert("MESSAGES", $data);
  return Database_Select("MESSAGES", $data, "MESSAGE_ID");
}

function Message_ShowList($user_id, $message_type)
{
  $messages = array();
  $messages_pp = Web_GetOption("MESSAGES_PP");   
  $link = null;
  if($message_type == "USER")
  {
    $count = Database_Count("MESSAGES", array("READ_USER_ID" => $user_id, "MESSAGE_TYPE" => "USER"));
    $messages = Database_Select_All("MESSAGES", array("READ_USER_ID" => $user_id, "MESSAGE_TYPE" => "USER"), "array", "ORDER BY `MESSAGE_ID` DESC");  
  }
  else if($message_type == "ADMIN")
  {
    $count = Database_Count("MESSAGES", array("READ_USER_ID" => $user_id, "MESSAGE_TYPE" => "ADMIN"));
    $messages = Database_Select_All("MESSAGES", array("READ_USER_ID" => $user_id, "MESSAGE_TYPE" => "ADMIN"), "array", "ORDER BY `MESSAGE_ID` DESC");  
    $link = "?page=messages&action=s_admin&s=";
  }
  else if($message_type == "ALL")
  {
    $count = Database_Count("MESSAGES", array("READ_USER_ID" => $user_id));
    $messages = Database_Select_All("MESSAGES", array("READ_USER_ID" => $user_id), "array", "ORDER BY `MESSAGE_ID` DESC"); 
    $link = "?page=messages&s=";  
  }
  else if($message_type == "UNREAD")
  {
    $count = Database_Count("MESSAGES", array("READ_USER_ID" => $user_id));
    $messages = Database_Select_All("MESSAGES", array("READ_USER_ID" => $user_id, "MESSAGE_SHOWED" => "NONE"), "array", "ORDER BY `MESSAGE_ID` DESC");
    $link = "?page=messages&action=s_unread&s=";   
  }
  else if($message_type == "SEND")
  {
    $count = Database_Count("MESSAGES", array("SEND_USER_ID" => $user_id, "MESSAGE_TYPE" => "USER"));
    $messages = Database_Select_All("MESSAGES", array("SEND_USER_ID" => $user_id, "MESSAGE_TYPE" => "USER"), "array", "ORDER BY `MESSAGE_ID` DESC");
    $link = "?page=messages&action=s_send&s=";      
  }
  
  $page = 0;  
  $pages = $count / $messages_pp;
  $pages = round_up($pages);
     
  if(!empty($_GET["s"]) && isset($_GET["s"]) && is_numeric($_GET["s"])) 
  {
    if($_GET["s"] > $pages) $page = $pages;
    else if($_GET["s"] < 0) $page = 1;
    else $page = $_GET["s"];
  }
  else $page = 1;
    
  $start = ($page - 1)  * $messages_pp; 
  $end = min(($start + $messages_pp), $count); 
    
  $page_back = $page - 1;
  $page_next = $page + 1;
  
  $showcount = 0;
  
  echo "<div class='table-responsive'>";
  echo "<table class='table table-hover'>";
  echo "<tr>"; 
  echo "<th width='15%'>".Web_GetLocale("MSG_06")."</th>"; 
  if($message_type != "SEND") echo "<th width='10%'>".Web_GetLocale("MSG_07")."</th>"; 
  else echo "<th width='10%'>".Web_GetLocale("MSG_21")."</th>"; 
  echo "<th width='15%'>".Web_GetLocale("MSG_08")."</th>"; 
  echo "<th width='40%'>".Web_GetLocale("MSG_09")."</th>"; 
  echo "<th width='10%'>#</th>"; 
  echo "</tr>"; 
            

  for($i = 0;$i < count($messages);$i++) 
  {
    if($i >= $start && $i < $end) 
    {
      $showcount ++;
      echo "<tr>";  
      echo "<td>".ShowTime($messages[$i]["MESSAGE_DATE"])."</td>";  
      if($message_type != "SEND") echo "<td><a href='?page=profile&user=".User_Name($messages[$i]["SEND_USER_ID"])."'>".User_Name($messages[$i]["SEND_USER_ID"])."</a></td>";  
      else echo "<td><a href='?page=profile&user=".User_Name($messages[$i]["READ_USER_ID"])."'>".User_Name($messages[$i]["READ_USER_ID"])."</a></td>"; 
      echo "<td>".$messages[$i]["MESSAGE_TOPIC"]."</td>";  
      echo "<td>".mb_substr($messages[$i]["MESSAGE_TEXT"], 0, 65, "utf-8")."..</td>";  
      echo "<td><a href='?page=messages&action=s_msg&msg=".$messages[$i]["MESSAGE_ID"]."'>".Web_GetLocale("MSG_10")."</a></td>";  
      echo "</tr>";  
    }   
  }
  if($showcount == 0) echo "<tr><td colspan='5'><center>".Web_GetLocale("MSG_14")."</center></td></tr>";
  echo "</table>";
  echo "</div>";
  
  if($pages > 1)
  {
    echo "<div style='float:right;'>";
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
    echo "</div>"; 
  }
}
?>