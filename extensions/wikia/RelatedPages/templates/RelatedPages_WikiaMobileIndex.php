<? if ( !$skipRendering ) :?>
	<section id=wkRelPag>
		<h1 class="collSec addChev open"><?= $wf->MsgForContent( 'wikiarelatedpages-heading' ) ;?></h1>
		<ul class="wkLst open">
		<? foreach ( $pages as $page ) :?>
			<? $noImage = empty( $page['imgUrl'] ) ;?>
			<li><a href="<?= $page['url'] ;?>"<?= ($noImage) ? ' class=noImg' : '' ;?>><? if( !$noImage ) :?><img src="<?= $page['imgUrl']; ?>" width=100 height=50 /><? endif ;?><?= $page['title'] ?></a></li>
		<? endforeach ;?>
		</ul>
	</section>
<? endif ;?>