Hello Structured World!
<ul>
<?php foreach ( $mainObjects as $objectClass => $objectName ): ?>
	<li>
		<a href="?method=getCollection&objectType=<?=$objectClass?>">
		<?=$objectName;?>
		</a>
		<small>( <?=$objectClass ?>)</small>
	</li>
<?php endforeach; ?>
</ul>
