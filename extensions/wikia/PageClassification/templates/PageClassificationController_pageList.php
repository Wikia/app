<h3>List of identified pages on: [wiki]</h3>
<?php if ( !empty( $pagelist ) ) { ?>
<ul>
<?php foreach ( $pagelist as $wiki ) { ?>
	<li><a href="http://<?=$wiki['domain']?>/wiki/<?=$wiki['articleTitle']?>"><?=$wiki['articleTitle']?></a> (articleId: <?=$wiki['articleId']?>) - <?=$wiki['type']?></li>
<?php } ?>
</ul>
<?php } else { ?>
The is no data.
<? } ?>
