<?php
if($_SESSION["USER_ID"] > 0)
{
  if(User_Rights($_SESSION["USER_ID"], "F"))
  {
    ?>
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title"><?php echo Web_GetLocale("ADMIN_01");?></h3>
      </div>
      <div class="panel-body"> 
        <div class="row">
          <div class="col-sm-3 col-md-2">
            <ul class="nav nav-pills nav-stacked">
              <li<?php echo (empty($_GET["admin"])) ? " class='active'" : "";?> role="presentation"><a href="?page=admin"><i class="fa fa-dashboard"></i> <?php echo Web_GetLocale("ADMIN_02");?></a></li>
              <li<?php echo ($_GET["admin"] == "users") ? " class='active'" : "";?> role="presentation"><a href="?page=admin&admin=users"><i class="fa fa-user"></i> <?php echo Web_GetLocale("ADMIN_03");?></a></li>
              <li<?php echo ($_GET["admin"] == "reports") ? " class='active'" : "";?> role="presentation"><a href="?page=admin&admin=reports"><i class="fa fa-flag"></i> <?php echo Web_GetLocale("ADMIN_57");?></a></li>
              <li<?php echo ($_GET["admin"] == "bans") ? " class='active'" : "";?> role="presentation"><a href="?page=admin&admin=bans"><i class="fa fa-ban"></i> <?php echo Web_GetLocale("ADMIN_180");?></a></li>
              <li<?php echo ($_GET["admin"] == "message") ? " class='active'" : "";?> role="presentation"><a href="?page=admin&admin=message"><i class="fa fa-envelope-o"></i> <?php echo Web_GetLocale("ADMIN_78");?></a></li>
              <li<?php echo ($_GET["admin"] == "posts") ? " class='active'" : "";?> role="presentation"><a href="?page=admin&admin=posts"><i class="fa fa-pencil-square-o"></i> <?php echo Web_GetLocale("ADMIN_04");?></a></li>
              <li<?php echo ($_GET["admin"] == "design") ? " class='active'" : "";?> role="presentation"><a href="?page=admin&admin=design"><i class="fa fa-desktop"></i> <?php echo Web_GetLocale("ADMIN_07");?></a></li>
              <li<?php echo ($_GET["admin"] == "menu") ? " class='active'" : "";?> role="presentation"><a href="?page=admin&admin=menu"><i class="fa fa-link"></i> <?php echo Web_GetLocale("ADMIN_24");?></a></li> 
              <li<?php echo ($_GET["admin"] == "files") ? " class='active'" : "";?> role="presentation"><a href="?page=admin&admin=files"><i class="fa fa-file"></i> <?php echo Web_GetLocale("ADMIN_11");?></a></li>  
              <li<?php echo ($_GET["admin"] == "pages") ? " class='active'" : "";?> role="presentation"><a href="?page=admin&admin=pages"><i class="fa fa-file-text"></i> <?php echo Web_GetLocale("ADMIN_12");?></a></li>
              <li<?php echo ($_GET["admin"] == "sidebar") ? " class='active'" : "";?> role="presentation"><a href="?page=admin&admin=sidebar"><i class="fa fa-list"></i> <?php echo Web_GetLocale("ADMIN_10");?></a></li>
              <li<?php echo ($_GET["admin"] == "plugins") ? " class='active'" : "";?> role="presentation"><a href="?page=admin&admin=plugins"><i class="fa fa-plug"></i> <?php echo Web_GetLocale("ADMIN_25");?></a></li>
              <li class="divider"></li>
              <li<?php echo ($_GET["admin"] == "main") ? " class='active'" : "";?> role="presentation"><a href="?page=admin&admin=main"><i class="fa fa-gears"></i> <?php echo Web_GetLocale("ADMIN_08");?></a></li> 
              <li<?php echo ($_GET["admin"] == "other") ? " class='active'" : "";?> role="presentation"><a href="?page=admin&admin=other"><i class="fa fa-gear"></i> <?php echo Web_GetLocale("ADMIN_09");?></a></li>   
              <li<?php echo ($_GET["admin"] == "update") ? " class='active'" : "";?> role="presentation"><a href="?page=admin&admin=update"><i class="fa fa-rocket"></i> <?php echo Web_GetLocale("ADMIN_166");?></a></li>   
            </ul>
          </div>
          <div class="col-sm-9 col-md-10">
          <?php
          if(!empty($_GET["admin"]) && isset($_GET["admin"]))
          {
            if($_GET["admin"] == "posts" && User_Rights($_SESSION["USER_ID"], "K"))
            {
							if(!empty($_GET["action"]) && isset($_GET["action"]) && !empty($_GET["p"]) && isset($_GET["p"]))
							{
								if($_GET["action"] == "new" && $_GET["p"] == "x")
								{
									?>
									<h1><?php echo Web_GetLocale("ADMIN_146");?></h1>
									<form method="post">
                    <div class="form-group col-lg-12">
                    	<label><?php echo Web_GetLocale("ADMIN_148");?></label>
                      <input type="text" class="form-control" name="post_name">
                  	</div>
										<div class="form-group col-lg-12">
                    	<label><?php echo Web_GetLocale("ADMIN_152");?></label>
                      <input type="text" class="form-control" name="post_img">
                  	</div>
                    <div class="form-group col-lg-12">
                    	<label><?php echo Web_GetLocale("ADMIN_147");?></label>
                      <textarea class="form-control" name="post_content" rows="5" style="resize: vertical; overflow: auto; margin-top: 0px; margin-bottom: 0px;" placeholder="<?php echo Web_GetLocale("ADMIN_151");?>"></textarea>  
                  	</div> 
                    <input type="submit" name="post_create" class="btn btn-primary" value="<?php echo Web_GetLocale("ADMIN_149");?>">
                    <a href="?page=admin&admin=posts" class="btn btn-warning"><?php echo Web_GetLocale("ADMIN_150");?></a>
                  </form>  
									<?php
									if(@$_POST["post_create"])
									{
										if(!empty($_POST["post_content"]))
										{
											$pname = null;
											$pimg = null;
											if(empty($_POST["post_name"])) $pname = "NONE";
											else $pname = $_POST["post_name"];
											if(empty($_POST["post_img"])) $pimg = "NONE";
											else $pimg = $_POST["post_img"];
											Database_Insert("POSTS", 
												array(
												"POST_NAME" => strip_tags($pname),
												"POST_TEXT" => $_POST["post_content"],
												"POST_IMG" => $pimg,
												"POST_DATE" => time(),
												"POST_TYPE" => "news_post",
												"USER_ID" => $_SESSION["USER_ID"],
												"POST_SHOW" => 1
											));
											header("location: ?page=admin&admin=posts");		
										}
										else echo ShowNotification("warning", Web_GetLocale("ADMIN_E03"));
									}
								}
								else if($_GET["action"] == "edit")
								{
									$post = Database_Select("POSTS", array("POST_ID" => $_GET["p"], "POST_TYPE" => "news_post"));
									if($post != "N/A")
									{
										$pname = $post["POST_NAME"];
										if($pname == "NONE") $pname = Web_GetLocale("ADMIN_153");
										?>
										<h1><?php echo Web_GetLocale("ADMIN_154")." <b>".$pname."</b>";?></h1>
										<form method="post">
											<div class="form-group col-lg-12">
												<label><?php echo Web_GetLocale("ADMIN_148");?></label>
												<input type="text" class="form-control" name="post_name" value="<?php if($post["POST_NAME"] != "NONE") echo $post["POST_NAME"];?>">
											</div>
											<div class="form-group col-lg-12">
												<label><?php echo Web_GetLocale("ADMIN_152");?></label>
												<input type="text" class="form-control" name="post_img" value="<?php if($post["POST_IMG"] != "NONE") echo $post["POST_IMG"];?>">
											</div>
											<div class="form-group col-lg-12">
												<label><?php echo Web_GetLocale("ADMIN_147");?></label>
												<textarea class="form-control" name="post_content" rows="5" style="resize: vertical; overflow: auto; margin-top: 0px; margin-bottom: 0px;" placeholder="<?php echo Web_GetLocale("ADMIN_151");?>"><?php echo $post["POST_TEXT"];?></textarea>  
											</div> 
											<input type="submit" name="post_edit" class="btn btn-primary" value="<?php echo Web_GetLocale("ADMIN_155");?>">
											<a href="?page=admin&admin=posts" class="btn btn-warning"><?php echo Web_GetLocale("ADMIN_150");?></a>
											<a href="?page=admin&admin=posts&action=delete&p=<?php echo $post["POST_ID"];?>" class="btn btn-danger"><?php echo Web_GetLocale("ADMIN_156");?></a>
										</form>  
										<?php		
										if(@$_POST["post_edit"])
										{
											if(!empty($_POST["post_content"]))
											{
												$pname = null;
												$pimg = null;
												if(empty($_POST["post_name"])) $pname = "NONE";
												else $pname = $_POST["post_name"];
												if(empty($_POST["post_img"])) $pimg = "NONE";
												else $pimg = $_POST["post_img"];
												Database_Update("POSTS", 
													array(
														"POST_NAME" => strip_tags($pname),
														"POST_TEXT" => $_POST["post_content"],
														"POST_IMG" => $pimg,
														"POST_DATE" => time(),
														"USER_ID" => $_SESSION["USER_ID"],
												), array("POST_ID" => $post["POST_ID"]));		
												header("location: ?page=admin&admin=posts");
											}
											else echo ShowNotification("warning", Web_GetLocale("ADMIN_E03"));
										}
									}
									else header("location: ?page=admin&admin=posts");
								}
								else if($_GET["action"] == "delete")
								{
									$post = Database_Select("POSTS", array("POST_ID" => $_GET["p"], "POST_TYPE" => "news_post"));
									if($post != "N/A")
									{
										$pname = $post["POST_NAME"];
										if($pname == "NONE") $pname = Web_GetLocale("ADMIN_153");
										?>
										<h1><?php echo Web_GetLocale("ADMIN_157")." <b>".$pname."</b>";?>?</h1>
                    <form method="post">
                    <input type="submit" name="delete_post" value="<?php echo Web_GetLocale("ADMIN_156");?>" class="btn btn-danger">
                    <a href="?page=admin&admin=posts" class="btn btn-primary"><?php echo Web_GetLocale("ADMIN_150");?></a>  
                    </form>
										<?php
										if(@$_POST["delete_post"])
										{
											Database_Delete("POSTS", array("POST_ID" => $post["POST_ID"]));
											header("location: ?page=admin&admin=posts");	
										}
									}
									else header("location: ?page=admin&admin=posts");
								}
								else header("location: ?page=admin&admin=posts");
							}
							else
							{
            		?>
                <h1><?php echo Web_GetLocale("ADMIN_04");?></h1>
                <?php
                $post = Database_Select_All("POSTS", array("POST_TYPE" => "news_post"), "array", "ORDER BY `POST_ID` DESC");
                if(count($post) > 0)
                {
                  ?>
                  <div class="list-group">
                  <?php
                  for($i = 0;$i < count($post);$i ++)
                  {
										if($post[$i]["POST_NAME"] == "NONE") echo "<a href='?page=admin&admin=posts&action=edit&p=".$post[$i]["POST_ID"]."' class='list-group-item'>".Web_GetLocale("ADMIN_153")."</a>";
										else echo "<a href='?page=admin&admin=posts&action=edit&p=".$post[$i]["POST_ID"]."' class='list-group-item'>".$post[$i]["POST_NAME"]."</a>";
                  }
                  ?>
                  </div>
                  <?php 
								}
                ?><a href="?page=admin&admin=posts&action=new&p=x" class="btn btn-primary"><?php echo Web_GetLocale("ADMIN_146");?></a><?php
            	}
						} 
            else if($_GET["admin"] == "update" && User_Rights($_SESSION["USER_ID"], "T"))
            {
              ?>
              <h1><?php echo Web_GetLocale("ADMIN_166");?></h1>
              <?php
              if(!empty($_GET["action"]) && isset($_GET["action"]) && $_GET["action"] == "update")
              {
                $update_data = Web_VersionCheck();
                if($update_data == "OK") echo Web_GetLocale("ADMIN_171");
                else echo Web_GetLocale("ADMIN_172")."<hr>".$update_data."<hr>";
                ?>
                <br>
                <a href="?page=admin&admin=update" class="btn btn-success"><?php echo Web_GetLocale("ADMIN_B");?></a>
                <?php 
              }
              else if(!empty($_GET["action"]) && isset($_GET["action"]) && $_GET["action"] == "reupdate")
              {
                $update_data = Web_VersionCheck(1);
                echo Web_GetLocale("ADMIN_206")."<hr>".$update_data."<hr>";
                ?>
                <br>
                <a href="?page=admin&admin=update" class="btn btn-success"><?php echo Web_GetLocale("ADMIN_B");?></a>
                <?php 
              }
              else
              {
                ?>
                <p>
                <ul>
                  <li><?php echo Web_GetLocale("ADMIN_167");?>: <?php echo ShowTime(filemtime("_core/config.php"));?></li>
                  <li><?php echo Web_GetLocale("ADMIN_168");?>: <?php echo Web_GetVersion();?></li>
                </ul>
                <a href="?page=admin&admin=update&action=update" class="btn btn-success"><?php echo Web_GetLocale("ADMIN_169");?></a>
                <a href="?page=admin&admin=update&action=reupdate" class="btn btn-warning"><?php echo Web_GetLocale("ADMIN_205");?></a>
                <p>*<?php echo Web_GetLocale("ADMIN_170");?></p>
                <?php
                echo "<h2>".Web_GetLocale("ADMIN_204")."</h2>";
                echo Web_ShowUpdates();
              }
            }
            else if($_GET["admin"] == "menu" && User_Rights($_SESSION["USER_ID"], "M"))
            {   
              if(!empty($_GET["action"]) && isset($_GET["action"]))
              {
                if($_GET["action"] == "new_link")
                {
                  ?>
                  <h1>
                  <?php 
                  echo Web_GetLocale("ADMIN_129");
                  if(!empty($_GET["d"]) && isset($_GET["d"]))
                  {
                    $dd = Database_Select("MENU", array("MENU_ID" => $_GET["d"]));
                    if($dd != "N/A")
                    {
                      echo Web_GetLocale("ADMIN_135")." <b>".$dd["MENU_NAME"]."</b>";
                    }
                    else header("location: ?page=admin&admin=menu");
                  }
                  ?>
                  </h1>
                  <form method="post">
                    <div class="form-group col-lg-12">
                    	<label><?php echo Web_GetLocale("ADMIN_130");?></label>
                      <input type="text" class="form-control" name="link_name">
                  	</div>
                    <div class="form-group col-lg-12">
                    	<label><?php echo Web_GetLocale("ADMIN_131");?></label>
                      <input type="text" class="form-control" name="link_url">
                  	</div> 
                    <input type="submit" name="link_create" class="btn btn-primary" value="<?php echo Web_GetLocale("ADMIN_125");?>">
                    <a href="?page=admin&admin=menu" class="btn btn-warning"><?php echo Web_GetLocale("ADMIN_132");?></a>
                  </form>  
                  <?php
                  if(@$_POST["link_create"])
                  {
                    if(!empty($_POST["link_name"]) && !empty($_POST["link_url"]))
                    {
                      if(!empty($_GET["d"]) && isset($_GET["d"]))
                      {
                        Database_Insert("MENU",
                          array(
                            "MENU_NAME" => strip_tags($_POST["link_name"]),
                            "MENU_LINK" => $_POST["link_url"],
                            "MENU_DROPDOWN" => $_GET["d"]
                        )); 
                      }
                      else
                      {
                        Database_Insert("MENU",
                          array(
                            "MENU_NAME" => strip_tags($_POST["link_name"]),
                            "MENU_LINK" => $_POST["link_url"],
                            "MENU_DROPDOWN" => "NONE"
                        ));  
                      }
                      header("location: ?page=admin&admin=menu");
                    }
                    else echo ShowNotification("warning", Web_GetLocale("ADMIN_E03"));
                  }
                }
                else if($_GET["action"] == "new_dropdown")
                {
                  ?>
                  <h1><?php echo Web_GetLocale("ADMIN_133");?></h1>
                  <form method="post">
                    <div class="form-group col-lg-12">
                    	<label><?php echo Web_GetLocale("ADMIN_134");?></label>
                      <input type="text" class="form-control" name="cat_name">
                  	</div>
                    <input type="submit" name="cat_create" class="btn btn-primary" value="<?php echo Web_GetLocale("ADMIN_126");?>">
                    <a href="?page=admin&admin=menu" class="btn btn-warning"><?php echo Web_GetLocale("ADMIN_132");?></a>
                  </form>  
                  <?php
                  if(@$_POST["cat_create"])
                  {
                    if(!empty($_POST["cat_name"]))
                    {
                      Database_Insert("MENU",
                        array(
                          "MENU_NAME" => $_POST["cat_name"],
                          "MENU_LINK" => "NONE",
                          "MENU_DROPDOWN" => "MAIN"
                      )); 
                      header("location: ?page=admin&admin=menu");
                    }
                    else echo ShowNotification("warning", Web_GetLocale("ADMIN_E03"));
                  }
                }
                else if($_GET["action"] == "edit")
                {
                  if(!empty($_GET["l"]) && isset($_GET["l"]))
                  {
                    $ll = Database_Select("MENU", array("MENU_ID" => $_GET["l"]));
                    if($ll != "N/A")
                    {
                      ?>
                      <h1><?php echo Web_GetLocale("ADMIN_138")." <b>".$ll["MENU_NAME"]."</b>";?></h1>
                      <form method="post">
                        <div class="form-group col-lg-12">
                        	<label><?php echo Web_GetLocale("ADMIN_130");?></label>
                          <input type="text" class="form-control" name="link_name" value="<?php echo $ll["MENU_NAME"];?>">
                      	</div>
                        <div class="form-group col-lg-12">
                        	<label><?php echo Web_GetLocale("ADMIN_131");?></label>
                          <input type="text" class="form-control" name="link_url" value="<?php echo $ll["MENU_LINK"];?>">
                      	</div> 
                        <input type="submit" name="link_edit" class="btn btn-primary" value="<?php echo Web_GetLocale("ADMIN_142");?>">
                        <a href="?page=admin&admin=menu" class="btn btn-warning"><?php echo Web_GetLocale("ADMIN_132");?></a>
                        <a href="?page=admin&admin=menu&action=delete&l=<?php echo $ll["MENU_ID"];?>" class="btn btn-danger"><?php echo Web_GetLocale("ADMIN_143");?></a>
                      </form> 
                      <?php
                      if(@$_POST["link_edit"])
                      {
                        if(!empty($_POST["link_name"]) && !empty($_POST["link_url"]))
                        {
                          Database_Update("MENU", array("MENU_NAME" => strip_tags($_POST["link_name"]), "MENU_LINK" => $_POST["link_url"]), array("MENU_ID" => $ll["MENU_ID"]));
                          header("location: ?page=admin&admin=menu");
                        }
                        else header("location: ?page=admin&admin=menu");
                      }
                    }
                    else header("location: ?page=admin&admin=menu");
                  }
                  else if(!empty($_GET["d"]) && isset($_GET["d"]))
                  {
                    $dd = Database_Select("MENU", array("MENU_ID" => $_GET["d"]));
                    if($dd != "N/A")
                    {
                      ?>
                      <h1><?php echo Web_GetLocale("ADMIN_133")." <b>".$dd["MENU_NAME"]."</b>";?></h1>
                      <form method="post">
                        <div class="form-group col-lg-12">
                        	<label><?php echo Web_GetLocale("ADMIN_134");?></label>
                          <input type="text" class="form-control" name="cat_name" value="<?php echo $dd["MENU_NAME"];?>">
                      	</div>
                        <input type="submit" name="cat_edit" class="btn btn-primary" value="<?php echo Web_GetLocale("ADMIN_140");?>">
                        <a href="?page=admin&admin=menu" class="btn btn-warning"><?php echo Web_GetLocale("ADMIN_132");?></a>
                        <a href="?page=admin&admin=menu&action=delete&d=<?php echo $dd["MENU_ID"];?>" class="btn btn-danger"><?php echo Web_GetLocale("ADMIN_141");?></a>
                      </form> 
                      <?php
                      if(@$_POST["cat_edit"])
                      {
                        if(!empty($_POST["cat_name"]))
                        {
                          Database_Update("MENU", array("MENU_NAME" => strip_tags($_POST["cat_name"])), array("MENU_ID" => $dd["MENU_ID"]));
                          header("location: ?page=admin&admin=menu");
                        }
                        else header("location: ?page=admin&admin=menu");
                      }
                    }
                    else header("location: ?page=admin&admin=menu");
                  }
                  else header("location: ?page=admin&admin=menu");
                }
                else if($_GET["action"] == "delete")
                {
                  if(!empty($_GET["l"]) && isset($_GET["l"]))
                  {
                    $ll = Database_Select("MENU", array("MENU_ID" => $_GET["l"]));
                    if($ll != "N/A")
                    {
                      ?>
                      <h1><?php echo Web_GetLocale("ADMIN_144")." <b>".$ll["MENU_NAME"]."</b>";?></h1>
                      <form method="post">
                      <input type="submit" name="delete_link" value="<?php echo Web_GetLocale("ADMIN_143");?>" class="btn btn-danger">
                      <a href="?page=admin&admin=menu" class="btn btn-primary"><?php echo Web_GetLocale("ADMIN_132");?></a>  
                      </form>
                      <?php
                      if(@$_POST["delete_link"])
                      {
                        Database_Delete("MENU", array("MENU_ID" => $ll["MENU_ID"]));
                        header("location: ?page=admin&admin=menu");
                      }
                    }
                  }
                  else if(!empty($_GET["d"]) && isset($_GET["d"]))
                  {
                    $dd = Database_Select("MENU", array("MENU_ID" => $_GET["d"]));
                    if($dd != "N/A")
                    {
                      ?>
                      <h1><?php echo Web_GetLocale("ADMIN_145")." <b>".$dd["MENU_NAME"]."</b>";?></h1>
                      <form method="post">
                      <input type="submit" name="delete_cat" value="<?php echo Web_GetLocale("ADMIN_141");?>" class="btn btn-danger">
                      <a href="?page=admin&admin=menu" class="btn btn-primary"><?php echo Web_GetLocale("ADMIN_132");?></a>  
                      </form>
                      <?php
                      if(@$_POST["delete_cat"])
                      {
                        Database_Delete("MENU", array("MENU_ID" => $dd["MENU_ID"]));
                        Database_Delete("MENU", array("MENU_DROPDOWN" => $dd["MENU_ID"])); 
                        header("location: ?page=admin&admin=menu");
                      }
                    } 
                  }
                  else header("location: ?page=admin&admin=menu");
                }
                else header("location: ?page=admin&admin=menu");
              }
              else
              {
                ?>
                <h1><?php echo Web_GetLocale("ADMIN_122");?></h1>
                <?php
                $menu = Database_Select_All("MENU", array("NONE" => "NONE"));
                  for($i = 0;$i < count($menu);$i ++)
                  {
                    if($menu[$i]["MENU_DROPDOWN"] == "NONE") echo "<li>[".Web_GetLocale("ADMIN_123")."] ".$menu[$i]["MENU_NAME"]." - <a class='btn btn-warning btn-xs' href='?page=admin&admin=menu&action=edit&l=".$menu[$i]["MENU_ID"]."'>".Web_GetLocale("ADMIN_127")."</a></li>";
                    else if($menu[$i]["MENU_DROPDOWN"] == "MAIN")
                    {
                      echo "<li>[".Web_GetLocale("ADMIN_124")."] ".$menu[$i]["MENU_NAME"]." - <a class='btn btn-warning btn-xs' href='?page=admin&admin=menu&action=edit&d=".$menu[$i]["MENU_ID"]."'>".Web_GetLocale("ADMIN_128")."</a>";
                      echo "<ul>";
                      $menu_d = Database_Select_All("MENU", array("MENU_DROPDOWN" => $menu[$i]["MENU_ID"]));       
                      if(count($menu_d) > 0)
                      {
                        for($y = 0;$y < count($menu_d);$y ++)
                        {
                          echo "<li>[".Web_GetLocale("ADMIN_123")."] ".$menu_d[$y]["MENU_NAME"]." - <a class='btn btn-warning btn-xs' href='?page=admin&admin=menu&action=edit&l=".$menu_d[$y]["MENU_ID"]."'>".Web_GetLocale("ADMIN_127")."</a></li>";  
                        }              
                      }  
                      echo "<li><a class='btn btn-primary btn-xs' href='?page=admin&admin=menu&action=new_link&d=".$menu[$i]["MENU_ID"]."'>".Web_GetLocale("ADMIN_125")."</a></li>";
                      echo "</ul>";
                      echo "</li>";
                    }
                  }
                  echo "<li><a class='btn btn-primary btn-xs' href='?page=admin&admin=menu&action=new_link'>".Web_GetLocale("ADMIN_125")."</a></li>";
                  echo "<li><a class='btn btn-primary btn-xs' href='?page=admin&admin=menu&action=new_dropdown'>".Web_GetLocale("ADMIN_126")."</a></li>";  
                  echo "<br>";
                  echo Web_GetLocale("ADMIN_136");
                  
                  if(User_Rights($_SESSION["USER_ID"], "M"))
                  {
                    ?>
                    <h2><?php echo Web_GetLocale("ADMIN_137");?></h2>
                    <form method="post">
                      <div class="form-group col-lg-12">
                        <div class="radio">
                          <label>
                            <input type="radio" name="menu_style" id="menu_style1" value="default"<?php if(Web_GetOption("MENU") == "default") echo " checked"?>>
                            Styl 1
                          </label>
                        </div>
                        <div class="radio">
                          <label>
                            <input type="radio" name="menu_style" id="menu_style2" value="inverse"<?php if(Web_GetOption("MENU") == "inverse") echo " checked"?>>
                            Styl 2
                          </label>
                        </div>
                      </div>
                      <input type="submit" name="change_style" class="btn btn-primary" value="<?php echo Web_GetLocale("ADMIN_S");?>"> 
                    </form>
                    <?php   
                    if(@$_POST["change_style"])
                    {
                      if(!empty($_POST["menu_style"]) && isset($_POST["menu_style"]))
                      {
                        if($_POST["menu_style"] == "default" || $_POST["menu_style"] == "inverse")
                        {
                          Database_Update("OPTIONS", array("OPTION_VALUE" => $_POST["menu_style"]), array("OPTION_KEY" => "MENU"));
                          header("location: ?page=admin&admin=menu");
                        }
                        else header("location: ?page=admin&admin=menu");
                      }
                      else header("location: ?page=admin&admin=menu"); 
                    } 
                  }
                
                ?>
                
                <?php
              }
            }
            else if($_GET["admin"] == "bans" && User_Rights($_SESSION["USER_ID"], "I"))
						{
              if(!empty($_GET["action"]) && isset($_GET["action"]) && !empty($_GET["ban"]) && isset($_GET["ban"]))
              {  
                if($_GET["action"] == "view")
                {
                  $ban_data = Database_Select("BANS", array("BAN_ID" => $_GET["ban"]));
                  if($ban_data != "N/A")
                  {
                    ?>
                    <h1><?php echo Web_GetLocale("ADMIN_180")." #".$_GET["ban"];?></h1>
                    <?php
                    if($ban_data["USER_ID"] != "NONE") echo "<p><b>".Web_GetLocale("BAN_06").":</b> ".User_Name($ban_data["USER_ID"])."</p>";
                    else echo "<p><b>".Web_GetLocale("BAN_07").":</b> ".$ban_data["IP"]."</p>";  
                    ?>
                    <p>
                      <b><?php echo Web_GetLocale("BAN_02");?>:</b><br>
                      <?php echo StrMagic($ban_data["BAN_REASON"]);?>   
                    </p>
                    <p><?php echo Web_GetLocale("BAN_05")." <b>".ShowTime($ban_data["BAN_DATE"])."</b>.";?></p>
                    <a href="?page=admin&admin=bans" class="btn btn-success"><?php echo Web_GetLocale("ADMIN_B");?></a>
                    <a href="?page=admin&admin=bans&ban=<?php echo $_GET["ban"];?>&action=delete" class="btn btn-danger"><?php echo Web_GetLocale("ADMIN_194");?></a>
                    <?php
                  }
                  else header("location: ?page=admin&admin=bans");
                }
                else if($_GET["action"] == "delete")
                {
                  $ban_data = Database_Select("BANS", array("BAN_ID" => $_GET["ban"]));
                  if($ban_data != "N/A")
                  {
                    ?>
                    <h1><?php echo Web_GetLocale("ADMIN_195");?></h1>
                    <form method="post">
                      <input type="submit" name="delete_ban" value="<?php echo Web_GetLocale("ADMIN_196");?>" class="btn btn-danger">
                      <a href="?page=admin&admin=bans" class="btn btn-primary"><?php echo Web_GetLocale("ADMIN_B");?></a>  
                    </form>
                    <?php  
                    if(@$_POST["delete_ban"])
                    {
                      Database_Delete("BANS", array("BAN_ID" => $_GET["ban"]));
                      header("location: ?page=admin&admin=bans");
                    }                       
                  }
                  else header("location: ?page=admin&admin=bans");  
                }
                else if($_GET["action"] == "new" && $_GET["ban"] == "x")
                {
                  ?>
                  <h1><?php echo Web_GetLocale("ADMIN_197");?></h1>
                  <form method="post">
                    <div class="form-group col-lg-12">
                      <label><?php echo Web_GetLocale("ADMIN_178");?></label>
                      <input type="text" class="form-control" name="ban_ip">
                    </div>
                    <div class="form-group col-lg-12">
                      <label><?php echo Web_GetLocale("BAN_02");?></label>
                      <textarea class="form-control" name="ban_reason" rows="5" style="resize: vertical; overflow: auto; margin-top: 0px; margin-bottom: 0px;" placeholder="<?php echo Web_GetLocale("ADMIN_182");?>"></textarea>
                    </div>
                    <input type="submit" name="add_ban" value="<?php echo Web_GetLocale("ADMIN_192");?>" class="btn btn-warning">
                    <a href="?page=admin&admin=bans" class="btn btn-primary"><?php echo Web_GetLocale("ADMIN_B");?></a>
                  </form>
                  <?php 
                  if(@$_POST["add_ban"])
                  {
                    if(!empty($_POST["ban_ip"]) && !empty($_POST["ban_reason"]))
                    {
                      if (filter_var($_POST["ban_ip"], FILTER_VALIDATE_IP))
                      {
                        $ban_id = Database_Insert("BANS", 
                          array(
                            "BAN_REASON" => $_POST["ban_reason"],
                            "BAN_DATE" => time(),
                            "USER_ID" => "NONE",
                            "IP" => $_POST["ban_ip"]
                        ));
                        header("location: ?page=admin&admin=bans&ban=".$ban_id."&action=view"); 
                      }  
                      else echo ShowNotification("warning", Web_GetLocale("ADMIN_E06")); 
                    }
                    else echo ShowNotification("warning", Web_GetLocale("ADMIN_E03"));
                  }
                }
                else header("location: ?page=admin&admin=bans");
              }
              else
              {
                ?>
                <h1><?php echo Web_GetLocale("ADMIN_188");?></h1>
                <div class='table-responsive'>
                  <table class='table table-hover'>
  								  <tr>
  										<th width='1%'>#</th>
  										<th width='39%'><?php echo Web_GetLocale("ADMIN_189");?></th>
  										<th width='20%'><?php echo Web_GetLocale("ADMIN_178");?></th>
  										<th width='20%'><?php echo Web_GetLocale("ADMIN_58");?></th>
  										<th width='20%'><?php echo Web_GetLocale("ADMIN_163");?></th>
  									</tr>
                    <?php
                    $ban = Database_Select_All("BANS", array("NONE" => "NONE"));
                    if(count($ban) > 0)
                    {
                      for($i = 0;$i < count($ban);$i++)
                      {
                        ?>
                        <tr>
                          <td><?php echo $i+1;?></td>
                          <td><?php echo ShowTime($ban[$i]["BAN_DATE"]);?></td>
                          <td><?php echo $ban[$i]["IP"];?></td>
                          <td>
                          <?php 
                          if($ban[$i]["USER_ID"] != "NONE") echo User_Name($ban[$i]["USER_ID"]);
                          else echo "NONE";
                          ?>
                          </td>
                          <td><a href="?page=admin&admin=bans&ban=<?php echo $ban[$i]["BAN_ID"];?>&action=view"><?php echo Web_GetLocale("ADMIN_191");?></a></td>
                        </tr>
                        <?php 
                      } 
                    }
                    else echo "<tr><td colspan='5'><center>".Web_GetLocale("ADMIN_190")."</center></td></tr>";
                    ?>
                  </table>
                  <a href="?page=admin&admin=bans&ban=x&action=new" class="btn btn-warning"><?php echo Web_GetLocale("ADMIN_192");?></a>
                  <a href="?page=admin&admin=users" class="btn btn-warning"><?php echo Web_GetLocale("ADMIN_193");?></a>
                </div>
                <?php
              }
            }
						else if($_GET["admin"] == "users" && User_Rights($_SESSION["USER_ID"], "G"))
						{
							if(!empty($_GET["action"]) && isset($_GET["action"]) && !empty($_GET["user"]) && isset($_GET["user"]))
              {
                if($_GET["action"] == "edit")
                {
                  $user_id = Database_Select("USER", array("USER_NAME" => $_GET["user"]), "USER_ID");
                  if($user_id > 0)
                  {
                    ?>
                    <h2><?php echo Web_GetLocale("PROFILE_01");?> <b><?php echo $_GET["user"];?></b></h2>
                    <div class="row">
                      <div class="col-md-2 col-lg-2" align="center">
                        <img width="129px" height="129px" alt="<?php echo User_Data($user_id, "USER_DISPLAY_NAME");?>" src="<?php echo User_Data($user_id, "USER_AVATAR");?>" class="img-rounded img-responsive">
                        <form method="post">
                          <input type="submit" class="btn btn-danger" name="avatar_del" value="<?php echo Web_GetLocale("SETTINGS_09");?>">
                        </form>
                      </div>
                      <div class=" col-md-10 col-lg-10"> 
                        <form method="post">
                        <table class="table table-user-information">
                          <thead>
                            <tr>
                              <th width="30%"><?php echo Web_GetLocale("ADMIN_173");?></th>
                              <th width="70%"><?php echo Web_GetLocale("ADMIN_174");?></th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td><?php echo Web_GetLocale("PROFILE_02");?></td>
                              <td><input type="text" class="form-control" name="user_name" value="<?php echo User_Data($user_id, "USER_NAME");?>"</td>
                            </tr>  
                            <tr>
                              <td><?php echo Web_GetLocale("PROFILE_03");?></td>
                              <td><input type="text" class="form-control" name="user_display_name" value="<?php echo User_Data($user_id, "USER_DISPLAY_NAME");?>"</td>
                            </tr>  
                            <tr>
                              <td><?php echo Web_GetLocale("PROFILE_04");?></td>
                              <td><input type="text" class="form-control" name="user_email" value="<?php echo User_Data($user_id, "USER_EMAIL");?>"</td>
                            </tr>  
                            <tr>
                              <td><?php echo Web_GetLocale("SETTINGS_12");?></td>
                              <td><input type="text" class="form-control" name="user_avatar" value="<?php echo User_Data($user_id, "USER_AVATAR");?>"</td>
                            </tr>
                            <tr>
                              <td><?php echo Web_GetLocale("ADMIN_175");?></td>
                              <td><input type="text" class="form-control" name="user_rights" value="<?php echo User_Data($user_id, "USER_RIGHTS");?>"</td>
                            </tr>
                            <tr>
                              <td><?php echo Web_GetLocale("ADMIN_178");?></td>
                              <td><a href="http://whatismyipaddress.com/ip/<?php echo User_Data($user_id, "USER_IP");?>" target='_blank'><?php echo User_Data($user_id, "USER_IP");?></a></td>
                            </tr>
                            <tr>
                              <td>
                                <a href="?page=admin&admin=users" class="btn btn-primary"><?php echo Web_GetLocale("ADMIN_179");?></a>
                              </td>
                              <td align='right'>
                                <input type="submit" class="btn btn-success" name="user_save" value="<?php echo Web_GetLocale("ADMIN_S");?>">
                                <a href="?page=admin&admin=users&user=<?php echo $_GET["user"];?>&action=ban" class="btn btn-warning"><?php echo Web_GetLocale("ADMIN_177");?></a>
                                <a href="?page=admin&admin=users&user=<?php echo $_GET["user"];?>&action=delete" class="btn btn-danger"><?php echo Web_GetLocale("ADMIN_176");?></a>
                              </td>
                            </tr>  
                          </tbody>
                        </table>
                        </form>
                        <?php
                        if(@$_POST["avatar_del"])
                        {
                          if($user["USER_RIGHTS"] != "G")
                          {
                            Database_Update("USER", array("USER_AVATAR" => "assets/images/noav.png"), array("USER_ID" => $user_id));
                            header("location: ?page=admin&admin=users&user=".$_GET["user"]."&action=edit");
                          }
                        }
                        if(@$_POST["user_save"])
                        {
                          if(!empty($_POST["user_display_name"]) && !empty($_POST["user_name"]) && !empty($_POST["user_email"]) && !empty($_POST["user_avatar"]) && !empty($_POST["user_rights"]))
                          {
                            if(User_Data($user_id, "USER_RIGHTS") != "X" && User_Rights($_SESSION["USER_ID"], "G"))
                            {
                              Database_Update("USER", 
                                array(
                                  "USER_DISPLAY_NAME" => $_POST["user_display_name"],
                                  "USER_NAME" => $_POST["user_name"],
                                  "USER_EMAIL" => $_POST["user_email"],
                                  "USER_AVATAR" => $_POST["user_avatar"],
                                  "USER_RIGHTS" => $_POST["user_rights"]                                  
                              ), array("USER_ID" => $user_id));
                              ShowNotification("success", Web_GetLocale("SETTINGS_EOK"));    
                            }
                            else header("location: ?page=admin&admin=users&user=".$_GET["user"]."&action=edit");  
                          } 
                          else echo ShowNotification("warning", Web_GetLocale("ADMIN_E03"));
                        }
                        ?>
                      </div>
                    </div>
                    <?php
                  }
                }
                else if($_GET["action"] == "ban")
                {
                  $user = Database_Select("USER", array("USER_NAME" => $_GET["user"]));
                  if($user != "N/A")
                  {
                    if($user["USER_RIGHTS"] != "X" && User_Rights($_SESSION["USER_ID"], "I"))
                    {
                      ?>
                      <h1><?php echo Web_GetLocale("ADMIN_181")." <b>".$_GET["user"]."</b>";?></h1>
                      <form method="post">
                        <div class="form-group col-lg-12">
                          <label><?php echo Web_GetLocale("PROFILE_02");?></label>
                          <input type="text" class="form-control" name="ban_user" value="<?php echo $_GET["user"];?>" readonly>
                        </div>
                        <div class="form-group col-lg-12">
                          <label><?php echo Web_GetLocale("BAN_02");?></label>
                          <textarea class="form-control" name="ban_reason" rows="5" style="resize: vertical; overflow: auto; margin-top: 0px; margin-bottom: 0px;" placeholder="<?php echo Web_GetLocale("ADMIN_182");?>"></textarea>
                        </div>
                        <input type="submit" name="create_ban" class="btn btn-danger" value="<?php echo Web_GetLocale("ADMIN_181");?>">
                        <a href="?page=admin&admin=users&user=<?php echo $_GET["user"];?>&action=edit" class="btn btn-warning"><?php echo Web_GetLocale("ADMIN_B");?></a>
                      </form>
                      <?php
                      if(@$_POST["create_ban"])
                      {
                        if(!empty($_POST["ban_reason"]))
                        {
                          Database_Insert("BANS", 
                            array(
                            "BAN_REASON" => $_POST["ban_reason"],
                            "BAN_DATE" => time(),
                            "USER_ID" => $user["USER_ID"],
                            "IP" => "NONE"
                          ));
                          header("location: ?page=admin&admin=bans");
                        } 
                      }
                    }
                    else header("location: ?page=admin&admin=users");
                  }
                  else header("location: ?page=admin&admin=users");
                }
                else if($_GET["action"] == "delete")
                {
                  $user = Database_Select("USER", array("USER_NAME" => $_GET["user"]));
                  if($user != "N/A")
                  {
                    if($user["USER_RIGHTS"] != "X" && User_Rights($_SESSION["USER_ID"], "X"))
                    {
                      ?>
                      <h1><?php echo Web_GetLocale("ADMIN_183")." <b>".$_GET["user"]."</b>?";?></h1>
                      <form method="post">
                        <input type="submit" name="delete_user" value="<?php echo Web_GetLocale("ADMIN_176");?>" class="btn btn-danger">
                        <a href="?page=admin&admin=users" class="btn btn-primary"><?php echo Web_GetLocale("ADMIN_B");?></a>  
                      </form>
                      <?php
                      if(@$_POST["delete_user"]) 
                      {
                        Database_Delete("POSTS", array("POST_TYPE" => "status_post", "USER_ID" => $user["USER_ID"]));
                        Database_Delete("USER", array("USER_ID" => $user["USER_ID"]));
                        header("location: ?page=admin&admin=users");
                      } 
                    }
                    else header("location: ?page=admin&admin=users");
                  }
                  else header("location: ?page=admin&admin=users");
                }
                else header("location: ?page=admin&admin=users");
							}
							else
							{
								?>
								<h1><?php echo Web_GetLocale("ADMIN_158");?></h1>	
								<?php
								$count = 0;
								$user_pp = 0;          
								$link = null;
								
								$count = Database_CountTable("USER");
								$user_pp = 30;   
								$link = "?page=admin&admin=users&s=";
								
								$page = 0;  
								$pages = $count / $user_pp;
								$pages = round_up($pages);

								if(!empty($_GET["s"]) && isset($_GET["s"]) && is_numeric($_GET["s"])) 
								{
									if($_GET["s"] > $pages) $page = $pages;
									else if($_GET["s"] < 0) $page = 1;
									else $page = $_GET["s"];
								}
								else $page = 1;

								$start = ($page - 1)  * $user_pp; 
								$end = min(($start + $user_pp), $count); 

								$page_back = $page - 1;
								$page_next = $page + 1;
								
								$user = Database_Select_All("USER", array("NONE" => "NONE"));
								
								?>
								<div class='table-responsive'>
                	<table class='table table-hover'>
									<tr>
										<th width='1%'>#</th>
										<th width='39%'><?php echo Web_GetLocale("ADMIN_159");?> (<?php echo Web_GetLocale("ADMIN_160");?>)</th>
										<th width='20%'><?php echo Web_GetLocale("ADMIN_161");?></th>
										<th width='20%'><?php echo Web_GetLocale("ADMIN_162");?></th>
										<th width='20%'><?php echo Web_GetLocale("ADMIN_163");?></th>
									</tr>
									<?php
									for($i = 0;$i < count($user);$i++) 
									{
										if($i >= $start && $i < $end)
										{
											?>
											<tr>
												<td><img alt="Avatar" width="20px" height="20px" src="<?php echo $user[$i]["USER_AVATAR"];?>"></td>
												<td><?php echo $user[$i]["USER_DISPLAY_NAME"];?> (<?php echo $user[$i]["USER_NAME"];?>)</td>
												<td><?php echo ShowTime($user[$i]["USER_DATE_R"]);?></td>
												<td><?php echo ShowTime($user[$i]["USER_DATE_L"]);?></td>
												<td><a href='?page=admin&admin=users&user=<?php echo $user[$i]["USER_NAME"];?>&action=edit'><?php echo Web_GetLocale("ADMIN_164");?></a></td>
											</tr>
											<?php
										}
									}
									?>
									</table>
								</div>
								<?php
								if($pages > 1)
								{
									echo "<center>";
									echo "<ul class='pagination'>";

									if($page == 1 || $page == "1") echo "<li class='disabled'><a><i class='fa fa-angle-double-left'></i></a></li>";
									else echo "<li><a href='".$link."1'><i class='fa fa-angle-double-left'></i></a></li>";

									if($page == 1 || $page == "1") echo "<li class='disabled'><a><i class='fa fa-angle-left'></i></a></li>";
									else echo "<li><a href='".$link.$page_back."'><i class='fa fa-angle-left'></i></a></li>";

									for($i = 1;$i < $pages+1;$i++)
									{
										if($i == $page) echo "<li class='active'><a href='".$link.$i."'>".$i."</a></li>";
										else echo "<li><a href='".$link.$i."'>".$i."</a></li>"; 
									}

									if($page == $pages) echo "<li class='disabled'><a><i class='fa fa-angle-right'></i></a></li>";
									else echo "<li><a href='".$link.$page_next."'><i class='fa fa-angle-right'></i></a></li>";

									if($page == $pages) echo "<li class='disabled'><a><i class='fa fa-angle-double-right'></i></a></li>";
									else echo "<li><a href='".$link.$end."'><i class='fa fa-angle-double-right'></i></a></li>";
									echo "</ul>";
									echo "</center>"; 
								}
							}
						}
            else if($_GET["admin"] == "pages" && User_Rights($_SESSION["USER_ID"], "O"))
            {
              if(!empty($_GET["action"]) && isset($_GET["action"]) && !empty($_GET["p"]) && isset($_GET["p"]))
              {
                if($_GET["action"] == "new" && $_GET["p"] == "x")
                {
                  ?>
                  <h1><?php echo Web_GetLocale("ADMIN_108");?></h1>
                  <form method="post">
                  <div class="form-group col-lg-12">
                  	<label><?php echo Web_GetLocale("ADMIN_109");?></label>
                    <input type="text" class="form-control" name="page_name">
                	</div>
                  <div class="form-group col-lg-12">
                  	<label><?php echo Web_GetLocale("ADMIN_110");?></label>
                    <textarea class="form-control" name="page_content" rows="5" style="resize: vertical; overflow: auto; margin-top: 0px; margin-bottom: 0px;" placeholder="<?php echo Web_GetLocale("ADMIN_111");?>"></textarea>  
                	</div> 
                  <div class="form-group col-lg-12">
                  	<label><?php echo Web_GetLocale("ADMIN_112");?></label>
                    <select name="page_access_mode" class="form-control">
                      <option value="1"><?php echo Web_GetLocale("ADMIN_113");?></option>
                      <option value="2"><?php echo Web_GetLocale("ADMIN_114");?></option>
                    </select>
                	</div> 
                  <input type="submit" name="create_page" class="btn btn-primary" value="<?php echo Web_GetLocale("ADMIN_115");?>">
                  <a href="?page=admin&admin=pages" class="btn btn-warning"><?php echo Web_GetLocale("ADMIN_116");?></a>
                  </form>
                  <?php       
                  if(@$_POST["create_page"])
                  {
                    if(!empty($_POST["page_name"]) && !empty($_POST["page_content"]) && !empty($_POST["page_access_mode"]))
                    {
                      Database_Insert("POSTS", 
                        array(
                          "POST_NAME" => strip_tags($_POST["page_name"]),
                          "POST_TEXT" => $_POST["page_content"],
                          "POST_IMG" => "NONE",
                          "POST_DATE" => time(),
                          "POST_TYPE" => "page_post",
                          "USER_ID" => $_SESSION["USER_ID"],
                          "POST_SHOW" => $_POST["page_access_mode"]
                      ));
                      header("location: ?page=admin&admin=pages");
                    }
                    else echo ShowNotification("warning", Web_GetLocale("ADMIN_E03"));
                  }
                }
                else if($_GET["action"] == "edit")
                {
                  $page = Database_Select("POSTS", array("POST_TYPE" => "page_post", "POST_ID" => $_GET["p"]));
                  if($page != "N/A")
                  {
                    ?>
                    <h1><?php echo Web_GetLocale("ADMIN_117")." <b>".$page["POST_NAME"]."</b>";?> <?php if(User_Rights($_SESSION["USER_ID"], "X")) echo "<a target='_blank' href='?page=pages&p=".$_GET["p"]."' class='btn btn-xs btn-info'>".Web_GetLocale("ADMIN_121")."</a>";?></h1>
                    <form method="post">
                      <div class="form-group col-lg-12">
                      	<label><?php echo Web_GetLocale("ADMIN_109");?></label>
                        <input type="text" class="form-control" name="page_name" value="<?php echo $page["POST_NAME"];?>">
                    	</div>
                      <div class="form-group col-lg-12">
                      	<label><?php echo Web_GetLocale("ADMIN_110");?></label>
                        <textarea class="form-control" name="page_content" rows="5" style="resize: vertical; overflow: auto; margin-top: 0px; margin-bottom: 0px;" placeholder="<?php echo Web_GetLocale("ADMIN_111");?>"><?php echo $page["POST_TEXT"];?></textarea>  
                    	</div> 
                      <div class="form-group col-lg-12">
                      	<label><?php echo Web_GetLocale("ADMIN_112");?></label>
                        <select name="page_access_mode" class="form-control">
                        <?php
                        if($page["POST_SHOW"] == 1) echo "<option value='1' selected>".Web_GetLocale("ADMIN_113")."</option>";
                        else echo "<option value='1'>".Web_GetLocale("ADMIN_113")."</option>";
                        
                        if($page["POST_SHOW"] == 2) echo "<option value='2' selected>".Web_GetLocale("ADMIN_114")."</option>";
                        else echo "<option value='2'>".Web_GetLocale("ADMIN_114")."</option>";
                        ?>
                        </select>
                    	</div> 
                      
                      <input type="submit" name="edit_page" class="btn btn-primary" value="<?php echo Web_GetLocale("ADMIN_118");?>">
                      <a href="?page=admin&admin=pages" class="btn btn-warning"><?php echo Web_GetLocale("ADMIN_116");?></a>
                      <a href="?page=admin&admin=pages&action=delete&p=<?php echo $_GET["p"];?>" class="btn btn-danger"><?php echo Web_GetLocale("ADMIN_119");?></a>
                    </form>
                    <?php
                    if(@$_POST["edit_page"])
                    {
                      if(!empty($_POST["page_name"]) && !empty($_POST["page_content"]) && !empty($_POST["page_access_mode"]))
                      {
                        Database_Update("POSTS", 
                          array(
                            "POST_NAME" => strip_tags($_POST["page_name"]),
                            "POST_TEXT" => $_POST["page_content"],
                            "POST_IMG" => "NONE",
                            "POST_DATE" => time(),
                            "POST_TYPE" => "page_post",
                            "USER_ID" => $_SESSION["USER_ID"],
                            "POST_SHOW" => $_POST["page_access_mode"]
                        ), array("POST_ID" => $_GET["p"]));
                        header("location: ?page=admin&admin=pages");
                      }
                      else echo ShowNotification("warning", Web_GetLocale("ADMIN_E03"));
                    }
                  }  
                  else header("location: ?page=admin&admin=pages");
                }
                else if($_GET["action"] == "delete")
                {
                  $page = Database_Select("POSTS", array("POST_TYPE" => "page_post", "POST_ID" => $_GET["p"]));
                  if($page != "N/A")
                  {
                    ?>
                    <h1><?php echo Web_GetLocale("ADMIN_120")." <b>".$page["POST_NAME"]."</b>";?>?</h1>
                    <form method="post">
                    <input type="submit" name="delete_page" value="<?php echo Web_GetLocale("ADMIN_119");?>" class="btn btn-danger">
                    <a href="?page=admin&admin=pages" class="btn btn-primary"><?php echo Web_GetLocale("ADMIN_116");?></a>  
                    </form>
                    <?php
                    if(@$_POST["delete_page"])
                    {
                      Database_Delete("POSTS", array("POST_ID" => $_GET["p"]));
                      header("location: ?page=admin&admin=pages");
                    }
                  }  
                  else header("location: ?page=admin&admin=pages");
                } 
                else header("location: ?page=admin&admin=pages");
              }
              else
              {
                ?>
                <h1><?php echo Web_GetLocale("ADMIN_103");?></h1>
                <p><?php echo Web_GetLocale("ADMIN_104");?></p>
                <?php
                $page = Database_Select_All("POSTS", array("POST_TYPE" => "page_post"));
                if(count($page) > 0)
                {
                  ?>
                  <div class="list-group">
                  <?php
                  for($i = 0;$i < count($page);$i ++)
                  {
                    echo "<a href='?page=admin&admin=pages&action=edit&p=".$page[$i]["POST_ID"]."' class='list-group-item'>".$page[$i]["POST_NAME"]."</a>";
                  }
                  ?>
                  </div>
                  
                  <?php
                } 
                ?><a href="?page=admin&admin=pages&action=new&p=x" class="btn btn-primary"><?php echo Web_GetLocale("ADMIN_105");?></a><?php
              }
            }
            else if($_GET["admin"] == "other" && User_Rights($_SESSION["USER_ID"], "S"))
            {
              ?>
              <h1><?php echo Web_GetLocale("ADMIN_97");?></h1>
              
              <form method="post">
                <div class="form-group col-lg-12">
                	<label><?php echo Web_GetLocale("ADMIN_98");?></label>
                  <input type="text" class="form-control" name="news" value="<?php echo Web_GetOption("NEWS_PP");?>">
              	</div>
                <div class="form-group col-lg-12">
                	<label><?php echo Web_GetLocale("ADMIN_99");?></label>
                  <input type="text" class="form-control" name="coments" value="<?php echo Web_GetOption("COMMENT_N_PP");?>">
              	</div>
                <div class="form-group col-lg-12">
                	<label><?php echo Web_GetLocale("ADMIN_100");?></label>
                  <input type="text" class="form-control" name="status" value="<?php echo Web_GetOption("STATUS_PP");?>">
              	</div>
                <div class="form-group col-lg-12">
                	<label><?php echo Web_GetLocale("ADMIN_101");?></label>
                  <input type="text" class="form-control" name="messages" value="<?php echo Web_GetOption("MESSAGES_PP");?>">
              	</div>    
                <input type="submit" name="other_settings_save" value="<?php echo Web_GetLocale("ADMIN_S");?>" class='btn btn-primary btn-block'> 
              </form>
              <?php
              if(@$_POST["other_settings_save"])
              {
                if(!empty($_POST["news"]) && !empty($_POST["coments"]) && !empty($_POST["status"]) && !empty($_POST["messages"]))
                {
                  if(is_numeric($_POST["news"]) && is_numeric($_POST["coments"]) && is_numeric($_POST["status"]) && is_numeric($_POST["messages"]))
                  {
                    Database_Update("OPTIONS", array("OPTION_VALUE" => $_POST["news"]), array("OPTION_KEY" => "NEWS_PP"));
                    Database_Update("OPTIONS", array("OPTION_VALUE" => $_POST["coments"]), array("OPTION_KEY" => "COMMENT_N_PP"));
                    Database_Update("OPTIONS", array("OPTION_VALUE" => $_POST["status"]), array("OPTION_KEY" => "STATUS_PP"));
                    Database_Update("OPTIONS", array("OPTION_VALUE" => $_POST["messages"]), array("OPTION_KEY" => "MESSAGES_PP"));
                    header("location: ?page=admin&admin=other");
                  }
                  else echo ShowNotification("danger", Web_GetOption("ADMIN_E05"));
                }
                else echo ShowNotification("danger", Web_GetOption("ADMIN_E03"));   
              }
            }
            else if($_GET["admin"] == "main" && User_Rights($_SESSION["USER_ID"], "R"))
            {
              ?>
              <h1><?php echo Web_GetLocale("ADMIN_91");?></h1>
              
              <form method="post">
                <div class="form-group col-lg-12">
                	<label><?php echo Web_GetLocale("ADMIN_92");?></label>
                  <input type="text" class="form-control" name="web_name" value="<?php echo Web_GetOption("NAME");?>">
              	</div>
                <div class="form-group col-lg-12">
                	<label><?php echo Web_GetLocale("ADMIN_94");?></label>
                  <input type="text" class="form-control" name="web_email" value="<?php echo Web_GetOption("EMAIL");?>">
              	</div>
                <div class="form-group col-lg-12">
                	<label><?php echo Web_GetLocale("ADMIN_95");?></label>
                  <select class="form-control" name="web_home_page">
                    <?php
                    if(Web_GetOption("HOME_PAGE") == "news_posts") echo "<option value='news_post' selected>".Web_GetLocale("ADMIN_106")."</option>";
                    else echo "<option value='news_post'>".Web_GetLocale("ADMIN_106")."</option>";
                    $pages = Database_Select_All("POSTS", array("POST_TYPE" => "page_post", "POST_SHOW" => 1));
                    if(count($pages) > 0)
                    {
                      for($i = 0;$i < count($pages);$i ++)
                      {
                        if(Web_GetOption("HOME_PAGE") == "page_post#".$pages[$i]["POST_ID"]."") echo "<option value='".$pages[$i]["POST_ID"]."' selected>[".Web_GetLocale("ADMIN_107")."] ".$pages[$i]["POST_NAME"]."</option>"; 
                        else echo "<option value='".$pages[$i]["POST_ID"]."'>[".Web_GetLocale("ADMIN_107")."] ".$pages[$i]["POST_NAME"]."</option>";  
                      }
                    }
                    ?>
                  </select>    
              	</div>     
                <div class="form-group col-lg-12">
                	<label><?php echo Web_GetLocale("ADMIN_96");?></label>
                  <select class="form-control" name="web_language">
                  <?php
                  if ($dh = opendir(LANG_DIR)) 
                  {
                    while(($file = readdir($dh)) !== false) 
                    {                           
                      if ($file != "." && $file != "..")
                      {
                        $pathinfo = pathinfo(LANG_DIR.$file);   
                        if(Web_GetOption("LANG") == basename($file, ".".$pathinfo["extension"])) echo "<option name='".basename($file, ".".$pathinfo["extension"])."' selected>".basename($file, ".".$pathinfo["extension"])."</option>";
                        else echo "<option name='".basename($file, ".".$pathinfo["extension"])."'>".basename($file, ".".$pathinfo["extension"])."</option>";
                      }
                    }
                  }
                  ?>
                  </select>
              	</div>    
                <div class="form-group col-lg-12">
                  <label><?php echo Web_GetLocale("ADMIN_184");?></label>
                  <input type="text" class="form-control" name="web_favicon" value="<?php echo Web_GetOption("FAVICON");?>">
                </div>
                <div class="form-group col-lg-12">
                  <label><?php echo Web_GetLocale("ADMIN_185");?></label>
                  <input type="text" class="form-control" name="web_logo" value="<?php echo Web_GetOption("LOGO");?>">
                </div>
                <div class="form-group col-lg-12">
                  <label><?php echo Web_GetLocale("ADMIN_186");?></label>
                  <input type="text" class="form-control" name="web_keywords" value="<?php echo Web_GetOption("KEYWORDS");?>">
                </div>
                <div class="form-group col-lg-12">
                  <label><?php echo Web_GetLocale("ADMIN_187");?></label>
                  <input type="text" class="form-control" name="web_desc" value="<?php echo Web_GetOption("DESCRIPTION");?>">
                </div>           
                <div class="form-group col-lg-12"> 
                  <div class="checkbox">
                    <label><input name="cloudflare" type="checkbox"<?php if(Web_GetOption("CLOUDFLARE") == "true") echo " checked";?>> <?php echo Web_GetLocale("ADMIN_198");?></label>
                  </div>
                </div>
             
                <input type="submit" name="main_settings_save" value="<?php echo Web_GetLocale("ADMIN_S");?>" class='btn btn-primary btn-block'> 
              </form>
              <?php  
              if(@$_POST["main_settings_save"])
              {
                if(!empty($_POST["web_name"]) && !empty($_POST["web_email"]) && !empty($_POST["web_language"]) && !empty($_POST["web_home_page"]) && !empty($_POST["web_favicon"]) && !empty($_POST["web_logo"]) && !empty($_POST["web_keywords"]) && !empty($_POST["web_desc"]))
                {
                  if(filter_var($_POST["web_email"], FILTER_VALIDATE_EMAIL))
                  { 
                    if(is_numeric($_POST["web_home_page"])) $homepage = "page_post#".$_POST["web_home_page"]."";
                    else $homepage = $_POST["web_home_page"];
                    Database_Update("OPTIONS", array("OPTION_VALUE" => strip_tags($_POST["web_name"])), array("OPTION_KEY" => "NAME"));
                    Database_Update("OPTIONS", array("OPTION_VALUE" => $_POST["web_email"]), array("OPTION_KEY" => "EMAIL"));
                    Database_Update("OPTIONS", array("OPTION_VALUE" => $_POST["web_language"]), array("OPTION_KEY" => "LANG"));
                    Database_Update("OPTIONS", array("OPTION_VALUE" => $homepage), array("OPTION_KEY" => "HOME_PAGE"));
                    Database_Update("OPTIONS", array("OPTION_VALUE" => $_POST["web_favicon"]), array("OPTION_KEY" => "FAVICON"));
                    Database_Update("OPTIONS", array("OPTION_VALUE" => $_POST["web_logo"]), array("OPTION_KEY" => "LOGO"));
                    Database_Update("OPTIONS", array("OPTION_VALUE" => $_POST["web_keywords"]), array("OPTION_KEY" => "KEYWORDS"));
                    Database_Update("OPTIONS", array("OPTION_VALUE" => $_POST["web_desc"]), array("OPTION_KEY" => "DESCRIPTION"));
                    if(!empty($_POST["cloudflare"])) Database_Update("OPTIONS", array("OPTION_VALUE" => "true"), array("OPTION_KEY" => "CLOUDFLARE"));
                    else Database_Update("OPTIONS", array("OPTION_VALUE" => "false"), array("OPTION_KEY" => "CLOUDFLARE"));
                    header("location: ?page=admin&admin=main");
                  }
                  else echo ShowNotification("danger", Web_GetOption("ADMIN_E04"));
                }
                else echo ShowNotification("danger", Web_GetOption("ADMIN_E03"));
              } 
            }
            else if($_GET["admin"] == "files" && User_Rights($_SESSION["USER_ID"], "N"))
            {  
              if(!empty($_GET["action"]) && isset($_GET["action"]) && !empty($_GET["file"]) && isset($_GET["file"]))
              {
                if($_GET["action"] == "view" && file_exists(UPLOAD_DIR.$_GET["file"]))
                {
                  ?>
                  <h1><?php echo File_GetIconFromFile(UPLOAD_DIR.$_GET["file"])." ".$_GET["file"];?></h1>
                  <?php
                  File_Show(UPLOAD_DIR.$_GET["file"]);
                  ?>
                  <br>
                  <a href="?page=admin&admin=files" class="btn btn-primary"><?php echo Web_GetLocale("ADMIN_87");?></a>
                  <a href="?page=admin&admin=files&action=delete&file=<?php echo $_GET["file"];?>" class="btn btn-danger"><?php echo Web_GetLocale("ADMIN_88");?></a>
                  <?php
                }
                else if($_GET["action"] == "delete" && file_exists(UPLOAD_DIR.$_GET["file"]))
                {
                  ?>
                  <h1><?php echo Web_GetLocale("ADMIN_89")." <b>".$_GET["file"]."</b>";?>?</h1>
                  <form method="post">
                  <input type="submit" name="delete_file" value="<?php echo Web_GetLocale("ADMIN_88");?>" class="btn btn-danger">
                  <a href="?page=admin&admin=files" class="btn btn-primary"><?php echo Web_GetLocale("ADMIN_87");?></a>  
                  </form>
                  <?php
                  if(@$_POST["delete_file"])
                  {
                    unlink(UPLOAD_DIR.$_GET["file"]); 
                    header("location: ?page=admin&admin=files"); 
                  }
                }
                else if($_GET["action"] == "upload" && $_GET["file"] == "new")
                {
                  ?>
                  <h1><?php echo Web_GetLocale("ADMIN_82");?></h1>
                  <form method="post" enctype="multipart/form-data">
                  <input type="file" class="form-control" name="file" id="file">
                  <br>
                  <input name="upload_file" type="submit" class="btn btn-primary" value="<?php echo Web_GetLocale("ADMIN_90");?>">
                  </form>
                  <?php
                  if(@$_POST["upload_file"])
                  {
                    $upload_dir = "uploads/avatars/";
                    $file_name = File_FileName($_FILES["file"]["name"]);
                    $upload_path = UPLOAD_DIR.$file_name;
                    if (file_exists($upload_path)) $upload_path = UPLOAD_DIR.rand(0, 10000).$file_name;  
                    if ($_FILES["file"]["size"] < 50000000)  
                    {
                      if ($_FILES["file"]["error"] > 0)
                      {
                        echo "Error Code: ".$_FILES["file"]["error"]."<br />";
                      }
                      else
                      {
                        move_uploaded_file($_FILES["file"]["tmp_name"], $upload_path);
                        header("location: ?page=admin&admin=files");
                      }
                    }
                  }
                }
                else header("location: ?page=admin&admin=files");
              }
              else
              {
                ?>
                <h1><?php echo Web_GetLocale("ADMIN_82");?></h1>
                <?php  
                File_ShowUploads();
                ?>
                <a href="?page=admin&admin=files&action=upload&file=new" class="btn btn-primary"><?php echo Web_GetLocale("ADMIN_90");?></a>  
                <?php
              }
            }
            else if($_GET["admin"] == "message" && User_Rights($_SESSION["USER_ID"], "J"))
            {
              ?>
              <h1><?php echo Web_GetLocale("ADMIN_78");?></h1>
              <p><?php echo Web_GetLocale("ADMIN_79");?></p>
              
              <form method="post">
                <div class="form-group col-lg-12">
                	<label><?php echo Web_GetLocale("MSG_08");?></label>
                  <input type="text" class="form-control" name="msg_topic">
              	</div>
                <div class="form-group col-lg-12">
                	<label><?php echo Web_GetLocale("ADMIN_81");?></label>
                  <textarea class="form-control" name="msg_text" rows="5" style="resize: vertical; overflow: auto; margin-top: 0px; margin-bottom: 0px;" placeholder="<?php echo Web_GetLocale("MSG_17");?>"></textarea>   
              	</div>               
                <input type="submit" name="msg_send" value="<?php echo Web_GetLocale("MSG_18");?>" class='btn btn-primary btn-block'> 
              </form>
              <?php
              if(@$_POST["msg_send"])
              {
                if(!empty($_POST["msg_text"]) && !empty($_POST["msg_topic"]))
                {
                  $users = Database_Select_All("USER", array("NONE" => "NONE"), "USER_ID");
                  for($i = 0;$i < count($users);$i++)
                  {
                    Message_Create(
                      array(
                        "MESSAGE_TOPIC" => $_POST["msg_topic"],
                        "MESSAGE_TEXT" => $_POST["msg_text"],
                        "MESSAGE_TYPE" => "ADMIN",
                        "SEND_USER_ID" => $_SESSION["USER_ID"],
                        "READ_USER_ID" => $users[$i]["USER_ID"],
                        "MESSAGE_DATE" => time(),
                        "MESSAGE_SHOWED" => "NONE"
                    ));
                  }
                  echo ShowNotification("success", Web_GetLocale("ADMIN_80"));    
                }
                else header("location: ?page=admin&admin=message");
              }
            }       
            else if($_GET["admin"] == "reports" && User_Rights($_SESSION["USER_ID"], "H"))
            {   
              if(!empty($_GET["action"]) && isset($_GET["action"]))
              {
                if($_GET["action"] == "delete" && User_Rights($_SESSION["USER_ID"], "X"))
                {
                  ?>
                  <h1><?php echo Web_GetLocale("ADMIN_57");?></h1>
                  <p><?php echo Web_GetLocale("ADMIN_63");?></p>
                  <form method="post">
                    <input type="submit" name="delete_reports" value="<?php echo Web_GetLocale("ADMIN_64");?>" class="btn btn-danger">
                    <a href="?page=admin&admin=reports" class="btn btn-success"><?php echo Web_GetLocale("ADMIN_65");?></a>
                  </form>
                  <?php
                  if(@$_POST["delete_reports"])
                  {
                    $reports = Database_Select_All("REPORTS", array("NONE" => "NONE"));
                    for($i = 0;$i < count($reports); $i ++)
                    {
                      if($reports[$i]["REPORT_SHOW"] != "NONE") Database_Delete("REPORTS", array("REPORT_ID" => $reports[$i]["REPORT_ID"]));
                      header("location: ?page=admin&admin=reports");
                    }
                  } 
                }
                else if($_GET["action"] == "view" && !empty($_GET["report"]) && isset($_GET["report"]) && is_numeric($_GET["report"]))
                {
                  $report = Database_Select("REPORTS", array("REPORT_ID" => $_GET["report"]));
                  if($report != "N/A")
                  {
                    ?>
                    <h1><?php echo Web_GetLocale("ADMIN_57");?> #<?php echo $_GET["report"];?></h1>
                    <hr>
                    <?php 
                    echo Web_GetLocale("ADMIN_61")." : <b>".ShowTime($report["REPORT_DATE"])."</b><br>";
                    echo Web_GetLocale("ADMIN_67")." : <a href='?page=profile&user=".User_Name($report["REPORT_USER_ID"])."'>".User_Name($report["REPORT_USER_ID"])."</a><br>";
                    echo Web_GetLocale("ADMIN_68")." : <a href='?page=profile&user=".User_Name($report["USER_ID"])."'>".User_Name($report["USER_ID"])."</a>";
                    if($report["REPORT_ADMIN"] != "NONE") 
                    {
                      echo "<br>".Web_GetLocale("ADMIN_70")." : <a href='".User_Name($report["REPORT_ADMIN"])."'>".User_Name($report["REPORT_ADMIN"])."</a><br>";
                      echo Web_GetLocale("ADMIN_74")." : <b>".ShowTime($report["REPORT_SHOW"])."</b><br>";
                    }
                    ?>
                    <hr>
                    <?php 
                    echo "<b>".Web_GetLocale("ADMIN_69")."</b> :<br>";
                    echo show_string($report["REPORT_CONTENT"]);
                    ?>
                    <hr>
                    
                    <?php
                    if($report["REPORT_ADMIN"] != "NONE") 
                    {
                      $msg = Database_Select("MESSAGES", array("MESSAGE_ID" => $report["REPORT_MSG"]));
                      if($msg != "N/A")
                      {
                        echo "<h2>".Web_GetLocale("ADMIN_76")."</h2>";
                        echo StrMagic($msg["MESSAGE_TEXT"]);    
                      }
                      else echo Web_GetLocale("ADMIN_75"); 
                      echo "<hr>";
                    }
                    else
                    {
                      ?>
                      <form method="post">
                        <textarea class="form-control" name="report_content" rows="5" style="resize: vertical; overflow: auto; margin-top: 0px; margin-bottom: 0px;" placeholder="<?php echo Web_GetLocale("ADMIN_72");?>"></textarea>                    
                        <input type="submit" name="report_re" value="<?php echo Web_GetLocale("ADMIN_71");?>" class='btn btn-primary btn-block'>
                      </form>
                      <?php
                      if(@$_POST["report_re"])
                      {
                        if(!empty($_POST["report_content"]))
                        {
                          $msg_id = Message_Create(
                            array(
                              "MESSAGE_TOPIC" => "".Web_GetLocale("ADMIN_57")." ".Web_GetLocale("ADMIN_73")." ".User_Name($report["REPORT_USER_ID"])."",
                              "MESSAGE_TEXT" => "Generating report message, please wait.",
                              "MESSAGE_TYPE" => "ADMIN",
                              "SEND_USER_ID" => $_SESSION["USER_ID"],
                              "READ_USER_ID" => $report["USER_ID"],
                              "MESSAGE_DATE" => time(),
                              "MESSAGE_SHOWED" => "NONE"
                          ));
                          Database_Update("REPORTS", 
                            array(
                            "REPORT_SHOW" => time(),
                            "REPORT_ADMIN" => $_SESSION["USER_ID"],
                            "REPORT_MSG" => $msg_id
                          ), array("REPORT_ID" => $_GET["report"]));
                          
                          unset($report);
                          $report = Database_Select("REPORTS", array("REPORT_ID" => $_GET["report"]));
                          
                          Database_Update("MESSAGES", 
                            array(
                              "MESSAGE_TEXT" => "
                                ".Web_GetLocale("ADMIN_61")." : [b]".ShowTime($report["REPORT_DATE"])."[/b]
                                ".Web_GetLocale("ADMIN_67")." : @".User_Name($report["REPORT_USER_ID"])."
                                ".Web_GetLocale("ADMIN_68")." : @".User_Name($report["USER_ID"])."
                                ".Web_GetLocale("ADMIN_70")." : @".User_Name($report["REPORT_ADMIN"])."
                                ".Web_GetLocale("ADMIN_74")." : [b]".ShowTime($report["REPORT_SHOW"])."[/b]
                                [b]".Web_GetLocale("ADMIN_69")."[/b] :
                                ".show_string($report["REPORT_CONTENT"])."
                                
                                ".$_POST["report_content"]."
                            "), array("MESSAGE_ID" => $msg_id));
													header("location: ?page=admin&admin=reports&action=view&report=".$_GET["report"]."");
                        }
                        else header("location: ?page=admin&admin=reports&action=view&report=".$_GET["report"]."");
                      }
                    }
                  }
                  else header("location: ?page=admin&admin=reports");
                }
                else header("location: ?page=admin&admin=reports");
              }
              else
              {
                ?>
                <h1><?php echo Web_GetLocale("ADMIN_57");?> <?php if(User_Rights($_SESSION["USER_ID"], "X")) echo "<a href='?page=admin&admin=reports&action=delete' class='btn btn-xs btn-danger'>".Web_GetLocale("ADMIN_62")."</a>";?></h1> 
                <?php
                $reports = Database_Select_All("REPORTS", array("NONE" => "NONE"), "array", "ORDER BY `REPORT_ID` DESC");
                if(count($reports) > 0)
                {
                  for($i = 0;$i < count($reports);$i ++)
                  {
                    $u1 = User_Data($reports[$i]["USER_ID"]); //Ten co nahlaĹˇoval
                    $u2 = User_Data($reports[$i]["REPORT_USER_ID"]); //Ten co byl nahlĂˇĹˇenĂ˝
                    ?>
                    <div class='table-responsive'>
                      <table class='table table-hover'>
                        <tr>
                          <td colspan="3" align="left"><a href="?page=admin&admin=reports&action=view&report=<?php echo $reports[$i]["REPORT_ID"];?>"><?php echo Web_GetLocale("ADMIN_57");?> #<?php echo $reports[$i]["REPORT_ID"];?></a></td>
                        </tr>
                        <tr>
                          <td width="10%">
                            <center>
                              <a href="?page=profile&user=<?php echo $u1["USER_NAME"];?>" target="_blank"><img src='<?php echo $u1["USER_AVATAR"];?>' alt='<?php echo $u1["USER_DISPLAY_NAME"];?>' class='img-rounded' width='100px' height='100px'></a>
                              <a href="?page=profile&user=<?php echo $u1["USER_NAME"];?>" class='btn btn-xs btn-primary btn-block'><?php echo $u1["USER_NAME"];?></a>
                            </center>
                          </td>
                          <td width="80%">
                          <?php 
                          echo Web_GetLocale("ADMIN_58")." <b>".$u1["USER_NAME"]."</b> ".Web_GetLocale("ADMIN_59")." <b>".$u2["USER_NAME"]."</b>.<br>"; 
                          echo show_string($reports[$i]["REPORT_CONTENT"]);
                          ?>
                          </td>
                          <td width="10%">
                            <center>
                              <a href="?page=profile&user=<?php echo $u2["USER_NAME"];?>" target="_blank"><img src='<?php echo $u2["USER_AVATAR"];?>' alt='<?php echo $u2["USER_DISPLAY_NAME"];?>' class='img-rounded' width='100px' height='100px'></a>
                              <a href="?page=profile&user=<?php echo $u2["USER_NAME"];?>" class='btn btn-xs btn-primary btn-block'><?php echo $u2["USER_NAME"];?></a>
                            </center>
                          </td>
                        </tr>
                        <tr>
                          <td colspan="3">
                          <?php 
                          echo "<span style='float:left;'>";
                          if($reports[$i]["REPORT_SHOW"] == "NONE") echo Web_GetLocale("ADMIN_60");
                          else echo Web_GetLocale("ADMIN_66")." ".ShowTime($reports[$i]["REPORT_SHOW"])." - <a href='".User_Name($reports[$i]["REPORT_ADMIN"])."'>".User_Name($reports[$i]["REPORT_ADMIN"])."</a>"; 
                          echo "</span>";
                          echo "<span style='float:right;'>";
                          echo Web_GetLocale("ADMIN_61")." ".ShowTime($reports[$i]["REPORT_DATE"])."";
                          echo "</span>";
                          ?>
                          </td>
                        </tr>
                      </table>
                    </div>
                    <?php
                  }
                }
                else echo Web_GetLocale("ADMIN_77");
              }
            }
            else if($_GET["admin"] == "sidebar" && User_Rights($_SESSION["USER_ID"], "P"))
            {      
              if(!empty($_GET["action"]) && isset($_GET["action"]))
              {
                if($_GET["action"] == "new")
                {
                  ?>
                  <h1><?php echo Web_GetLocale("ADMIN_41");?></h1>
                  <form method="post">
                    <div class="form-group col-lg-12">
                	    <label><?php echo Web_GetLocale("ADMIN_43");?></label>
                      <input type="text" class="form-control" name="sidebar_name">
              	    </div>
                    <div class="form-group col-lg-12">
                	    <label><?php echo Web_GetLocale("ADMIN_44");?></label>
                      <textarea class="form-control" name="sidebar_content" rows="5" style="resize: vertical; overflow: auto; margin-top: 0px; margin-bottom: 0px;" placeholder="<?php echo Web_GetLocale("ADMIN_53");?>"></textarea>
              	    </div>
                    <div class="form-group col-lg-12">
                  	   <label><?php echo Web_GetLocale("ADMIN_45");?></label>
                       <?php ShowColorPicker("sidebar_color");?>
                	  </div>
                    <input type="submit" class="btn btn-primary" value="<?php echo Web_GetLocale("ADMIN_47");?>" name="add_sidebar">
                    <a href="?page=admin&admin=sidebar" class="btn btn-warning"><?php echo Web_GetLocale("ADMIN_48");?></a>
                  </form>
                  <?php
                  if(@$_POST["add_sidebar"])
                  {
                    if(!empty($_POST["sidebar_name"]) && !empty($_POST["sidebar_content"]) && !empty($_POST["sidebar_color"]))
                    {
                      Database_Insert("SIDEBAR",
                        array(
                        "SIDEBAR_NAME" => $_POST["sidebar_name"],
                        "SIDEBAR_CONTENT" => $_POST["sidebar_content"],
                        "SIDEBAR_COLOR" => $_POST["sidebar_color"],
                        "SIDEBAR_PLUGIN" => "NONE",
                        "SIDEBAR_ALLOW" => "0"
                      ));
                      header("location: ?page=admin&admin=sidebar");
                    }
                    else echo Web_GetLocale("ADMIN_50");
                  }
                }
                else if($_GET["action"] == "new_plug")
                {
                  $plugins = Database_Select_All("PLUGINS", array("PLUGIN_ALLOW" => 1));
                  if(count($plugins) > 0)
                  { 
                    ?>
                    <h1><?php echo Web_GetLocale("ADMIN_42");?></h1>  
                    <form method="post">      
                    <div class="form-group col-lg-12">
                      <label><?php echo Web_GetLocale("ADMIN_43");?></label>
                      <input type="text" class="form-control" name="sidebar_name">
                    </div>        
                      <div class="form-group col-lg-12">
                        <label><?php echo Web_GetLocale("ADMIN_46");?></label>
                        <select name="sidebar_plugin" class="form-control">
                          <option selected disabled><?php echo Web_GetLocale("ADMIN_49");?></option>
                          <?php
                          for($i = 0;$i < count($plugins);$i ++)
                          {
                            if(file_exists(PLUGIN_DIR.$plugins[$i]["PLUGIN_NAME"]."/sidebar.php"))
                            {
                              echo "<option value='".$plugins[$i]["PLUGIN_NAME"]."'>".$plugins[$i]["PLUGIN_NAME"]."</option>";
                            }
                          }
                          ?>
                        </select>
                      </div>
                  
                      <div class="form-group col-lg-12">
                    	  <label><?php echo Web_GetLocale("ADMIN_45");?></label>
                        <?php ShowColorPicker("sidebar_color");?>
                  	  </div>
                      
                      <input type="submit" class="btn btn-primary" value="<?php echo Web_GetLocale("ADMIN_47");?>" name="add_sidebar">
                      <a href="?page=admin&admin=sidebar" class="btn btn-warning"><?php echo Web_GetLocale("ADMIN_48");?></a>
          
                    </form>
                    <?php
                    if(@$_POST["add_sidebar"])
                    {
                      if(!empty($_POST["sidebar_name"]) && !empty($_POST["sidebar_plugin"]) && !empty($_POST["sidebar_color"]))
                      {
                        Database_Insert("SIDEBAR",
                          array(
                            "SIDEBAR_NAME" => $_POST["sidebar_name"],
                            "SIDEBAR_CONTENT" => "NONE",
                            "SIDEBAR_COLOR" => $_POST["sidebar_color"],
                            "SIDEBAR_PLUGIN" => $_POST["sidebar_plugin"],
                            "SIDEBAR_ALLOW" => "0"
                        ));
                        header("location: ?page=admin&admin=sidebar");
                      }
                      else echo Web_GetLocale("ADMIN_50");  
                    }
                  }
                }
                else if($_GET["action"] == "edit" && !empty($_GET["sidebar"]) && isset($_GET["sidebar"]) && is_numeric($_GET["sidebar"]))
                {
                  $sidebar = Database_Select("SIDEBAR", array("SIDEBAR_ID" => $_GET["sidebar"]));
                  if($sidebar != "N/A")
                  {
                    if($sidebar["SIDEBAR_PLUGIN"] == "NONE")
                    {
                      ?>
                      <h1><?php echo Web_GetLocale("ADMIN_51");?> <b><?php echo $sidebar["SIDEBAR_NAME"];?></b></h1>
                      <form method="post">
                        <div class="form-group col-lg-12">
                    	    <label><?php echo Web_GetLocale("ADMIN_43");?></label>
                          <input type="text" class="form-control" name="sidebar_name" value="<?php echo $sidebar["SIDEBAR_NAME"];?>">
                  	    </div>
                        <div class="form-group col-lg-12">
                    	    <label><?php echo Web_GetLocale("ADMIN_44");?></label>
                          <textarea class="form-control" name="sidebar_content" rows="5" style="resize: vertical; overflow: auto; margin-top: 0px; margin-bottom: 0px;" placeholder="<?php echo Web_GetLocale("ADMIN_53");?>"><?php echo $sidebar["SIDEBAR_CONTENT"];?></textarea>
                  	    </div>
                        <div class="form-group col-lg-12">
                      	   <label><?php echo Web_GetLocale("ADMIN_45");?></label>
                      	   <?php ShowColorPicker("sidebar_color", $sidebar["SIDEBAR_COLOR"]);?>
                    	  </div>
                        <div class="form-group col-lg-12">
                           <label>
                              <input type="checkbox" name="sidebar_allow" value="1"<?php if($sidebar["SIDEBAR_ALLOW"] == "1") echo " checked";?>> <?php echo Web_GetLocale("ADMIN_52");?>
                            </label>
                        </div>
                        <input type="submit" class="btn btn-success" value="<?php echo Web_GetLocale("ADMIN_55");?>" name="edit_sidebar">
                        <a href="?page=admin&admin=sidebar" class="btn btn-info"><?php echo Web_GetLocale("ADMIN_48");?></a>
                        <a href="?page=admin&admin=sidebar&action=delete&sidebar=<?php echo $_GET["sidebar"];?>" class="btn btn-danger"><?php echo Web_GetLocale("ADMIN_54");?></a>
                      </form>
                      <?php 
                      if(@$_POST["edit_sidebar"])
                      {
                        if(!empty($_POST["sidebar_name"]) && !empty($_POST["sidebar_content"]) && !empty($_POST["sidebar_color"]))
                        {
                          Database_Update("SIDEBAR", 
                            array(
                              "SIDEBAR_NAME" => $_POST["sidebar_name"],
                              "SIDEBAR_CONTENT" => $_POST["sidebar_content"],
                              "SIDEBAR_COLOR" => $_POST["sidebar_color"],
                              "SIDEBAR_ALLOW" => $_POST["sidebar_allow"]
                            ), 
                            array("SIDEBAR_ID" => $_GET["sidebar"]));
                            header("location: ?page=admin&admin=sidebar");
                        }
                        else echo Web_GetLocale("ADMIN_50");
                      }
                    }
                    else
                    {
                      ?>
                      <h1><?php echo Web_GetLocale("ADMIN_51");?> <b><?php echo $sidebar["SIDEBAR_NAME"];?></b></h1>
                      <form method="post">
                        <div class="form-group col-lg-12">
                    	    <label><?php echo Web_GetLocale("ADMIN_43");?></label>
                          <input type="text" class="form-control" name="sidebar_name" value="<?php echo $sidebar["SIDEBAR_NAME"];?>">
                  	    </div>
                        <div class="form-group col-lg-12">
                      	   <label><?php echo Web_GetLocale("ADMIN_45");?></label>
                      	   <?php ShowColorPicker("sidebar_color", $sidebar["SIDEBAR_COLOR"]);?>
                    	  </div>
                        <div class="form-group col-lg-12">
                           <label>
                              <input type="checkbox" name="sidebar_allow" value="1"<?php if($sidebar["SIDEBAR_ALLOW"] == "1") echo " checked";?>> <?php echo Web_GetLocale("ADMIN_52");?>
                            </label>
                        </div>
                        <input type="submit" class="btn btn-success" value="<?php echo Web_GetLocale("ADMIN_55");?>" name="edit_sidebar">
                        <a href="?page=admin&admin=sidebar" class="btn btn-info"><?php echo Web_GetLocale("ADMIN_48");?></a>
                        <a href="?page=admin&admin=sidebar&action=delete&sidebar=<?php echo $_GET["sidebar"];?>" class="btn btn-danger"><?php echo Web_GetLocale("ADMIN_54");?></a>
                      </form>
                      <?php
                      if(@$_POST["edit_sidebar"])
                      {
                        if(!empty($_POST["sidebar_name"]) && !empty($_POST["sidebar_color"]))
                        {
                          Database_Update("SIDEBAR", 
                            array(
                              "SIDEBAR_NAME" => $_POST["sidebar_name"],
                              "SIDEBAR_COLOR" => $_POST["sidebar_color"],
                              "SIDEBAR_ALLOW" => $_POST["sidebar_allow"]
                            ), 
                            array("SIDEBAR_ID" => $_GET["sidebar"]));
                            header("location: ?page=admin&admin=sidebar");
                        }
                        else echo Web_GetLocale("ADMIN_50"); 
                      }
                    }
                  }
                  else header("location: ?page=admin&admin=sidebar");   
                }
                else if($_GET["action"] == "delete" && !empty($_GET["sidebar"]) && isset($_GET["sidebar"]) && is_numeric($_GET["sidebar"]))
                {
                  $sidebar = Database_Select("SIDEBAR", array("SIDEBAR_ID" => $_GET["sidebar"]));
                  if($sidebar != "N/A")
                  {
                    ?>
                    <h1><?php echo Web_GetLocale("ADMIN_56");?> <b><?php echo $sidebar["SIDEBAR_NAME"];?></b>?</h1>
                    
                    <form method="post">
                    <input type="submit" name="delete_sidebar" value="<?php echo Web_GetLocale("ADMIN_54");?>" class="btn btn-danger">
                    <a href="?page=admin&admin=sidebar" class="btn btn-success"><?php echo Web_GetLocale("ADMIN_48");?></a>
                    </form>
                    <?php  
                    if(@$_POST["delete_sidebar"])
                    {
                      Database_Delete("SIDEBAR", array("SIDEBAR_ID" => $_GET["sidebar"]));
                      header("location: ?page=admin&admin=sidebar");
                    }
                  }
                  else header("location: ?page=admin&admin=sidebar");
                }
                else header("location: ?page=admin&admin=sidebar");
              }
              else
              {
                ?>
                <h1><?php echo Web_GetLocale("ADMIN_40");?></h1>
                
                <?php
                $sidebar = Database_Select_All("SIDEBAR", array("NONE" => "NONE"));
                if(count($sidebar) > 0)
                {
                  ?>
                  <div class="list-group">
                  <?php
                  for($i = 0;$i < count($sidebar);$i ++)
                  {
                    $active = null;
                    if($sidebar[$i]["SIDEBAR_ALLOW"] == "1") $active = " active";
                    echo "<a href='?page=admin&admin=sidebar&action=edit&sidebar=".$sidebar[$i]["SIDEBAR_ID"]."' class='list-group-item".$active."'>".$sidebar[$i]["SIDEBAR_NAME"]."</a>";
                  }
                  ?>
                  </div>
                  <?php
                }
                ?> 
                <a href="?page=admin&admin=sidebar&action=new" class="btn btn-primary"><?php echo Web_GetLocale("ADMIN_41");?></a>
                <?php 
                if(Database_Count("PLUGINS", array("PLUGIN_ALLOW" => 1)) > 0) echo "<a href='?page=admin&admin=sidebar&action=new_plug' class='btn btn-primary'>".Web_GetLocale("ADMIN_42")."</a>";
              }
            }
            else if($_GET["admin"] == "design" && User_Rights($_SESSION["USER_ID"], "L"))
            {
              if(!empty($_GET["action"]) && isset($_GET["action"]) && !empty($_GET["design"]) && isset($_GET["design"]))
              {
                if($_GET["action"] == "edit")
                {
                  if(file_exists(THEME_DIR.$_GET["design"]."/style.css")
                    && file_exists(THEME_DIR.$_GET["design"]."/theme.php")
                    && file_exists(THEME_DIR.$_GET["design"]."/preview.png"))
                  {
                    Database_Update("OPTIONS", array("OPTION_VALUE" => $_GET["design"]), array("OPTION_KEY" => "THEME"));
                    Database_Update("OPTIONS", array("OPTION_VALUE" => "default"), array("OPTION_KEY" => "MENU"));
                    header("location: ?page=admin&admin=design");  
                  } 
                  else header("location: ?page=admin&admin=design"); 
                }
              }
              else
              {
                ?>
                <h1><?php echo Web_GetLocale("ADMIN_33");?></h1>
                <p><?php echo Web_GetLocale("ADMIN_34");?></p>
                
                <h2><?php echo Web_GetLocale("ADMIN_36");?></h2>
                <p><?php echo Web_GetLocale("ADMIN_38");?></p>
                <?php
                require_once(THEME_DIR.Web_GetOption("THEME")."/theme.php"); 
                ?>
                <div class="row">
                  <div class="col-sm-6 col-md-4">
                    <div class="thumbnail">
                      <img src="themes/<?php echo Web_GetOption("THEME");?>/preview.png" alt="<?php echo $theme_info["THEME_NAME"];?>">
                      <div class="caption">
                        <h3><?php echo $theme_info["THEME_NAME"];?></h3>
                        <p>
                          <ul>
                            <li><?php echo Web_GetLocale("ADMIN_28");?>: <?php echo $theme_info["THEME_AUTOR"];?></li>
                            <li><a href='<?php echo $theme_info["THEME_URL"];?>' target='_blank'><?php echo $theme_info["THEME_URL"];?></a></li>
                          </ul>
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
                <?php
                unset($theme_info);
                ?>
                
                
                <h2><?php echo Web_GetLocale("ADMIN_37");?></h2>
                <p><?php echo Web_GetLocale("ADMIN_39");?></p>
                <div class="row">
                <?php
                if ($dh = opendir(THEME_DIR)) 
                {
                  while(($file = readdir($dh)) !== false) 
                  {                           
                    if ($file != "." && $file != "..")
                    {
                      if(Theme_Files($file))
                      {
                        if($file != Web_GetOption("THEME"))
                        {
                          require_once(THEME_DIR.$file."/theme.php"); 
                          ?>
                          <div class="col-sm-6 col-md-4">
                            <div class="thumbnail">
                              <img src="themes/<?php echo $file;?>/preview.png" alt="<?php echo $theme_info["THEME_NAME"];?>">
                              <div class="caption">
                                <h3><?php echo $theme_info["THEME_NAME"];?></h3>
                                <p>
                                  <ul>
                                    <li><?php echo Web_GetLocale("ADMIN_28");?>: <?php echo $theme_info["THEME_AUTOR"];?></li>
                                    <li><a href='<?php echo $theme_info["THEME_URL"];?>' target='_blank'><?php echo $theme_info["THEME_URL"];?></a></li>
                                  </ul>
                                </p>
                                <p>
                                  <a href="?page=admin&admin=design&action=edit&design=<?php echo $file;?>" class="btn btn-success btn-block" role="button"><?php echo Web_GetLocale("ADMIN_35");?></a>
                                </p>
                              </div>
                            </div>
                          </div>
                          <?php
                          unset($theme_info);
                        }
                      }
                    }
                  }
                }
                ?>
                </div>
                <?php
              }
}
            else if($_GET["admin"] == "plugins" && User_Rights($_SESSION["USER_ID"], "Q"))
            {
              if(!empty($_GET["action"]) && isset($_GET["action"]) && !empty($_GET["plugin"]) && isset($_GET["plugin"]))
              {
                if($_GET["action"] == "install")
                {
                  if(Plugin_Files($_GET["plugin"]))
                  {
                    require_once(PLUGIN_DIR.$_GET["plugin"]."/install.php"); 
                    Database_Insert("PLUGINS", array("PLUGIN_NAME" => $_GET["plugin"], "PLUGIN_ALLOW" => 1));
                    header("location: ?page=admin&admin=plugins");    
                  } 
                  else header("location: ?page=admin&admin=plugins");    
                }
                else if($_GET["action"] == "uninstall")
                {
                  $s = Database_Select("PLUGINS", array("PLUGIN_NAME" => $_GET["plugin"], "PLUGIN_ALLOW" => 1));
                  if($s > 0)
                  {
                    if(Plugin_Files($_GET["plugin"]))
                    { 
                      require_once(PLUGIN_DIR.$_GET["plugin"]."/uninstall.php"); 
                      Database_Delete("PLUGINS", array("PLUGIN_NAME" => $_GET["plugin"]));
                      header("location: ?page=admin&admin=plugins"); 
                    } 
                  }
                  else header("location: ?page=admin&admin=plugins");  
                }
                else if($_GET["action"] == "admin")
                {
                  $s = Database_Select("PLUGINS", array("PLUGIN_NAME" => $_GET["plugin"], "PLUGIN_ALLOW" => 1));
                  if($s > 0)
                  {
                    require_once(PLUGIN_DIR.$_GET["plugin"]."/".$_GET["plugin"].".func.php");
                    require_once(PLUGIN_DIR.$_GET["plugin"]."/admin.php");  
                  } 
                  else header("location: ?page=admin&admin=plugins");   
                }
                else header("location: ?page=admin&admin=plugins");   
              }
              else
              {
                ?>
                <h1><?php echo Web_GetLocale("ADMIN_25");?></h1>
                <p><?php echo Web_GetLocale("ADMIN_26");?></p>
                
                <?php
                if ($dh = opendir(PLUGIN_DIR)) 
                {
                  while(($file = readdir($dh)) !== false) 
                  {                           
                    if ($file != "." && $file != "..")
                    {
                      if(Plugin_Files($file))
                      {   
                        $plugin_exists = Database_Select("PLUGINS", array("PLUGIN_NAME" => $file));
                        if($plugin_exists == 0)
                        {
                          require_once(PLUGIN_DIR.$file."/info.php");
                          ?>
                          <div class="panel panel-default">
                            <div class="panel-heading"><?php echo $plugin_info["PLUGIN_NAME"]." ".$plugin_info["PLUGIN_VERSION"];?></div>
                            <div class="panel-body">
                              <?php
                              echo $plugin_info["PLUGIN_DESC"]."<hr>";
                              echo Web_GetLocale("ADMIN_28").": ".$plugin_info["PLUGIN_AUTOR"]."<br>";
                              echo Web_GetLocale("ADMIN_29").": <a href='".$plugin_info["PLUGIN_WWW"]."'>".$plugin_info["PLUGIN_WWW"]."</a><br>";
                              echo "<hr>";
                              ?>
                              <a href="?page=admin&admin=plugins&action=install&plugin=<?php echo $file;?>" class="btn btn-success btn-lg btn-block"><?php echo Web_GetLocale("ADMIN_30");?></a>
                            </div>
                          </div>
                          <?php
                          unset($plugin_info);
                        }
                      }
                    }
                  }
                  closedir($dh);
                }
                ?>
                <h1><?php echo Web_GetLocale("ADMIN_27");?></h1>
                <?php
                $plugin = Database_Select_All("PLUGINS", array("NONE" => "NONE"));
                for($i = 0;$i < count($plugin);$i++)
                {
                  require_once(PLUGIN_DIR.$plugin[$i]["PLUGIN_NAME"]."/info.php");
                  ?>
                  <div class="panel panel-default">
                    <div class="panel-heading"><?php echo $plugin_info["PLUGIN_NAME"]." ".$plugin_info["PLUGIN_VERSION"];?></div>
                      <div class="panel-body">
                        <?php
                        echo $plugin_info["PLUGIN_DESC"]."<hr>";
                        echo Web_GetLocale("ADMIN_28").": ".$plugin_info["PLUGIN_AUTOR"]."<br>";
                        echo Web_GetLocale("ADMIN_29").": <a href='".$plugin_info["PLUGIN_WWW"]."'>".$plugin_info["PLUGIN_WWW"]."</a><br>";
                        echo "<hr>";
                        ?>
                        <a href="?page=admin&admin=plugins&action=uninstall&plugin=<?php echo $plugin[$i]["PLUGIN_NAME"];?>" class="btn btn-danger btn-lg btn-block"><?php echo Web_GetLocale("ADMIN_31");?></a>
                        <?php
                        if(file_exists(PLUGIN_DIR.$plugin[$i]["PLUGIN_NAME"]."/admin.php")) echo "<a href='?page=admin&admin=plugins&action=admin&plugin=".$plugin[$i]["PLUGIN_NAME"]."' class='btn btn-info btn-lg btn-block'>".Web_GetLocale("ADMIN_32")."</a>";
                        ?>
                      </div>
                    </div>
                  <?php
                  unset($plugin_info);  
                }
              }
            }
            else
            {
              ?>
              <h1><?php echo Web_GetLocale("ADMIN_E01");?></h1>
              <p><?php echo Web_GetLocale("ADMIN_E02");?></p>
              <?php
            }
          }  
          else
          {
            ?>
            <h1><?php echo Web_GetLocale("ADMIN_02");?></h1>
            <p><?php echo Web_GetLocale("ADMIN_102");?></p>
            <br>
            <div class="row">
              <div class="col-md-4">
              
                <div class="panel panel-default">
                  <div class="panel-heading"><i class="fa fa-user"></i> <?php echo Web_GetLocale("ADMIN_03");?></a></div>
                  <div class="panel-body">
                    <ul>
                      <li><?php echo Web_GetLocale("ADMIN_17");?>: <?php echo Database_CountTable("USER");?></li>
                      <li><?php echo Web_GetLocale("ADMIN_18");?>: <?php echo Database_Count("USER", array("USER_RIGHTS" => "unactivate"));?></li>
                      <li><?php echo Web_GetLocale("ADMIN_19");?>: <?php echo Database_Count("USER", array("USER_RIGHTS" => "blocked"));?></li>
                      <li><?php echo Web_GetLocale("ADMIN_20");?>: 
                      <?php
                      $u = Database_Select("USER", array("NONE" => "NONE"), "array", "ORDER BY `USER_ID` DESC");
                      echo "<a href='?page=profile&user=".$u["USER_NAME"]."'>".$u["USER_DISPLAY_NAME"]."</a>";
                      ?>    
                      <li><a href="?page=admin&admin=users"><?php echo Web_GetLocale("ADMIN_202");?></a></li>  
                      </li>
                    </ul>
                  </div>
                </div>
                
                <div class="panel panel-default">
                  <div class="panel-heading"><i class="fa fa-file"></i> <?php echo Web_GetLocale("ADMIN_11");?></div>
                  <div class="panel-body">       
                    <ul>
                      <?php
                      $size = 0;
                      $files = 0;
                      if ($dh = opendir(UPLOAD_DIR)) 
                      {
                        while(($file = readdir($dh)) !== false) 
                        {                           
                          if ($file != "." && $file != "..")
                          {   
                            $size = $size + filesize(UPLOAD_DIR.$file); 
                            $files ++;
                          }
                        }
                      }
                      echo "<li>".Web_GetLocale("ADMIN_200")." - ".$files."</li>";
                      echo "<li>".Web_GetLocale("ADMIN_199")." - ".($size / 1000000)." MB</li>";
                      ?>
                      <li><a href="?page=admin&admin=files"><?php echo Web_GetLocale("ADMIN_201");?></a></li>
                    </ul>
                  </div>
                </div>
                              
              </div>
              <div class="col-md-4">
              
                <div class="panel panel-default">
                  <div class="panel-heading"><i class="fa fa-pencil-square-o"></i> <?php echo Web_GetLocale("ADMIN_04");?></div>
                  <div class="panel-body">
                    <ul>
                      <li><?php echo Web_GetLocale("ADMIN_21");?>: <?php echo Database_Count("POSTS", array("POST_TYPE" => "news_post"));?></li>
                      <li><?php echo Web_GetLocale("ADMIN_22");?>: <?php echo Database_Count("POSTS", array("POST_TYPE" => "comments_post"));?></li>
                      <li><?php echo Web_GetLocale("ADMIN_23");?>: <?php echo Database_Count("POSTS", array("POST_TYPE" => "status_post"));?></li>
                      </li>
                    </ul>
                  </div>
                </div>
              
              </div>
              <div class="col-md-4">
              
                <div class="panel panel-info">
                  <div class="panel-heading"><i class="fa fa-server"></i> <?php echo Web_GetLocale("ADMIN_13");?></a></div>
                  <div class="panel-body">
                    <ul>
                      <li><?php echo Web_GetLocale("ADMIN_14");?> - <?php echo Web_GetOption("NAME");?></li>
                      <li><?php echo Web_GetLocale("ADMIN_15");?> - <?php echo Web_GetOption("THEME");?></li>
                      <li><?php echo Web_GetLocale("ADMIN_16");?> - Domm's Web Engine</li>
                      <li><?php echo Web_GetLocale("ADMIN_168");?> - <?php echo Web_GetVersion();?></li>
                      <li><a href="?page=admin&admin=main"><?php echo Web_GetLocale("ADMIN_203");?></a></li>  
                    </ul>
                  </div>
                </div>  
              
              </div>
            </div>
            <?php
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
        <h1><?php echo Web_GetLocale("ERROR_01");?></h1>
        <p>
          <?php echo Web_GetLocale("ERROR_02");?>  
        </p>
      </div>
    </div>
    <?php
  }
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