<?php if($resultSet->getResultsFound() > 1 ): ?>
	<li class=group>
		<p>
			<a class=groupTitle href="<?= $resultSet->getHeader( 'host' );?>"><?=
				$resultSet->getHeader( 'wikititle' );?></a>
			<a class=searchGroup href="<?= $resultSet->getHeader('host') .'/wiki/Special:Search?search='.urlencode
			($query).'&fulltext=Search';?>"></a>
		</p>
		<a class=url href="<?= $resultSet->getHeader( 'host' );?>"><?=$resultSet->getHeader(
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

