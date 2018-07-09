<div class="wds-dropdown wds-global-navigation__user-menu wds-has-dark-shadow wds-global-navigation__user-anon">
	<div class="wds-dropdown__toggle">
		<?= $app->renderPartial( 'DesignSystemGlobalNavigationService',
			'avatar', ['src'=> '', 'alt' => ''] ); ?>
		<?= DesignSystemHelper::renderSvg( 'wds-icons-dropdown-tiny', 'wds-icon wds-icon-tiny wds-dropdown__toggle-chevron' ); ?>
	</div>
	<div class="wds-dropdown__content wds-is-right-aligned">
		<ul class="wds-list wds-has-lines-between">
			<li>
				<a class="wds-button wds-is-full-width"
				   href="<?= Sanitizer::encodeAttribute( ( new UserLoginHelper() )->getNewAuthUrl( $model['signin']['href'] ) ); ?>"
				   rel="nofollow"
				   data-tracking-label="<?= Sanitizer::encodeAttribute( $model['signin']['tracking-label'] ); ?>">
					<?= DesignSystemHelper::renderText( $model['signin']['title'] ) ?>
				</a>
			</li>
			<li>
				<div
					class="wds-global-navigation__user-menu-dropdown-caption"><?= wfMessage( 'global-navigation-anon-register-description' )->escaped() ?></div>
				<a class="wds-button wds-is-full-width wds-is-secondary"
				   href="<?= Sanitizer::encodeAttribute( ( new UserLoginHelper() )->getNewAuthUrl( $model['register']['href'] ) ); ?>"
				   rel="nofollow"
				   data-tracking-label="<?= Sanitizer::encodeAttribute( $model['register']['tracking-label'] ); ?>">
					<?= DesignSystemHelper::renderText( $model['register']['title'] ) ?>
				</a>
			</li>
		</ul>
	</div>
</div>
