<li class="wds-tabs__tab">
	<div class="wds-tabs__tab-label">
		<a href="<?= $link->href ?>"
		   <? if ( $isPreview ): ?>target="_blank"<? endif; ?>
		   data-tracking="<?= $link->tracking ?>"
		>
			<?= DesignSystemHelper::renderSvg( $link->label->iconKey, 'wds-icon-tiny wds-icon' ); ?>
			<span><?= $link->label->renderInContentLang() ?></span>
		</a>
	</div>
</li>