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
	</header>
<? foreach ( $collections as $index => $collection ) {
	$batch = ( $index == $requestedIndex ) ? $requestedBatch : 1;
	$itemsBatch = wfPaginateArray( $collection, WikiaMobileCategoryModel::BATCH_SIZE, $batch );
	$currentBatch = $itemsBatch['currentBatch'];
	$nextBatch = $currentBatch + 1;
	$prevBatch = $currentBatch - 1;
	$urlSafeIndex = rawurlencode( $index );
	$id = 'catAlpha' . $urlSafeIndex;
	?>
	<h2 id="<?= $id ;?>" data-count="<?= $wg->ContLang->formatNum( $itemsBatch['total'] ) ;?>"><?= $index; ?></h2>
	<section class=artSec id="<?= $urlSafeIndex; ?>" data-batches=<?= $itemsBatch['batches'] ;?>>
		<a class="pagLess<?= ( $currentBatch > 1 ? ' visible' : '' ) ;?>" data-batch="<?=$prevBatch?>" href="?page=<?=$prevBatch;?>&index=<?=$urlSafeIndex;?>#<?=$id;?>"><?= wfMessage( 'wikiamobile-category-items-prev' )->text() ;?></a>
		<?= $app->getView( 'WikiaMobileCategoryService', 'getBatch', array( 'itemsBatch' => $itemsBatch['items'] ) ) ;?>
		<a class="pagMore<?= ( $itemsBatch['next']  ? ' visible' : '' ) ;?>" data-batch="<?=$nextBatch;?>" href="?page=<?=$nextBatch;?>&index=<?=$urlSafeIndex;?>#<?=$id;?>"><?= wfMessage( 'wikiamobile-category-items-more' )->text() ;?></a>
	</section>
<? } ?>
</section>
