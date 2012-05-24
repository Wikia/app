<ul>
	<? foreach( $options as $index => $name ): ?>
		<li>
			<input type="checkbox" name="namespace[]" value="<?= $index ?>" <?= in_array($index, $selected, true) ? 'checked' : '' ?>><?= $name ?>
		</li>
	<? endforeach; ?>
</ul>