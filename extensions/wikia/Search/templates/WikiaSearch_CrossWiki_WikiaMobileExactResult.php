<li class=group>
	<?php
	$trackingData = 'class=ResultLink data-wid="'.$resultSet->getHeader('cityId').
		'" data-gpos="' . $pos .
		'" data-pos=0 data-sterm="' . addslashes($query).
		'" data-stype="inter" data-rver="' . WikiaSearchController::RVERSION .
		'" data-event=search_click_wiki';
	?>
	<?php
	$urlInfo = parse_url( $resultSet->getHeader( 'url' ) );
	$host = $urlInfo[ 'host' ] ;
	?>
	<p>
		<a class=groupTitle href="<?= $host ?>" <?= $trackingData; ?> ><?=
			$resultSet->getHeader('title');?></a>
		<a class=searchGroup href="<?= $host .'/wiki/Special:Search?search='.urlencode
		($query).'&fulltext=Search';?>"></a>
	</p>
	<a class=url href="<?= $host ?>" <?= $trackingData; ?> ><?=$host ?></a>
	<span class=desc><?= $resultSet->getHeader('description'); ?></span>
</li>