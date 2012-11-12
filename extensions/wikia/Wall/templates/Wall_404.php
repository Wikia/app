<div class="mw-userpage-userdoesnotexist error wall-userpage-userdoesnotexist">
	<p><?= wfMsg('wall-userdoesnotexist', $userName);?></p>
</div>
<? if ($showMissingArticle): ?>
	<div class='noarticletext'>
		<?= wfMsgExt( 'noarticletext' , array('parseinline')); ?>
	</div>
<? endif ?>