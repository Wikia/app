<?php if (!empty( $notifications )): ?>
<div class="wds-banner-notification-container">
	<? foreach( $notifications as $notification ): ?>
		<div class="wds-banner-notification <?= $notification['class'] ?>">
			<div class="wds-banner-notification__icon">
				<?= DesignSystemHelper::renderSvg('wds-icons-alert-small', 'wds-icon wds-icon-small') ?>
<!--				{{svg icon class='wds-icon wds-icon-small'}}-->
			</div>
			<span class="wds-banner-notification__text">
				<?= $notification['message'] ?>
			</span>
			<?= DesignSystemHelper::renderSvg( 'wds-icons-cross-tiny',
				'wds-icon wds-icon-tiny wds-banner-notification__close' ) ?>
<!--			{{svg 'wds-icons-cross-tiny' class='wds-icon wds-icon-tiny wds-banner-notification__close'}}-->

			<!--			<button class="close wikia-chiclet-button"><img src=" --><?//= $wg->StylePath ?><!--/oasis/images/icon_close.png"></button>-->
<!--			<div class="msg">--><?//= $notification['message'] ?><!--</div>-->
		</div>
	<? endforeach ?>
</div>
<?php endif ?>
