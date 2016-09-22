<?php if ( empty( $wgSuppressWikiaBar ) ): ?>
	<div id="WikiaBar">
		<?= $app->renderView( 'Notifications', 'Index' ); ?>
		<div id="WikiaBarWrapper" class="WikiaBarWrapper hidden">
			<? if ( !empty( $wg->WikiaSeasonsWikiaBar ) && $wg->User->isAnon() ): ?>
			<div class="wikia-bar-seasons">
				<? endif; ?>
				<div class="wikia-bar<? if ( $wg->User->isAnon() ): ?> wikia-bar-anon<? endif; ?>">
					<a href="#" class="arrow" data-tooltip="<?= wfMessage( 'wikiabar-tooltip' )->escaped(); ?>"
					   data-tooltipshow="<?= wfMessage( 'wikiabar-tooltip-show' )->escaped(); ?>"></a>
					<?php if ( $wg->User->isAnon() ): ?>
						<?= $app->renderView( 'WikiaBar', 'Anon',
								[
									'lang' => $lang,
									'vertical' => $vertical,
								] ); ?>
					<?php else: ?>
						<?= $app->renderView( 'WikiaBar', 'User', $wg->Request->getValues() ); ?>
					<?php endif; ?>
				</div>
				<? if ( !empty( $wg->WikiaSeasonsWikiaBar ) && $wg->User->isAnon() ): ?>
			</div>
		<? endif; ?>
		</div>
		<div class="WikiaBarCollapseWrapper">
			<a href="#" class="wikia-bar-collapse" data-tooltip="<?= wfMessage( 'wikiabar-tooltip' )->escaped(); ?>"></a>
		</div>
	</div>
<?php endif; ?>
