<?
/**
 * @var $items array
 */
?>
<section id=wkCatExh class=noWrap>
<? foreach($items as $item)  :?>
	<div class=wkExhItm><a href=<?= $item['url'] ;?>>
	<? if( !empty( $item['img'] ) ) :?>
		<img src="<?= $item['img'] ;?>" alt='<?= $item['title'] ;?>'>
	<? else : ?>
		<div class=exhPlcHld></div>
	<? endif ;?>
		<div class=wkExhTtl><span><?= $item['title'] ;?></span></div>
	</a></div>
<? endforeach ;?>
</section>