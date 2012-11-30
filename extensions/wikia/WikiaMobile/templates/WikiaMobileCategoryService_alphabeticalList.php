<?
/**
 * @var $app WikiaApp
 * @var $wg WikiaGlobalRegistry
 * @var $wf WikiaFunctionWrapper
 * @var $collections WikiaMobileCategoryItemsCollection[]
 * @var $requestedIndex Integer
 * @var $requestedBatch Integer
 * @var $total Integer
 */
?>
<section class="alphaSec noWrap">
	<header><?= $wf->MsgForContent( 'wikiamobile-categories-items-total', $wg->ContLang->formatNum( $total ) ) ;?><button class=wkBtn id=expAll><span class=expand><?= $wf->MsgForContent( 'wikiamobile-categories-expand' ) ;?></span><span class=collapse><?= $wf->MsgForContent( 'wikiamobile-categories-collapse' ) ;?></span></button></header>
<? foreach ( $collections as $index => $collection) :?>
	<?
	$batch = ( $index == $requestedIndex ) ? $requestedBatch : 1;
	$itemsBatch = $collection->getItems( $batch );
	$nextBatch = $itemsBatch['currentBatch'] + 1;
	$prevBatch = $itemsBatch['currentBatch'] - 1;
	$urlSafeIndex = urlencode( $index );
	$id = 'catAlpha' . $urlSafeIndex;
	?>
	<h2 class=collSec><?= strtoupper( $index ) ;?> <span class=cnt><?= $wg->ContLang->formatNum( $itemsBatch['total'] ) ;?></span><span class=chev></span></h2>
	<section id=<?= $id ;?> class=artSec data-batches=<?= $itemsBatch['batches'] ;?>>
		<a class="pagLess<?= ( $itemsBatch['currentBatch'] > 1 ? ' visible' : '' ) ;?>" data-batch="<?=$prevBatch?>" href="?page=<?=$prevBatch;?>&index=<?=$urlSafeIndex;?>#<?=$id;?>"><?= $wf->Msg( 'wikiamobile-category-items-prev' ) ;?></a>
		<?= $app->getView( 'WikiaMobileCategoryService', 'getBatch', array( 'itemsBatch' => $itemsBatch ) ) ;?>
		<a class="pagMore<?= ( $itemsBatch['next']  ? ' visible' : '' ) ;?>" data-batch="<?=$nextBatch;?>" href="?page=<?=$nextBatch;?>&index=<?=$urlSafeIndex;?>#<?=$id;?>"><?= $wf->Msg( 'wikiamobile-category-items-more' ) ;?></a>
	</section>
<? endforeach ;?>
</section>