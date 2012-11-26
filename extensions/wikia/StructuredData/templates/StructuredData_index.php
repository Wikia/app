<h1>Hello Structured World!</h1>
<div class="SDClass-list main">
	<h3>Main Structure Data Classes</h3>
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
</div>
<div class="SDClass-list">
	<h3>Secondary Structure Data Classes</h3>
	<ul class="SDClass-list">
		<?php foreach ( $advObjects as $objectClass => $objectName ): ?>
		<li>
			<a href="?method=getCollection&objectType=<?=$objectClass?>">
				<?=$objectName;?>
			</a>
			<small>( <?=$objectClass ?>)</small>
		</li>
		<?php endforeach; ?>
	</ul>
</div>


