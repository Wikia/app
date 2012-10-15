<?php
if ( !defined( 'MEDIAWIKI' ) ) {
	exit( 1 );
}
?>
<!-- s:<?php echo __FILE__ ?> -->
<!-- JavaScript part -->
<script type="text/javascript">
/*<![CDATA[*/
jQuery( '#createpage_upload_file_section<?php echo $imagenum ?>' ).change( function( e ) {
	CreateAPage.upload( e, { 'num': <?php echo $imagenum ?> } );
});
/*]]>*/
</script>
<div id="createpage_upload_div_section<?php echo $imagenum ?>">
	<div class="createpage_input_file createpage_input_file_no_path">
		<div class="thumb tleft" id="createpage_main_thumb_section<?php echo $imagenum ?>" style="display: none">
			<div class="thumbinner"><img id="createpage_image_thumb_section<?php echo $imagenum ?>" src="" alt="..." /></div>
		</div>
		<label id="createpage_image_label_section<?php echo $imagenum ?>" class="button color1">
			<span id="createpage_image_text_section<?php echo $imagenum ?>"><?php echo wfMsg( 'createpage-insert-image' ) ?></span>
			<span id="createpage_image_cancel_section<?php echo $imagenum ?>" style="display: none"><?php echo wfMsg( 'cancel' ) ?></span>
			<input type="file" name="wpAllUploadFile<?php echo $imagenum ?>" id="createpage_upload_file_section<?php echo $imagenum ?>" tabindex="-1" />
		</label>
		<div id="createpage_upload_progress_section<?php echo $imagenum ?>" class="progress">&nbsp;</div>
	</div>
	<input type="hidden" id="wpAllDestFile<?php echo $imagenum ?>" name="wpAllDestFile<?php echo $imagenum ?>" value="" />
	<input type="hidden" name="wpAllIgnoreWarning<?php echo $imagenum ?>" value="1" />
	<input type="hidden" name="wpAllUploadDescription<?php echo $imagenum ?>" value="<?php echo wfMsg( 'createpage-uploaded-from' ) ?>" />
	<input type="hidden" id="wpAllLastTimestamp<?php echo $imagenum ?>" name="wpAllLastTimestamp<?php echo $imagenum ?>" value="None" />
	<input type="hidden" id="wpAllUploadTarget<?php echo $imagenum ?>" name="wpAllUploadTarget<?php echo $imagenum ?>" value="wpTextboxes<?php echo $target_tag ?>" />
	<input type="hidden" name="wpAllWatchthis<?php echo $imagenum ?>" value="1" />
	<noscript>
		<input type="submit" id="createpage_upload_submit_section<?php echo $imagenum ?>" name="wpImageUpload" value="<?php echo wfMsg( 'createpage-upload' ) ?>" class="upload_submit" />
	</noscript>
</div>
<!-- e:<?php echo __FILE__ ?> -->
