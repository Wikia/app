<section class="wkImgStk thumb" data-img-count=<?= $count ;?>><img src=<?= $images[0][0] ;?>><? if( $count ) :?>
		<ul>
		<? foreach ( $images as $val) :?>
			<li data-img='<?= $val[0];?>' data-thumb='<?= $val[1] ;?>' data-name='<?= $val[3] ;?>'><?= $val[2] ;?></li>
		<? endforeach ;?>
		</ul><? endif ;?><footer class=thumbcaption><?= $footerText ;?></footer></section>