<section class="MobileProduct">
	<div class="product">
		<header>
			<hgroup>
				<h2><?= wfMsgForContent( "mobileproducts-{$product}-title" ) ;?></h2>
				<span class="subtitle"><?= wfMsgForContent( "mobileproducts-{$product}-subtitle" ) ;?></span>
			</hgroup>
			<span class="price"><?= wfMsgForContent( "mobileproducts-{$product}-price" ) ;?></span>
		</header>
		<article>
			<section class="description">
				<?= wfMsgExt( "mobileproducts-{$product}-description", array( 'parse', 'content' ) ) ;?>
			</section>
			<? if ( !empty ( $stores ) ) :?>
				<aside>
					<ul>
						<? foreach ( $stores as $store ) :?>
							<li>
								<? if( !empty( $store['href'] ) ) :?><a href="<?= $store['href'] ;?>"><? endif ;?>
								<img src="<?= "{$imagesPath}{$store['img']}" ;?>" />
								<? if( !empty( $store['href'] ) ) :?></a><? endif ;?>
								<span class="requires"><?= $store['requires'] ;?></span>
							</li>
						<? endforeach ;?>	
					</ul>
				</aside>
			<? endif ;?>
		</article>
		<footer>
			<?= wfMsgExt( "mobileproducts-{$product}-footer", array( 'parse', 'content' ) ) ;?>
		</footer>
	</div>
	<? if ( !$mobile ) :?>
		<div id="mobileProductSlideshow" class="<?= $device ;?>">
			<ul class="slideClass">
				<? foreach ( $slides as $slide ) :?>
					<li><img src="<?= $slide ;?>" /></li>
				<? endforeach ;?>
			</ul>
			<ul class="slideButton">
				<? for ($x = 0; $x < count( $slides ); $x++) :?>
					<li><a><img src="<?= $wgBlankImgUrl ;?>" /></a></li>
				<? endfor ;?>
			</ul>
		</div>
	<? endif ;?>
</section>