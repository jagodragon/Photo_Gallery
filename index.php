<?php
//========================//
if(INCLUDED !== TRUE) 
{
	echo "No Direct File Linking Allowed!"; 
	exit;
}
// ==================== //

// To access site config variables, use $Config->get(' VARIABLE NAME ');
// Here is an example trying to get an echo the site title. NOTE that
// (string) is not required by all variables, Just on strings

//echo 'Example 1: Site Title = '.(string)$Config->get('site_title');

//echo '<br /><br />'.add_pictureletter('Example 2: Module Config -> Title =').''.(string)$Module_Config['title'];

// To Access the DB. Its the same way as the site. Use $DB to access the realm
// Database. $CDB accesses the character DB, and $WDB accesses the world DB
// Please refer to the MangosWeb Wiki for different database querys such as
// select, query, selectCell, selectRow, and count.

//echo '<br /><br /><br />Example 3:';
//$username = $DB->selectCell("SELECT `username` FROM `account` WHERE `id` > 1 LIMIT 1");
//echo ''.add_pictureletter('Random account from the database - ').''.$username.'';

//echo '<br /><br /><br />'.add_pictureletter('Example 4: Loading other pages within the module.').'';	
//echo '<a href="?module='. MODULE_NAME .'&sub=screenshot_gallery&page=1"><br />'.add_pictureletter('screenshots').'';
//echo '<br />Gallery</a> ';
//echo '<br /><a href="?module='. MODULE_NAME .'&sub=wallpaper_gallery&page=1"><br />'.add_pictureletter('wallpapers').'';
//echo '<br />Gallery</a> ';


//**************** Commits an edit to the db **************************//
if (isset($_POST['doedit']))
{
  if (isset ($_POST['galtype']))
  {
    $galtype=$_POST['galtype'];
	$oldgaltype=$DB->selectCell("SELECT `cat` FROM `mw_gallery` WHERE `id`= '".$_POST['picid']."'");
  }
  else
  {
    echo $module_lang['selecttype'];
	exit;
  }
  $img=isset ($_FILES["filename"]["name"]) ? $_FILES["filename"]["name"] : '';
  $comment=isset($_POST['message']) ? $_POST['message'] : '';
  $autor=$user['username'];
  $date=date("Y-m-d");
  $filemane=$DB->selectCell("SELECT `img` FROM `mw_gallery` WHERE `id`= '".$_POST['picid']."'");
  if ($oldgaltype == $galtype)
  {
    $DB->query("update `mw_gallery` SET `comment`='".$comment."' WHERE `id`='".$_POST['picid']."'");
	echo ''.$module_lang['editsuccess'].'<br/>';
  }
  elseif ($oldgaltype == 'deleted')
  {
    $oldgaltype=$DB->selectCell("SELECT `oldcat` FROM `mw_gallery` WHERE `id`= '".$_POST['picid']."'");
	if(copy("../".$Module_Config['mangwebdir']."/images/".$oldgaltype."s/".$filemane."","../".$Module_Config['mangwebdir']."/images/".$galtype."s/".$filemane.""))
    {
      $DB->query("update `mw_gallery` SET `comment`='".$comment."',`cat`='".$galtype."' WHERE `id`='".$_POST['picid']."'");
      echo ''.$module_lang['editsuccess'].'<br/>';
    }
	else
    {
      $DB->query("update `mw_gallery` SET `comment`='".$comment."',`cat`='".$galtype."',`oldcat`='' WHERE `id`='".$_POST['picid']."'");
      echo ''.$module_lang['editsuccess'].'<br/>';
    }
  }
  Else
  {
    if(copy("../".$Module_Config['mangwebdir']."/images/".$oldgaltype."s/".$filemane."","../".$Module_Config['mangwebdir']."/images/".$galtype."s/".$filemane.""))
    {
      $DB->query("update `mw_gallery` SET `comment`='".$comment."',`cat`='".$galtype."' WHERE `id`='".$_POST['picid']."'");
	  echo ''.$module_lang['editsuccess'].'<br/>';
    }
    else
    {
      echo $module_lang['Uploaderror'];  
    }
  }
}

//**************** Commits a delete to the db **************************//
if (isset($_POST['dodelete']))
{
          //    UPDATE `mw_gallery` SET `cat` = 'deleted', `oldcat` = 'wallpaper' WHERE `id` = 1;
    $DB->query("update `mw_gallery` SET `cat` = 'deleted', `oldcat` = '".$_POST['oldgal']."' WHERE `id`='".$_POST['picid']."';");
    echo ''.$module_lang['deletesuccess'].'<br/>';
  
}

//**************** Prints main menu **************************//
foreach ($Gal_list as $galleries)
{
echo '<a href="?module='. MODULE_NAME .'&sub=gallery&gal='. $galleries .'&page=1"><br />'.add_pictureletter($module_lang[$galleries]).'';
echo '<br/>'.$module_lang['gallery'].'</a>';
echo '<br/>';
}
echo '<a href="?module='. MODULE_NAME .'&sub=gallery&page=1"><br />'.add_pictureletter($module_lang['allimages']).'';
echo '<br/>'.$module_lang['inthegallery'].'</a>';
echo '<br/>';
if ($user['account_level'] >= 3)
{
  if ( (int)$DB->selectCell("SELECT COUNT(`id`) FROM `mw_gallery` WHERE `cat` ='deleted';") >> 0)
  {
    echo '<a href="?module='. MODULE_NAME .'&sub=gallery&gal=deleted&page=1"><br />'.add_pictureletter($module_lang['deleted']).'';
    echo '<br/>'.$module_lang['images'].'</a>';
    echo '<br/>';
  }
}
echo '<a href="?module='. MODULE_NAME .'&sub=add_image"><br />'.add_pictureletter($module_lang['addyourown']).'';
echo '<br/>'.$module_lang['images'].'</a> ';

?>