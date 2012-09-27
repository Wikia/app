<?php if( empty($wgSuppressWikiaBar) ): ?>
	<?= F::app()->renderView('Notifications', 'Index'); ?>
	<div id="WikiaBarWrapper" class="WikiaBarWrapper hidden">
		<div class="wikia-bar<?if($wg->User->isAnon()):?> wikia-bar-anon<?endif;?>">
			<a href="#" class="arrow" data-tooltip="<?= wfMsg('wikiabar-tooltip') ?>" data-tooltipshow="<?= wfMsg('wikiabar-tooltip-show') ?>"></a>
			<?php
			if ($wg->User->isAnon()) {
				echo F::app()->renderView('WikiaBar', 'Anon',
					array(
						'lang' => $lang,
						'vertical' => $vertical
					));
			} else {
				echo F::app()->renderView('WikiaBar', 'User', F::app()->wg->Request->getValues());
			}
			?>
		</div>
	</div>
</div>
<div class="WikiaBarCollapseWrapper">
    <a href="#" class="wikia-bar-collapse" data-tooltip="<?= wfMsg('wikiabar-tooltip') ?>"></a>
</div>
<?php endif; ?>
