<?/**
 * @var $itemsBatch array
 * @var $item Array
 */?>
<ul class=wkLst>
<? foreach ( $itemsBatch as $item ) :?>
	<li<?= $item['is_category'] ? ' class=cld' : '';?>><a href="<?= $item['url'] ;?>"><?= $item['name']; ?></a></li>
<? endforeach ;?>
</ul>