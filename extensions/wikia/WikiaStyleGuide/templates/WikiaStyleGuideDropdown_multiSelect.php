<div class="WikiaDropdown MultiSelect">
	<div class="selected-items">
		<span class="selected-items-list"></span>
		<img class="arrow" src="<?= $wg->BlankImgUrl ?>" />
	</div>
	<div class="dropdown">
		<?= $toolbar ?>
		<?php if(!empty($selectAll) && $selectAll === true): ?>
			<div class="toolbar">
				<label><input type="checkbox" name="select-all" class="select-all" value="all"><?= wfMessage( 'wikiastyleguide-dropdown-select-all' )->escaped(); ?></label>
			</div>
		<?php endif; ?>
		<ul class="dropdown-list">
			<? foreach($options as $option): ?>
				<? $isSelected = in_array($option['value'], $selected); ?>
				<li class="dropdown-item<?= $isSelected ? ' selected' : '' ?>">
					<label><input type="checkbox" name="namespace[]" value="<?= Sanitizer::encodeAttribute( $option['value'] ) ?>"<?= $isSelected ? ' checked' : '' ?>><?= htmlspecialchars( $option['label'] ) ?></label>
				</li>
			<? endforeach; ?>
		</ul>
	</div>
</div>
