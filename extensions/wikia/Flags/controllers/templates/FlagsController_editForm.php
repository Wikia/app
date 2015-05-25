<form action="<?= Sanitizer::cleanUrl( $formSubmitUrl ) ?>" method="POST" id="flagsEditForm">
	<ul class="flags">
		<?php foreach ( $flags as $flagTypeId => $flag ): ?>
		<?php $prefix = "{$inputNamePrefix}:{$flagTypeId}" ?>
		<li>
			<?php isset( $flag['flag_id'] ) ? $checked = 'checked' : $checked = '';	?>
			<input type="checkbox" name="<?= Sanitizer::encodeAttribute( "{$prefix}:{$inputNameCheckbox}" ) ?>" <?= $checked ?>>
			<label for="<?= Sanitizer::encodeAttribute( "{$prefix}:{$inputNameCheckbox}" ) ?>"><?= $flag['flag_name'] ?></label>
			<a href="<?= Sanitizer::cleanUrl( $flag['flag_view_url'] ) ?>" target="_blank"><?= wfMessage( 'flags-edit-form-more-info' )->escaped() ?></a>
			<?php
				$flagParamsNames = json_decode( $flag['flag_params_names'] );
				foreach ( $flagParamsNames as $flagParamName => $flagParamDescription ):
					$flagParamValue = (string)$flag['params'][$flagParamName];
			?>
			<input type="text" name="<?= Sanitizer::encodeAttribute( "{$prefix}:{$flagParamName}" ) ?>" value="<?= Sanitizer::encodeAttribute( $flagParamValue ) ?>" placeholder="<?= Sanitizer::encodeAttribute( $flagParamDescription ) ?>" class="param">
			<?php
				endforeach;
			?>
		</li>
		<?php endforeach; ?>
	</ul>
	<input type="hidden" name="page_id" value="<?= Sanitizer::encodeAttribute( $pageId ) ?>">
	<input type="hidden" name="edit_token" value="<?= Sanitizer::encodeAttribute( $editToken ) ?>">
</form>
