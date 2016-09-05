<? //TODO: Clean up this file - https://wikia-inc.atlassian.net/browse/XW-1966 ?>
<? if ( !isset( $model['header']['subtitle'] ) ): ?>
	<a href="<?= Sanitizer::encodeAttribute( $model['header']['href'] ); ?>" class="wds-global-navigation__logo">
		<?= DesignSystemHelper::getSvg(
			$model['header']['image'],
			'wds-global-navigation__logo-fandom',
			wfMessage( $model['header']['title']['value'] )->escaped()
		) ?>
	</a>
<? else: ?>
	<a href="<?= Sanitizer::encodeAttribute( $model['header']['href'] ); ?>" class="wds-global-navigation__logo wds-global-navigation__logo-wikia">
		<?= DesignSystemHelper::getSvg(
			$model['header']['image'],
			'wds-global-navigation__logo-wikia-icon',
			wfMessage( $model['header']['title']['key'] )->escaped()
		) ?>
		<span class="wds-global-navigation__logo-wikia-caption"><?=
			DesignSystemHelper::renderText( $model['header']['subtitle'] )
		?></span>
	</a>
<? endif; ?>
