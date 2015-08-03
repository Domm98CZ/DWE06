<?php
function Plugin_Files($plugin, $sidebar = 0)
{
  if(file_exists(PLUGIN_DIR.$plugin."/install.php")
  && file_exists(PLUGIN_DIR.$plugin."/uninstall.php")
  && file_exists(PLUGIN_DIR.$plugin."/info.php")
  && file_exists(PLUGIN_DIR.$plugin."/".$plugin.".php")
  && file_exists(PLUGIN_DIR.$plugin."/".$plugin.".func.php"))
  {
    if($sidebar == 0) return true;
    if($sidebar == 1 && file_exists(PLUGIN_DIR.$plugin."/sidebar.php")) return true;
    else return false;
  }
  else return false;
}
function Plugins_Load()
{
  $plugin = Database_Select_All("PLUGINS", array("PLUGIN_ALLOW" => "1")); 
  for($i = 0;$i < count($plugin);$i ++)
  {
    require_once(PLUGIN_DIR.$plugin[$i]["PLUGIN_NAME"]."/".$plugin[$i]["PLUGIN_NAME"].".func.php");
  }
}

function Plugin_GetLocale($plugin, $msg, $lang = null)
{
  $plugin = Database_Select("PLUGINS", array("PLUGIN_NAME" => $_GET["plugin"], "PLUGIN_ALLOW" => 1));
  if($plugin["PLUGIN_NAME"])
  {
    if(empty($lang)) $lang = Web_GetOption("LANG");
    $fail_text = "Message ".$lang."-".$msg." can't be found.";
  
    $file_path = PLUGIN_DIR.$plugin["PLUGIN_NAME"]."/languages/".$lang.".php";
    if(file_exists($file_path)) include($file_path);
    else return $fail_text;
  
    if(isset($plugin_language[$msg]) && !empty($plugin_language[$msg])) return $plugin_language[$msg];
    else return $fail_text; 
  }
  else return "Plugin ".$plugin." doesn't exists.";
}
?>