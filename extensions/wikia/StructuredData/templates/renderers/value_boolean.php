<?php $value = $object->getValue(); ?>
<?php if($context == SD_CONTEXT_EDITING): ?>
	<div class="input-group">
		<select name="<?=$object->getPropertyName();?>">
			<option <?=is_null($value) ? 'selected="selected"' : ''; ?> value="-1"><?= wfMsg('structureddata-object-empty-property') ?></option>
			<option <?=$value  ? 'selected="selected"' : ''; ?> value="1"><?= wfMsg('structureddata-object-prop-boolean-true') ?></option>
			<option <?=!$value ? 'selected="selected"' : ''; ?> value="0"><?= wfMsg('structureddata-object-prop-boolean-false')
				?></option>
		</select>
	</div>
<?php else: ?>
<?php if(is_null($value)): ?>
		<p class="empty"><?= wfMsg('structureddata-object-empty-property') ?></p>
	<?php else: ?>
		<?=($value) ? wfMsg('structureddata-object-prop-boolean-true') : wfMsg('structureddata-object-prop-boolean-false');?>
	<?php endif; ?>
<?php endif; ?>