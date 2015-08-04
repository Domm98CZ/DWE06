<?php
function ShowColorPicker($name, $color = null)
{
  ?>
  <select name="<?php echo $name;?>" class="form-control">
    <option<?php echo (empty($color)) ? " selected" : "";?> disabled><?php echo Web_GetLocale("COLOR_01");?></option>
    <option<?php echo ($color == "default") ? " selected" : ""?> value='default'>Default</option>
    <option<?php echo ($color == "primary") ? " selected" : "";?> value='primary'>Primary</option>
    <option<?php echo ($color == "info") ? " selected" : "";?> value='info'>Info</option>
    <option<?php echo ($color == "success") ? " selected" : "";?> value='success'>Success</option>
    <option<?php echo ($color == "warning") ? " selected" : "";?> value='warning'>Warning</option>
    <option<?php echo ($color == "danger") ? " selected" : "";?> value='danger'>Danger</option>
  </select>
  <?php
}

function ShowTime($time)
{
  if($time < 100) return "N/A";
  else return date("d. m. Y H:i", $time);
}

function round_up($value, $places=0) 
{
  $mult = pow(10, abs($places)); 
  return $places < 0 ?
  ceil($value / $mult) * $mult :
  ceil($value * $mult) / $mult;
}

function ShowBB()
{
  $text = array();
  $text[] = "@".Database_Select("USER", array("USER_RIGHTS" => "A"), "USER_NAME", "ORDER BY `USER_ID` DESC");
  $text[] = "http://www.twitch.tv/esl_csgo";
  $text[] = "https://www.youtube.com/watch?v=TbGu4mxZDY8";
  $text[] = "[url=http://facebook.com]Facebook[/url]";
  $text[] = "[img]".Database_Select("USER", array("USER_RIGHTS" => "A"), "USER_AVATAR", "ORDER BY `USER_ID` DESC")."[/img]";
  $text[] = "[b]text[/b]";
  $text[] = "[u]text[/u]";
  $text[] = "[i]text[/i]";
  $text[] = "[bgcolor=lime]text[/bgcolor]";
  $text[] = "[bgcolor=#00FF00]text[/bgcolor]";
  $text[] = "[color=lime]text[/color]";
  $text[] = "[color=#00FF00]text[/color]";
  $text[] = "[center]text[/center]";
  $text[] = "[big]text[/big]";
  $text[] = "[small]text[/small]";
  $text[] = "[left]text[/left]";
  $text[] = "[right]text[/right]";

  echo "<div class='table-responsive'>";
  echo "<table class='table'>";
  for($i = 0;$i < count($text);$i ++)
  {
    echo "<tr>";
    echo "<td width='40%'>".$text[$i]."</td>";
    echo "<td width='60%'>".StrMagic($text[$i])."</td>";
    echo "</tr>";
  }
  echo "</table>";
  echo "</div>";
}

function show_string($string)
{
  $string = strip_tags($string);
 	$string = str_replace("\n", "<br />", $string);  
  return $string;  
}

