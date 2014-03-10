<?
/**
 * @var $links String[]
 * @var $defaultSkin String
 * @var $wf WikiaFunctionWrapper
 * @var $copyrightLink String
 * @var $feedbackLink String
 */
?>
<footer id=wkFtr>
	<a id=wkLogo href=http://wikia.com></a>
	<? if( !empty( $links ) ) :?>
		<ul>
			<? foreach( $links as $link ) :?>
			<li><?= $link ;?></li>
			<? endforeach ;?>
		</ul>
	<? endif ;?>
	<ul>
		<li><a href="?useskin=<?= $defaultSkin ?>" id=wkFllSite data-skin="<?= $defaultSkin ?>"><?= wfMsg('mobile-full-site') ;?></a></li>
		<li><?= $copyrightLink ;?></li>
		<li><a href="<?= $feedbackLink ;?>" target=_blank><?= wfMsg('wikiamobile-feedback') ;?></a></li>
	</ul>
</footer>
