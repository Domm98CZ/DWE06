<?php
try {
    $dwe_db = new PDO("mysql:host=".$conf["DB:SERVER"].";dbname=".$conf["DB:NAME"], "".$conf["DB:USER"]."", "".$conf["DB:PASS"]."", array(
      PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
      PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET utf8",
    )); 
    $dwe_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Database servers are down.";
    exit();
}

function Database_Insert($table, $data = array())
{
  $dwe_db = $GLOBALS["dwe_db"];
  $conf = $GLOBALS["conf"];
	$sql = null;
	$sql .= "INSERT INTO `".$conf["DB:PREFIX"].$table."` (`";
	$sql .= implode('`, `', array_keys($data));
  $sql .= "`) VALUES (";
	$sql .= str_repeat('?,', count($data) - 1);
	$sql .= "?)";  
	$result = $dwe_db->prepare($sql);
  $result->execute(array_values($data));
  return $dwe_db->lastInsertId();
}

function Database_Update($table, $data = array(), $params = array())
{
  $dwe_db = $GLOBALS["dwe_db"];
  $conf = $GLOBALS["conf"];
	$sql = null;
  $data_str = null;
  $param_str = null;
  $execute_data = array();
	$sql .= "UPDATE `".$conf["DB:PREFIX"].$table."` SET "; 
  $data_key = array_keys($data);
  $data_value = array_values($data);
  for($i = 0;$i < count($data);$i++) 
  {
    $data_str .= "`".$data_key[$i]."` = ?, ";
    $execute_data[] = $data_value[$i];
  }
  $data_str = substr($data_str, 0, -2); 
  $sql .= $data_str;
  $sql .= " WHERE "; 
  $param_key = array_keys($params);
  $param_value = array_values($params);
  for($i = 0;$i < count($params);$i++) 
  {
    $param_str .= "`".$param_key[$i]."` = ? AND";
    $execute_data[] = $param_value[$i];
  }
  $param_str = substr($param_str, 0, -4);
  $sql .= $param_str;  
  
	$result = $dwe_db->prepare($sql);
  $result->execute(array_values($execute_data));
}

function Database_Delete($table, $params = array())
{
  $dwe_db = $GLOBALS["dwe_db"];
  $conf = $GLOBALS["conf"];
	$sql = null;
  $param_str = null;
	$sql .= "DELETE FROM `".$conf["DB:PREFIX"].$table."` WHERE ";  
  $param_key = array_keys($params);
  $param_value = array_values($params);
  for($i = 0;$i < count($params);$i++) $param_str .= "`".$param_key[$i]."` = ? AND";
  $param_str = substr($param_str, 0, -4);
  $sql .= $param_str;
	$result = $dwe_db->prepare($sql);
  $result->execute(array_values($params));
}

function Database_Select($table, $params = array(), $data = 'array', $order = null)
{
  $dwe_db = $GLOBALS["dwe_db"];
  $conf = $GLOBALS["conf"];
	$sql = null;
  $param_str = null;
	$sql .= "SELECT * FROM `".$conf["DB:PREFIX"].$table."`";  
  $param_key = array_keys($params);
  $param_value = array_values($params);
  if($param_key[0] != "NONE" && $param_value[0] != "NONE")
  {
    $sql .= " WHERE ";
    for($i = 0;$i < count($params);$i++) $param_str .= "`".$param_key[$i]."` = ? AND";
    $param_str = substr($param_str, 0, -4);
    $sql .= $param_str;
  }
  if(!empty($order)) $sql .= " ".$order;
	$result = $dwe_db->prepare($sql);
  $result->execute(array_values($params));
  $info = $result->fetch();
  if($info > 0)
  {
    if($data == 'array') return $info;  
    else return $info[$data];
  }
  else return null;
}

function Database_Select_All($table, $params = array(), $wdata = 'array', $order = null)
{         
  $data_array = array();
  $counter = 0;
  $dwe_db = $GLOBALS["dwe_db"];
  $conf = $GLOBALS["conf"];
	$sql = null;
  $param_str = null;
	$sql .= "SELECT * FROM `".$conf["DB:PREFIX"].$table."`";  
  $param_key = array_keys($params);
  $param_value = array_values($params);
  if($param_key[0] != "NONE" && $param_value[0] != "NONE")
  {
    $sql .= " WHERE ";
    for($i = 0;$i < count($params);$i++) $param_str .= "`".$param_key[$i]."` = ? AND";
    $param_str = substr($param_str, 0, -4);
    $sql .= $param_str;
  }
  if(!empty($order)) $sql .= " ".$order;
	$result = $dwe_db->prepare($sql);
  $result->execute(array_values($params));
  while ($data = $result->fetch(PDO::FETCH_ASSOC))
  { 
    for($i = 0;$i < count($data);$i ++)
    {
      if($wdata == "array") $data_array[$counter] = $data;
      else $data_array[$counter][$wdata] = $data[$wdata]; 
    }
    $counter ++;  
  }
  return $data_array;
}

function Database_Count($table, $params = array())
{
  $dwe_db = $GLOBALS["dwe_db"];
  $conf = $GLOBALS["conf"];
	$sql = null;          
  $param_str = null;
	$sql .= "SELECT * FROM `".$conf["DB:PREFIX"].$table."` WHERE ";  
  $param_key = array_keys($params);
  $param_value = array_values($params);
  for($i = 0;$i < count($params);$i++) $param_str .= "`".$param_key[$i]."` = ? AND";
  $param_str = substr($param_str, 0, -4);
  $sql .= $param_str; 
	$result = $dwe_db->prepare($sql);
  $result->execute(array_values($params));
  $count = $result->rowCount();   
  return $count;
}

function Database_CountTable($table)
{
  $dwe_db = $GLOBALS["dwe_db"];  
  $conf = $GLOBALS["conf"];
  $sql = null;          
	$sql .= "SELECT * FROM `".$conf["DB:PREFIX"].$table."`";
  $result = $dwe_db->prepare($sql);
  $result->execute();
  $count = $result->rowCount();   
  return $count;
}

function Database_FreeSql($sql)
{
  $dwe_db = $GLOBALS["dwe_db"];  
  $result = $dwe_db->prepare($sql);
  $result->execute();  
}
?>