function StrMagic($string)
{
  $string = htmlspecialchars($string);
  $string = strip_tags($string);
 	$string = str_replace("\n", "<br />", $string);  
	$string = preg_replace("/\s*[a-zA-Z\/\/:\.]*twitch.tv\/([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i", "<br><div class='embed-responsive embed-responsive-16by9'><iframe src='http://www.twitch.tv/$1/embed' frameborder='0' scrolling='no' height='378' width='620' class='embed-responsive-item'></iframe></div>", $string);
  $string = preg_replace("/\s*[a-zA-Z\/\/:\.]*youtube.com\/watch\?v=([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i","<div class='embed-responsive embed-responsive-16by9'><iframe class='embed-responsive-item' title='YouTube Player' src='http://www.youtube.com/embed/$1?autoplay=0' frameborder='0' allowfullscreen></iframe></div>",$string);
  $string = str_replace('[br]', '<br />', $string);
  $string = preg_replace("/@([a-z0-9_]+)/i", "<a href='?page=profile&user=$1'>@$1</a>", $string);
  $string = preg_replace('#\[b\](.*?)\[/b\]#si', '<strong>\1</strong>', $string);
  $string = preg_replace('#\[u\](.*?)\[/u\]#si', '<u>\1</u>', $string);
  $string = preg_replace('#\[i\](.*?)\[/i\]#si', '<i>\1</i>', $string);
  $string = preg_replace('#\[bgcolor=(black|blue|brown|cyan|gray|green|lime|maroon|navy|olive|orange|purple|red|silver|violet|white|yellow)\](.*?)\[/bgcolor\]#si', '<span style=\'background-color:\1;padding:2px\'>\2</span>', $string);
  $string = preg_replace('#\[bgcolor=([\#a-f0-9]*?)\](.*?)\[/bgcolor\]#si', '<span style=\'background-color:\1;padding:2px\'>\2</span>', $string);
  $string = preg_replace('#\[color=(black|blue|brown|cyan|gray|green|lime|maroon|navy|olive|orange|purple|red|silver|violet|white|yellow)\](.*?)\[/color\]#si', '<span style=\'color:\1\'>\2</span>', $string);
  $string = preg_replace('#\[color=([\#a-f0-9]*?)\](.*?)\[/color\]#si', '<span style=\'color:\1\'>\2</span>', $string);
  $string = preg_replace('#\[center\](.*?)\[/center\]#si', '<div style=\'text-align:center\'>\1</div>', $string);
  $string = preg_replace('#\[big\](.*?)\[/big\]#si', '<span style=\'font-size:20px\'>\1</span>', $string);
  $string = preg_replace('#\[small\](.*?)\[/small\]#si', '<span style=\'font-size:8px\'>\1</span>', $string);
  $string = preg_replace('#\[left\](.*?)\[/left\]#si', '<div style=\'text-align:left\'>\1</div>', $string);
  $string = preg_replace('#\[right\](.*?)\[/right\]#si', '<div style=\'text-align:right\'>\1</div>', $string);      
  $string = preg_replace('#\[url=(.*?)\](.*?)\[/url\]#si', '<a href="\1">\2</a>', $string);
  $string = preg_replace('#\[img\](.*?)\[/img\]#si', '<img src="\1" style="max-width:200px;max-height:200px;">', $string);
	return $string;
}

function ShowNotification($type, $text)
{
  $not_str = null;
  $not_str .= "<div class='alert alert-".$type."' role='alert'>\n";
  $not_str .= "<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>";
  $not_str .= $text."\n";
  $not_str .= "</div>\n";
  echo $not_str;
}

function Web_IPBanned()
{
  if($_GET["page"] != "bans")
  {
    $ban_data = Database_Select("BANS", array("IP" => User_IP(1)));
    if($ban_data != "N/A") header("location: ?page=bans&ban=".$ban_data["BAN_ID"]);
  }
}

function Web_Email($email, $subject, $msg)
{
  $email_string = null;
  $email_string = "
  <html>
    <head>
      <title>".$subject."</title>
    </head>
    <body>
      ".$msg."
    </body>
  </html>";
  
  $headers = null;
  $headers .= "MIME-Version: 1.0\r\n";
  $headers .= "Content-type:text/html;charset=UTF-8\r\n";
  $headers .= "To: ".$email." <".$email.">\r\n";
  $headers .= "From: ".Web_GetOption("NAME")." <".Web_GetOption("EMAIL").">\r\n";
  mail($email, $subject, $email_string, $headers);
}

