<?php if ( isset( $model['subtitle'] ) ): ?>
	<div class="wds-global-navigation__account-menu-dropdown-caption">
		<?= DesignSystemHelper::renderText( $model['subtitle'] ) ?>
	</div>
<?php endif; ?>

<?php if ( $model['title']['key'] === 'global-navigation-user-sign-out'): ?>
	<div class="<?= $classNames ?> wds-sign-out"
	     id="<?= Sanitizer::encodeAttribute( $model['title']['key'] ); ?>">
		<?/* Logout is a POST, so we render a button inside a form here */?>
		<form method="POST" action="<?= Sanitizer::encodeAttribute( $href ); ?>">
			<input type="hidden" name="redirect"
			       value="<?= Sanitizer::encodeAttribute( $model['redirect'] ); ?>">
			<button type="submit" class="wds-sign-out__button">
				<?= DesignSystemHelper::renderText( $model['title'] ) ?>
			</button>
		</form>
	</div>
<?php else: ?>
	<a href="<?= Sanitizer::encodeAttribute( $href ); ?>"
	   rel="nofollow"
	   id="<?= Sanitizer::encodeAttribute( $model['title']['key'] ); ?>"
	   data-tracking-label="<?= Sanitizer::encodeAttribute( $model['tracking_label'] ) ?>"
	   class="<?= $classNames ?>">
		<?= DesignSystemHelper::renderText( $model['title'] ) ?>
	</a>
<?php endif; ?>
