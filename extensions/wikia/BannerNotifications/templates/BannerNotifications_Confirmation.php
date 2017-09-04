<?php if ( !empty( $notifications ) ): ?>
	<div class="wds-banner-notification__container">
		<? foreach ( $notifications as $notification ): ?>
			<div class="wds-banner-notification <?= $notification['class'] ?>">
				<div class="wds-banner-notification__icon">
					<?= DesignSystemHelper::renderSvg( $notification['icon'],
						'wds-icon wds-icon-small' ) ?>
				</div>
				<span class="wds-banner-notification__text">
					<?= $notification['message'] ?>
				</span>
				<?= DesignSystemHelper::renderSvg( 'wds-icons-cross-tiny',
					'wds-icon wds-icon-tiny wds-banner-notification__close' ) ?>
			</div>
		<? endforeach ?>
	</div>
<?php endif ?>
