<?php if($resultSet->getResultsFound() > 1 ): ?>
	<?php if ( $resultSet->getHeader('wikititle') ): ?>
		<li class=group>
			<p>
				<a class=groupTitle href="<?= $resultSet->getHeader( 'url' );?>"><?=
					$resultSet->getHeader( 'wikititle' );?></a>
				<a class=searchGroup href="<?= 'http://' . $resultSet->getHeader('host')
					.'/wiki/Special:Search?search='.urlencode
				($query).'&fulltext=Search';?>"></a>
			</p>
			<a class=url href="<?= $resultSet->getHeader( 'url' );?>"><?=$resultSet->getHeader(
					'host' );?></a>
			<span class=desc><?= $resultSet->getDescription(); ?></span>
		</li>
	<?php endif; ?>
<?php else : ?>
	<?= $app->getView( 'WikiaSearch', 'CrossWiki_WikiaMobileExactResult', array(
		'resultSet' => $resultSet,
		'gpos' => 0,
		'pos' => $pos,
		'query' => $query,
		'rank' =>  $resultSet->getHeader('cityRank'),
	)); ?>
<?php endif; ?>

