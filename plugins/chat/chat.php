<div class='panel panel-primary'>
  <div class='panel-heading'>
    <h3 class='panel-title'>Chat</h3>
  </div>
  <div class='panel-body'>
  <?php
  if($_SESSION["USER_ID"] > 0)
  {
    ?>
    <form method="post">        
      <textarea class="form-control" name="chat_text" rows="3" style="resize: vertical; overflow: auto; margin-top: 0px; margin-bottom: 0px;" placeholder="Sem napište vaší zprávu.."></textarea>
      <input type="submit" class='btn btn-primary btn-block' name="chat_send" value="Odeslat zprávu">
    </form>
    <?php
    if(@$_POST["chat_send"])
    {
      if(!empty($_POST["chat_text"]))
      {
        $last_message = Database_Select("CHAT_MESSAGES", array("USER_ID" => $_SESSION["USER_ID"]), "MESSAGE_TIME", "ORDER BY `MESSAGE_ID` DESC");
        if((time() - $last_message) > 60)
        {
          Database_Insert("CHAT_MESSAGES", 
            array(
            "MESSAGE_TEXT" => $_POST["chat_text"],
            "USER_ID" => $_SESSION["USER_ID"],
            "MESSAGE_TIME" => time(),
            "MESSAGE_SHOW" => 1
          )); 
          header("Location: ".$_SERVER["REQUEST_URI"]);
        }
        else echo "Jedna zpráva za 1 minutu.";
      }
    }     
  }
  
  $count = 0;
  $chat_msg_pp = 0;          
  $link = null;
  
  $count = Database_CountTable("CHAT_MESSAGES");
  $chat_msg_pp = 10;   
  $link = "?page=plugin&plugin=chat&s=";
  
  $page = 0;  
  $pages = $count / $chat_msg_pp;
  $pages = round_up($pages);
     
  if(!empty($_GET["s"]) && isset($_GET["s"]) && is_numeric($_GET["s"])) 
  {
    if($_GET["s"] > $pages) $page = $pages;
    else if($_GET["s"] < 0) $page = 1;
    else $page = $_GET["s"];
  }
  else $page = 1;
    
  $start = ($page - 1)  * $chat_msg_pp; 
  $end = min(($start + $chat_msg_pp), $count); 
    
  $page_back = $page - 1;
  $page_next = $page + 1;
  
  $chat_message = Database_Select_All("CHAT_MESSAGES", array("NONE" => "NONE"), "array", "ORDER BY `MESSAGE_ID` DESC");
  if(count($chat_message) > 0)
  {
    for($i = 0;$i < count($chat_message);$i++)
    {
      if($i >= $start && $i < $end)
      {
      ?>
        <div class="media">
          <div class="media-left">
            <a href='?page=profile&user=<?php echo User_Data($chat_message[$i]["USER_ID"], "USER_NAME");?>'><img class='media-object' width='64px' height='64px' src='<?php echo User_Data($chat_message[$i]["USER_ID"], "USER_AVATAR");?>' alt='<?php echo User_Data($chat_message[$i]["USER_ID"], "USER_DISPLAY_NAME");?>'></a>
          </div>
          <div class="media-body">
            <h4 class="media-heading"><a href='?page=profile&user=<?php echo User_Data($chat_message[$i]["USER_ID"], "USER_NAME");?>'><?php echo User_Data($chat_message[$i]["USER_ID"], "USER_DISPLAY_NAME");?></a> <?php echo Web_GetLocale("COMM_03");?></h4>
            <?php
            if($chat_message[$i]["USER_ID"] == $_SESSION["USER_ID"] && $_SESSION["USER_ID"] > 0 || User_Rights($_SESSION["USER_ID"], "Z") && $_SESSION["USER_ID"] > 0)
  			    {
              ?>
              <form method="post">
                <input type="hidden" name="chat_message_id" value="<?php echo $chat_message[$i]["MESSAGE_ID"];?>">
                <input type="submit" name="chat_message_delete" value="Smazat zprávu" class="btn btn-xs btn-danger">
              </form>        
              <?php
            }
            ?>
            <small><?php echo ShowTime($chat_message[$i]["MESSAGE_TIME"]);?></small>
            <p><?php echo StrMagic($chat_message[$i]["MESSAGE_TEXT"]);?></p>
          </div>
        </div>
      <?php
      }    
    }
    
    if(@$_POST["chat_message_delete"])
    {
      if(!empty($_POST["chat_message_id"]) && isset($_POST["chat_message_id"]) && is_numeric($_POST["chat_message_id"]) && $_SESSION["USER_ID"] > 0)
      {
        if(User_Rights($_SESSION["USER_ID"], "Z")) $comment = Database_Select("CHAT_MESSAGES", array("MESSAGE_ID" => $_POST["chat_message_id"]));
    		else $comment = Database_Select("CHAT_MESSAGES", array("MESSAGE_ID" => $_POST["chat_message_id"], "USER_ID" => $_SESSION["USER_ID"]));
    		if($comment != "N/A")
    		{
    			Database_Delete("CHAT_MESSAGES", array("MESSAGE_ID" => $_POST["chat_message_id"]));
    			header("Location: ".$_SERVER["REQUEST_URI"]);
    		}
    		else header("location: index.php");	
      }
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
  ?>
  </div>
</div>