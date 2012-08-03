<?php if( $resultSet->getResultsFound() > 1 ): ?>
<li class=group>
<?php
	$trackingData = 'class=ResultLink data-wid="'.$resultSet->getHeader('cityId').'" data-gpos="'.$pos.'" data-pos=0 data-sterm="'.addslashes($query).'" data-stype="'.( $isInterWiki ? 'inter' : 'intra' ).'" data-rver="'.$relevancyFunctionId.'" data-event=search_click_wiki';
?>
	<p>
		<a class=groupTitle href="<?= $resultSet->getHeader( 'cityUrl' );?>" <?= $trackingData; ?> ><?= $resultSet->getHeader( 'cityTitle' );?></a>
		<a class=searchGroup href="<?= $resultSet->getHeader('cityUrl') .'/wiki/Special:Search?search='.urlencode($query).'&fulltext=Search';?>"></a>
	</p>
	<a class=url href="<?= $resultSet->getHeader( 'cityUrl' );?>" <?= $trackingData; ?> ><?=$resultSet->getHeader( 'cityUrl' );?></a>
	<?php for($i = 1; $i < 5; $i++){
		$result = $resultSet->next();
		if($result instanceof WikiaSearchResult): ?>
		<div class=groupResults>
			<?= $app->getView( 'WikiaSearch', 'WikiaMobileResult', array(
				'result' => $result,
				'gpos' => $pos,
				'pos' => $i,
				'query' => $query,
				'inGroup' => true,
				'isInterWiki' => $isInterWiki,
				'relevancyFunctionId' => $relevancyFunctionId ) ); ?>
		</div>
		<?php else: break; endif; ?>
	<?php }; ?>
</li>
<?php else: ?>
	<?= $app->getView( 'WikiaSearch', 'WikiaMobileResult', array(
		'result' => $resultSet->next(),
		'gpos' => 0,
		'pos' => $pos,
		'query' => $query,
		'rank' =>  $resultSet->getHeader('cityRank'),
		'isInterWiki'=> true,
		'relevancyFunctionId' => $relevancyFunctionId ) ); ?>
<?php endif; ?>
