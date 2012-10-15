<section class="SalesSupportModule module">
	<h2 class="dark_text_2"><? if( !isMsgEmpty( 'myhome-community-corner-header' ) ) { echo wfMsg('myhome-community-corner-header'); } ?></h2>
	<div id="sales-support-content"><?=wfMsgExt('sales-support-corner', array('parse','content'))?></div>
	
<?php if($isAdmin) { ?>
	<div id="sales-support-edit"><a class="more" href="<?=Title::newFromText('sales-support-corner', NS_MEDIAWIKI)->getLocalURL('action=edit')?>" rel="nofollow"><?=wfMsg('corportaepage-sales-support-edit')?></a></div>
<?php } ?>
</section>