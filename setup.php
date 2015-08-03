<?php
ob_start();
require_once "_core/functions/Web.func.php";
?>
<!DOCTYPE html>
<html> 
  <head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>DWE Setup</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">  
    <link rel="shortcut icon" href="assets/images/favicon.png" />
    <link href="themes/default/style.css" rel="stylesheet">
    <!--[if lt IE 9]>
      <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <link href="assets/css/main.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <meta name="generator" content="Domm Web Engine <?php echo Web_GetVersion();?>" />
  </head>
  <body>
    <div class="container">
      <h1>DWE Setup</h1>
      <div class="panel panel-primary">
        <?php
        if(!empty($_GET["step"]) && isset($_GET["step"]) && is_numeric($_GET["step"])) 
        {
					if(!file_exists("_core/config.php")) die("DWE: Error install #1!");
          require_once "_core/config.php";
          require_once "_core/functions/Database.func.php";
          require_once "_core/functions/User.func.php";
          if($_GET["step"] == 2)
          {
            ?>
            <div class="panel-heading">
              <h3 class="panel-title">Vytvoření admin uživatele</h3>
            </div>
            <div class="panel-body">
              <p>Nyní potřebujeme vytvořit uživatele, kterému budou automaticky přiděleny nejvyšší práva.</p>
              <form method="post">
                <div class="form-group col-lg-12">
                  <label>Přihlašovací jméno</label>
                  <input type="text" class="form-control" name="admin_name">
                </div> 
                <div class="form-group col-lg-12">
                  <label>E-Mail</label>
                  <input type="text" class="form-control" name="admin_email">
                </div> 
                <div class="form-group col-lg-12">
                  <label>Heslo</label>
                  <input type="password" class="form-control" name="admin_pass_01">
                </div>
                <div class="form-group col-lg-12">
                  <label>Heslo (znovu)</label>
                  <input type="password" class="form-control" name="admin_pass_02">
                </div> 
                <input type="submit" class="btn btn-block btn-primary" value="Vytvořit administrátora" name="admin_create">
              </form>
            </div>
            <?php  
            if(@$_POST["admin_create"])
            {
              if(!empty($_POST["admin_name"]) && !empty($_POST["admin_email"]) && !empty($_POST["admin_pass_01"])  && !empty($_POST["admin_pass_02"]))
              {
                if(strlen($_POST["admin_name"]) > 2 && preg_match("/^[_a-zA-Z0-9-]+$/", $_POST["admin_name"])) 
                {
                  if($_POST["admin_pass_01"] == $_POST["admin_pass_02"])
                  {
                    if(filter_var($_POST["admin_email"], FILTER_VALIDATE_EMAIL)) 
                    {
                      $user_id = User_Create(
                        array(
                          "USER_NAME" => $_POST["admin_name"],
                          "USER_PASS" => "NONE",
                          "USER_SALT" => User_GeneratePasswordSalt(),
                          "USER_DISPLAY_NAME" => $_POST["admin_name"],
                          "USER_EMAIL" => $_POST["admin_email"],
                          "USER_IP" => User_IP(1),
                          "USER_AVATAR" => "assets/images/noav.png",
                          "USER_DATE_R" => time(),
                          "USER_DATE_L" => time(),
                          "USER_DATE_A" => time(), 
                          "USER_RIGHTS" => "X" 
                        )
                      );
                      
                      Database_Update("USER", array("USER_PASS" => User_GeneratePassword($user_id, $_POST["admin_pass_01"])), array("USER_ID" => $user_id));   +
                      Database_Insert("OPTIONS", array("OPTION_VALUE" => $_POST["admin_email"], "OPTION_KEY" => "EMAIL"));
                      header("location: setup.php?step=3");   
                    }
                    else echo ShowNotification("warning", "Nevalidní e-mail.");
                  }
                  else echo ShowNotification("warning", "Zadaná hesla musí být stejná.");
                }
                else echo ShowNotification("warning", "Přihlašovací jméno musí být delší než 2 znaky a může obsahovat pouze znaky a-Z, 0-9, a nesmí obsahovat diakritiku!");
              }
              else echo ShowNotification("warning", "Musí být vyplněny všechny údaje.");
            }
          }
          else if($_GET["step"] == 3)
          {
            ?>
            <div class="panel-heading">
              <h3 class="panel-title">Hotovo!</h3>
            </div>
            <div class="panel-body">
              <p>Nyní je web nainstalován, vidíte že to nebylo nic tak složitého!</p>
              <form method="post">
                <input type="submit" class="btn btn-block btn-primary" value="Zobrazit web" name="completed">
              </form> 
            </div>
            <?php  
            if(@$_POST["completed"])
            {
              unlink("setup.php");
              header("location: index.php");
            }
          }
          else header("location: setup.php");
        }
        else
        {
          if(file_exists("_core/config.php")) die("DWE: I'am alredy installed.");
          //Step 1 - Database
          ?>
          <div class="panel-heading">
            <h3 class="panel-title">Připojení k databázi</h3>
          </div>
          <div class="panel-body">
            <p>Na web je potřeba databáze, napište nám údaje k vaší databázi.</p>
            <p>Tento krok může trvat o něco déle, vytváří se totiž všechny tabulky.</p>
            <form method="post">
              <div class="form-group col-lg-12">
                <label>Databázový server</label>
                <input type="text" class="form-control" name="db_server">
              </div> 
              <div class="form-group col-lg-12">
                <label>Jméno databáze</label>
                <input type="text" class="form-control" name="db_name">
              </div> 
              <div class="form-group col-lg-12">
                <label>Databázový uživatel</label>
                <input type="text" class="form-control" name="db_user">
              </div>
              <div class="form-group col-lg-12">
                <label>Heslo uživatele</label>
                <input type="password" class="form-control" name="db_password">
              </div> 
              <div class="form-group col-lg-12">
                <label>Prefix tabulek (pokud nevíte o co se jedná, nechte toto pole tak jak je)</label>
                <input type="text" class="form-control" name="db_prefix" value="<?php echo rand(10000, 99999);?>DWE_">
              </div> 
              <input type="submit" class="btn btn-block btn-primary" value="Setup Database" name="db_setup">
            </form>
            <?php
            if(@$_POST["db_setup"])
            {
              if(!empty($_POST["db_server"]) && !empty($_POST["db_name"]) && !empty($_POST["db_user"]) && !empty($_POST["db_password"]))
              {
                try {
                    $dwe_db = new PDO("mysql:host=".$_POST["db_server"].";dbname=".$_POST["db_name"], "".$_POST["db_user"]."", "".$_POST["db_password"]."", array(
                      PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                      PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET utf8"
                    )); 
                    File_CreateConfig(
                        array(
                          "DB:SERVER" => $_POST["db_server"],  
                          "DB:NAME" => $_POST["db_name"],  
                          "DB:USER" => $_POST["db_user"],  
                          "DB:PASS" => $_POST["db_password"],  
                          "DB:PREFIX" => $_POST["db_prefix"],  
                          "DWE:VERSION" => "6.0",  
                          "DWE:BUILD" => 1
                      ));  
                      header("location: setup.php?step=2");
                    $dwe_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    
                    unset($dwe_db);
                    
                    require_once "_core/config.php";
                    require_once "_core/functions/Database.func.php";
                    
                    Database_FreeSql("                   
                    CREATE TABLE IF NOT EXISTS `".$conf["DB:PREFIX"]."BANS` (
                      `BAN_ID` int(11) NOT NULL AUTO_INCREMENT,
                      `BAN_REASON` text COLLATE utf8_czech_ci NOT NULL,
                      `BAN_DATE` int(10) NOT NULL,
                      `USER_ID` varchar(11) COLLATE utf8_czech_ci NOT NULL,
                      `IP` varchar(20) COLLATE utf8_czech_ci NOT NULL,
                      PRIMARY KEY (`BAN_ID`)
                    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=1;
                    
                    CREATE TABLE IF NOT EXISTS `".$conf["DB:PREFIX"]."KEYS` (
                      `KEY_ID` int(11) NOT NULL AUTO_INCREMENT,
                      `USER_ID` int(11) NOT NULL,
                      `KEY` text COLLATE utf8_czech_ci NOT NULL,
                      `KEY_TIME` int(10) NOT NULL,
                      `KEY_TYPE` varchar(10) COLLATE utf8_czech_ci NOT NULL,
                      PRIMARY KEY (`KEY_ID`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=1;
                    
                    
                    CREATE TABLE IF NOT EXISTS `".$conf["DB:PREFIX"]."MENU` (
                      `MENU_ID` int(11) NOT NULL AUTO_INCREMENT,
                      `MENU_NAME` text COLLATE utf8_czech_ci NOT NULL,
                      `MENU_LINK` text COLLATE utf8_czech_ci NOT NULL,
                      `MENU_DROPDOWN` varchar(30) COLLATE utf8_czech_ci NOT NULL,
                      PRIMARY KEY (`MENU_ID`)
                    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=1;
                    
                    CREATE TABLE IF NOT EXISTS `".$conf["DB:PREFIX"]."MESSAGES` (
                      `MESSAGE_ID` int(11) NOT NULL AUTO_INCREMENT,
                      `MESSAGE_TOPIC` text COLLATE utf8_czech_ci NOT NULL,
                      `MESSAGE_TEXT` text COLLATE utf8_czech_ci NOT NULL,
                      `MESSAGE_TYPE` varchar(20) COLLATE utf8_czech_ci NOT NULL,
                      `SEND_USER_ID` int(11) NOT NULL,
                      `READ_USER_ID` int(11) NOT NULL,
                      `MESSAGE_DATE` int(10) NOT NULL,
                      `MESSAGE_SHOWED` varchar(10) COLLATE utf8_czech_ci NOT NULL,
                      PRIMARY KEY (`MESSAGE_ID`)
                    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=1;
                    
                    CREATE TABLE IF NOT EXISTS `".$conf["DB:PREFIX"]."OPTIONS` (
                      `OPTION_ID` int(11) NOT NULL AUTO_INCREMENT,
                      `OPTION_KEY` varchar(30) COLLATE utf8_czech_ci NOT NULL,
                      `OPTION_VALUE` text COLLATE utf8_czech_ci NOT NULL,
                      PRIMARY KEY (`OPTION_ID`)
                    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=1;
                    
                    CREATE TABLE IF NOT EXISTS `".$conf["DB:PREFIX"]."PLUGINS` (
                      `PLUGIN_ID` int(11) NOT NULL AUTO_INCREMENT,
                      `PLUGIN_NAME` text COLLATE utf8_czech_ci NOT NULL,
                      `PLUGIN_ALLOW` int(1) NOT NULL DEFAULT '0',
                      PRIMARY KEY (`PLUGIN_ID`)
                    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=1;
                    
                    CREATE TABLE IF NOT EXISTS `".$conf["DB:PREFIX"]."POSTS` (
                      `POST_ID` int(11) NOT NULL AUTO_INCREMENT,
                      `POST_NAME` text COLLATE utf8_czech_ci NOT NULL,
                      `POST_TEXT` text COLLATE utf8_czech_ci NOT NULL,
                      `POST_IMG` text COLLATE utf8_czech_ci NOT NULL,
                      `POST_DATE` int(10) NOT NULL,
                      `POST_TYPE` varchar(30) COLLATE utf8_czech_ci NOT NULL,
                      `USER_ID` int(11) NOT NULL,
                      `POST_SHOW` int(1) NOT NULL,
                      PRIMARY KEY (`POST_ID`)
                    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=1;
                    
                    CREATE TABLE IF NOT EXISTS `".$conf["DB:PREFIX"]."REPORTS` (
                      `REPORT_ID` int(11) NOT NULL AUTO_INCREMENT,
                      `REPORT_USER_ID` int(11) NOT NULL,
                      `USER_ID` int(11) NOT NULL,
                      `REPORT_CONTENT` text COLLATE utf8_czech_ci NOT NULL,
                      `REPORT_DATE` int(10) NOT NULL,
                      `REPORT_SHOW` varchar(10) COLLATE utf8_czech_ci NOT NULL,
                      `REPORT_ADMIN` varchar(11) COLLATE utf8_czech_ci NOT NULL,
                      `REPORT_MSG` int(11) NOT NULL DEFAULT '0',
                      PRIMARY KEY (`REPORT_ID`)
                    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=1;
                    
                    CREATE TABLE IF NOT EXISTS `".$conf["DB:PREFIX"]."SIDEBAR` (
                      `SIDEBAR_ID` int(11) NOT NULL AUTO_INCREMENT,
                      `SIDEBAR_NAME` text COLLATE utf8_czech_ci NOT NULL,
                      `SIDEBAR_CONTENT` text COLLATE utf8_czech_ci NOT NULL,
                      `SIDEBAR_COLOR` varchar(10) COLLATE utf8_czech_ci NOT NULL,
                      `SIDEBAR_PLUGIN` text COLLATE utf8_czech_ci NOT NULL,
                      `SIDEBAR_ALLOW` int(1) NOT NULL,
                      PRIMARY KEY (`SIDEBAR_ID`)
                    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=1;
                    
                    CREATE TABLE IF NOT EXISTS `".$conf["DB:PREFIX"]."USER` (
                      `USER_ID` int(11) NOT NULL AUTO_INCREMENT,
                      `USER_NAME` varchar(30) COLLATE utf8_czech_ci NOT NULL,
                      `USER_PASS` text COLLATE utf8_czech_ci NOT NULL,
                      `USER_SALT` text COLLATE utf8_czech_ci NOT NULL,
                      `USER_DISPLAY_NAME` varchar(50) COLLATE utf8_czech_ci NOT NULL,
                      `USER_EMAIL` varchar(255) COLLATE utf8_czech_ci NOT NULL,
                      `USER_IP` varchar(15) COLLATE utf8_czech_ci NOT NULL,
                      `USER_AVATAR` text COLLATE utf8_czech_ci NOT NULL,
                      `USER_DATE_R` int(10) NOT NULL,
                      `USER_DATE_L` int(10) NOT NULL,
                      `USER_DATE_A` int(10) NOT NULL,
                      `USER_RIGHTS` text COLLATE utf8_czech_ci NOT NULL,
                      PRIMARY KEY (`USER_ID`)
                    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=1; 
                    ");
                    
                    Database_Insert("OPTIONS", array("OPTION_VALUE" => "DWE", "OPTION_KEY" => "NAME"));
                    Database_Insert("OPTIONS", array("OPTION_VALUE" => "Czech", "OPTION_KEY" => "LANG"));
                    Database_Insert("OPTIONS", array("OPTION_VALUE" => "news_posts", "OPTION_KEY" => "HOME_PAGE"));
                    Database_Insert("OPTIONS", array("OPTION_VALUE" => $_SERVER["HTTP_HOST"], "OPTION_KEY" => "URL"));
                    Database_Insert("OPTIONS", array("OPTION_VALUE" => "default", "OPTION_KEY" => "THEME"));
                    Database_Insert("OPTIONS", array("OPTION_VALUE" => "assets/images/favicon.png", "OPTION_KEY" => "FAVICON"));
                    Database_Insert("OPTIONS", array("OPTION_VALUE" => "assets/images/dwe_logo.png", "OPTION_KEY" => "LOGO"));
                    Database_Insert("OPTIONS", array("OPTION_VALUE" => "DWE, Domm Web Engine", "OPTION_KEY" => "KEYWORDS"));
                    Database_Insert("OPTIONS", array("OPTION_VALUE" => "Web powered by DWE.", "OPTION_KEY" => "DESCRIPTION"));
                    Database_Insert("OPTIONS", array("OPTION_VALUE" => "false", "OPTION_KEY" => "CLOUDFLARE"));
                    
                    Database_Insert("OPTIONS", array("OPTION_VALUE" => "5", "OPTION_KEY" => "NEWS_PP"));
                    Database_Insert("OPTIONS", array("OPTION_VALUE" => "5", "OPTION_KEY" => "COMMENT_N_PP"));
                    Database_Insert("OPTIONS", array("OPTION_VALUE" => "3", "OPTION_KEY" => "STATUS_PP"));
                    Database_Insert("OPTIONS", array("OPTION_VALUE" => "10", "OPTION_KEY" => "MESSAGES_PP"));
                    
                } catch (PDOException $e) {
                  echo ShowNotification("danger", "Databázový server není funkční! Je možné, že jste zadali nefunkční údaje.");    
                }    
              }
              else echo ShowNotification("warning", "Musí být vyplněna všechna pole.");
            }
            ?>
          </div>
          <?php
        }
        ?>
      </div>
    </div>
  </body>
</html>