<?php
function User_Rights($user_id, $rights)
{
  $r = null;
  $r = User_Data($user_id, "USER_RIGHTS");
  if(!empty($r))
  {
    if($r == "X") return true;
    if($r == "unactivate") return false;
    if($r == "banned") return false;
    else
    {
      $user_rights = explode("-", $r);
      if (in_array($rights, $user_rights)) return true;     
      else return false;
    }
  }  
}

function User_Banned($user_id)
{       
  if($_GET["page"] != "bans")
  {
    $ban_data = Database_Select("BANS", array("USER_ID" => $user_id));
    if($ban_data != "N/A") header("location: ?page=bans&ban=".$ban_data["BAN_ID"]);
  }
}

function User_Data($user_id, $data = 'array')
{
  return Database_Select("USER", array("USER_ID" => $user_id), $data); 
}

function User_Name($user_id)
{ 
  return Database_Select("USER", array("USER_ID" => $user_id), "USER_NAME");
}

function User_ID($user_name)
{ 
  return Database_Select("USER", array("USER_NAME" => $user_name), "USER_ID");
}

function User_IP($er = 0)
{
  $user_ip = null;
  if(Web_GetOption("CLOUDFLARE") == "true") $user_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
  else $user_ip = $_SERVER['REMOTE_ADDR']; 
  if($er == 1) return $user_ip;
  else echo $user_ip; 
}

function User_Load($user_id)
{ 
  $user_info = Database_Select("USER", array("USER_ID" => $user_id)); 
  
  $user_ip = null;
  if(Web_GetOption("CLOUDFLARE") == "true") $user_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
  else $user_ip = $_SERVER['REMOTE_ADDR']; 
   
  Database_Update("USER", array("USER_DATE_A" => time(), "USER_IP" => $user_ip), array("USER_ID" => $user_id));
  
  $opt = array_keys($user_info);
  for($i = 0;$i < count($opt);$i++) $_SESSION[$opt[$i]] = $user_info[$opt[$i]];
  /* IP */
  $_SESSION["USER_IP"] = $user_ip;
}


function User_GenerateKey($key = '')
{   
  $letters_s = array();
  $letters_b = array();       
  $letters_s = range("a", "z");
  $letters_b = range("A", "Z");
  $numbers = range(0, 9);
  $letters = array();
  for($i = 0;$i < count($letters_s);$i ++) $letters[] = $letters_s[$i];  
  for($i = 0;$i < count($letters_s);$i ++) $letters[] = $letters_b[$i];  
  for($i = 0;$i < count($numbers);$i ++) $letters[] = $numbers[$i];  
  $key_str = null;
  $key_str .= $key;
  for($i = 0;$i < 20;$i ++) $key_str .= $letters[rand(0, count($letters))];
  return $key_str;
}

function User_CreateKey($user_id, $key, $type = "all")
{   
  return Database_Insert("KEYS", 
    array(
      "USER_ID" => $user_id,
      "KEY" => $key,
      "KEY_TIME" => time(),
      "KEY_TYPE" => $type
    )
  );
}

function User_Create($data = array())
{
  Database_Insert("USER", $data);
  return Database_Select("USER", $data, "USER_ID"); 
}

function User_GeneratePasswordSalt($key = 'DOMMDWE_')
{   
  $letters_s = array();
  $letters_b = array();       
  $letters_s = range("a", "z");
  $letters_b = range("A", "Z");
  $numbers = range(0, 9);
  $letters = array();
  for($i = 0;$i < count($letters_s);$i ++) $letters[] = $letters_s[$i];  
  for($i = 0;$i < count($letters_s);$i ++) $letters[] = $letters_b[$i];  
  for($i = 0;$i < count($numbers);$i ++) $letters[] = $numbers[$i];  
  $user_salt = null;
  $user_salt .= $key;
  for($i = 0;$i < 50;$i ++) $user_salt .= $letters[rand(0, count($letters))];
  return $user_salt;
}


function User_CreatePasswordSalt($user_id, $key = 'DOMMDWE_')
{
  $user_salt = User_GeneratePasswordSalt($key);
  return Database_Update("USER", array("USER_SALT" => $user_salt), array("USER_ID" => $user_id));
}

function User_GeneratePassword($user_id, $password_text, $salt = null)
{
  $password = null;
  if(empty($salt)) $salt = Database_Select("USER", array("USER_ID" => $user_id), "USER_SALT");
  $password .= md5($salt);
  $password .= md5($password_text);
  $password = hash("sha512", $salt.hash("sha512", $password)); 
  return $password;
}

function User_CreatePassword($user_id, $password)
{
  return Database_Update("USER", array("USER_PASS" => $password), array("USER_ID" => $user_id));  
}
?>