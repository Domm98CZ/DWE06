<?php
if(!file_exists("_core/config.php")) die("DWE: Please firstly complete setup.");
require_once "_core/main.php"; 
?>
<!DOCTYPE html>
<html> 
  <head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title><?php echo Web_GetOption("NAME");?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">  
    <meta name='robots' content="index,follow" />
    <meta name='author' content="<?php echo Database_Select("USER", array("NONE" => "NONE"), "USER_DISPLAY_NAME", "ORDER BY `USER_ID` ASC");?>" />
    <meta name='description' content="<?php echo Web_GetOption("DESCRIPTION");?>" />
    <meta name='keywords' content="<?php echo Web_GetOption("KEYWORDS");?>" />
    <meta name='identifier-url' content="http://<?php echo Web_GetOption("URL");?>" />
    <meta property='og:url' content="http://<?php echo Web_GetOption("URL");?>" />
    <meta property='og:title' content="<?php echo Web_GetOption("NAME");?>" />
    <meta property='og:site_name' content="<?php echo Web_GetOption("NAME");?>" />
    <meta property='og:image' content="<?php echo Web_GetOption("LOGO");?>" />   
    <link rel="shortcut icon" href="<?php echo Web_GetOption("FAVICON");?>" />
    <link href="themes/<?php echo Web_GetOption("THEME");?>/style.css" rel="stylesheet">
    <!--[if lt IE 9]>
      <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <link href="assets/css/main.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <meta name="generator" content="Domm Web Engine <?php echo Web_GetVersion();?>" />
  </head>
  <body>
    <nav class="navbar navbar-<?php echo Web_GetOption("MENU");?> navbar-fixed-top" role="navigation">
    	<div class="navbar-header">
        <a class="navbar-brand" rel="home" href="http://<?php echo Web_GetOption("URL");?>"><?php echo Web_GetOption("NAME");?></a>
    		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
    		<span class="sr-only">Toggle navigation</span>
    		<span class="icon-bar"></span>
    		<span class="icon-bar"></span>
    		<span class="icon-bar"></span>
    		</button>
    	</div>
      <?php
      if($_SESSION["USER_ID"] > 0)
      {
      ?>
      <ul class="nav navbar-nav navbar-right" style="padding-right:10px;">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
            <img alt="Avatar" width="20px" height="20px" src="<?php echo User_Data($_SESSION["USER_ID"], "USER_AVATAR");?>"> <?php echo User_Data($_SESSION["USER_ID"], "USER_DISPLAY_NAME");?> <span class="caret"></span>
          </a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="?page=profile"><i class="fa fa-fw fa-user"></i> <?php echo Web_GetLocale("USER_01");?></a></li>
            <li><a href="?page=messages"><i class="fa fa-fw fa-envelope"></i> 
            <?php 
            echo Web_GetLocale("USER_02");
            if(Message_Count($_SESSION["USER_ID"]) > 0) echo " <span class='badge'>".Message_Count($_SESSION["USER_ID"])."</span>";
            ?>       
            </a></li>
            <li><a href="?page=settings"><i class="fa fa-fw fa-gear"></i> <?php echo Web_GetLocale("USER_03");?></a></li>
            <?php
            if(User_Rights($_SESSION["USER_ID"], "E")) echo "<li><a href='?page=admin'><i class='fa fa-fw fa-gears'></i> ".Web_GetLocale("USER_05")."</a></li>";
            ?>
            <li class="divider"></li>
            <li><a href="?page=logout"><i class="fa fa-fw fa-power-off"></i> <?php echo Web_GetLocale("USER_04");?></a></li>
          </ul>
        </li>
      </ul>
      <?php
      }
      else
      {
        ?>
        <ul class="nav navbar-nav navbar-right" style="padding-right:10px;">
          <li><a href="?page=login">Přihlásit se</a></li>
          <li><a href="?page=register">Registrovat se</a></li>
        </ul>
        <?php
      }
      ?>
    	<div class="collapse navbar-collapse">
        <?php
        $menu = Database_Select_All("MENU", array("NONE" => "NONE"));
        if(count($menu) > 0)
        {
          echo "<ul class='nav navbar-nav'>";
          for($i = 0;$i < count($menu);$i ++)
          {
            if($menu[$i]["MENU_DROPDOWN"] == "NONE") echo "<li><a href='".$menu[$i]["MENU_LINK"]."'>".$menu[$i]["MENU_NAME"]."</a></li>";
            else if($menu[$i]["MENU_DROPDOWN"] == "MAIN")
            {
              $menu_d = Database_Select_All("MENU", array("MENU_DROPDOWN" => $menu[$i]["MENU_ID"]));
              if(count($menu_d) > 0)
              {
                echo "<li class='dropdown'>"; 
                echo "<a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'>".$menu[$i]["MENU_NAME"]." <span class='caret'></span></a>";
                echo "<ul class='dropdown-menu'>";
                for($y = 0;$y < count($menu_d);$y ++)
                {
                  echo "<li><a href='".$menu_d[$y]["MENU_LINK"]."'>".$menu_d[$y]["MENU_NAME"]."</a></li>";  
                }
                echo "</ul>";
                echo "</li>";
              }
            }
          }          
          echo "</ul>";
        }
        ?>
    	</div>       
    </nav>
    
    <div class="container-fluid">  
      <!--center-->
      <div class="col-md-9">
      <?php
      if(!EMPTY($_GET["page"]) && isset($_GET["page"]) && preg_match("/([A-Za-z])\w+/", $_GET["page"]))
      {
        if(file_exists("pages/".$_GET["page"].".php")) 
        {
          if($_GET["page"] == "index") include "pages/home.php";
          include "pages/".$_GET["page"].".php";
        }
        else include "pages/error.php"; 
      }
      else include "pages/home.php";  
      ?>
      </div><!--/center-->
    
      <!--right-->
      <div class="col-md-3">
      <?php Sidebar_ShowAll();?>
      </div><!--/right-->
  
    </div><!--/container-fluid-->
    	<!-- script references -->
		<script src="assets/js/jquery.min.js"></script>
		<script src="assets/js/bootstrap.min.js"></script>
	</body>
</html>