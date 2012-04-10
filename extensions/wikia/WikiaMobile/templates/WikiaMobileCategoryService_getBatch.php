<ul class=wkLst>
<? foreach ( $itemsBatch['items'] as $item ) :?>
	<li<?= ( $item->getType() == WikiaMobileCategoryItem::TYPE_SUBCATEGORY ) ? ' class=cld' : '';?>><a href="<?= $item->getUrl() ;?>"><?= $item->getName(); ?></a></li>
<? endforeach ;?>
</ul>