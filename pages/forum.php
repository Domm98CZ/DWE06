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
          <h3 class='panel-title'><?php echo Web_GetLocale("FORUM_14")." - ".Forum_TopicName($_GET["topic"]);?></h3>
        </div>
        <div class='panel-body'>
          <div class="row">
            <div class="col-md-7">
              <form method="post">
                <div class="form-group col-lg-12">
                  <label><?php echo Web_GetLocale("FORUM_15");?></label>
                	<input type="text" class="form-control" name="thread_name">
              	</div>
                <div class="form-group col-lg-12">
                  <label><?php echo Web_GetLocale("FORUM_16");?></label>
                	<textarea class="form-control" name="thread_text" rows="5" style="resize: vertical; overflow: auto; margin-top: 0px; margin-bottom: 0px;" placeholder="<?php echo Web_GetLocale("FORUM_18");?>"></textarea>
              	</div>
                <input type="submit" class='btn btn-primary btn-block' name="thread_send" value="<?php echo Web_GetLocale("FORUM_17");?>">
              </form>
              <?php
              if(@$_POST["thread_send"])
              {
                if(!empty($_POST["thread_name"]) && !empty($_POST["thread_text"]))
                {
                  $th_id = Forum_CreateThread(
                    array(
                      "THREAD_NAME" => $_POST["thread_name"],
                      "THREAD_CONTENT" => $_POST["thread_text"],
                      "THREAD_DATE" => time(),
                      "USER_ID" => $_SESSION["USER_ID"],
                      "TOPIC_ID" => $_GET["topic"]
                  ));  
                  header("location: ?page=forum&thread=".$th_id); 
                }
                else ShowNotification("warning", Web_GetLocale("FORUM_E02"));
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
    else header("location: ?page=forum&topic=".$_GET["topic"]); 
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
    ?>
    <div class='panel panel-primary'>
      <div class='panel-heading'>
        <h3 class='panel-title'><?php echo Web_GetLocale("FORUM_19")." - ".Forum_ThreadName($_GET["thread"]);?></h3>
      </div>
      <div class='panel-body'>
      <form method="post">
        <textarea class="form-control" name="thread_reply" rows="5" style="resize: vertical; overflow: auto; margin-top: 0px; margin-bottom: 0px;" placeholder="<?php echo Web_GetLocale("FORUM_22");?>"></textarea>
        <input type="submit" class="btn btn-primary btn-block" name="thread_rpost" value="<?php echo Web_GetLocale("FORUM_20");?>">
      </form>
      <?php
      if(@$_POST["thread_rpost"])
      {
        if(!empty($_POST["thread_reply"]))
        {
          Forum_CreateReply(
            array(
            "REPLY_TEXT" => $_POST["thread_reply"],
            "REPLY_DATE" => time(),
            "USER_ID" => $_SESSION["USER_ID"],
            "THREAD_ID" => $_GET["thread"]    
          ));                      
          header("location: ?page=forum&thread=".$_GET["thread"]);    
        }
      }
      ?>
      </div>
    </div>
    <?php
  }
  else header("location: ?page=forum&thread=".$_GET["thread"]);   
}
else
{
  Forum_ShowPath("none");
  Forum_ShowCats();
}
?>