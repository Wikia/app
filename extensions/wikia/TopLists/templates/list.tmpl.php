<?php var_dump( $attribs ); ?>
<ul>
<?php foreach($list->getItems() as $index => $item ): ?>
	<li><strong>#<?=( ++$index );?></strong> <?= $item->getTitle()->getSubpageText(); ?></li>
<?php endforeach; ?>
</ul>