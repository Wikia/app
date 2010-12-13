<!-- s:<?= __FILE__ ?> -->

	<? if( !empty($tagPosition) ){ ?>
	<p id="hubposition" >
	<?
		echo wfMsg('pv-ranking').' ';
		$tmpArray = array();
		foreach ( $tagPosition as $val ) {
			$tmpArray[] = wfMsg('hub-position', $val['position'], $val['name'] );
		}
		echo implode ( ', ', $tmpArray );
	?>
	</p>
	<? } ?>
	
<!-- e:<?= __FILE__ ?> -->
