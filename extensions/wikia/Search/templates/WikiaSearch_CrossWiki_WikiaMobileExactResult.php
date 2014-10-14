<li class=group>
	<?php
		$urlInfo = parse_url( $resultSet->getHeader( 'url' ) );
		$host = $urlInfo[ 'host' ] ;
	?>
	<p>
		<a class=groupTitle href="<?= $resultSet->getHeader( 'url' ) ?>"><?=
			$resultSet->getHeader('title');?></a>
		<a class=searchGroup href="<?= 'http://' . $host .'/wiki/Special:Search?search='
			.urlencode
		($query).'&fulltext=Search';?>"></a>
	</p>
	<a class=url href="<?= $resultSet->getHeader( 'url' ) ?>"><?= $host ?></a>
	<span class=desc><?= $resultSet->getDescription(); ?></span>
</li>