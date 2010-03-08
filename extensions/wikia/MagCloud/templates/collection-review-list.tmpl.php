<!-- s:<?= __FILE__ ?> -->
<p id="MagCloudArticlesIntro"><?= wfMsgExt( 'magcloud-special-collection-review-list-info', array('parsemag'), $collection->countArticles() ) ?></p>

<div id="MagCloudArticlesTips" class="accent">
<?= wfMsgExt('magcloud-special-collection-review-list-tips', array('parse')) ?>
<img src="<?= htmlspecialchars($coverExamplesSrc) ?>" alt="Cover examples" width="273" height="100" usemap="#covermap" />
</div>

<map name="covermap">
<area shape="rect" coords="  0,0, 78,100" href="http://magcloud.com/browse/Issue/44110" alt="Star Trek Weapons" target="_blank" />
<area shape="rect" coords=" 98,0,176,100" href="http://magcloud.com/browse/Issue/40645" alt="Grover's Jobs"     target="_blank" />
<area shape="rect" coords="196,0,273,100" href="http://magcloud.com/browse/Issue/44114" alt="Star Trek Planets" target="_blank" />
</map>

<div id="MagCloudArticlesListWrapper">
	<h3><?= wfMsg( 'magcloud-order-your-articles'); ?></h3>
	<div id="MagCloudArticlesList">
	<ul class="reset">
<?php 	global $wgStylePath;
	foreach($collection->getArticles() as $index => $article): ?>
		<li>
			<span class="MagCloudArticlesListGrab">&nbsp;</span>
			<a href="<?= htmlspecialchars($article['url']) ?>" class="MagCloudArticlesListLink" title="<?= htmlspecialchars($article['title']) ?>"><?= htmlspecialchars( MagCloud::getAbbreviatedTitle($article['title']) ) ?></a>
			<img src="http://images1.wikia.nocookie.net/common/skins/common/blank.gif/cb1" id="fe_sharefeature_img" class="sprite delete" alt="<?= wfMsg('delete') ?>" />
		</li>
<?php endforeach; ?>
	</ul>
	</div>
</div>

<div id="SpecialMagCloudButtons" style="clear: left; margin-right: 45%">
<?php
	if (!$isAnon):
?>
	<a id="MagCloudOpenLoadMagazineDialog" class="wikia-button secondary" style="float: left">
		<?= wfMsg('magcloud-load-magazine-title'); ?>
	</a>
<?php
	endif;
?>
	<a id="MagCloudGoToMagazine" class="wikia-button forward" href="<?= htmlspecialchars($title->getLocalUrl() . '/Design_Cover') ?>" style="float: right">
		<?= wfMsg('magcloud-button-design-a-cover'); ?>
	</a>
</div>

<script type="text/javascript">/*<![CDATA[*/
	SpecialMagCloud.setupArticlesList($('#MagCloudArticlesList'));
	$('#MagCloudOpenLoadMagazineDialog').click(function() {
		MagCloud.track('/review/loadmagazine');

		MagCloud.openLoadMagazinePopup();
	});
	$('#MagCloudGoToMagazine').click(function() {
		MagCloud.track('/review/designcover');
	});
	$('.MagCloudArticlesListGrab').click(function() {
		MagCloud.track('/review/list-grab');
	});
	$('.MagCloudArticlesListLink').click(function() {
		MagCloud.track('/review/list-link');
	});
	$('.MagCloudArticlesListRemove').click(function() {
		MagCloud.track('/review/list-remove');
	});
/*]]>*/</script>
<!-- e:<?= __FILE__ ?> -->