function Web_PostForm($post_type, $id, $loc1 = 'COMM_01', $loc2 = 'COMM_02')
{
  if($_SESSION["USER_ID"] > 0)
  {
    if($post_type != "status_post") echo "<hr>";
    ?>
    <form method="post">
    <div class="media">
      <div class="media-left">
          <img class="media-object" width="64px" height="64px" src="<?php echo User_Data($_SESSION["USER_ID"], "USER_AVATAR");?>" alt="<?php echo User_Data($_SESSION["USER_ID"], "USER_DISPLAY_NAME");?>">
        </div>
        <div class="media-body" style="width:100%">
          <textarea class="form-control" name="comment_text" rows="2" style="resize: vertical; overflow: auto; margin-top: 0px; margin-bottom: 0px;" placeholder="<?php echo Web_GetLocale($loc1);?>"></textarea>  
          <div style="float:right">
            <input type="submit" class="btn btn-primary" name="post_comment" value="<?php echo Web_GetLocale($loc2);?>">
          </div>  
        </div>
      </div> 
    </form>
    <?php
    if(@$_POST["post_comment"])
    {
      if(!empty($_POST["comment_text"]))
      {
        Post_Create(array(
          "POST_NAME" => $id,
          "POST_TEXT" => $_POST["comment_text"],
          "POST_IMG" => "NONE",
          "POST_DATE" => time(),
          "POST_TYPE" => $post_type,
          "USER_ID" => $_SESSION["USER_ID"],
          "POST_SHOW" => 1
        )); 
        if($post_type == "comments_post") header("Location: ?page=post&post=".$id."");
        else if($post_type == "status_post")  header("Location: ?page=profile&user=".User_Name($id).""); 
      }  
    }
  }
}

function Web_LoginForm($opt = 0)
{
  ?>
  <form method="post" action="?page=login">
    <div class="input-group">
      <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
      <input id="user" type="text" class="form-control" name="user_name" value="" placeholder="<?php echo Web_GetLocale("LOGIN_02");?>">                                        
    </div>

    <div class="input-group">
      <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
      <input id="password" type="password" class="form-control" name="user_password" placeholder="<?php echo Web_GetLocale("LOGIN_03");?>">
    </div>                                                                  

    <input type="submit" name="login" class="btn btn-primary btn-block"" value="<?php echo Web_GetLocale("LOGIN_04");?>">                        
    <br>
    <center>
    <?php
    if($opt == 1) ?><a href="?page=register"><?php echo Web_GetLocale("LOGIN_05");?></a> - <a href="?page=password"><?php echo Web_GetLocale("LOGIN_06");?></a><?php  
    ?> 
    </center>
  </form>
  <?php
}

function Web_GetOption($key)
{
  return Database_Select("OPTIONS", array("OPTION_KEY" => $key), "OPTION_VALUE");
}

function Web_GetLocale($msg)
{
  $lang = Web_GetOption("LANG");
  $fail_text = "Message ".$lang."-".$msg." can't be found.";

  $file_path = "languages/".$lang.".php";
  if(file_exists($file_path)) include($file_path);
  else return $fail_text;

  if(isset($language[$msg]) && !empty($language[$msg])) return $language[$msg];
  else return $fail_text; 
}

function Web_ShowUpdates()
{
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_HEADER, 0);
  curl_setopt($ch, CURLOPT_URL, "http://dwe.domm98.cz/updates/updates.php");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_TIMEOUT, 30);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
  $updates_data = curl_exec($ch);
  curl_close($ch);  
  return $updates_data;  
}

