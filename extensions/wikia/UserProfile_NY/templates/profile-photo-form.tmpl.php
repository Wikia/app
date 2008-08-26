<!-- s:<?= __FILE__ ?> -->
<!-- css part -->
<style type="text/css">
/*<![CDATA[*/
.clearfix {
	overflow:auto;
}

h1 {
	font-weight:normal;
	line-height:1.2em;
	font-size:26px;
	margin:0px 0px 10px 0px;
}

h2 {
	font-size:20px;
	margin:0px 0px 10px 0px;
}

h3 {
	margin:0 0 5px 0;
	padding:0;
}

body {
	font-family:arial;
	margin:0;
}

.photo-upload-container {
	width:60%;
	background-color:#EFF3F0;
	border:1px solid #D4DFD7;
	padding:10px;
}

.photo-upload-image {
	float:left;
	width:30%;
}

.photo-upload-image img {
	border:1px solid #dcdcdc;
	width:70%;
}

.photo-upload-form {
	float:left;
	font-size:12px;
	width:50%;
}

.photo-upload-form  p {
	margin:0 0 10px 0;
	padding:0;
}

.photo-upload-small {
	color:#666;
	font-size:10px;
}

.photo-upload-message {
	font-size:14px;
	margin:0 0 12px 0;
}

.photo-upload-error {
	color:red;
	font-weight:bold;
	font-size:12px;
	margin:0 0 10px 0;
}

/*]]>*/
</style>
<!-- js part -->
<?php
global $wgUser;
$p = new ProfilePhoto( $wgUser->getID() );
?>
<h1>Profile Picture</h1>
<div class="photo-upload-message"><?= wfMsg("profilephoto_intro")?></div>
<div class="photo-upload-container clearfix">
	<div class="photo-upload-image">
	    <h3><?= wfMsg("profilephoto_current") ?></h3>
		<?= $p->getPhotoImageTag("p") ?>
	</div>
	<div class="photo-upload-form">
		<?php
		if ($is_posted) {
		    switch($status) {
		        case UPLOAD_ERR_OK:
		            	echo "<div class=\"photo-upload-error\">" . wfMsg("profilephoto_error_success") . "</div>";
		            break;
		        case UPLOAD_ERR_NO_FILE:
		            	echo "<div class=\"photo-upload-error\">" . wfMsg("profilephoto_error_toobig")  . "</div>";
		            break;
		        case UPLOAD_ERR_EXTENSION:
		            	echo "<div class=\"photo-upload-error\">" . wfMsg("profilephoto_error_badext")  . "</div>";
		            break;
		        case UPLOAD_ERR_CANT_WRITE:
		            	echo "<div class=\"photo-upload-error\">" . wfMsg("profilephoto_error_readonly") . "</div>";
		            break;
		        case WMSG_REMOVE_ERROR:
		            	echo "<div class=\"photo-upload-error\">" . wfMsg("profilephoto_cannotremoveforyou") . "</div>";
		        break;
			case WMSG_REMOVE_SUCCESS:
		            	echo "<div class=\"photo-upload-error\">" . wfMsg("profilephoto_remove_sucess") . "</div>";
		        break;
		    }
		}
		?>
		<h2>Upload Photo</h2>
		<p><?= wfMsg("profilephoto_uploadinfo") ?></p>
		<form id="wa-upload-form" enctype="multipart/form-data" action="" method="post">
	        <input type="hidden" name="action" value="upload" />
	        <input type="file" id="wa-upload-file" name="wpUpload" size="20" /><p>
	        <input type="submit" id="wa-upload-submit" name="wpSubmit" value="<?=wfMsg("profilephoto_upload")?>" /> 
	    </form>
	    	<form id="wa-upload-form" enctype="multipart/form-data" action="" method="post">
		<input type="hidden" name="action" value="remove" />
		<p class="photo-upload-small"><?=wfMsg("profilephoto_filesize")?></p>
		<h2><?=wfMsg("profilephoto_remove")?></h2>
		<p><?=wfMsg("profilephoto_remove_message")?></p>
		<input type="submit" value="<?=wfMsg("profilephoto_remove")?>"/>
		 </form>
	</div>
</div>
<!-- e:<?= __FILE__ ?> -->
