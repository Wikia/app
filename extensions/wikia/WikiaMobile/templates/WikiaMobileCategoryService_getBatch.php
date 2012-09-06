<?
/**
 * @var $itemsBatch array
 * @var $item WikiaMobileCategoryItem
 */
?>
<? if( isset( $itemsBatch ) && is_array( $itemsBatch ) ) : ?>
<ul class=wkLst>
<? foreach ( $itemsBatch['items'] as $item ) :?>
	<li<?= ( $item->getType() == WikiaMobileCategoryItem::TYPE_SUBCATEGORY ) ? ' class=cld' : '';?>><a href="<?= $item->getUrl() ;?>"><?= $item->getName(); ?></a></li>
<? endforeach ;?>
</ul>
<? endif; ?>