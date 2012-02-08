<section>
	<header><?= $wf->MsgExt( 'wikiamobile-categories-items-total', array( 'parsemag', 'content' ), $wg->ContLang->formatNum( $total ), $name ) ;?></header>
<? foreach ( $collections as $letter => $collection) :?>
	<?
	$itemsBatch = $collection->getItems( 1 );
	$nextBatch = $itemsBatch['currentBatch'] + 1;
	$id = 'catAlpha' . htmlentities( $letter );
	$urlSafeLetter = urlencode( $letter );
	$urlSafeId = urlencode( $id );
	?>
	<h2 class=collSec><?= strtoupper( $letter ) ;?> <span class=cnt>(<?= $wg->ContLang->formatNum( $itemsBatch['total'] ) ;?>)</span><span class=chev></span></h2>
	<section id=<?= $id ;?>>
		<ul>
		<? foreach ( $itemsBatch['items'] as $item ) :?>
			<li<?= ( $item->getType() == WikiaMobileCategoryItem::TYPE_SUBCATEGORY ) ? ' class=sub' : '';?>><a href="<?= $item->getUrl() ;?>"><?= $item->getName(); ?></a></li>
		<? endforeach ;?>
		</ul>
		<? if ( $itemsBatch['next'] ) :?>
		<a id=catMore class="lbl pag" href="?page=<?=$nextBatch;?>&letter=<?=$urlSafeLetter;?>#<?=$urlSafeId;?>"><?= $wf->Msg( 'wikiamobile-category-items-more' ) ;?></a>
		<? endif ;?>
	</section>
<? endforeach ;?>
</section>