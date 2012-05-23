<ul>
<? foreach ( $options as $index => $name ) { ?>
	<li>
		<input type="checkbox" name="namespace[]" value="<?= $index ?>" <? if ( in_array($index, $selected) ) echo "checked"; ?>><?= $name ?>
	</li>
<? } ?>
</ul>