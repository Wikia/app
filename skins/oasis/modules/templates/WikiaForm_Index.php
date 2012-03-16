<form action="<?= !empty($form['action']) ? $form['action'] : '' ?>" method="<?= !empty($form['method']) ? $form['method'] : '' ?>" name="<?= !empty($form['name']) ? $form['name'] : '' ?>" class="WikiaForm <?= !empty($form['class']) ? $form['class'] : '' ?>" <?= !empty($form['id']) ? 'id="' . $form['id'] . '"' : '' ?>>
	<fieldset>
		<? if(!empty($form['isInvalid'])) { ?>
			<div class="input-group error general-errors">
				<div class="error-msg"><?= $form['errorMsg'] ?></div>
			</div>
		<? }// general error ?>
		<? if(!empty($form['inputs'])) { ?>
			<? foreach($form['inputs'] as $input){
				// handle tooltips
				if (isset($input['tooltip'])) {
					$tooltip = Xml::element('img', array(
						'src' => $wg->BlankImgUrl,
						'class' => 'tooltip sprite question',
						'data-tooltip' => $input['tooltip'],
					));
				}
				else {
					$tooltip = '';
				}
			?>
				<? if($input['type'] === 'hidden') { ?>
					<input type="hidden" name="<?= $input['name'] ?>" value="<?= !empty($input['value']) ? $input['value'] : '' ?>">
				<? } else { ?>
					<div class="input-group <?= empty($input['isRequired']) ? '' : 'required' ?> <?= empty($input['isInvalid']) ? '' : 'error' ?> <?= empty($input['class']) ? '' : $input['class'] ?> ">
						<? if($input['type'] === 'text') { ?>
							<label><?= !empty($input['label']) ? $input['label'] : '' ?></label>
							<input type="text" name="<?= $input['name'] ?>" value="<?= !empty($input['value']) ? $input['value'] : '' ?>">
						<? } elseif($input['type'] === 'password') { ?>
							<label><?= !empty($input['label']) ? $input['label'] : '' ?></label>
							<input type="password" name="<?= $input['name'] ?>" value="<?= !empty($input['value']) ? $input['value'] : '' ?>">
						<? } elseif($input['type'] === 'textarea') { ?>
							<label><?= !empty($input['label']) ? $input['label'] : '' ?></label>
							<textarea><?= !empty($input['value']) ? $input['value'] : '' ?></textarea>
						<? } elseif($input['type'] === 'display') { ?>
							<label><?= !empty($input['label']) ? $input['label'] : '' ?><?= $tooltip ?></label>
							<strong><?= !empty($input['value']) ? $input['value'] : '' ?></strong>
						<? } elseif($input['type'] === 'checkbox') { ?>
							<label>
								<input type="checkbox" name="<?= $input['name'] ?>" value="<?= !empty($input['value']) ? $input['value'] : '' ?>" <?= !empty($input['checked']) ? 'checked' : '' ?>> <?= !empty($input['label']) ? $input['label'] : '' ?>
							</label>
						<? } elseif($input['type'] === 'custom') { ?>
							<?= $input['output'] ?>
						<? } elseif($input['type'] === 'nirvanaview') { ?>
							<?= F::app()->getView( $input['controller'], $input['view'], empty($input['params']) ? array() : $input['params'] ) ?>
						<? } elseif($input['type'] === 'nirvana') { ?>
							<?= (string)F::app()->sendRequest( $input['controller'], $input['method'], empty($input['params']) ? array() : $input['params'] ) ?>
						<? } ?>

						<? if(!empty($input['isInvalid'])) { ?>
							<div class="error-msg">
								<?= $input['errorMsg'] ?>
							</div>
						<? } ?>
					</div>
				<? } ?>
			<? } ?>
		<? } ?>
	</fieldset>

	<div class="submits">
		<? if(!empty($form['submits'])) { ?>
			<? foreach($form['submits'] as $submit) { ?>
				<input type="submit" value="<?= $submit['value'] ?>" class="<?= !empty($submit['class']) ? $submit['class'] : '' ?>" name="<?= !empty($submit['name']) ? $submit['name'] : '' ?>" <?= !empty($submit['action']) ? 'action="'.$submit['action'].'"' : '' ?>>
			<? }// submit ?>
		<? } ?>
	</div>
</form>
