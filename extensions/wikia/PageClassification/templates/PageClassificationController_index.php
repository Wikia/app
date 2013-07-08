<h3>List of wikis with identified pages</h3>
<?php if ( !empty( $wikilist ) ) { ?>
<ul>
<?php foreach ( $wikilist as $wiki ) { ?>
	<li><a href="<?=$wiki['browseUrl']?>"><?=$wiki['domain']?></a></li>
<?php } ?>
</ul>
<?php } else { ?>
The is no data.
<? } ?>
