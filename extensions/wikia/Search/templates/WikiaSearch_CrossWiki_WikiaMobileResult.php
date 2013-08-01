<?php
$title = ( $hl = $result->getText( 'headline_txt' ) ) ? $hl : $result->getText( 'sitename_txt' );
$url = $result['url'];
?><li class=group>
	<p>
		<a class=groupTitle href="<?= $url;?>"><?=$title;?></a>
		<a class=searchGroup href="<?= $url
			.'/wiki/Special:Search?search='.urlencode
		($query).'&fulltext=Search';?>"></a>
	</p>
	<a class=url href="<?= $url;?>"><?=parse_url( $url, PHP_URL_HOST );?></a>
	<span class=desc><?= $result->getText( Wikia\Search\Utilities::field( 'description' ), 60 ); ?></span>
</li>
