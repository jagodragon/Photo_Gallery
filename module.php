<?php
/*
	Module Development Kit v1.0 For MangosWeb Enhanced
	Built for MangosWeb v3 Module System v1.0
	
	Always Keep the following lines until you see
	where i say END OF REQUIRED. Very Important
*/

//========================//
if(INCLUDED !== TRUE) 
{
	echo "No Direct File Linking Allowed!"; 
	exit;
}
// ==================== //

// Define the module name
define('MODULE_NAME', $_GET['module']);

// Lets get the module path, so when we include images we can go " echo "MODULE_PATH .'images/image.png'"
// rather then "modules/test/images/image.png"
define('MODULE_PATH', 'modules/'. MODULE_NAME .'/');

// !!! - If you have a functions file that needs loading before the header, put here. - !!!
// include( MODULE_PATH.'functions.php');

// =============== START OF TEMPLATE HEADER INTEGRATION ===============//
// Remove the following lines (28 - 50) if you DONT want to
// implement into the current template. Also remove lines in the
// footer. Look below

// Start include of template header and functions file
if(file_exists($Template['functions'])) 
{
	include($Template['functions']);
}
ob_start();
	include($Template['header']);
ob_end_flush();

// To start the div's of our module for template integration
// Official templates will have this function
if(function_exists('Content_Div_Start'))
{
	echo "<br />";
	Content_Div_Start();
}

// ================ END OF TEMPLATE HEADER INTEGRATION ================//

/***************************************************************
 * END OF REQUIRED - Edit below this line!
 ***************************************************************/

 // include the module config file(s)
 include(MODULE_PATH .'config/config.php');
 include(MODULE_PATH .'config/lang_'.$GLOBALS["user_cur_lang"].'.php');
 
//getting module theme from site theme 
If (isset($user['theme']))
{
  $template_list = explode(",", $Config->get('templates'));
  $modulethemenum = $user['theme'];
  foreach ($template_list as $template)
  {
    $currtmp2[] = $template ;
  }
  $moduletheme = $currtmp2[$modulethemenum];
}
else
  $moduletheme = 'WotLK';
  
if (file_exists('templates/'.$moduletheme.'/frame/_.gif'))
{
  $moduletheme = $moduletheme;
}
else
  $moduletheme = 'WotLK';

// If URL looks like this ?module= xxx $sub= xxx
if(isset($_GET['page']))
{
  $page=$_GET['page'];
	include(MODULE_PATH . $_GET['sub'] .'.php');
}
elseif(isset($_GET['sub']))
{
	include(MODULE_PATH . $_GET['sub'] .'.php');
}
else
{
	include(MODULE_PATH . 'index.php');
}

/***************************************************************
 * REQUIRED - Donot Edit below this line unless you know what your doing!
 ***************************************************************/
 
// =============== START OF TEMPLATE FOOTER INTEGRATION ===============//
 
// To end the div's of our module for template integration
if(function_exists('Content_Div_End'))
{
	Content_Div_End();
}
 
// Set our time end, so we can see how fast the page loaded.
define('TIME_END', microtime(1));
define('PAGE_LOAD_TIME', TIME_END - TIME_START);

// Include the template footer
include($Template['footer']);

// ================ END OF TEMPLATE FOOTER INTEGRATION ================//
?>