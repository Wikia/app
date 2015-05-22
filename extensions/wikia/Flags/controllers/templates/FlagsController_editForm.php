<form action="<?= $formSubmitUrl ?>" method="POST" id="flagsEditForm">
	<ul class="flags">
		<?php foreach ( $flags as $flag_type_id => $flag ): ?>
		<li>
			<input type="checkbox" name="<?= $inputNamePrefix . ':' . $flag_type_id . ':' . $inputNameCheckbox ?>" <?php if ( $flag['flag_id'] ){ echo 'checked="checked"'; }?>/>
			<label><?= $flag['flag_name'] ?></label>
			<a href="<?= $flag['flag_view_url'] ?>" target="_blank">More info</a>
			<?php
			$flagParamsNames = json_decode($flag['flag_params_names']);
			foreach ( $flagParamsNames as $flagParamName ):
			?>
				<input type="text" name="<?= $inputNamePrefix . ':' . $flag_type_id . ':' . $flagParamName ?>" value="<?= isset( $flag['params'][$flagParamName] ) ? $flag['params'][$flagParamName] : '' ?>" placeholder="<?= $flagParamName ?>" class="param" />
			<?php endforeach; ?>
		</li>
		<?php endforeach; ?>
	</ul>
	<input type="hidden" name="pageId" value="<?= $pageId ?>"/>
	<input type="hidden" name="token" value="<?= $editToken ?>"/>
</form>
