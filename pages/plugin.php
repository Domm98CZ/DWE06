<?php
if(!empty($_GET["plugin"]) && isset($_GET["plugin"]))
{
  $plugin = Database_Select("PLUGINS", array("PLUGIN_NAME" => $_GET["plugin"], "PLUGIN_ALLOW" => 1));
  if(!empty($plugin) && isset($plugin))
  {
    require_once PLUGIN_DIR.$plugin["PLUGIN_NAME"]."/".$plugin["PLUGIN_NAME"].".php";
  }
  else
  {
    ?>
    <div class="panel panel-default">
      <div class="panel-body">
        <h1><?php echo Web_GetLocale("PLUGIN_E01");?></h1>
        <p>
          <?php echo Web_GetLocale("PLUGIN_E02");?>  
        </p>
      </div>
    </div>
    <?php
  }
}
else header("location: index.php");
?>