<?php
//error_reporting(0);
ob_start();
include "config.php";

/* DEFINITIONS */
define("THEME_DIR", "themes/");
define("PLUGIN_DIR", "plugins/");
define("UPLOAD_DIR", "uploads/");  
define("LANG_DIR", "languages/");   

/* LOAD FUNCTIONS */
require_once "functions/Database.func.php";
require_once "functions/Web.func.php";
require_once "functions/Post.func.php";
require_once "functions/User.func.php";
require_once "functions/Messages.func.php";
require_once "functions/Theme.func.php";
require_once "functions/Sidebar.func.php";
require_once "functions/Plugin.func.php";

/* Start functions */
Theme_Load();
Plugins_Load();
Web_IPBanned();

/* User */
session_start();
if(!EMPTY($_SESSION["USER_ID"]))
{
  User_Load($_SESSION["USER_ID"]);  
  User_Banned($_SESSION["USER_ID"]);
}
else 
{
  $opt = array_keys($_SESSION);
  for($i = 0;$i < count($opt);$i++) unset($_SESSION[$opt[$i]]);
}

if(User_IP(1) != "78.102.20.9" && User_IP(1) != "77.78.89.185") die("Litujeme, ale nemate pravo k pristupu k tomuto souboru!");
?>