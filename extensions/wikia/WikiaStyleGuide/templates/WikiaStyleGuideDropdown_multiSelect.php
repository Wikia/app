<div class="WikiaDropdown MultiSelect">
	<div class="selected-items">
		<strong>(Main), Talk, User</strong> and 2 more
		<img class="arrow" src="<?= $wg->BlankImgUrl ?>" />
	</div>
	<ul>
		<? foreach($options as $index => $name): ?>
			<? $selected = isset($selected[$index]); ?>
			<li<?=  $selected ? ' class="selected"' : '' ?>>
				<label><input type="checkbox" name="namespace[]" value="<?= $index ?>"<?= $selected ? ' checked' : '' ?>><?= $name ?></label>
			</li>
		<? endforeach; ?>
	</ul>
</div>