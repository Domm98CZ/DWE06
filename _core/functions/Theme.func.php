<?php
function Theme_Files($theme)
{
  if(file_exists(THEME_DIR.$theme."/style.css")
  && file_exists(THEME_DIR.$theme."/theme.php")
  && file_exists(THEME_DIR.$theme."/preview.png")) return true;
  else return false;
}

function Theme_Load()
{
  if(!file_exists(THEME_DIR.Web_GetOption("THEME")."/style.css") || !file_exists(THEME_DIR.Web_GetOption("THEME")."/theme.php") && file_exists(THEME_DIR.Web_GetOption("THEME")."/preview.png"))
  {
    //try load default
    if(file_exists(THEME_DIR."default/style.css") && file_exists(THEME_DIR."default/theme.php") && file_exists(THEME_DIR."default/preview.png")) 
    {
      Database_Update("OPTIONS", array("OPTION_VALUE" => "default"), array("OPTION_KEY" => "THEME"));     
    }
    else 
    {
      echo "Theme ".$theme." isn't working.<br>";
      echo "Theme default isn't working.";
      exit();
    }
  } 
}
?>