function Web_VersionCheck($reupdate = 0)
{
  $x = Web_GetVersion();
  $v = explode(" #", $x);
  $version = $v[0];
  $build = $v[1];  
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_HEADER, 0);
  curl_setopt($ch, CURLOPT_URL, "http://dwe.domm98.cz/updates/");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_TIMEOUT, 30);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
  $updater_data = curl_exec($ch);
  curl_close($ch);  
  
  $update_version = null;
  $update_build = 0;
  $update_name = null;
  $update_time = null;
  $update_files = 0;
  $update_file = null;
  $update_str = null;
  
  if(preg_match('/\(Lastest Version: (.*?)\)/', $updater_data, $matches1))
  {
    $w = explode(" #", $matches1[1]);
    $update_version = $w[0];
    $update_build = $w[1];
  }
  if(preg_match('/\(Version Name: (.*?)\)/', $updater_data, $matches2)) $update_name = $matches2[1]; 
  if(preg_match('/\(Published Time: (.*?)\)/', $updater_data, $matches3)) $update_time = $matches3[1];
  if(preg_match('/\(Updated Files: (.*?)\)/', $updater_data, $matches4)) $update_files = $matches4[1]; 
   
  for($i = 0;$i < $update_files;$i ++)
  {
    if(preg_match('/\(File #'.$i.': \[Path: (.*?)\]\[Update: (.*?)\]\[Action: (.*?)\]\)/', $updater_data, $matches5)) 
    {
      $update_file[$i]["PATH"] = $matches5[1];
      $update_file[$i]["UPDATE"] = $matches5[2];
      $update_file[$i]["ACTION"] = $matches5[3];
    }  
  }
  
  if(floatval($update_version) >= floatval($version) || $reupdate == 1)
  {
    if(intval($update_build) > intval($build) || $reupdate == 1)
    {
      $conf = $GLOBALS["conf"];
      File_CreateConfig(
        array(
          "DB:SERVER" => $conf["DB:SERVER"],  
          "DB:NAME" => $conf["DB:NAME"],  
          "DB:USER" => $conf["DB:USER"],  
          "DB:PASS" => $conf["DB:PASS"],  
          "DB:PREFIX" => $conf["DB:PREFIX"],  
          "DWE:VERSION" => $update_version,  
          "DWE:BUILD" => intval($update_build)
      ));
    
      for($y = 0;$y < count($update_file);$y ++)
      {
        if($update_file[$y]["ACTION"] == "DELETE")
        {
          if(file_exists($update_file[$y]["PATH"])) 
          {
            unlink($update_file[$y]["PATH"]);
            $update_str .= "".$update_file[$y]["PATH"]." - Removed<br>";
          }
        }
        else if($update_file[$y]["ACTION"] == "UPDATE")
        {  
          $file_content = file_get_contents("http://dwe.domm98.cz/updates/update_files/".$update_time."/".$update_file[$y]["UPDATE"]);
          if($file_content)
          {       
            if(file_exists($update_file[$y]["PATH"])) unlink($update_file[$y]["PATH"]);
            $file = fopen ($update_file[$y]["PATH"], "w");
            fwrite($file, $file_content);
            fclose($file);
            $update_str .= "".$update_file[$y]["PATH"]." - Updated<br>"; 
          }
        }
        else if($update_file[$y]["ACTION"] == "CREATE")
        {         
          $file_content = file_get_contents("http://dwe.domm98.cz/updates/update_files/".$update_time."/".$update_file[$y]["UPDATE"]);
          if($file_content)
          {
            $file = fopen ($update_file[$y]["PATH"],'w');
            fwrite($file, $file_content);
            fclose($file);
            $update_str .= "".$update_file[$y]["PATH"]." - Created<br>";     
          }
        }
      }
      return $update_str;
    }
    else if(intval($update_build) == intval($build)) return "OK";
  }
}


function Web_GetVersion()
{
  $version = $GLOBALS["conf"]["DWE:VERSION"];
  $build = $GLOBALS["conf"]["DWE:BUILD"];
  return $version." #".$build;
}

//FILE FUNCTIONS
$allowed_ex = array("png", "gif", "jpg", "jpeg", "html", "mp4", "mp3", "wav", "pdf", "txt", "avi", "zip");
$not_allowed_chars = array(" ", "<", ">", "!", "?", "*", "(", ")", "{", "}", "\"", "'", "/", "|", "%", "`", "^", "&", "#");

function File_GetIconFromFile($file)
{   
  if(file_exists($file))
  {
    $pathinfo = pathinfo($file);
    return File_GetIconFromFileType($pathinfo["extension"]);
  }
  else return "N/A";
}

function File_FileName($file_name)
{
  $not_allowed_chars = $GLOBALS["not_allowed_chars"];
  for($i = 0; $i < count($not_allowed_chars);$i ++) str_replace($not_allowed_chars[$i], "", $file_name);
  return $file_name;
}

function File_GetIconFromFileType($file_type)
{
  $icon = "<i class='fa fa-file'></i>";
  if($file_type == "png" || $file_type == "gif" || $file_type == "jpg" || $file_type == "jpeg") $icon = "<i class='fa fa-file-image-o'></i>";
  else if($file_type == "html") $icon = "<i class='fa fa-file-code-o'></i>";
  else if($file_type == "txt") $icon = "<i class='fa fa-file-text-o'></i>";
  else if($file_type == "pdf") $icon = "<i class='fa fa-file-pdf-o'></i>";
  else if($file_type == "zip") $icon = "<i class='fa fa-file-archive-o></i>";
  else if($file_type == "mp3" || $file_type == "wav") $icon = "<i class='fa fa-file-audio-o'></i>";
  else if($file_type == "mp4" || $file_type == "avi") $icon = "<i class='fa fa-file-movie-o'></i>";  
  return $icon;  
}

