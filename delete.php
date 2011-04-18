<?php
//========================//
if(INCLUDED !== TRUE) 
{
	echo "No Direct File Linking Allowed!"; 
	exit;
}
// ==================== //

if (!isset ($_GET['pic']))
{
  echo '
    <center>
	  '.$module_lang['nopictoedit'].'<br/>
      <a href="?module='. MODULE_NAME .'">'.$module_lang[$galleries].' </a>
    </center>
  ';
  exit;
}

$picture = $DB->selectRow("SELECT * FROM mw_gallery WHERE `id`='".$_GET['pic']."'");

if ($user['username'] == $picture['autor'] or $user['account_level'] >= 3 )
{
  echo '
    <form method="post" action="?module='. MODULE_NAME .'" enctype="multipart/form-data">
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
            <td>
              <a href="images/'. $picture['cat'] .'s/'. $picture['img'] .'" target="_blank"><img src="modules/'. MODULE_NAME .'/show_picture.php?filename='. $picture['img'] .'&amp;gallery='. $picture['cat'] .'&amp;width=282" width="282" alt="" style="border: 1px solid #333333"/>
            </td>
            <td background="modules/'. MODULE_NAME .'/templates/'.$moduletheme.'/frame/_r.gif"><img src="modules/'. MODULE_NAME .'/templates/'.$moduletheme.'/frame/_.gif" height="0" width="0"></td>
            <td width="25" />
            <td width="200">
              <br />   '.$module_lang['comment'].': '.$picture['comment'].'
              <br />   '.$module_lang['author'].": ".$picture['autor'].' 
              <br />   '.$module_lang['date'].": ".$picture['date'].' 
            </td>
          </tr>
          <tr>
            <td><img src="modules/'. MODULE_NAME .'/templates/'.$moduletheme.'/frame/lb.png" class="png" style="width: 12px; height: 12px;" border="0" height="12" width="12"></td>
            <td background="modules/'. MODULE_NAME .'/templates/'.$moduletheme.'/frame/_b.gif"><img src="modules/'. MODULE_NAME .'/templates/'.$moduletheme.'/frame/_.gif" height="1" width="9"></td>
            <td><img src="modules/'. MODULE_NAME .'/templates/'.$moduletheme.'/frame/rb.png" class="png" style="width: 12px; height: 12px;" border="0" height="12" width="12"></td>
          </tr>
        </tr>
      </tbody>
    </table>
	<input type="hidden" name="postnewfile" value="POST">
	<input type="hidden" name="oldgal" value="'.$picture['cat'].'">
    <input type="hidden" name="picid" value="'.$_GET['pic'].'">
    <input type="hidden" name="galtype" value="deleted">
    <b>'.$module_lang['deleteconfirm'].'</b>
      <input type="submit" value="'.$module_lang['delete'].'" name="dodelete">
      <input type="submit" value="'.$module_lang['cancel'].'" name="cancel">
      <br/>
    </center>
    </form>
  ';
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
?>