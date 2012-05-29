<div class="WikiaDropdown MultiSelect">
	<div class="selected-items">
		<span class="list"><?= $wf->Msg('wikiastyleguide-dropdown-selecteditems-list') ?></span>
		<img class="arrow" src="<?= $wg->BlankImgUrl ?>" />
	</div>
	<ul>
		<? foreach($options as $index => $name): ?>
			<? $isSelected = isset($selected[$index]); ?>
			<li<?= $isSelected ? ' class="selected"' : '' ?>>
				<label><input type="checkbox" name="namespace[]" value="<?= $index ?>"<?= $isSelected ? ' checked' : '' ?>><?= $name ?></label>
			</li>
		<? endforeach; ?>
	</ul>
</div>