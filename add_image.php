<?php
//========================//
if(INCLUDED !== TRUE) 
{
	echo "No Direct File Linking Allowed!"; 
	exit;
}
// ==================== //
/*
echo "<center>It Works! Loaded the page!</center>";
echo ' <center><a href="?module='. MODULE_NAME .'"><br />Click here to return</a></center> ';
if(isset($page))
{
  echo ' <center>You are on page '. $page .'</center> ';
}
*/
if ($user['username'] == 'Guest')
{
  echo '<b>'.$module_lang['mustlogin'].'</b>';
  exit;
}

if (isset($_POST['doadd']))
{
  if (isset ($_POST['galtype']))
  {
    $galtype=$_POST['galtype'];
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
  if($_FILES["filename"]["size"] > (1024*$Module_Config['maxfilesize']*1024) ) 
  {
    echo $module_lang['filesize'];
    echo " ";
    echo $Module_Config['maxfilesize'];
    echo 'Mb';
    exit; 
  }
  if(!in_array($_FILES["filename"]["type"], array("image/jpeg", "image/pjpeg", "image/jpg"))) 
  {
    echo $module_lang['nonfiletype'];
    echo ("<br/>");
    exit;
  }
  if($DB->selectCell("SELECT count(*) FROM `mw_gallery` WHERE img='".$img."' AND cat='".$galtype."'"))
  {
    echo $module_lang['ErrorFilename'];
    exit;
  }
  if(copy($_FILES["filename"]["tmp_name"],"../".$Module_Config['mangwebdir']."/images/".$galtype."s/".$_FILES["filename"]["name"].""))
  {
    $DB->query("INSERT INTO mw_gallery (img,comment,autor,date,cat) VALUES('".$img."','".$comment."','".$autor."',current_date,'".$galtype."')");
  }
  else
  {
    echo /*$lang['Uploaderror']*/'uploaderror';  
  }
}


echo '
  <form method="post" action="index.php?module=Photo_Gallery&sub=add_image" enctype="multipart/form-data">
  <select name="galtype">
  <option value="">'.$module_lang['galtype'].' -&gt;</option>
';
foreach($Gal_list as $listings)
{
echo"
  <option value=".$listings.">".$module_lang[$listings]."</option>";
}
echo'
  </select>
  <br/>
  '.$module_lang['author'].': <b>'.$user['username'].'</b><br/>
  '.$module_lang['comment'].':<br/>
  <textarea name="message" cols="5" rows="5" id="textarea" style="width: 40%; height: 70px;"></textarea><br/>
  '.$module_lang['file'].':<br/>
  <input type="hidden" name="postnewfile" value="POST">
  <input type="file" name="filename"><br/> 
  <font color="red"><b>'.$module_lang['filesize'].': '.$Module_Config['maxfilesize'].' Mb</b></font>
  <center>
    <input type="submit" value="'.$module_lang['upload'].'" name="doadd">
    <input type="submit" value="'.$module_lang['cancel'].'" name="cancel">
    <br/>
  </center>
';
echo '
<form>
';
?>