<!-- s:<?= __FILE__ ?> -->
<fieldset id="cp-infobox-fieldset">
<legend><?=$infobox_legend?> <span style="font-size: small; font-weight: normal; margin-left: 5px">[<a id="cp-infobox-toggle" title="toggle" href="#"><?= wfMsg('me_hide') ?></a>]</span></legend>
<div id="cp-infobox" style="display: block;">
<input type="hidden" id="wpInfoboxValue" name="wpInfoboxValue" value="<?= htmlspecialchars ($infoboxes) ?>" />
<?
$inf_par_num = 0 ;
$inf_image_num = 0 ;
#---
foreach ($inf_pars as $inf_par) {
	$inf_par = preg_replace ("/=/", "<!---equals--->", $inf_par, 1) ;
	$inf_par_pair = preg_split ("/<\!---equals--->/", $inf_par, -1) ;	
	if (is_array ($inf_par_pair)) {
		if (preg_match(IMAGEUPLOAD_TAG_SPECIFIC, $inf_par_pair[1], $match)) {
			$oTmplImg = new EasyTemplate( dirname( __FILE__ ));
			$oTmplImg->set_vars(
					array(
						'me_upload' => wfMsg('me_upload') ,
						'image_num' => $inf_image_num ,
						'image_helper' => $inf_par ,
						'image_name' => $inf_par_pair[0]
					     )
					);
			$editimage = $oTmplImg->execute("editimage") ;
			$inf_image_num++ ;
?>
<div id="createpage_upload_div<?= $inf_image_num ?>">
<label for="wpUploadFile" class="normal-label"><?= $inf_par_pair[0] ?></label><?=$editimage?>
<?
		} elseif (preg_match(INFOBOX_SEPARATOR, $inf_par_pair[1], $math)) {   	 	 
			# Replace each template parameter with <!---separator---> as value with:  	 	 
			echo '<div class="createpage-separator">&nbsp;</div>'; 
		} else {
?>			
<label for="wpInfoboxPar<?=$inf_par_num?>" class="normal-label"><?=$inf_par_pair[0]?></label><input type="text" id="wpInfoboxPar<?=$inf_par_num?>" name="wpInfoboxPar<?=$inf_par_num?>" value="<?= htmlspecialchars (trim($inf_par_pair[1])) ?>" class="normal-input" /><br/>

<script type="text/javascript">
/*<![CDATA[*/
YE.onContentReady('<?= "wpInfoboxPar" . $inf_par_num ?>', YWC.ClearInput, {num: <?= $inf_par_num ?>});
/*]]>*/
</script>
<?
		}
		$inf_par_num++ ;
	}
}
?>
</div>
</fieldset>
<!-- e:<?= __FILE__ ?> -->

