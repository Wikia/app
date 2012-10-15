<?
/**
 * @var $networks SocialSharing[]
 */
?>
<ul class=wkLst>
<? foreach ( $networks as $n ) :?>
	<li class=<?= $n->getId() ;?>Shr><a href="<?= ($n->getId() == 'email' ? $n->getUrl( '__1__&subject=__4__', '__3__' ) : $n->getUrl('__1__', '__2__'));/*param substitution happens in JS*/ ;?>" target=_blank>&nbsp;</a></li>
<? endforeach ;?>
</ul>