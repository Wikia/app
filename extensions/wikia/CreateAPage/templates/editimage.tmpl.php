<!-- s:<?= __FILE__ ?> -->
<!-- js part -->
<script type="text/javascript">
/*<![CDATA[*/
YE.addListener( "createpage_upload_file<?= $image_num ?>", "change", YWCI.Upload, {"num" : <?= $image_num ?> } );
/*]]>*/
</script>
	<div class="createpage_input_file createpage_input_file_no_path">
		<div class="thumb tleft" id="createpage_main_thumb<?= $image_num ?>" style="display: none"><div class="thumbinner"><img id="createpage_image_thumb<?= $image_num ?>" src=""  alt="..." /></div></div>
		<label id="createpage_image_label<?= $image_num ?>" class="button color1">
			<span id="createpage_image_text<?= $image_num ?>"><?= wfMsg ('createpage_insert_image') ?></span>
			<span id="createpage_image_cancel<?= $image_num ?>" style="display: none"><?= wfMsg ('cancel') ?></span>
		        <input type="file" name="wpUploadFile<?= $image_num ?>" id="createpage_upload_file<?= $image_num ?>" tabindex="-1" />
		</label>
		<div id="createpage_upload_progress<?= $image_num ?>" class="progress">&nbsp;</div>
	</div>
	        <input type="hidden" id="wpDestFile<?= $image_num ?>" name="wpDestFile<?= $image_num ?>" value="" />
	        <input type="hidden" name="wpIgnoreWarning<?= $image_num ?>" value="1" />
	        <input type="hidden" name="wpUploadDescription<?= $image_num ?>" value="<?= wfMsg ('createpage_uploaded_from') ?>" />
	        <input type="hidden" name="wpWatchthis<?= $image_num ?>" value="1" />
		<input type="hidden" id="wpLastTimestamp<?= $image_num ?>" name="wpLastTimestamp<?= $image_num ?>" value="None" />
		<input type="hidden" id="wpInfImg<?= $image_num ?>" name="wpInfImg<?= $image_num ?>" value="<?= $image_helper ?>" />
		<input type="hidden" id="wpParName<?= $image_num ?>" name="wpParName<?= $image_num ?>" value="<?= $image_name ?>" />
		<input type="hidden" id="wpNoUse<?= $image_num ?>" name="wpNoUse<?= $image_num ?>" value="No" />
		<noscript>
	            <input type="submit" id="createpage_upload_submit<?= $image_num ?>" name="wpImageUpload" value="<?= $me_upload ?>" class="upload_submit" />
		</noscript>
	</div>
<!-- e:<?= __FILE__ ?> -->
