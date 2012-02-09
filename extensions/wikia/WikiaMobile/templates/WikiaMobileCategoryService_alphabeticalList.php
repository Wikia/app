<section>
	<header><?= $wf->MsgExt( 'wikiamobile-categories-items-total', array( 'parsemag', 'content' ), $wg->ContLang->formatNum( $total ), $name ) ;?></header>
<? foreach ( $collections as $index => $collection) :?>
	<?
	$batch = ( $index == $requestedIndex ) ? $requestedBatch : 1;
	$itemsBatch = $collection->getItems( $batch );
	$nextBatch = $itemsBatch['currentBatch'] + 1;
	$prevBatch = $itemsBatch['currentBatch'] - 1;
	$id = 'catAlpha' . htmlentities( $index );
	$urlSafeIndex = urlencode( $index );
	$urlSafeId = urlencode( $id );
	?>
	<h2 class=collSec><?= strtoupper( $index ) ;?> <span class=cnt>(<?= $wg->ContLang->formatNum( $itemsBatch['total'] ) ;?>)</span><span class=chev></span></h2>
	<section id=<?= $id ;?>>
		<? if ( $itemsBatch['currentBatch'] > 1 ) :?>
		<a id=catLess class="lbl pag" href="?page=<?=$prevBatch;?>&index=<?=$urlSafeIndex;?>#<?=$urlSafeId;?>"><?= $wf->Msg( 'wikiamobile-category-items-prev' ) ;?></a>
		<? endif ;?>

		<ul>
		<? foreach ( $itemsBatch['items'] as $item ) :?>
			<li<?= ( $item->getType() == WikiaMobileCategoryItem::TYPE_SUBCATEGORY ) ? ' class=sub' : '';?>><a href="<?= $item->getUrl() ;?>"><?= $item->getName(); ?></a></li>
		<? endforeach ;?>
		</ul>

		<? if ( $itemsBatch['next'] ) :?>
		<a id=catMore class="lbl pag" href="?page=<?=$nextBatch;?>&index=<?=$urlSafeIndex;?>#<?=$urlSafeId;?>"><?= $wf->Msg( 'wikiamobile-category-items-more' ) ;?></a>
		<? endif ;?>
	</section>
<? endforeach ;?>
</section>