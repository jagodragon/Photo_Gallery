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
foreach ($Gal_list as $galleries)
{
echo '<a href="?module='. MODULE_NAME .'&sub=gallery&gal='. $galleries .'&page=1"><br />'.add_pictureletter($module_lang[$galleries]).'';
echo '<br/>'.$module_lang['gallery'].'</a>';
echo '<br/>';
}
echo '<a href="?module='. MODULE_NAME .'&sub=gallery&page=1"><br />'.add_pictureletter($module_lang['allimages']).'';
echo '<br/>'.$module_lang['inthegallery'].'</a>';
echo '<br/>';
echo '<a href="?module='. MODULE_NAME .'&sub=add_image"><br />'.add_pictureletter($module_lang['addyourown']).'';
echo '<br/>'.$module_lang['images'].'</a> ';

?>