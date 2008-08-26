<!-- s:<?= __FILE__ ?> -->
<!-- js part -->
<script type="text/javascript">
/*<![CDATA[*/
YE.addListener( "createpage_upload_file_section<?= $imagenum ?>", "change", YWC.Upload, {"num" : <?= $imagenum ?> } );
/*]]>*/
</script>
<div id="createpage_upload_div_section<?= $imagenum ?>">
        <div class="createpage_input_file createpage_input_file_no_path">
		<div class="thumb tleft" id="createpage_main_thumb_section<?= $imagenum ?>" style="display: none"><div class="thumbinner"><img id="createpage_image_thumb_section<?= $imagenum ?>" src="" alt="..." /></div></div>
                <label id="createpage_image_label_section<?= $imagenum ?>" class="button color1">
                        <span id="createpage_image_text_section<?= $imagenum ?>"><?= wfMsg ('createpage_insert_image') ?></span>
                        <span id="createpage_image_cancel_section<?= $imagenum ?>" style="display: none"><?= wfMsg ('cancel') ?></span>
                        <input type="file" name="wpAllUploadFile<?= $imagenum ?>" id="createpage_upload_file_section<?= $imagenum ?>" tabindex="-1" />
                </label>
        	<div id="createpage_upload_progress_section<?= $imagenum ?>" class="progress">&nbsp;</div>
        </div>
	<input type="hidden" id="wpAllDestFile<?= $imagenum ?>" name="wpAllDestFile<?= $imagenum ?>" value="" />
        <input type="hidden" name="wpAllIgnoreWarning<?= $imagenum ?>" value="1" />
        <input type="hidden" name="wpAllUploadDescription<?= $imagenum ?>" value="<?= wfMsg ('createpage_uploaded_from') ?>" />
	<input type="hidden" id="wpAllLastTimestamp<?= $imagenum ?>" name="wpAllLastTimestamp<?= $imagenum ?>" value="None" />
	<input type="hidden" id="wpAllUploadTarget<?= $imagenum ?>" name="wpAllUploadTarget<?= $imagenum ?>" value="wpTextboxes<?= $target_tag ?>" />
        <input type="hidden" name="wpAllWatchthis<?= $imagenum ?>" value="1" />
        <noscript>
            <input type="submit" id="createpage_upload_submit_section<?= $imagenum ?>" name="wpImageUpload" value="<?= $me_upload ?>" class="upload_submit" />
        </noscript>
</div>
<!-- e:<?= __FILE__ ?> -->
