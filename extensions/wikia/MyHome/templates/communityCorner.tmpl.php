<div id="myhome-community-corner">
	<h2 class="dark_text_2"><?=wfMsg('myhome-community-corner-header')?></h2>
	<div id="myhome-community-corner-content"><?=wfMsgExt('community-messages', array('parse','content'))?></div>
<?php if($isAdmin) { ?>
	<div id="myhome-community-corner-edit"><a href="<?=Title::newFromText('community-messages', NS_MEDIAWIKI)->getLocalURL('action=edit')?>" rel="nofollow"><?=wfMsg('myhome-community-corner-edit')?></a></div>
<?php } ?>
</div>
