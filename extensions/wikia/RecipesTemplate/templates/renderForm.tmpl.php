<?php
	// render create forms toggle
	include(dirname(__FILE__) . '/toggleForms.tmpl.php');

	// preview area
	if (!empty($preview)) {
?>
<div class="recipes-template-preview clearfix">
	<div class="recipes-template-preview-bar"><?= wfMsg('recipes-template-preview-bar') ?></div>
<?= $preview ?>
</div>
<?php
	}

	// error messages
	if (!empty($errorMessage)) {
?>
<div class="usermessage"><?= htmlspecialchars($errorMessage) ?></div>
<?php
	}
?>
<form action="<?= htmlspecialchars($formAction) ?>" method="post">
<table class="recipes-template-form reset">
	<colgroup>
		<col width="150" />
		<col width="260" />
		<col width="290" />
	</colgroup>
	<tbody>
<?php
	// render fields
	foreach ($fields as $id => $field) {
?>
		<tr<?= (!empty($field['error']) ? ' class="recipes-template-error-row"' : '') ?>>
<?php
		// render heading
		if ($field['type'] == 'heading') {
			if (isset($field['editLink']) && $isAdmin) {
				$msgTitle = Title::newFromText($field['editLink'], NS_MEDIAWIKI);
				$editLink = Xml::element(
					'a',
					array('href' => $msgTitle->getLocalUrl('action=edit'), 'class' => 'recipes-template-edit-link'),
					wfMsg('recipes-template-edit-this-menu'));
			}
			else {
				$editLink = '';
			}
?>
			<td colspan="3"><h3 class="dark_text_1"><?= wfMsg("recipes-template-{$field['label']}-label") ?></h3><?= $editLink ?></td>
<?php
		}

		// render category chooser
		else if ($field['type'] == 'multiselect') {
			// get category chooser structure and values
			$value = isset($field['value'])
				? $field['value']
				: RecipesTemplate::parseCategoryChooserMessage($field['values']);

			// let's render each category chooser row
			$row = 0;
			foreach($value as $rowName => $rowValues) {
?>
			<td><label><?= htmlspecialchars($rowName) ?>:</label></td>
			<td>
				<select name="<?= $id ?>[]" id="<?= $id ?>-<?= $row ?>">
					<option value="-1"><?= htmlspecialchars($rowName) ?></option>
<?php
				// render dropdown menu
				foreach ($rowValues as $n => $option) {
					if (!is_numeric($n)) continue;
?>
					<option value="<?= $n ?>"<?= (isset($option['selected']) ? ' selected="selected"' : '') ?>><?= htmlspecialchars($option['value']) ?></option>
<?php
				}

				$otherValue = isset($rowValues['other']['value']) ? htmlspecialchars($rowValues['other']['value']) : false;
?>
					<option value="other"<?= ($otherValue !== false ? ' selected="selected"' : '') ?>><?= wfMsg('recipes-template-other') ?></option>
				</select>

				<div class="recipes-template-suggest-wrapper"<?= ($otherValue === false ? " style=\"display: none\"" : '')?>>
					<input type="text" name="<?= $id ?>Other[]" id="<?= $id ?>Other-<?= $row?>" value="<?= $otherValue ?>" />
				</div>
			</td>
			<td>
<?php
				// show error message for first row of category chooser
				if ($row==0 && isset($field['error_msg'])) {
?>
				<div class="recipes-template-error plainlinks"><?= $field['error_msg'] ?></div>
<?php
				}
?>
			</td>
		</tr>
		<tr>
<?php
				// count rows
				$row++;
			}
		}
		else {
?>
<?php
			if (isset($field['label'])) {
?>
			<td><label for="<?= $id ?>"><?= wfMsg("recipes-template-{$field['label']}-label") ?></label></td>
<?php
			}
			else {
?>
			<td></td>
<?php
			}
?>
			<td>
<?php
			switch($field['type']) {
				// simple input
				case 'input':
					$value = isset($field['value']) ? htmlspecialchars($field['value']) : '';
?>
				<div class="<?= empty($field['noToolbar']) ? 'recipes-template-textarea-wrapper' : 'recipes-template-simple-input' ?>">
					<input type="text" id="<?= $id ?>" name="<?= $id ?>" value="<?= $value ?>" />
				</div>
<?php
					break;

				// area for multiple values
				case 'multifield':
					if (!empty($field['value'])) {
						$values = $field['value'];
					}
					else {
						// initialize with three empty rows
						$values = array_fill(0, 3, '');
					}
?>
				<div class="recipes-template-multifield-wrapper" id="<?= $id ?>">
<?php
					foreach($values as $value) {
?>
					<div class="recipes-template-textarea-wrapper">
						<input type="text" name="<?= $id ?>[]" value="<?= $value ?>" />
					</div>
<?php
					}
?>
				</div>
<?php
					break;

				// textarea with mini MW toolbar
				case 'textarea':
					$value = isset($field['value']) ? htmlspecialchars($field['value']) : '';
?>
				<div class="recipes-template-textarea-wrapper">
					<textarea id="<?= $id ?>" name="<?= $id ?>" rows="4"><?= $value ?></textarea>
				</div>
<?php
					break;

				// time selection
				case 'time':
					if (!empty($field['value'])) {
						$hours = intval($field['value']['hours']);
						$minutes = intval($field['value']['minutes']);
					}
					else {
						$hours = $minutes = 0;
					}
?>
				<div class="recipes-template-time">
					<input type="text" id="<?= $id ?>-hours" name="<?= $id ?>-hours" value="<?= $hours ?>" maxlength="2" />
					<label for="<?= $id ?>-hours"><?= wfMsg('recipes-template-hours') ?></label>

					<input type="text" id="<?= $id ?>-minutes" name="<?= $id ?>-minutes" value="<?= $minutes ?>" maxlength="2" />
					<label for="<?= $id ?>-minutes"><?= wfMsg('recipes-template-minutes') ?></label>
				</div>
<?php
					break;

				// dropdown menu
				case 'select':
?>
				<div class="recipes-template-category-chooser">
					<select id="<?= $id ?>" name="<?= $id ?>" value="<?= $hours ?>">
						<option>TBD</option>
					</select>
				</div>
<?php
					break;

				// photo upload / selection
				case 'upload':
					// init Wikia Mini Upload
					if (function_exists('WMUSetup')) {
						WMUSetup(false);
					}

					$name = isset($field['value']['name']) ? $field['value']['name'] : '';
					$thumb = isset($field['value']['thumb']) ? $field['value']['thumb'] : '';
?>
				<div class="recipes-template-upload">
					<input type="text" id="<?= $id ?>" name="<?= $id ?>" value="<?= $name ?>" readonly="readonly" />
					<a class="wikia-button" href="#"><?= wfMsg('recipes-template-browse') ?></a>

					<div class="recipes-template-upload-preview" style="<?= $thumb ? ("background-image: url({$thumb})") : 'display:none' ?>"></div>
				</div>
<?php
					break;
			}
?>
			</td>
<?php
			// render error message
			if (isset($field['error_msg'])) {
?>
			<td>
				<div class="recipes-template-error plainlinks"><?= $field['error_msg'] ?></div>
			</td>
<?php
			}
			// render hint
			else if (isset($field['hint'])) {
?>
			<td>
				<div class="recipes-template-hint-wrapper<?= isset($field['hintHideable']) ? ' recipes-template-hint-hideable' : '' ?>">
					<div class="recipes-template-hint accent"><?= wfMsg("recipes-template-{$field['hint']}-hint") ?></div>
				</div>
			</td>
<?php
			}
			else {
?>
			<td></td>
<?php
			}
		}
?>
		</tr>
<?php
	}
?>
		<tr class="recipes-template-submit-row">
			<td colspan="3">
				<input type="submit" id="wpPreview" name="wpPreview" value="<?= wfMsg('preview') ?>" class="big" />
				<input type="submit" id="wpSubmit" name="wpSubmit" value="<?= wfMsg("recipes-template-publish-{$formType}-value") ?>" class="big" />
			</td>
		</tr>
	</tbody>
</table>
</form>

<script type="text/javascript">/*<![CDATA[*/
	var RecipesTemplateMessages = <?= Wikia::json_encode($messages) ?>;
/*]]>*/</script>
