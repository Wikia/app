<!-- s:<?= __FILE__ ?> -->
<style>
.tr_list {
	border-bottom:1px dashed #778899; 
	padding-bottom:2px;
	font-size:12px;
}	
.tr_title {
	color:#3B7F07; 
	font-size:12px;
}
</style>
<?php if ( !empty($err) ) : ?>
<p class='error'><?=$err?></p>
<?php endif ?>
<?php 
if ( empty($regexList) ) {
	echo wfMsg( 'textregex_nocurrently-blocked' );
} else {
	echo wfMsgExt( 'textregex-currently-blocked', array('parse') );
?>	
<form name="textregexlist" method="get" action="<?=$action?>">
<?= $sPrevNext; ?>
<ul>
<?php
	foreach ( $regexList as $row ) { 
		$oUser = User::newFromId($row['user']);
?>
<li class="tr_list">
	<strong class="tr_title"><?=$row['text']?></strong> <?= wfMsg('textregex-addedby-user', ($oUser instanceof User) ? $oUser->getName() : "", $row['timestamp']) ?>
   (<?=wfMsgExt('textregex-remove-url', 'parseinline', $action_unblock, $row['id'])?>) (<?=wfMsgExt('textregex-stats-url', 'parseinline', $action_stats, $row['id'])?>)
</li>
<?php
	}
?>
</ul>
<?= $sPrevNext; ?>
</form>
<? } ?>
<!-- e:<?= __FILE__ ?> -->
