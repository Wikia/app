<?php if ( !empty( $approveCheckbox ) ): ?>
	<label for="wpApprove" class="approve-changes-label">
		<input id='wpApprove' name='wpApprove' type='checkbox' value='1'/>
		<?= wfMessage( 'content-review-edit-page-checkbox-label' )->escaped() ?>
	</label>
<?php endif ?>
<div class="wds-dropdown codepage-publish-button">
	<span class="wds-button wds-dropdown__toggle" role="button">
		<span id="wpSave" onclick="document.getElementById('editform').submit();"><?= wfMessage( 'savearticle' )->escaped(); ?></span>
		<?= DesignSystemHelper::renderSvg( 'wds-icons-dropdown-tiny',
			'wds-icon wds-icon-tiny wds-dropdown__toggle-chevron'
		); ?>
	</span>
	<div class="wds-dropdown__content">
		<ul class="wds-list">
			<li><a id="wpDiff" accesskey="<?= wfMessage( 'accesskey-diff' )->escaped(); ?>" href="#"><?= wfMessage( 'showdiff' )->escaped(); ?></a></li>
		</ul>
	</div>
</div>
<noscript>
	<input id="wpSave" type="submit" value="<?= wfMessage( 'savearticle' )->escaped(); ?>" />
</noscript>
