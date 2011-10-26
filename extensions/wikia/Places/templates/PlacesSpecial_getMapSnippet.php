<table style="width:200px; height:<?=( isset( $imgUrl ) && !empty( $imgUrl ) ) ? '170px' : '60px'; ?>"><tr><td>
<?php if( isset( $imgUrl ) && !empty( $imgUrl ) ) { ?>
	<a href='<?= $url; ?>'><img src='<?= $imgUrl; ?>' style='display:block; width:200px; height:100px' /></a>
<?php } ?>
<a href='<?= $url; ?>' class='more'><?= $title ?></a>
</td></tr></table>
