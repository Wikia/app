<section class="wkImgStk thumb" data-img-count=<?= $count ;?>>
	<img src="<?= wfBlankImgUrl() ;?>" class="galPlcHld lazy" data-src="<?= $images[0][0] ;?>"/>
	<noscript><img src="<?= $images[0][0] ;?>"/></noscript>
	<? if( $count ) :?>
		<ul>
		<? foreach ( $images as $val) :?>
			<li data-img='<?= $val[0];?>' data-thumb='<?= $val[1] ;?>' data-name='<?= $val[3] ;?>'><?= $val[2] ;?></li>
		<? endforeach ;?>
		</ul>
	<? endif ;?>
	<footer class=thumbcaption><?= $footerText ;?></footer>
</section>