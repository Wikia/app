<?
/**
 * @var $links String[]
 * @var $defaultSkin String
 * @var $centralUrl String
 * @var $copyrightLink String
 * @var $privacyLink String
 * @var $feedbackLink String
 */
?>
<footer id=wkFtr>
	<a id=wkLogo href="<?= $centralUrl ?>"></a>
	<? if( !empty( $links ) ) :?>
		<ul>
			<? foreach( $links as $link ) :?>
			<li><?= $link ;?></li>
			<? endforeach ;?>
		</ul>
	<? endif ;?>
	<ul>
		<li><a href="?useskin=<?= $defaultSkin ?>" id=wkFllSite data-skin="<?= $defaultSkin ?>"><?= wfMessage( 'mobile-full-site' )->escaped(); ?></a></li>
		<li><?= $copyrightLink ;?></li>
		<li><?= $privacyLink ;?></li>
		<li><a href="<?= $feedbackLink ;?>" target=_blank><?= wfMessage('wikiamobile-feedback' )->escaped(); ?></a></li>
	</ul>
</footer>
