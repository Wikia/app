<div class="WikiaDropdown MultiSelect">
	<div class="selected-items">
		<span class="selected-items-list"></span>
		<img class="arrow" src="<?= $wg->BlankImgUrl ?>" />
	</div>
	<div class="dropdown">
		<?= $toolbar ?>
		<ul class="dropdown-list">
			<? foreach($options as $option): ?>
				<? $isSelected = in_array($option['value'], $selected); ?>
				<li class="dropdown-item<?= $isSelected ? ' selected' : '' ?>">
					<label><input type="checkbox" name="namespace[]" value="<?= $option['value'] ?>"<?= $isSelected ? ' checked' : '' ?>><?= $option['label'] ?></label>
				</li>
			<? endforeach; ?>
		</ul>
	</div>
</div>