<? if ( !$skipRendering ) :?>
	<section id="wkRelPag">
		<h1 class="collSec open"><?= wfMsgForContent( 'wikiarelatedpages-heading' ) ;?><span class=chev></span></h1>
		<ul class="open wkLst">
		<? foreach ( $pages as $page ) :?>
			<? $noImage = empty( $page['imgUrl'] ) ;?>
			<li><a href="<?= $page['url'] ;?>"<?= ($noImage) ? 'class="noImg"' : '' ;?>><? if( !$noImage ) :?><img src="<?= $page['imgUrl']; ?>"/><? endif ;?><?= $page['title'] ?></a></li>
		<? endforeach ;?>
		</ul>
	</section>
<? endif ;?>