<?php
if(!empty($_GET["ban"]) && isset($_GET["ban"]) && is_numeric($_GET["ban"]))
{
  $ban_data = Database_Select("BANS", array("BAN_ID" => $_GET["ban"]));
  if(!empty($ban_data) && isset($ban_data))
  {
    ?>
    <div class="panel panel-danger">
      <div class="panel-body">
        <?php
        if($ban_data["USER_ID"] != "NONE") echo "<h1>".Web_GetLocale("BAN_01")."</h1>";
        else echo "<h1>".Web_GetLocale("BAN_03")."</h1>";

        if($ban_data["USER_ID"] != "NONE") echo "<p><b>".Web_GetLocale("BAN_06").":</b> ".User_Name($ban_data["USER_ID"])."</p>";
        else echo "<p><b>".Web_GetLocale("BAN_07").":</b> ".$ban_data["IP"]."</p>";  
        ?>
        <p>
          <b><?php echo Web_GetLocale("BAN_02");?>:</b><br>
          <?php echo StrMagic($ban_data["BAN_REASON"]);?>   
        </p>
        <p><?php echo Web_GetLocale("BAN_05")." <b>".ShowTime($ban_data["BAN_DATE"])."</b>";?></p>
        <p><?php echo Web_GetLocale("BAN_04");?>.</p>
      </div>
    </div>
    <?php
  }
  else header("location: index.php");
}
else header("location: index.php");
?>
