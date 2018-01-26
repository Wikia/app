<div class="wds-button-group">
	<? if ($buttonAction['type'] ?? '' == 'submit'): ?>
		<button
		   class="wds-is-squished wds-button"
		   id="<?= Sanitizer::encodeAttribute( $buttonAction['id'] ) ?>"
		   data-tracking="<?= $buttonAction['data-tracking'] ?>"
		   form="<?= $buttonAction['form'] ?>"
		   type="submit"
			<?= empty( $buttonAction['accesskey'] ) ? ''
				: 'accesskey="' . Sanitizer::encodeAttribute( $buttonAction['accesskey'] ) . '"' ?>
		>
			<?= DesignSystemHelper::renderSvg( $buttonAction['icon'], 'wds-icon wds-icon-small' ); ?>
			<span><?= htmlspecialchars( $buttonAction['text'] ) ?></span>
		</button>
	<? else: ?>
		<a href="<?= $buttonAction['href'] ?>"
		   class="wds-is-squished wds-button"
		   id="<?= Sanitizer::encodeAttribute( $buttonAction['id'] ) ?>"
		   data-tracking="<?= $buttonAction['data-tracking'] ?>"
			<?= empty( $buttonAction['accesskey'] ) ? ''
				: 'accesskey="' . Sanitizer::encodeAttribute( $buttonAction['accesskey'] ) . '"' ?>
		>
			<?= DesignSystemHelper::renderSvg( $buttonAction['icon'], 'wds-icon wds-icon-small' ); ?>
			<span><?= htmlspecialchars( $buttonAction['text'] ) ?></span>
		</a>
	<?endif;?>
	<div class="wds-dropdown">
		<div class="wds-button wds-is-squished wds-dropdown__toggle">
			<?= DesignSystemHelper::renderSvg( 'wds-icons-dropdown-tiny',
				'wds-icon wds-icon-tiny wds-dropdown__toggle-chevron' ); ?>
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
</div>