function File_Show($file_path)
{
  $allowed_ex = $GLOBALS['allowed_ex'];
  if(file_exists($file_path))
  {
    if(filetype($file_path) == "file") 
    {
      $pathinfo = pathinfo($file_path);
      if($pathinfo["extension"] == "png" || $pathinfo["extension"] == "gif" || $pathinfo["extension"] == "jpg" || $pathinfo["extension"] == "jpeg")
      {
        echo "<img src='".$file_path."' class='img-thumbnail'><br>";
      }    
      else if($pathinfo["extension"] == "html" || $pathinfo["extension"] == "txt")
      {
        $file = @file($file_path);  
        foreach($file as $row) echo htmlspecialchars($row)."<br>";  
      } 
      else if($pathinfo["extension"] == "pdf")
      {
        echo "<object data='".$file_path."' type='application/pdf' width='100%' height='800px'>";
        echo "<p>Error, your browser doesn't support this pdf view method, <a href='".$file_path."'>here is file link.</a></p>";
        echo "</object>";
      } 
      else if($pathinfo["extension"] == "mp3" || $pathinfo["extension"] == "wav")
      {
        echo "<audio controls>";
        echo "<source src='".$file_path."' type='audio/".$pathinfo["extension"]."'>";
        echo "Error, your browser doesn't support this audio player, <a href='".$file_path."'>here is file link.</a>";
        echo "</audio>";
      } 
      else if($pathinfo["extension"] == "mp4" || $pathinfo["extension"] == "avi")
      {
        echo "<video width='100%' height='100%' controls>";
        echo "<source src='".$file_path."' type='video/".$pathinfo["extension"]."'>";
        echo "Error, your browser doesn't support this video player, <a href='".$file_path."'>here is file link.</a>";
        echo "</video>";
      }  
      else 
      {
        echo Web_GetLocale("ADMIN_83");
      }
      echo "<hr>";
      echo "<b>".Web_GetLocale("ADMIN_84")."</b>: ".$pathinfo["basename"]."<br>";
      echo "<b>".Web_GetLocale("ADMIN_85")."</b>: ".$pathinfo["extension"]."<br>";
      echo "<b>".Web_GetLocale("ADMIN_86")."</b>: <a href='".$file_path."' target='_blank'>".$file_path."</a><br>";
    }
    else header("location: ?page=admin&admin=files"); 
  }
  else header("location: ?page=admin&admin=files"); 
} 

function File_ShowUploads()
{    
  $allowed_ex = $GLOBALS['allowed_ex'];
  if ($dh = opendir(UPLOAD_DIR)) 
  {
    echo "<div class='list-group'>";
    while(($file = readdir($dh)) !== false) 
    {                           
      if ($file != "." && $file != "..")
      {
        if(filetype(UPLOAD_DIR.$file) == "file") 
        {
          $pathinfo = pathinfo(UPLOAD_DIR.$file);
          for($i = 0;$i < count($allowed_ex);$i ++)
          {
            if($pathinfo["extension"] == $allowed_ex[$i])
            {              
              echo "<a href='?page=admin&admin=files&action=view&file=".urlencode($file)."' class='list-group-item'>".File_GetIconFromFileType($pathinfo["extension"])." ".$file."</a>";
            }
          }
        }
      }
    }
    echo "</div>";
  }
}

function File_CreateConfig($data = array())
{
  if(file_exists("_core/config.php")) unlink("_core/config.php");
  
  $file = fopen("_core/config.php", "w");
  fwrite($file, "<?php\n");  
  
  $string = null;
  $data_key = array_keys($data);
  $data_value = array_values($data);
  for($i = 0;$i < count($data);$i++) 
  {
    $string .= "\$conf[\"".$data_key[$i]."\"] = \"".$data_value[$i]."\";\n";  
  }  
  fwrite($file, $string);
  fwrite($file, "?>");
  fclose($file);  
}
?>