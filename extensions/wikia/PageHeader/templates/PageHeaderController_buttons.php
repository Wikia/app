<div>
	<? if ( $actionButton->shouldDisplay() ): ?>
		<?= $app->renderView( 'Wikia\PageHeader\PageHeader', 'actionButton' ); ?>
	<? endif; ?>
	<? if ( $shouldDisplayShareButton ): ?>
		<a id="ShareEntryPoint" class="wds-button wds-is-squished wds-is-secondary" href="#" data-id="share">
			<?= DesignSystemHelper::renderSvg( 'wds-icons-share', 'wds-icon wds-icon-small'); ?>
			<span><?= wfMessage( 'page-header-button-share' )->escaped()?></span>
		</a>
	<? endif; ?>
	<? if ( $shouldDisplayAddNewImageButton): ?>
		<a class="wds-button wds-is-squished" href="#">
			<?= DesignSystemHelper::renderSvg( 'wds-icons-image', 'wds-icon wds-icon-small'); ?>
			<span><?= wfMessage( 'page-header-button-add-new-image' )->escaped()?></span>
		</a>
	<? endif; ?>
	<? if ( $shouldDisplayAddNewVideoButton): ?>
		<a class="wds-button wds-is-squished" href="#">
			<?= DesignSystemHelper::renderSvg( 'wds-icons-video-camera', 'wds-icon wds-icon-small'); ?>
			<span><?= wfMessage( 'page-header-button-add-new-video' )->escaped()?></span>
		</a>
	<? endif; ?>
<!--	--><?// if ( $shouldDisplayAddNewVideoButton): ?>
	<?= $app->renderView( 'CommentsLikes', 'index', [  ] ); ?>
<!--	--><?// endif; ?>
</div>