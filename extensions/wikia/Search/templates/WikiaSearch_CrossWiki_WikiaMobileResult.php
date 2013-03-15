<?php if($resultSet->getResultsFound() > 1 ): ?>
	<li class=group>
		<?php
		$trackingData = 'class=ResultLink data-wid="'.$resultSet->getHeader('cityId').
			'" data-gpos="' . $pos .
			'" data-pos=0 data-sterm="' . addslashes($query).
			'" data-stype="' . ( $isInterWiki ? 'inter' : 'intra' ).
			'" data-rver="' . WikiaSearchController::RVERSION .
			'" data-event=search_click_wiki';
		?>
		<p>
			<a class=groupTitle href="<?= $resultSet->getHeader( 'host' );?>" <?= $trackingData; ?> ><?=
				$resultSet->getHeader( 'wikititle' );?></a>
			<a class=searchGroup href="<?= $resultSet->getHeader('host') .'/wiki/Special:Search?search='.urlencode
			($query).'&fulltext=Search';?>"></a>
		</p>
		<a class=url href="<?= $resultSet->getHeader( 'host' );?>" <?= $trackingData; ?> ><?=$resultSet->getHeader(
				'host' );?></a>
		<span class=desc><?= $resultSet->getHeader('description'); ?></span>
	</li>
<?php else : ?>
	<?= $app->getView( 'WikiaSearch', 'CrossWiki_WikiaMobileExactResult', array(
		'resultSet' => $resultSet,
		'gpos' => 0,
		'pos' => $pos,
		'query' => $query,
		'rank' =>  $resultSet->getHeader('cityRank'),
	)); ?>
<?php endif; ?>

