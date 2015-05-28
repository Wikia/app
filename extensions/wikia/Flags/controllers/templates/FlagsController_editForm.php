<?php
if ( empty($flags) ) :
	echo wfMessage( 'flags-edit-modal-no-flags-on-community' )->parseAsBlock();
else:
 ?>
<form action="<?= Sanitizer::cleanUrl( $formSubmitUrl ) ?>" method="POST" id="flagsEditForm">
	<ul>
		<?php foreach ( $flags as $flagTypeId => $flag ): ?>
		<?php $prefix = "{$inputNamePrefix}:{$flagTypeId}" ?>
		<li>
			<?php isset( $flag['flag_id'] ) ? $checked = 'checked' : $checked = '';	?>
			<input type="checkbox" id="<?= Sanitizer::encodeAttribute( $prefix ) ?>" name="<?= Sanitizer::encodeAttribute( "{$prefix}:{$inputNameCheckbox}" ) ?>" <?= $checked ?>>
			<label for="<?= Sanitizer::encodeAttribute( $prefix ) ?>"><?= $flag['flag_name'] ?></label>
			<a href="<?= Sanitizer::cleanUrl( $flag['flag_view_url'] ) ?>" target="_blank"><?= wfMessage( 'flags-edit-form-more-info' )->escaped() ?></a>
			<?php
			$flagParamsNames = json_decode( $flag['flag_params_names'] );
			if ( !empty( $flagParamsNames ) ):
			?>
				<fieldset class="params">
				<?php
				foreach ( $flagParamsNames as $flagParamName => $flagParamDescription ):
					$flagParamValue = isset( $flag['params'][$flagParamName] ) ? (string)$flag['params'][$flagParamName] : '';
				?>
					<input type="text" name="<?= Sanitizer::encodeAttribute( "{$prefix}:{$flagParamName}" ) ?>" value="<?= Sanitizer::encodeAttribute( $flagParamValue ) ?>" placeholder="<?= Sanitizer::encodeAttribute( $flagParamDescription ) ?>" class="param">
				<?php
				endforeach;
				?>
				</fieldset>
			<?php 
			endif;
			?>
		</li>
		<?php endforeach; ?>
	</ul>
	<input type="hidden" name="page_id" value="<?= Sanitizer::encodeAttribute( $pageId ) ?>">
	<input type="hidden" name="edit_token" value="<?= Sanitizer::encodeAttribute( $editToken ) ?>">
</form>
<?php
endif;
?>
