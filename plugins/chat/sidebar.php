
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
  
  $chat_message = Database_Select_All("CHAT_MESSAGES", array("NONE" => "NONE"), "array", "ORDER BY `MESSAGE_ID` DESC LIMIT 5");
  if(count($chat_message) > 0)
  {
    for($i = 0;$i < count($chat_message);$i++)
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
            <form method="post" action="?page=plugin&plugin=chat">
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
    echo "<center><a href='?page=plugin&plugin=chat'>Všechny zprávy</a></center>";
  }
  ?>