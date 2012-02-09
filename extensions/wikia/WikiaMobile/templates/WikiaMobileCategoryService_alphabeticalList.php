<section class=alphaSec>
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
	<section id=<?= $id ;?> class=artSec>
		<? if ( $itemsBatch['currentBatch'] > 1 ) :?>
		<a class=pagLess data-batch=<?=$prevBatch;?> href="?page=<?=$prevBatch;?>&index=<?=$urlSafeIndex;?>#<?=$urlSafeId;?>"><?= $wf->Msg( 'wikiamobile-category-items-prev' ) ;?></a>
		<? endif ;?>

		<?= $app->getView( 'WikiaMobile', 'getCategoryIndexBatch', array( 'itemsBatch' => $itemsBatch ) ) ;?>

		<? if ( $itemsBatch['next'] ) :?>
		<a class=pagMore data-batch=<?=$nextBatch;?> href="?page=<?=$nextBatch;?>&index=<?=$urlSafeIndex;?>#<?=$urlSafeId;?>"><?= $wf->Msg( 'wikiamobile-category-items-more' ) ;?></a>
		<? endif ;?>
	</section>
<? endforeach ;?>
</section>