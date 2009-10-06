<!-- s:<?= __FILE__ ?> -->
<p id="MagCloudArticlesIntro"><?= wfMsgExt( 'magcloud-special-collection-review-list-info', array('parsemag'), $collection->countArticles() ) ?></p>

<div id="MagCloudArticlesTips" class="accent">
<?= wfMsgExt('magcloud-special-collection-review-list-tips', array('parse')) ?>
<img src="<?= htmlspecialchars($coverExamplesSrc) ?>" alt="Cover examples" width="273" height="100" />
</div>

<div id="MagCloudArticlesListWrapper">
	<h3><?= wfMsg( 'magcloud-order-your-articles'); ?></h3>
	<div id="MagCloudArticlesList">
	<ul class="reset">
<?php foreach($collection->getArticles() as $index => $article): ?>
		<li>
			<span class="MagCloudArticlesListGrab">&nbsp;</span>
			<a href="<?= htmlspecialchars($article['url']) ?>" class="MagCloudArticlesListLink" title="<?= htmlspecialchars($article['title']) ?>"><?= htmlspecialchars( MagCloud::getAbbreviatedTitle($article['title']) ) ?></a>
			<span class="MagCloudArticlesListRemove">&nbsp;</span>
		</li>
<?php endforeach; ?>
	</ul>
	</div>
</div>

<div id="SpecialMagCloudButtons" style="clear: left; margin-right: 45%">
<?php
	if (!$isAnon):
?>
	<a id="MagCloudOpenLoadMagazineDialog" class="wikia_button secondary" style="float: left">
		<span><?= wfMsg('magcloud-load-magazine-title'); ?></span>
	</a>
<?php
	endif;
?>
	<a id="MagCloudGoToMagazine" class="wikia_button forward" href="<?= htmlspecialchars($title->getLocalUrl() . '/Design_Cover') ?>" style="float: right">
		<span><?= wfMsg('magcloud-button-design-a-cover'); ?></span>
	</a>
</div>

<script type="text/javascript">/*<![CDATA[*/
	SpecialMagCloud.setupArticlesList($('#MagCloudArticlesList'));
	$('#MagCloudOpenLoadMagazineDialog').click(MagCloud.openLoadMagazinePopup);
/*]]>*/</script>
<!-- e:<?= __FILE__ ?> -->
