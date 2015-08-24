<?php
function Sidebar_ShowAll()
{
  $sidebars = Database_Select_All("SIDEBAR", array("SIDEBAR_ALLOW" => 1));
  for($i = 0;$i < count($sidebars);$i ++) Sidebar_Show($sidebars[$i]["SIDEBAR_ID"]);
}

function Sidebar_Show($sidebar_id)
{
  $sidebar = Database_Select("SIDEBAR", array("SIDEBAR_ID" => $sidebar_id, "SIDEBAR_ALLOW" => 1));
  if(!empty($sidebar) && isset($sidebar))
  {
    ?>
    <div class="panel panel-<?php echo $sidebar["SIDEBAR_COLOR"];?>">
      <div class="panel-heading">
        <h3 class="panel-title"><?php echo $sidebar["SIDEBAR_NAME"];?></h3>
      </div>
      <div class="panel-body">
      <?php
      if($sidebar["SIDEBAR_PLUGIN"] == "NONE")
      {
        echo $sidebar["SIDEBAR_CONTENT"];
      }
      else
      {
        if(Plugin_Files($sidebar["SIDEBAR_PLUGIN"], 1))
        {
					$plugin = Database_Select("PLUGINS", array("PLUGIN_NAME" => $sidebar["SIDEBAR_PLUGIN"], "PLUGIN_ALLOW" => "1"));
					if(!empty($plugin) && isset($plugin)) require_once(PLUGIN_DIR.$sidebar["SIDEBAR_PLUGIN"]."/sidebar.php");	
					else echo "Unknow plugin <b>".$sidebar["SIDEBAR_PLUGIN"]."</b>."; 
        }
      }
      ?>
      </div>
    </div>
    <?php
  }
  else echo "Sidebar id ".$sidebar_id." is not exists or is not allowed!";
}
?>