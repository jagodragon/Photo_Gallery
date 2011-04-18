<?php
//========================//
if(INCLUDED !== TRUE) 
{
	echo "No Direct File Linking Allowed!"; 
	exit;
}
// ==================== //
/*

*/

if (isset ($_GET['page']))
  $page=$_GET['page'];
else
  $page=1;
$limitstart = (($page*$Module_Config['pagelimit'])-$Module_Config['pagelimit']);
if (isset ($_GET['gal']))
{
  if ( $_GET['gal'] == 'deleted' )
    if ($user['account_level'] >= 3 )
    {
      $lastpicid = (int)$DB->selectCell("SELECT `id` FROM `mw_gallery` WHERE `cat`='".$_GET['gal']."' ORDER BY `id` DESC LIMIT 1;");
      $pictures = $DB->select("SELECT * FROM `mw_gallery` WHERE `cat`='".$_GET['gal']."' ORDER BY `id` ASC LIMIT ".$limitstart.",".$Module_Config['pagelimit'].";");
      $totalimages = (int)$DB->selectCell("select count(id) from `mw_gallery` where `cat`='".$_GET['gal']."';");
    }
    else
    {
      echo'
        <center>
	      '.$module_lang['notowneredit'].'<br/>
          <a href="?module='. MODULE_NAME .'">'.$module_lang[$galleries].' </a>
        </center>
      ';
      exit;
    }
  else
  {
    $lastpicid = (int)$DB->selectCell("SELECT `id` FROM `mw_gallery` WHERE `cat`='".$_GET['gal']."' ORDER BY `id` DESC LIMIT 1;");
    $pictures = $DB->select("SELECT * FROM `mw_gallery` WHERE `cat`='".$_GET['gal']."' ORDER BY `id` ASC LIMIT ".$limitstart.",".$Module_Config['pagelimit'].";");
    $totalimages = (int)$DB->selectCell("select count(id) from `mw_gallery` where `cat`='".$_GET['gal']."';");
  }
}
else
{
  $lastpicid = (int)$DB->selectCell("SELECT `id` FROM `mw_gallery` ORDER BY `id` DESC LIMIT 1;");
  if ($user['account_level'] >= 3)
    $pictures = $DB->select("SELECT * FROM `mw_gallery` ORDER BY `id` ASC LIMIT ".$limitstart.",".$Module_Config['pagelimit'].";");
  else
    $pictures = $DB->select("SELECT * FROM `mw_gallery` WHERE `cat`!='deleted' ORDER BY `id` ASC LIMIT ".$limitstart.",".$Module_Config['pagelimit'].";");
  $totalimages = (int)$DB->selectCell("select count(id) from `mw_gallery`;");
}
if ($totalimages >> 0)
{
  foreach($pictures as $picture)
  {
    echo '
      <center>
        <table style="margin: 7px;" border="0" cellpadding="0" cellspacing="0">
          <tbody>
            <tr>
              <td><img src="modules/'. MODULE_NAME .'/templates/'.$moduletheme.'/frame/lt.png" class="png" style="width: 12px; height: 9px;" border="0" height="0" width="0"></td>
              <td background="modules/'. MODULE_NAME .'/templates/'.$moduletheme.'/frame/_t.gif"><img src="modules/'. MODULE_NAME .'/templates/'.$moduletheme.'/frame/_.gif" height="0" width="0"></td>
              <td><img src="modules/'. MODULE_NAME .'/templates/'.$moduletheme.'/frame/rt.png" class="png" style="width: 12px; height: 9px;" border="0" height="0" width="0"></td>
            </tr>
            <tr>
              <td background="modules/'. MODULE_NAME .'/templates/'.$moduletheme.'/frame/_l.gif"><img src="modules/'. MODULE_NAME .'/templates/'.$moduletheme.'/frame/_.gif" height="0" width="0"></td>
              <td>';
if ($picture['cat'] == 'deleted')
{
  echo         '<a href="images/'. $picture['oldcat'] .'s/'. $picture['img'] .'" target="_blank"><img src="modules/'. MODULE_NAME .'/show_picture.php?filename='. $picture['img'] .'&amp;gallery='. $picture['oldcat'] .'&amp;width=282" width="282" alt="" style="border: 1px solid #333333"/>';
}
Else
{
  echo         '<a href="images/'. $picture['cat'] .'s/'. $picture['img'] .'" target="_blank"><img src="modules/'. MODULE_NAME .'/show_picture.php?filename='. $picture['img'] .'&amp;gallery='. $picture['cat'] .'&amp;width=282" width="282" alt="" style="border: 1px solid #333333"/>';
}
echo '
				</td>
              <td background="modules/'. MODULE_NAME .'/templates/'.$moduletheme.'/frame/_r.gif"><img src="modules/'. MODULE_NAME .'/templates/'.$moduletheme.'/frame/_.gif" height="0" width="0"></td>
              <td width="25" />
              <td width="200">
                <br />   '.$module_lang['comment'].': '.$picture['comment'].'
                <br />   '.$module_lang['author'].": ".$picture['autor'].' 
                <br />   '.$module_lang['date'].": ".$picture['date'].' 
	';
    if ($picture['cat'] == 'deleted')
    echo'
                <br/>
                <b>'.$module_lang['deleted'].' '.$module_lang[$picture['oldcat']].'<b>
    ';
	if ($picture['autor'] == $user['username'] or $user['account_level'] >= 3 )
	echo'
                <br/>
				<form method="post" action="index.php?module='. MODULE_NAME .'&sub=edit&pic='.$picture['id'].'" enctype="multipart/form-data">
				  <input type="submit" value="'.$module_lang['edit'].'" name="edit">
				</form>
	';
	if ($picture['autor'] == $user['username'] or $user['account_level'] >= 3 )
	  if ($picture['cat'] != 'deleted' )
        echo'
                <form method="post" action="index.php?module='. MODULE_NAME .'&sub=delete&pic='.$picture['id'].'" enctype="multipart/form-data">
                  <input type="submit" value="'.$module_lang['delete'].'" name="deletpic">
                </form>
        ';
	echo'
              </td>
            </tr>
            <tr>
              <td><img src="modules/'. MODULE_NAME .'/templates/'.$moduletheme.'/frame/lb.png" class="png" style="width: 12px; height: 12px;" border="0" height="12" width="12"></td>
              <td background="modules/'. MODULE_NAME .'/templates/'.$moduletheme.'/frame/_b.gif"><img src="modules/'. MODULE_NAME .'/templates/'.$moduletheme.'/frame/_.gif" height="1" width="9"></td>
              <td><img src="modules/'. MODULE_NAME .'/templates/'.$moduletheme.'/frame/rb.png" class="png" style="width: 12px; height: 12px;" border="0" height="12" width="12"></td>
            </tr>';
  }

  unset($pictures);

  echo '</tr></tbody></table>';
  echo '<table><tbody><tr>';
  if ((int)$page >> 1)
  {
    $prevpg = $page-1;
    if (isset ($_GET['gal']))
      echo '<td><a href="?module='. MODULE_NAME .'&sub=gallery&gal='. $_GET['gal'] .'&page='. $prevpg .'"><img src="modules/'. MODULE_NAME .'/templates/'.$moduletheme.'/arrow-left.gif">'. $module_lang['back'] .'</a></td>';
    else
      echo '<td><a href="?module='. MODULE_NAME .'&sub=gallery&page='. $prevpg .'"><img src="modules/'. MODULE_NAME .'/templates/'.$moduletheme.'/arrow-left.gif">'. $module_lang['back'] .'</a></td>';
  }
  else
    echo '<td><img src="modules/'. MODULE_NAME .'/templates/'.$moduletheme.'/arrow-left-grey.gif">'. $module_lang['back'] .'</td>';

  echo '<td width="200">
          <center><b> Page : '.$page.' </b></center>
        </td>';
  $lastpicsshown = (int)($picture['id']);
  if ($lastpicsshown != $lastpicid)
  {
    $nextpg = $page+1;
    if (isset ($_GET['gal']))
      echo '<td><a href="?module='. MODULE_NAME .'&sub=gallery&gal='. $_GET['gal'] .'&page='. $nextpg .'">'. $module_lang['next'] .'<img src="modules/'. MODULE_NAME .'/templates/'.$moduletheme.'/arrow-right.gif"></a></td>';
    else
      echo '<td><a href="?module='. MODULE_NAME .'&sub=gallery&page='. $nextpg .'">'. $module_lang['next'] .'<img src="modules/'. MODULE_NAME .'/templates/'.$moduletheme.'/arrow-right.gif"></a></td>';
  }
  else
    echo '<td>'. $module_lang['next'] .'<img src="modules/'. MODULE_NAME .'/templates/'.$moduletheme.'/arrow-right-grey.gif"></td>';

  echo '</tr></tbody></table></center>';  
  unset($picture);
}
else
{
  echo '<center>'.$module_lang['noimages'].'<br/>
        <a href=?module='. MODULE_NAME .'&sub=add_image">'.$module_lang['befirst'].'</a></center>
       ';
}
/*
echo ' <center><br /><br /><a href="?module='. MODULE_NAME .'"><br />'.add_pictureletter('G').'';
echo '<br />o back to the gallery start page</a></center>';
*/
?>
