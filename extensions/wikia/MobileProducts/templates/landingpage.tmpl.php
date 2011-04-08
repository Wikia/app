<section class="MobileProducts">
	<? if ( !$mobile ) :?>
		<div id="mobileProductsSlideshow">
			<ul class="slideClass">
				<? foreach ( $slides as $slide ) :?>
					<li><a href="<?= $slide[ 'href' ] ;?>"><img src="<?= $slide[ 'img' ] ;?>" /></a></li>
				<? endforeach ;?>
			</ul>
			<ul class="slideButton">
				<? for ($x = 0; $x < count( $slides ); $x++) :?>
					<li><a><img src="<?= $wgBlankImgUrl ;?>" /></a></li>
				<? endfor ;?>
			</ul>
		</div>
	<? endif ;?>
	<ul class="Boxes">
		<? foreach ( $boxes as $box ) :?>
			<li>
				<img src="<?= $box['img'] ;?>"/>
				<h2><a href="<?= $box['href'] ;?>"><?= $box['title'] ;?></a></h2>
				<span class="description"><?= $box['description'] ;?></span>
				<a class="more" href="<?= $box['href'] ;?>"><?= wfMsgExt( 'mobileproducts-more-link', array( 'content', 'escape' ) ) ;?></a>
			</li>
		<? endforeach ;?>
	</ul>
	<img class="sprite shadow" src="<?= $wgBlankImgUrl ;?>">
	<ul class="Stores">
		<? foreach ( $marketApps as $marketApp ) :?>
			<li>
				<span class="AppTitle"><?= $marketApp['title'] ;?></span>
				<ul>
					<? foreach ( $marketApp['stores'] as $store ) :?>
						<li >
							<a href="<?= $store['href'] ;?>"><img src="<?= "{$imagesPath}{$store['img']}" ;?>"/></a>
						</li>
					<? endforeach ;?>
				</ul>
			</li>
		<? endforeach ;?>
	</ul>
</section>