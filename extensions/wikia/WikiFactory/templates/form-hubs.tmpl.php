<!-- s:<?= __FILE__ ?> -->
<h2>
    Hub
</h2>
<div id="wk-wf-category">
<?php
	if( !is_null( $info ) ):
		echo $info;
	endif;
?>
<?php
	echo $hub->getForm( $wiki->city_id, $title );
?>
</div>
<!-- e:<?= __FILE__ ?> -->
