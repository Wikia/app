<?php
if ( !defined( 'MEDIAWIKI' ) ) {
	exit( 1 );
}
?>
<!-- s:<?php echo __FILE__ ?> -->
<!-- JavaScript part -->
<script type="text/javascript">
/*<![CDATA[*/
jQuery( '#createpage_upload_file<?php echo $image_num ?>' ).change( function( e ) {
	CreateAPageInfobox.upload( e, { 'num': <?php echo $image_num ?> } );
});
/*]]>*/
</script>
	<div class="createpage_input_file createpage_input_file_no_path">
		<div class="thumb tleft" id="createpage_main_thumb<?php echo $image_num ?>" style="display: none">
			<div class="thumbinner">
				<img id="createpage_image_thumb<?php echo $image_num ?>" src="" alt="..." />
			</div>
		</div>
		<label id="createpage_image_label<?php echo $image_num ?>" class="button color1">
			<span id="createpage_image_text<?php echo $image_num ?>"><?php echo wfMsg( 'createpage-insert-image' ) ?></span>
			<span id="createpage_image_cancel<?php echo $image_num ?>" style="display: none"><?php echo wfMsg( 'cancel' ) ?></span>
			<input type="file" name="wpUploadFile<?php echo $image_num ?>" id="createpage_upload_file<?php echo $image_num ?>" tabindex="-1" />
		</label>
		<div id="createpage_upload_progress<?php echo $image_num ?>" class="progress">&nbsp;</div>
	</div>
		<input type="hidden" id="wpDestFile<?php echo $image_num ?>" name="wpDestFile<?php echo $image_num ?>" value="" />
		<input type="hidden" name="wpIgnoreWarning<?php echo $image_num ?>" value="1" />
		<input type="hidden" name="wpUploadDescription<?php echo $image_num ?>" value="<?php echo wfMsg( 'createpage-uploaded-from' ) ?>" />
		<input type="hidden" name="wpWatchthis<?php echo $image_num ?>" value="1" />
		<input type="hidden" id="wpLastTimestamp<?php echo $image_num ?>" name="wpLastTimestamp<?php echo $image_num ?>" value="None" />
		<input type="hidden" id="wpInfImg<?php echo $image_num ?>" name="wpInfImg<?php echo $image_num ?>" value="<?php echo $image_helper ?>" />
		<input type="hidden" id="wpParName<?php echo $image_num ?>" name="wpParName<?php echo $image_num ?>" value="<?php echo $image_name ?>" />
		<input type="hidden" id="wpNoUse<?php echo $image_num ?>" name="wpNoUse<?php echo $image_num ?>" value="No" />
		<noscript>
			<input type="submit" id="createpage_upload_submit<?php echo $image_num ?>" name="wpImageUpload" value="<?php echo wfMsg( 'createpage-upload' ) ?>" class="upload_submit" />
		</noscript>
	</div>
<!-- e:<?php echo __FILE__ ?> -->
