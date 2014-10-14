<?php if($resultSet->getResultsFound() >= 1 || $resultSet instanceof Wikia\Search\ResultSet\MatchGrouping): ?>
<li class=group>
<?php
	$trackingData = 'class=ResultLink data-wid="'.$resultSet->getHeader('wikiId').
		'" data-gpos="' . $pos .
		'" data-pos=0 data-sterm="' . addslashes($query).
		'" data-stype="' . ( $isInterWiki ? 'inter' : 'intra' ).
		'" data-rver="' . 6 .
		'" data-event=search_click_wiki';
?>
	<p>
		<a class=groupTitle href="<?= $resultSet->getHeader( 'url' );?>" <?= $trackingData; ?> ><?= $resultSet->getHeader( 'wikititle' );?></a>
		<a class=searchGroup href="<?= $resultSet->getHeader('url') .'/wiki/Special:Search?search='.urlencode($query).'&fulltext=Search';?>"></a>
	</p>
	<a class=url href="<?= $resultSet->getHeader( 'url' );?>" <?= $trackingData; ?> ><?=$resultSet->getHeader( 'url' );?></a>
	<?php 
	$i = 1;
	foreach( $resultSet as $result ) {
		if($result instanceof Wikia\Search\Result): ?>
		<div class=groupResults>
			<?= $app->getView( 'WikiaSearch', 'WikiaMobileResult', array(
				'result' => $result,
				'gpos' => $pos,
				'pos' => $i,
				'query' => $query,
				'inGroup' => true,
				'isInterWiki' => $isInterWiki,
				'relevancyFunctionId' => 6 ) ); ?>
		</div>
		<?php $i++; else: break; endif; ?>
	<?php if ( $i == 5 ) { break; } }; ?>
</li>
<?php elseif ($nextResult = $resultSet->next()): ?>
	<?= $app->getView( 'WikiaSearch', 'WikiaMobileResult', array(
		'result' => $nextResult,
		'gpos' => 0,
		'pos' => $pos,
		'query' => $query,
		'isInterWiki'=> true,
		'relevancyFunctionId' => 6 ) ); ?>
<?php endif; ?>
