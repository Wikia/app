<div class="wds-global-footer__bottom-bar-row wds-has-border-top global-footer-full-site-link-wrapper">
	<a href="<?= Sanitizer::encodeAttribute( $model['href'] ); ?>"
	   onclick="footerClick()"
	   class="wds-global-footer__button-link">
		<?= DesignSystemHelper::renderText( $model['title'] ) ?>
	</a>
</div>
