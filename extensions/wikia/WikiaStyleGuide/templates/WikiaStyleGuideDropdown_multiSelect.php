<div class="WikiaDropdown MultiSelect">
	<div class="selected-items">
		<span class="selected-items-list"></span>
		<img class="arrow" src="<?= $wg->BlankImgUrl ?>" />
	</div>
	<div class="dropdown">
		<?= $toolbar ?>
		<ul class="dropdown-list">
			<? foreach($options as $index => $name): ?>
				<? $isSelected = isset($selected[$index]); ?>
				<li class="dropdown-item<?= $isSelected ? ' selected' : '' ?>">
					<label><input type="checkbox" name="namespace[]" value="<?= $index ?>"<?= $isSelected ? ' checked' : '' ?>><?= $name ?></label>
				</li>
			<? endforeach; ?>
		</ul>
	</div>
</div>