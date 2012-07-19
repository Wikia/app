<? if( $count ) :?>
<section class="wkImgStk thumb" data-img-count=<?= $count ;?>><img src="<?= wfBlankImgUrl() ;?>" class="imgPlcHld lazy" data-src="<?= $images[0]['url'] ;?>" width=<?= $images[0]['width'] ;?> height=<?= $images[0]['height'] ;?>><noscript><img src="<?= $images[0]['url'] ;?>"  width=<?= $images[0]['width'] ;?> height=<?= $images[0]['height'] ;?>></noscript><ul>
		<? foreach ( $images as $val) :?>
			<li data-img='<?= $val['url'];?>' data-thumb='<?= $val['thumbURL'] ;?>' data-name='<?= $val['name'] ;?>'><?= $val['tag'] ;?></li>
		<? endforeach ;?></ul><footer class=thumbcaption><?= $footerText ;?></footer></section>
<? endif ;?>