<li class=group>
	<?php
		$urlInfo = parse_url( $resultSet->getHeader( 'url' ) );
		$host = $urlInfo[ 'host' ] ;
	?>
	<p>
		<a class=groupTitle href="<?= $host ?>"><?=
			$resultSet->getHeader('title');?></a>
		<a class=searchGroup href="<?= $host .'/wiki/Special:Search?search='.urlencode
		($query).'&fulltext=Search';?>"></a>
	</p>
	<a class=url href="<?= $host ?>"><?=$host ?></a>
	<span class=desc><?= $resultSet->getHeader('description'); ?></span>
</li>