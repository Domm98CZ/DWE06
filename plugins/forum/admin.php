<?php
if($_SESSION["USER_ID"] > 0)
{
  if(User_Rights($_SESSION["USER_ID"], "Q"))
  {
    echo "<h1>".Plugin_GetLocale("forum", "ADMIN_01")."</h1>";
    if(!empty($_GET["a"]) && isset($_GET["a"]))
    {
      if($_GET["a"] == "new")
      {     
        if(!empty($_GET["c"]) && isset($_GET["c"]) && $_GET["c"] == "x")
        {
          ?>
          <form method="post">
            <div class="form-group col-lg-12">
          	 <label><?php echo Plugin_GetLocale("forum", "ADMIN_02");?></label>
          	 <input type="text" class="form-control" name="cat_name">
        	  </div>
            <div class="form-group col-lg-12">
              <label><?php echo Plugin_GetLocale("forum", "ADMIN_03");?></label>
              <textarea class="form-control" name="cat_info" rows="5" style="resize: vertical; overflow: auto; margin-top: 0px; margin-bottom: 0px;" placeholder="<?php echo Plugin_GetLocale("forum", "ADMIN_04");?>"></textarea>
            </div>
            <div class="form-group col-lg-12">
          	   <label><?php echo Plugin_GetLocale("forum", "ADMIN_05");?></label>
          	   <select name='cat_color' class="form-control">
                <option selected disabled><?php echo Plugin_GetLocale("forum", "ADMIN_06");?></option>
                <option value='default'><?php echo Plugin_GetLocale("forum", "ADMIN_07");?></option>
                <option value='primary'><?php echo Plugin_GetLocale("forum", "ADMIN_08");?></option>
                <option value='info'><?php echo Plugin_GetLocale("forum", "ADMIN_09");?></option>
                <option value='success'><?php echo Plugin_GetLocale("forum", "ADMIN_10");?></option>
                <option value='warning'><?php echo Plugin_GetLocale("forum", "ADMIN_11");?></option>
                <option value='danger'><?php echo Plugin_GetLocale("forum", "ADMIN_12");?></option>
               </select>
        	  </div>
            <input type="submit" name="create_cat" class="btn btn-primary" value="<?php echo Plugin_GetLocale("forum", "ADMIN_13");?>">
          </form>
          <?php
          if(@$_POST["create_cat"])
          {
            if(!empty($_POST["cat_name"]) && !empty($_POST["cat_color"]) && !empty($_POST["cat_info"]))
            {
              if($_POST["cat_color"] == "default" || $_POST["cat_color"] == "primary" || $_POST["cat_color"] == "info" || $_POST["cat_color"] == "success" || $_POST["cat_color"] == "warning" || $_POST["cat_color"] == "danger")
              {
                $s = Database_Select("FORUM_CATS", array("CAT_NAME" => $_POST["cat_name"]), "CAT_ID");
                if($s == 0)
                {
                  Forum_CreateCat(array("CAT_NAME" => $_POST["cat_name"], "CAT_COLOR" => $_POST["cat_color"], "CAT_INFO" => $_POST["cat_info"]));
                  header("location: ?page=admin&admin=plugins&action=admin&plugin=forum");
                }
                else echo Plugin_GetLocale("forum", "ADMIN_14");
              }
              else header("location: ?page=admin&admin=plugins&action=admin&plugin=forum&c=x&a=new");
            } 
            else header("location: ?page=admin&admin=plugins&action=admin&plugin=forum&c=x&a=new");
          }
        }
        else if(!empty($_GET["c"]) && isset($_GET["c"]) && !empty($_GET["t"]) && isset($_GET["t"]) && $_GET["t"] == "x")
        {
          ?>
          <form method="post">
            <div class="form-group col-lg-12">
          	   <label><?php echo Plugin_GetLocale("forum", "ADMIN_15");?></label>
              <input type="text" class="form-control" name="topic_name">
        	  </div>
            <div class="form-group col-lg-12">
          	   <label><?php echo Plugin_GetLocale("forum", "ADMIN_16");?></label>
               <textarea class="form-control" name="topic_info" rows="5" style="resize: vertical; overflow: auto; margin-top: 0px; margin-bottom: 0px;" placeholder="<?php echo Plugin_GetLocale("forum", "ADMIN_17");?>"></textarea>
        	  </div>
            <div class="form-group col-lg-12">
          	   <label><?php echo Plugin_GetLocale("forum", "ADMIN_18");?></label>
               <input type="text" class="form-control" name="topic_img" value="assets/images/forum_icon.png">
        	  </div>
            <input type="submit" name="create_topic" class="btn btn-primary" value="<?php echo Plugin_GetLocale("forum", "ADMIN_19");?>">
          </form>
          <?php
          if(@$_POST["create_topic"])
          {
            if(!empty($_POST["topic_name"]) && !empty($_POST["topic_info"]) && !empty($_POST["topic_img"]))
            {
              Forum_CreateTopic(
                array(
                "TOPIC_NAME" => $_POST["topic_name"],
                "TOPIC_INFO" => $_POST["topic_info"],
                "TOPIC_IMG" => $_POST["topic_img"],
                "CAT_ID" => $_GET["c"]
              ));
              header("location: ?page=admin&admin=plugins&action=admin&plugin=forum");
            }
            else header("location: ?page=admin&admin=plugins&action=admin&plugin=forum&c=".$_GET["c"]."&t=x&a=new");
          }
        }
      }
      else if($_GET["a"] == "delete")
      {      
        if(!empty($_GET["c"]) && isset($_GET["c"]))
        {
          $c_e = Database_Select("FORUM_CATS", array("CAT_ID" => $_GET["c"]), "CAT_ID");
          if($c_e > 0)
          {
            ?>
            <?php echo Plugin_GetLocale("forum", "ADMIN_20");?> <b><?php echo Forum_CatName($_GET["c"]);?></b>
            <form method="post"> 
              <a href="?page=admin&admin=plugins&action=admin&plugin=forum" class="btn btn-success"><?php echo Plugin_GetLocale("forum", "ADMIN_21");?></a>
              <input type="submit" name="delete_cat" class="btn btn-danger" value="<?php echo Plugin_GetLocale("forum", "ADMIN_22");?>">
            </form>
            <?php
            if(@$_POST["delete_cat"])
            {
              Database_Delete("FORUM_CATS", array("CAT_ID" => $_GET["c"]));
              header("location: ?page=admin&admin=plugins&action=admin&plugin=forum");
            }
          }
          else header("location: ?page=admin&admin=plugins&action=admin&plugin=forum");
        }
        else if(!empty($_GET["t"]) && isset($_GET["t"]))
        {
          $t_e = Database_Select("FORUM_TOPICS", array("TOPIC_ID" => $_GET["t"]), "TOPIC_ID");
          if($t_e > 0)
          {
            ?>
            <?php echo Plugin_GetLocale("forum", "ADMIN_23");?> <b><?php echo Forum_TopicName($_GET["t"]);?></b>
            <form method="post"> 
              <a href="?page=admin&admin=plugins&action=admin&plugin=forum" class="btn btn-success"><?php echo Plugin_GetLocale("forum", "ADMIN_21");?></a>
              <input type="submit" name="delete_topic" class="btn btn-danger" value="<?php echo Plugin_GetLocale("forum", "ADMIN_22");?>">
            </form>
            <?php
            if(@$_POST["delete_topic"])
            {
              Database_Delete("FORUM_TOPICS", array("TOPIC_ID" => $_GET["t"]));
              header("location: ?page=admin&admin=plugins&action=admin&plugin=forum");
            }
          }
          else header("location: ?page=admin&admin=plugins&action=admin&plugin=forum");
        }
        else header("location: ?page=admin&admin=plugins&action=admin&plugin=forum");
      }
      else header("location: ?page=admin&admin=plugins&action=admin&plugin=forum");
    }
    else
    {
      echo "<ul>";
      $categories = Database_Select_All("FORUM_CATS", array("NONE" => "NONE"));
      for($c = 0;$c < count($categories);$c ++)
      {
        echo "<li>".$categories[$c]["CAT_NAME"]." <a href='?page=admin&admin=plugins&action=admin&plugin=forum&c=".$categories[$c]["CAT_ID"]."&a=delete' class='btn btn-danger btn-xs'>".Plugin_GetLocale("forum", "ADMIN_22")."</a>";
        $topics = Database_Select_All("FORUM_TOPICS", array("CAT_ID" => $categories[$c]["CAT_ID"])); 
        echo "<ul>";
        for($t = 0;$t < count($topics);$t ++)
        {
          echo "<li>".$topics[$t]["TOPIC_NAME"]." <a href='?page=admin&admin=plugins&action=admin&plugin=forum&t=".$topics[$t]["TOPIC_ID"]."&a=delete' class='btn btn-danger btn-xs'>".Plugin_GetLocale("forum", "ADMIN_22")."</a></li>";
        }
        echo "<li><a href='?page=admin&admin=plugins&action=admin&plugin=forum&c=".$categories[$c]["CAT_ID"]."&t=x&a=new'>".Plugin_GetLocale("forum", "ADMIN_24")."</a></li>";
        echo "</ul>";
        echo "</li>";  
      }
      echo "<li><a href='?page=admin&admin=plugins&action=admin&plugin=forum&c=x&a=new'>".Plugin_GetLocale("forum", "ADMIN_25")."</a></li>";
      echo "</ul>";
      echo "<a href='?page=plugin&plugin=forum'>".Plugin_GetLocale("forum", "ADMIN_26")."</a>";
    }
  }
  else header("location: ?page=admin&admin=plugins");
}
else header("location: ?page=login");
?>