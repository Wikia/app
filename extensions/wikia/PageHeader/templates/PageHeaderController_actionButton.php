<div class="wds-dropdown wds-no-chevron">
	<div class="wds-button wds-is-secondary">
		<?= DesignSystemHelper::renderSvg( 'wds-icons-bullet-list-small', 'wds-icon wds-icon-small' ); ?>
	</div>
	<div class="wds-dropdown__content wds-is-not-scrollable wds-is-right-aligned">
		<ul class="wds-list wds-is-linked">
			<? foreach ( $dropdownActions as $action ): ?>
				<li>
					<a id="<?= Sanitizer::encodeAttribute( $action['id'] ) ?>"
					   href="<?= Sanitizer::encodeAttribute( $action['href'] ) ?>"
						<?= !empty( $action['class'] ) ? 'class="' . $action['class'] . '"'
							: ''; ?>
					   data-tracking="<?= $action['data-tracking'] ?>"
						<?= empty( $action['accesskey'] ) ? '' : 'accesskey="' .
							  Sanitizer::encodeAttribute( $action['accesskey'] ) . '"' ?>>
						<?= htmlspecialchars( $action['text'] ) ?>
					</a>
				</li>
			<? endforeach; ?>
		</ul>
	</div>
</div>
<a href="<?= $buttonAction['href'] ?>"
   class="wds-button wds-is-secondary"
   id="<?= Sanitizer::encodeAttribute( $buttonAction['id'] ) ?>"
   title="<?= htmlspecialchars( $buttonAction['text'] ) ?>"
   data-tracking="<?= $buttonAction['data-tracking'] ?>"
	<?= empty( $buttonAction['accesskey'] ) ? ''
		: 'accesskey="' . Sanitizer::encodeAttribute( $buttonAction['accesskey'] ) . '"' ?>
>
	<?= DesignSystemHelper::renderSvg( $buttonAction['icon'], 'wds-icon wds-icon-small' ); ?>
</a>
