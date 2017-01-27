<div id="premium-design-ab-test-C-rightrail" class="header-column header-tally">
	<? if ( !is_null( $tallyMsg ) ): ?>
		<div class="tally"><?= $tallyMsg ?></div>
		<?= F::app()->renderView(
			'PageHeader',
			'AddNewPageButton'
		); ?>
	<? endif; ?>
</div>