<ul>
	<? foreach( $options as $index => $name ): ?>
		<li>
			<input type="checkbox" name="namespace[]" value="<?= $index ?>" <?= isset($selected[$index]) ? 'checked' : '' ?>><?= $name ?>
		</li>
	<? endforeach; ?>
</ul>