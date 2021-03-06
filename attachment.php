<?php
require_once("include/bittorrent.php");
dbconn();
require_once(get_langfile_path());
loggedinorreturn();
include_once($rootpath . 'classes/class_attachment.php');

$Attach = new ATTACHMENT($CURUSER['id']);
$count_limit = $Attach->get_count_limit();
$count_limit = (int)$count_limit;
$count_left = $Attach->get_count_left();
$size_limit = $Attach->get_size_limit_byte();
$allowed_exts = $Attach->get_allowed_ext();
$css_uri = get_css_uri();
$altsize = $_POST['altsize'];
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script type="text/javascript">if ( window.self === window.top ) {
    location.href = '/index.php';
}
</script>
<?php echo get_load_uri('css'); ?>
</head>
<body class="inframe">
  <form enctype="multipart/form-data" name="attachment" method="post" action="attachment.php">
<div class="table minor-list"><ul>
<?php
if ($Attach->enable_attachment()) {
  
  if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['files'])) {
    $warnings = [];
    $dlkeys = [];

    $file = $_FILES['files'];
    for ($i=0; $i < count($file['size']); $i += 1) {
		$filesize = $file["size"][$i];
		$filetype = $file["type"][$i];
		$origfilename = $file['name'][$i];
		$tmpname = $file['tmp_name'][$i];
		$ext_l = strrpos($origfilename, ".");
		$ext = strtolower(substr($origfilename, $ext_l+1, strlen($origfilename)-($ext_l+1)));
		$banned_ext = array('exe', 'com', 'bat', 'msi');
		$img_ext = array('jpeg', 'jpg', 'png', 'gif');
		if ($filesize == 0 || $origfilename == "") // nothing received
		{
			$warning = $lang_attachment['text_nothing_received'];
		}
		elseif ($count_left <= 0) //user cannot upload more files
		{
			$warning = $lang_attachment['text_file_number_limit_reached'];
		}
		elseif ($filesize > $size_limit || $filesize >= 5242880) //do not allow file bigger than 5 MB
		{
			$warning = $lang_attachment['text_file_size_too_big'];
		}
		elseif (!in_array($ext, $allowed_exts) || in_array($ext, $banned_ext)) //the file extension is banned
		{
			$warning = $lang_attachment['text_file_extension_not_allowed'];
		}
		else //everythins is okay
		{
			if (in_array($ext, $img_ext))
				$isimage = true;
			else $isimage = false;
			if ($savedirectorytype_attachment == 'onedir')
				$savepath = "";
			elseif ($savedirectorytype_attachment == 'monthdir')
				$savepath = date("Ym")."/";
			elseif ($savedirectorytype_attachment == 'daydir')
				$savepath = date("Ymd")."/";
			$filemd5 = md5_file($tmpname);

			$dlkey = get_single_value('attachments', 'dlkey', 'WHERE hash=UNHEX(?)', [$filemd5]);
			if ($dlkey) {
			  $dlkeys[] = $dlkey;
			  continue;
			}
			
			$filename = date("YmdHis").$filemd5;
			$file_location = make_folder($savedirectory_attachment."/", $savepath)  . $filename;
			$db_file_location = $savepath.$filename;
			$abandonorig = false;
			$hasthumb = false;
			$width = 0;
			if ($isimage) //the uploaded file is a image
			{
				$maycreatethumb = false;
				$stop = false;
				$imagesize = getimagesize($tmpname);
			if ($imagesize){
				$height = $imagesize[1];
				$width = $imagesize[0];
				$it = $imagesize[2];
				if ($it != 1 || !$Attach->is_gif_ani($tmpname)){ //if it is an animation GIF, stop creating thumbnail and adding watermark
				if ($thumbnailtype_attachment != 'no') //create thumbnail for big image
				{
					//determine the size of thumbnail
					if ($altsize == 'yes'){
					  if (isset($_REQUEST['altsize-num'])) {
					    $targetwidth = 0 + $_REQUEST['altsize-num'];
					    if ($targetwidth < 120) {
					      $targetwidth = 120;
					    }
					    else if ($targetwidth > $thumbwidth_attachment) {
					      $targetwidth = $thumbwidth_attachment;
					    }
					    $targetheight = 800;
					  }
					  else {
					    $targetwidth = $altthumbwidth_attachment;
					    $targetheight = $altthumbheight_attachment;
					  }
					}
					else
					{
						$targetwidth = $thumbwidth_attachment;
						$targetheight = $thumbheight_attachment;
					}
					$hscale=$height/$targetheight;
					$wscale=$width/$targetwidth;
					$scale=max(1, $hscale, $wscale);

					$newwidth=floor($width/$scale);
					$newheight=floor($height/$scale);

					if ($scale != 1){ //thumbnail is needed
						if ($it==1)
							$orig=@imagecreatefromgif($tmpname);
						elseif ($it == 2)
							$orig=@imagecreatefromjpeg($tmpname);
						else
							$orig=@imagecreatefrompng($tmpname);
						if ($orig && !$stop)
						{
							$thumb = imagecreatetruecolor($newwidth, $newheight);
							imagecopyresampled($thumb, $orig, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
							if ($thumbnailtype_attachment == 'createthumb'){
								$hasthumb = true;
								imagejpeg($thumb, $file_location.".".$ext.".thumb.jpg", $thumbquality_attachment);
							}
							elseif ($thumbnailtype_attachment == 'resizebigimg'){
								$ext = "jpg";
								$filetype = "image/jpeg";
								$it = 2;
								$height = $newheight;
								$width = $newwidth;
								$maycreatethumb = true;
								$abandonorig = true;
							}
						}
					}
				}
				$watermarkpos = $watermarkpos_attachment;
				if ($watermarkpos != 'no' && !$stop) //add watermark to image
				{
					if ($width > $watermarkwidth_attachment && $height > $watermarkheight_attachment)
					{
						if ($abandonorig)
						{
							$resource = $thumb;
						}
						else
						{
							$resource=imagecreatetruecolor($width,$height);
							if ($it==1)
								$resource_p=@imagecreatefromgif($tmpname);
							elseif ($it==2)
								$resource_p=@imagecreatefromjpeg($tmpname);
							else
								$resource_p=@imagecreatefrompng($tmpname);
							imagecopy($resource, $resource_p, 0, 0, 0, 0, $width, $height);
						}
						$watermark = imagecreatefrompng('pic/watermark.png');
						$watermark_width = imagesx($watermark);
						$watermark_height = imagesy($watermark);
						//the position of the watermark
						if ($watermarkpos == 'random')
							$watermarkpos = mt_rand(1, 9);
						switch ($watermarkpos)
						{
							case 1: {
								$wmx = 5;
								$wmy = 5;
								break;
								}
							case 2: {
								$wmx = ($width-$watermark_width)/2;
								$wmy = 5;
								break;
								}
							case 3: {
								$wmx = $width-$watermark_width-5;
								$wmy = 5;
								break;
								}
							case 4: {
								$wmx = 5;
								$wmy = ($height-$watermark_height)/2;
								break;
								}
							case 5: {
								$wmx = ($width-$watermark_width)/2;
								$wmy = ($height-$watermark_height)/2;
								break;
								}
							case 6: {
								$wmx = $width-$watermark_width-5;
								$wmy = ($height-$watermark_height)/2;
								break;
								}
							case 7: {
								$wmx = 5;
								$wmy = $height-$watermark_height-5;
								break;
								}
							case 8: {
								$wmx = ($width-$watermark_width)/2;
								$wmy = $height-$watermark_height-5;
								break;
								}
							case 9: {
								$wmx = $width-$watermark_width-5;
								$wmy = $height-$watermark_height-5;
								break;
								}
						}

						imagecopy($resource, $watermark, $wmx, $wmy, 0, 0, $watermark_width, $watermark_height);
						if ($it==1)
							imagegif($resource, $file_location.".".$ext);
						elseif ($it==2)
							imagejpeg($resource, $file_location.".".$ext, $watermarkquality_attachment);
						else
							imagepng($resource, $file_location.".".$ext);
						$filesize = filesize($file_location.".".$ext);
						$maycreatethumb = false;
						$abandonorig = true;
					}
				}
				if ($maycreatethumb){ // if no watermark is added, create the thumbnail now for the above resized image.
					imagejpeg($thumb, $file_location.".".$ext, $thumbquality_attachment);
					$filesize = filesize($file_location.".".$ext);
				}
				}
			}
			else $warning = $lang_attachment['text_invalid_image_file'];
			}
			if (!$abandonorig){
				if(!move_uploaded_file($tmpname, $file_location.".".$ext))
					$warning = $lang_attachment['text_cannot_move_file'];
			}
			if (isset($warning)) {
			  $warnings[] = $warning;
			  unset($warning);
			}
			else {//insert into database and add code to editor
				$dlkey = md5($db_file_location.".".$ext);
				sql_query("INSERT INTO attachments (userid, width, added, filename, filetype, filesize, location, dlkey, isimage, thumb, hash) VALUES (".$CURUSER['id'].", ".$width.", ".sqlesc(date("Y-m-d H:i:s")).", ".sqlesc($origfilename).", ".sqlesc($filetype).", ".$filesize.", ".sqlesc($db_file_location.".".$ext).", ".sqlesc($dlkey).", ".($isimage ? 1 : 0).", ".($hasthumb ? 1 : 0).", UNHEX(?))", [$filemd5]);
				$count_left--;
				$dlkeys[] = $dlkey;
			}
		}
	}

	    if (!empty($dlkeys)) {
	      echo "<script type=\"text/javascript\">parent.tag_extimage('".
		implode('\n', array_map(function($dlkey) {
		      return "[attach]" . $dlkey . "[/attach]";
		    }, $dlkeys)) . "');</script>";
	    }
  }



	print("<li><input type=\"file\" name=\"files[]\" multiple=\"multiple\" required=\"required\" style=\"width:150px;\"".($count_left ? "" : " disabled=\"disabled\"")." /></li>");
	print('<li><input type="checkbox" name="altsize" value="yes" id="altsize"'.($altsize == 'yes' ? ' checked="checked"' : "").' /><label for="altsize">'.$lang_attachment['text_small_thumbnail']."</label></li>");
	print('<li><input type="submit" name="submit" value="'.$lang_attachment['submit_upload'].'"'.($count_left ? "" : ' disabled="disabled"').' /></li>');
  
  if (!empty($warnings)) {
    echo implode('', array_map(function($warning) {
	return ('<li><span class="striking">'.$warning.'</span></li>');
	}, $warnings));
  }
  else {
    print("<li>".$lang_attachment['text_left'].'<span class="striking">'.$count_left."</span>".$lang_attachment['text_of'].$count_limit.'</li><li>'.$lang_attachment['text_size_limit'] . mksize($size_limit)."</li><li>".$lang_attachment['text_file_extensions']);
    $allowedextsblock = implode(', ', $allowed_exts);
    if (!$allowedextsblock) {
      $allowedextsblock = 'N/A';
    }
    print('<a onclick="parent.allowedtypes(event, this)" onmouseout="parent.allowedtypes(event, this)" onmouseover="parent.allowedtypes(event, this)" title="'.htmlspecialchars($allowedextsblock).'" href="#">'.$lang_attachment['text_mouse_over_here'].'</a></li>');
  }
}
?>
</ul></div>
</form>
<script type="text/javascript">
(function($) {
    var altsize = $('#altsize', document),
    altsize_num = $('<li><label>缩略图宽度<input name="altsize-num" type="number" value="<?=$altthumbwidth_attachment ?>" min="120" max="800" step="10" style="height:90%" />px</label></li>').hide();
    altsize.parent().after(altsize_num);
    altsize.click(function() {
	altsize_num.toggle(this.checked);
    }).triggerHandler('click');
})(window.top.$);
</script>
</body>
</html>
