<h1><?= wfMsg('structureddata-special-page-main-header') ?></h1>
<div class="SDClass-list main">
	<h3><?= wfMsg('structureddata-main-classes-list-header') ?></h3>
	<ul>
		<?php foreach ( $mainObjects as $objectClass => $objectName ): ?>
		<li>
			<a href="?method=getCollection&objectType=<?=$objectClass?>">
				<?=wfMsg($objectName);?>
			</a>
			<small>( <?=$objectClass ?>)</small>
		</li>
		<?php endforeach; ?>
	</ul>
</div>
<div class="SDClass-list">
	<h3><?= wfMsg('structureddata-secondary-classes-list-header') ?></h3>
	<ul class="SDClass-list">
		<?php foreach ( $advObjects as $objectClass => $objectName ): ?>
		<li>
			<a href="?method=getCollection&objectType=<?=$objectClass?>">
				<?=wfMsg($objectName);?>
			</a>
			<small>( <?=$objectClass ?>)</small>
		</li>
		<?php endforeach; ?>
	</ul>
</div>


