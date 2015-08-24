<?php
if($_SESSION["USER_ID"] > 0)
{
  ?>
  <div class="panel panel-primary">
    <div class="panel-heading">
      <h3 class="panel-title"><?php echo Web_GetLocale("MSG_01");?></h3>
    </div>
    <div class="panel-body">
      <div class="row">
        <div class="col-sm-3 col-md-2">
          <ul class="nav nav-pills nav-stacked">
            <li<?php echo (empty($_GET["action"])) ? " class='active'" : "";?> role="presentation"><a href="?page=messages"><?php echo Web_GetLocale("MSG_02");?></a></li>
            <li<?php echo ($_GET["action"] == "s_unread") ? " class='active'" : "";?> role="presentation"><a href="?page=messages&action=s_unread"><?php echo Web_GetLocale("MSG_03");?></a></li>
            <li<?php echo ($_GET["action"] == "s_admin") ? " class='active'" : "";?> role="presentation"><a href="?page=messages&action=s_admin"><?php echo Web_GetLocale("MSG_04");?></a></li>
            <li<?php echo ($_GET["action"] == "s_send") ? " class='active'" : "";?> role="presentation"><a href="?page=messages&action=s_send"><?php echo Web_GetLocale("MSG_19");?></a></li>  
          </ul>
          <hr>
          <a href="?page=messages&action=new" class="btn btn-success"><?php echo Web_GetLocale("MSG_05");?></a>
        </div>
        <div class="col-sm-9 col-md-10">
          <?php 
          if(!empty($_GET["action"]) && isset($_GET["action"]) && $_GET["action"] == "new")
          {
            $user = null;
            if(!empty($_GET["user"]) && isset($_GET["user"]))
            {
              $user_id = Database_Select("USER", array("USER_NAME" => $_GET["user"]), "USER_ID");
              if(!empty($user_id) && isset($user_id)) $user = $_GET["user"];   
            }
            ?>
            <form method="post">
              <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                <input id="user" type="text" class="form-control" name="user_name" value="<?php echo $user;?>" placeholder="<?php echo Web_GetLocale("MSG_15");?>">                                        
              </div>
              <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-comment"></i></span>
                <input id="user" type="text" class="form-control" name="msg_topic" value="" placeholder="<?php echo Web_GetLocale("MSG_16");?>">                                        
              </div>
        
              <textarea class="form-control" name="msg_text" rows="5" style="resize: vertical; overflow: auto; margin-top: 0px; margin-bottom: 0px;" placeholder="<?php echo Web_GetLocale("MSG_17");?>"></textarea>
              
              <input type="submit" class="btn btn-primary btn-block" name="post_msg" value="<?php echo Web_GetLocale("MSG_18");?>">         
            </form>  
            <?php  
            if(@$_POST["post_msg"])
            {
              if(!empty($_POST["user_name"]) && !empty($_POST["msg_topic"]) && !empty($_POST["msg_text"]))
              {
                $user_id = Database_Select("USER", array("USER_NAME" => $_POST["user_name"]), "USER_ID"); 
                if(!empty($user_id) && isset($user_id))
                {
                  Message_Create(
                    array(
                    "MESSAGE_TOPIC" => $_POST["msg_topic"],
                    "MESSAGE_TEXT" => $_POST["msg_text"],
                    "MESSAGE_TYPE" => "USER",
                    "SEND_USER_ID" => $_SESSION["USER_ID"],
                    "READ_USER_ID" => $user_id,
                    "MESSAGE_DATE" => time(),
                    "MESSAGE_SHOWED" => "NONE"
                  ));
                  header("location: ?page=messages&action=s_send");              
                } 
                else ShowNotification("warning", Web_GetLocale("MSG_E02")); 
              }
              else ShowNotification("warning", Web_GetLocale("MSG_E01")); 
            } 
          }
          else if(!empty($_GET["action"]) && isset($_GET["action"]) && $_GET["action"] == "s_msg" && !empty($_GET["msg"]) && isset($_GET["msg"]) && is_numeric($_GET["msg"]))
          {
            $msg = Database_Select("MESSAGES", array("MESSAGE_ID" => $_GET["msg"]));
            if($_SESSION["USER_ID"] == $msg["READ_USER_ID"] || $_SESSION["USER_ID"] == $msg["SEND_USER_ID"])
            {
              if($msg["MESSAGE_SHOWED"] == "NONE" && $_SESSION["USER_ID"] == $msg["READ_USER_ID"])
              {
                Database_Update("MESSAGES", array("MESSAGE_SHOWED" => time()), array("MESSAGE_ID" => $_GET["msg"]));
              }
              if($_SESSION["USER_ID"] == $msg["READ_USER_ID"]) echo "<h4>".Web_GetLocale("MSG_11")." ".User_Name($msg["SEND_USER_ID"])."</h4>";
              else if($_SESSION["USER_ID"] == $msg["SEND_USER_ID"]) echo "<h4>".Web_GetLocale("MSG_12")." ".User_Name($msg["READ_USER_ID"])."</h4>";
              ?>
              <small><?php echo Web_GetLocale("MSG_20")." ".ShowTime($msg["MESSAGE_DATE"]);?></small>
              <p>
              <?php echo StrMagic($msg["MESSAGE_TEXT"]);?>
              </p>
              <?php
              if($msg["MESSAGE_SHOWED"] != "NONE") echo "<small class='pull-right'>".Web_GetLocale("MSG_13")." ".ShowTime($msg["MESSAGE_SHOWED"])."</small>";
              if($_SESSION["USER_ID"] == $msg["READ_USER_ID"])
              {
                ?>
                <br><hr>
                <form method="post">
                  <textarea class="form-control" name="msg_text" rows="5" style="resize: vertical; overflow: auto; margin-top: 0px; margin-bottom: 0px;" placeholder="<?php echo Web_GetLocale("MSG_22");?>"></textarea>
                  <input type="submit" class="btn btn-primary btn-block" name="post_re" value="<?php echo Web_GetLocale("MSG_23");?>">
                </form>
                <?php 
                if(@$_POST["post_re"])
                {
                  if(!empty($_POST["msg_text"]))
                  {
                    $mzg = Database_Select("MESSAGES", array("MESSAGE_ID" => $_GET["msg"], "READ_USER_ID" => $_SESSION["USER_ID"]));
                    if(!empty($mzg) && isset($mzg))
                    {
                      Message_Create(
                        array(
                        "MESSAGE_TOPIC" => "RE: ".$mzg["MESSAGE_TOPIC"]."",
                        "MESSAGE_TEXT" => $_POST["msg_text"],
                        "MESSAGE_TYPE" => "USER",
                        "SEND_USER_ID" => $_SESSION["USER_ID"],
                        "READ_USER_ID" => $mzg["SEND_USER_ID"],
                        "MESSAGE_DATE" => time(),
                        "MESSAGE_SHOWED" => "NONE"
                      ));
                      header("location: ?page=messages&action=s_send"); 
                    }   
                    else header("location: ?page=messages"); 
                  }
                  else ShowNotification("warning", Web_GetLocale("MSG_E01")); 
                }
              }
            }        
          }
          else
          {
            if(!empty($_GET["action"]) && isset($_GET["action"]) && $_GET["action"] == "s_unread") Message_ShowList($_SESSION["USER_ID"], "UNREAD");
            else if(!empty($_GET["action"]) && isset($_GET["action"]) && $_GET["action"] == "s_admin") Message_ShowList($_SESSION["USER_ID"], "ADMIN");
            else if(!empty($_GET["action"]) && isset($_GET["action"]) && $_GET["action"] == "s_send") Message_ShowList($_SESSION["USER_ID"], "SEND");
            else Message_ShowList($_SESSION["USER_ID"], "ALL"); 
          }
          ?>
        </div>
      </div>
    </div>
  </div>
  <?php
}
else
{
  ?>
  <div class="panel panel-default">
    <div class="panel-body">
      <h1><?php echo Web_GetLocale("USER_E01");?></h1>
      <p>
        <?php echo Web_GetLocale("USER_E02");?>  
      </p>
    </div>
  </div>
  <?php
}
?>