Hello Structured World!
<ul>
<?php foreach ( $mainObjects as $objectClass => $objectName ): ?>
	<li>
		<a href="?method=getCollection&objectType=<?=$objectClass?>">
		<?=$objectName;?>
		</a>
		<small>( <?=$objectClass ?>)</small>
		<a href="<?=$specialPageUrl;?>/<?=$objectClass;?>/?action=create" class="wikia-button" title="Create new SDS Object">Create new object</a>
	</li>
<?php endforeach; ?>
</ul>
