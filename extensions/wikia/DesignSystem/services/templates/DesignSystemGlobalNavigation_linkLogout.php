<div id="<?= Sanitizer::encodeAttribute( $model['title']['key'] ); ?>">
	<? // Logout is a POST, so we render a button inside a form here ?>
	<form method="POST" action="<?= Sanitizer::encodeAttribute( $model['href'] ); ?>">
		<? // wds-sign-out__button will make this look like a link ?>
		<input type="hidden" name="<?= $model['param-name'] ?>"
			   value="<?= Sanitizer::encodeAttribute( ( new UserLoginHelper() )->getCurrentUrlOrMainPageIfOnUserLogout() ); ?>">
		<button type="submit" class="wds-sign-out__button" data-tracking-label="<?= Sanitizer::encodeAttribute( $model['tracking-label'] ); ?>">
			<?= DesignSystemHelper::renderText( $model['title'] ) ?>
		</button>
	</form>
</div>
