<?php
if(!EMPTY($_GET["category"]) && isset($_GET["category"]) && is_numeric($_GET["category"]))
{
  Forum_ShowPath("category", $_GET["category"]);
  Forum_ShowCat($_GET["category"]);
}
else if(!empty($_GET["topic"]) && isset($_GET["topic"]) && is_numeric($_GET["topic"]))
{
  if(!empty($_GET["thread"]) && isset($_GET["thread"]) && $_GET["thread"] == "new") 
  {
    if($_SESSION["USER_ID"] > 0)
    {
      Forum_ShowPath("thread_new", $_GET["topic"]);
      ?>
      <div class='panel panel-primary'>
        <div class='panel-heading'>
          <h3 class='panel-title'><?php echo Plugin_GetLocale("forum", "FORUM_14")." - ".Forum_TopicName($_GET["topic"]);?></h3>
        </div>
        <div class='panel-body'>
          <div class="row">
            <div class="col-md-7">
              <form method="post">
                <div class="form-group col-lg-12">
                  <label><?php echo Plugin_GetLocale("forum", "FORUM_15");?></label>
                	<input type="text" class="form-control" name="thread_name">
              	</div>
                <div class="form-group col-lg-12">
                  <label><?php echo Plugin_GetLocale("forum", "FORUM_16");?></label>
                	<textarea class="form-control" name="thread_text" rows="5" style="resize: vertical; overflow: auto; margin-top: 0px; margin-bottom: 0px;" placeholder="<?php echo Plugin_GetLocale("forum", "FORUM_18");?>"></textarea>
              	</div>
                <input type="submit" class='btn btn-primary btn-block' name="thread_send" value="<?php echo Plugin_GetLocale("forum", "FORUM_17");?>">
              </form>
              <?php
              if(@$_POST["thread_send"])
              {
                if(!empty($_POST["thread_name"]) && !empty($_POST["thread_text"]))
                { 
                  $last_thread = Database_Select("FORUM_THREADS", array("USER_ID" => $_SESSION["USER_ID"]), "THREAD_DATE", "ORDER BY `THREAD_ID` DESC");
                  if((time() - $last_thread) > 300)
                  {
                    $th_id = Forum_CreateThread(
                      array(
                        "THREAD_NAME" => $_POST["thread_name"],
                        "THREAD_CONTENT" => $_POST["thread_text"],
                        "THREAD_DATE" => time(),
                        "USER_ID" => $_SESSION["USER_ID"],
                        "TOPIC_ID" => $_GET["topic"]
                    ));  
                    header("location: ?page=plugin&plugin=forum&thread=".$th_id); 
                  }
                  else echo "Můžeš napsat jen jedno téma za 5 minut.";
                }
                else ShowNotification("warning", Plugin_GetLocale("forum", "FORUM_E02"));
              }
              ?>
            </div>
            <div class="col-md-5">
            <?php echo ShowBB();?>
            </div>
          </div>
        </div>
      </div>
      <?php
    }
    else header("location: ?page=plugin&plugin=forum&topic=".$_GET["topic"]); 
  }
  else 
  {
    Forum_ShowPath("topic", $_GET["topic"]);  
    Forum_ShowAll($_GET["topic"], "threads");  
  }
}
else if(!empty($_GET["thread"]) && isset($_GET["thread"]) && is_numeric($_GET["thread"]))
{
  Forum_ShowPath("thread", $_GET["thread"]);
  Forum_ShowAll($_GET["thread"], "posts"); 
  if($_SESSION["USER_ID"] > 0)
  {
    $thread = Database_Select("FORUM_THREADS", array("THREAD_ID" => $_GET["thread"]));  
    if($thread["THREAD_LOCK"] == 0)
    { 
      ?>
      <div class='panel panel-primary'>
        <div class='panel-heading'>
          <h3 class='panel-title'><?php echo Plugin_GetLocale("forum", "FORUM_19")." - ".Forum_ThreadName($_GET["thread"]);?></h3>
        </div>
        <div class='panel-body'>
        <form method="post">
          <textarea class="form-control" name="thread_reply" rows="5" style="resize: vertical; overflow: auto; margin-top: 0px; margin-bottom: 0px;" placeholder="<?php echo Plugin_GetLocale("forum", "FORUM_22");?>"></textarea>  
          <input type="submit" class="btn btn-primary btn-block" name="thread_rpost" value="<?php echo Plugin_GetLocale("forum", "FORUM_20");?>">
  
        </form>
        <?php
        if(@$_POST["thread_rpost"])
        {
          if(!empty($_POST["thread_reply"]))
          {   
            $last_reply = Database_Select("FORUM_REPLIES", array("USER_ID" => $_SESSION["USER_ID"]), "REPLY_DATE", "ORDER BY `REPLY_ID` DESC");
            if((time() - $last_reply) > 60)
            {
              Forum_CreateReply(
                array(
                "REPLY_TEXT" => $_POST["thread_reply"],
                "REPLY_DATE" => time(),
                "USER_ID" => $_SESSION["USER_ID"],
                "THREAD_ID" => $_GET["thread"]    
              ));                      
              header("location: ?page=plugin&plugin=forum&thread=".$_GET["thread"]);    
            }
            else echo "Můžeš poslat jen 1 odpověď za jednu minutu.";
          }
        }
        ?>
        </div>
      </div>
      <?php 
    }
    if(User_Rights($_SESSION["USER_ID"], "Y"))
    {
      echo "<div class='btn-group' role='group'>";
      echo "<form method='post'>";
      if($thread["THREAD_LOCK"] == 1) echo "<input type='submit' class='btn btn-success' name='thread_unlock' value='".Plugin_GetLocale("forum", "ADMIN_29")."'>";
      else echo "<input type='submit' class='btn btn-warning' name='thread_lock' value='".Plugin_GetLocale("forum", "ADMIN_28")."'>";
      echo "<input type='submit' class='btn btn-danger' name='thread_delete' value='".Plugin_GetLocale("forum", "ADMIN_27")."'>"; 
      echo "</form>";
      echo "</div>";
           
      if(@$_POST["thread_unlock"])
      {
        Database_Update("FORUM_THREADS", array("THREAD_LOCK" => 0), array("THREAD_ID" => $_GET["thread"]));
        header("Location: ".$_SERVER["REQUEST_URI"]);
      }
      if(@$_POST["thread_lock"])
      {
        Database_Update("FORUM_THREADS", array("THREAD_LOCK" => 1), array("THREAD_ID" => $_GET["thread"]));
        header("Location: ".$_SERVER["REQUEST_URI"]);
      }
      if(@$_POST["thread_delete"])
      {
        Database_Delete("FORUM_REPLIES", array("THREAD_ID" => $_GET["thread"])); 
        Database_Delete("FORUM_THREADS", array("THREAD_ID" => $_GET["thread"]));
        header("Location: ?page=plugin&plugin=forum");
      }
    }
  }
  else header("location: ?page=plugin&plugin=forum&thread=".$_GET["thread"]);   
}
else
{
  Forum_ShowPath("none");
  Forum_ShowCats();
}
?>