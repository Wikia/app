<?
	$formAttributes = isset( $form[ 'attributes' ] ) ? $form[ 'attributes' ] : array();
	$formAttributes = WikiaStyleGuideFormHelper::getFormAttributes( $formAttributes, $form );

	// Add WikiaForm class to form element
	$formAttributes[ 'class' ] = isset( $formAttributes[ 'class' ] )
		? $formAttributes[ 'class' ] . ' WikiaForm' : 'WikiaForm';
?>

<form <?= WikiaStyleGuideFormHelper::getAttributesString( $formAttributes ) ?>>
	<fieldset>
		<? if ( !empty( $form[ 'legend' ] ) ): ?>
			<legend><?= $form[ 'legend' ] ?></legend>
		<? endif ?>

		<? if ( !empty( $form[ 'isInvalid' ] ) ): ?>
			<div class="input-group error general-errors">
				<div class="error-msg"><?= $form[ 'errorMsg' ] ?></div>
			</div>
		<? endif ?>

		<? if ( !empty( $form[ 'success' ] ) ): ?>
			<div class="input-group general-errors">
				<div class="error-msg"><?= $form[ 'errorMsg' ] ?></div>
			</div>
		<? endif ?>

		<? if ( is_array( $form[ 'inputs' ] ) ): ?>
			<? foreach( $form[ 'inputs' ] as $input ): ?>
				<?php
					$inputAttributes = isset( $input[ 'attributes' ] ) ? $input[ 'attributes' ] : array();
					$inputAttributes = WikiaStyleGuideFormHelper::getInputAttributes( $inputAttributes, $input );
					$inputAttributes = WikiaStyleGuideFormHelper::getAttributesString( $inputAttributes );

					$class = !empty( $input[ 'class' ] ) ? $input[ 'class' ] : '';
					$error = !empty( $input[ 'isInvalid' ] ) ? 'error' : '';
					$label = !empty( $input[ 'label' ] ) ? $input[ 'label' ] : '';
					$required = !empty( $input[ 'isRequired' ] ) ? 'required' : '';
					$type = strtolower( $input[ 'type' ] );
					$value = !empty( $input[ 'value' ] ) ? $input[ 'value' ] : '';
					$wrappedByLabel = WikiaStyleGuideFormHelper::isWrappedByLabel( $type );

					// Handle tooltips
					$tooltip = '';
					if ( isset( $input[ 'tooltip' ] ) ) {
						$tooltip = Xml::element( 'img', array(
							'src' => $wg->BlankImgUrl,
							'class' => 'sprite question',
							'rel' => 'tooltip',
							'title' => $input[ 'tooltip' ],
						));
					}
				?>

				<? if ( $type === 'hidden' ): ?>
					<input type="hidden" <?= $inputAttributes ?>>
				<? elseif ( $type === 'raw' ): ?>
					<?= $input[ 'output' ] ?>
				<? else: ?>
					<? if ( empty($input['noDivWrapper']) ): ?>
						<div class="<?= WikiaStyleGuideFormHelper::getClassNamesString( array( 'input-group', $class, $error, $required ) ) ?>">
					<? endif; ?>

						<? if ( $label && !$wrappedByLabel ): ?>
							<label><?= ( !$wrappedByLabel ? $label . $tooltip : '' ) ?></label>
						<? endif ?>

						<? if ( $label && $wrappedByLabel ): ?>
							<label>
						<? endif ?>

						<? switch( $type ):
							// The odd formatting here is intentional, see: https://bugs.php.net/bug.php?id=36729
							case 'button': ?>
								<button type="button" <?= $inputAttributes ?>><?=
									( !empty( $input[ 'content' ] ) ? $input[ 'content' ] : '' )
								?></button>
							<? break; ?>
							<? case 'submit': ?>
								<input type="submit" <?= $inputAttributes ?>>
							<? break; ?>
							<? case 'checkbox': ?>
								<input type="checkbox" <?= $inputAttributes ?>>
								<? break; ?>
							<? case 'custom': ?>
								<?= $input[ 'output' ] ?>
							<? break; ?>
							<? case 'display': ?>
								<? if ( $value ): ?>
									<strong><?= $value ?></strong>
								<? endif ?>
							<? break; ?>
							<? case 'nirvana': ?>
								<?= ( string ) F::app()->sendRequest(
									$input[ 'controller' ],
									$input[ 'method' ],
									( empty( $input[ 'params' ] ) ? array() : $input[ 'params' ] )
								) ?>
							<? break; ?>
							<? case 'nirvanaview': ?>
								<?= F::app()->getView(
									$input[ 'controller' ],
									$input[ 'view' ],
									( empty( $input[ 'params' ] ) ? array() : $input[ 'params' ] )
								) ?>
							<? break; ?>
							<? case 'password': ?>
								<input type="password" <?= $inputAttributes ?>>
							<? break; ?>
							<? case 'select': ?>
								<select <?= $inputAttributes ?>>
									<? foreach( $input[ 'options' ] as $option ): ?>
										<option value="<?= $option[ 'value' ] ?>"<?=
											( $value && $option[ 'value' ] == $value ? ' selected' : '' ) ?>><?=
											( !empty( $option[ 'content' ] ) ? $option[ 'content' ] : $option[ 'value' ] )
										?></option>
									<? endforeach ?>
								</select>
							<? break; ?>
							<? case 'text': ?>
							<? case 'url': ?>
							<? case 'email': ?>
								<input type="<?= $type ?>" <?= $inputAttributes ?>>
							<? break; ?>
							<? case 'textarea': ?>
								<textarea <?= $inputAttributes ?>><?= $value ?></textarea>
							<? break; ?>
						<? endswitch; ?>

						<? if ( $error ): ?>
							<div class="error-msg"><?= $input[ 'errorMsg' ] ?></div>
						<? endif ?>

						<? if( $label && $wrappedByLabel ): ?>
							<?= $label ?></label>
						<? endif ?>

					<? if ( empty($input['noDivWrapper']) ): ?>
						</div>
					<? endif; ?>

				<? endif; ?>
			<? endforeach; ?>
		<? endif; ?>
	</fieldset>

	<? if ( !empty( $form[ 'submits' ] ) ): ?>
		<div class="submits">
			<? foreach( $form[ 'submits' ] as $submit ): ?>
				<?
					$submitAttributes = isset( $submit[ 'attributes' ] ) ? $submit[ 'attributes' ] : array();
					$submitAttributes = WikiaStyleGuideFormHelper::getInputAttributes( $submitAttributes, $submit );
					$submitAttributes = WikiaStyleGuideFormHelper::getAttributesString( $submitAttributes );
				?>
				<input type="submit" <?= $submitAttributes ?>>
			<? endforeach ?>
		</div>
	<? endif ?>
</form>
