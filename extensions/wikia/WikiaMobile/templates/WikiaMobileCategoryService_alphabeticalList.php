<?/**
 * @var $app WikiaApp
 * @var $wg WikiaGlobalRegistry
 * @var $wf WikiaFunctionWrapper
 * @var $collections Array
 * @var $requestedIndex Integer
 * @var $requestedBatch Integer
 * @var $total Integer
 */?>
<section class="alphaSec noWrap">
	<header>
		<?= wfMessage( 'wikiamobile-categories-items-total', $wg->ContLang->formatNum( $total ) )->inContentLanguage()->text() ;?>
		<button class=wkBtn id=expAll>
			<span class=expand><?= wfMessage( 'wikiamobile-categories-expand' )->inContentLanguage()->text() ;?></span>
			<span class=collapse><?= wfMessage( 'wikiamobile-categories-collapse' )->inContentLanguage()->text() ;?></span>
		</button>
	</header>
<? foreach ( $collections as $index => $collection ) {
	$batch = ( $index == $requestedIndex ) ? $requestedBatch : 1;
	$itemsBatch = wfPaginateArray( $collection, WikiaMobileCategoryModel::BATCH_SIZE, $batch );
	$currentBatch = $itemsBatch['currentBatch'];
	$nextBatch = $currentBatch + 1;
	$prevBatch = $currentBatch - 1;
	$urlSafeIndex = urlencode( $index );
	$id = 'catAlpha' . $urlSafeIndex;
	?>
	<h2 class=collSec><?= strtoupper( $index ) ;?>
		<span class=cnt><?= $wg->ContLang->formatNum( $itemsBatch['total'] ) ;?></span>
		<span class=chev></span>
	</h2>
	<section id=<?= $id ;?> class=artSec data-batches=<?= $itemsBatch['batches'] ;?>>
		<a class="pagLess<?= ( $currentBatch > 1 ? ' visible' : '' ) ;?>" data-batch="<?=$prevBatch?>" href="?page=<?=$prevBatch;?>&index=<?=$urlSafeIndex;?>#<?=$id;?>"><?= wfMessage( 'wikiamobile-category-items-prev' )->text() ;?></a>
		<?= $app->getView( 'WikiaMobileCategoryService', 'getBatch', array( 'itemsBatch' => $itemsBatch['items'] ) ) ;?>
		<a class="pagMore<?= ( $itemsBatch['next']  ? ' visible' : '' ) ;?>" data-batch="<?=$nextBatch;?>" href="?page=<?=$nextBatch;?>&index=<?=$urlSafeIndex;?>#<?=$id;?>"><?= wfMessage( 'wikiamobile-category-items-more' )->text() ;?></a>
	</section>
<? } ?>
</section>