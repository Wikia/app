<div class="MultiSelectDropdown">
	<div class="selected-items">Test1, Test2, Test3 ... and 2 more</div>
	<ul>
		<? foreach( $options as $index => $name ): ?>
			<li>
				<input type="checkbox" name="namespace[]" value="<?= $index ?>" <?= isset($selected[$index]) ? 'checked' : '' ?>><?= $name ?>
			</li>
		<? endforeach; ?>
	</ul>
</div>