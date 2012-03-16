<?php
   $loggedIn = $wg->User->getId() > 0;
?>
<section id=wkTopNav<?= ($searchOpen) ? ' class=srhOpn' : ''?>>
   <div id=wkTopBar>
   <? if( $wordmarkType == "graphic" ) :?>
	  <img id=wkImgMrk src="<?= $wordmarkUrl ;?>">
   <? else :?>
	   <div id=wkWrdMrk><?= $wikiName ;?></div>
   <? endif ;?>
   <a href=#wkNavSrh id=wkSrhTgl class=tgl></a>
   <a href=#wkNavMenu id=wkNavTgl class=tgl></a>
   <? if($wg->EnableUserLoginExt) : ?>
   <a href="<?= SpecialPage::getTitleFor('UserLogin')->getLocalURL() ;?>" id=wkPrfTgl class='tgl <?= ($loggedIn ? 'lgdin' : 'lgdout') ?>'></a>
   <? endif ; ?>
   </div>
   <div id=wkNav>
		 <header class="wkPrfHead up"><?= $wf->Msg('wikiamobile-menu') ?></header>
	  <nav id=wkWikiNav></nav>
   </div>
   <? if($wg->EnableUserLoginExt) : ?>
   <div id=wkPrf>
	  <header class="wkPrfHead<?= (!$loggedIn) ? ' up' : '' ?>">
		 <? if($loggedIn) {
			$userName = $wg->User->getName();
			echo AvatarService::renderAvatar( $userName, 22 ) . $userName;
		 } else {
			echo $wf->Msg('userlogin-login-heading');
		 }
		 ?>
	  </header>
	  <? if($loggedIn) :?>
		 <a id=wkLogOut href=<?= str_replace( "$1", SpecialPage::getSafeTitleFor('UserLogout')->getPrefixedText() . '?returnto=' . $wg->Title->getPrefixedURL(), $wg->ArticlePath ) ;?>><?= $wf->Msg('logout'); ?></a>
	  <? endif; ?>
   </div>
   <? endif ; ?>
</section>