<section class="wkImgStk thumb" data-img-count=<?= $count ;?>><img src=<?= $images[0][0] ;?>><? if( $count ) :?>
		<ul>
		<? foreach ( $images as $val) :?>
			<li data-img='<?= $val[0];?>' data-name='<?= $val[2] ;?>'><?= $val[1] ;?></li>
		<? endforeach ;?>
		</ul><? endif ;?><footer class=thumbcaption><?= $footerText ;?></footer></section>