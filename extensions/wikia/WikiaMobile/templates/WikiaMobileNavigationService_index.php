<?php
/**
 * @var $wg WikiaGlobalRegistry
 * @var $wf WikiaFunctionWrapper
 * @var $searchPage Bool
 * @var $wordmarkType String
 * @var $wordmarkUrl String
 * @var $wikiName String
 * @var $userName String
 */

	$loggedIn = $wg->User->isLoggedIn();
	$searchPage = $wg->Title->isSpecial( 'Search' );

	if ( $loggedIn ) {
		$userName = $wg->User->getName();
	}
?>
<section id=wkTopNav<?= $searchPage ? ' class="srhOpn"' : ''?>>
	<div id=wkTopBar>
		<a href="<?= Sanitizer::encodeAttribute( Title::newMainPage()->getFullURL() ) ?>">
		<? if( $wordmarkType == "graphic" ) :?>
			<img id="wkImgMrk" src="<?= Sanitizer::encodeAttribute( $wordmarkUrl ); ?>">
		<? else :?>
			<div id="wkWrdMrk"><?= htmlspecialchars( $wikiName ); ?></div>
		<? endif ;?>
		</a>
	<a href=#wkNavSrh id=wkSrhTgl class=tgl></a>
	<a href=#wkNavMenu id=wkNavTgl class=tgl></a>
	<? if ( $loggedIn ) {
		// This gives me image 50x50 but adds html attributes width and height with values 25
		echo '<a id="wkPrfTgl" class="tgl lgdin" href="#">' . AvatarService::renderAvatar( $userName, 25 ) . '</a>';
	} else {
		echo '<a id="wkPrfTgl" class="tgl lgdout ' . $loginButtonClass .'" href="' . Sanitizer::encodeAttribute( $loginUrl ) . '"></a>';
	}	?>
	</div>
	<div id=wkSrh>
		<form id=wkSrhFrm action="<?= Sanitizer::encodeAttribute( SpecialPage::getSafeTitleFor( 'Search' )->getLocalURL() ); ?>" method=get class='wkForm hide-clear'>
			<input type=hidden name=fulltext value=Search>
			<input id=wkSrhInp type=text name=search placeholder="<?= wfMessage( 'wikiamobile-search-this-wiki')->escaped(); ?>" value="<?= Sanitizer::encodeAttribute( $wg->request->getVal( 'search', '' ) ); ?>" required=required autocomplete=off autofocus>
			<div id=wkClear class='clsIco'></div>
			<input id=wkSrhSub class='wkBtn main' type=submit value='<?= wfMessage( 'wikiamobile-search' )->escaped(); ?>'>
		</form>
		<ul id=wkSrhSug class=wkLst></ul>
	</div>
	<div id=wkNav></div>
	<div id=wkPrf>
		<header class="wkPrfHead<?= ( !$loggedIn ) ? ' up' : '' ?>">
		<? if( $loggedIn ) {
			echo $userName;
		} else {
			echo wfMessage( 'userlogin-login-heading' )->text();
		}
		?>
		</header>
	<? if ( $loggedIn ) :?>
		<ul class=wkLst>
			<li><a class=chg href="<?= Sanitizer::encodeAttribute( AvatarService::getUrl( $userName ) ); ?>"><?= wfMessage( 'wikiamobile-profile' )->escaped(); ?></a></li>
			<li><a class=logout href="<?= Sanitizer::encodeAttribute( str_replace( "$1", SpecialPage::getSafeTitleFor( 'UserLogout' )->getPrefixedText() . '?returnto=' . $wg->Title->getPrefixedURL(), $wg->ArticlePath ) ); ?>"><?= wfMessage( 'logout' )->escaped(); ?></a></li>
		</ul>
	<? endif; ?>
	</div>
</section>
