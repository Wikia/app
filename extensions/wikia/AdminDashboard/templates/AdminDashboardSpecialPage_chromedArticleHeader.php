<div class="AdminDashboardGeneralHeader AdminDashboardArticleHeader">
	<h1><?= $headerText ?></h1>
</div>
<div class="AdminDashboardStub">
        <? if ( !empty($tagline) ) : ?>
            <h3 id="siteSub"><?= $tagline ?></h3>
        <? endif; ?>
        <? if ( !empty($subtitle) ) : ?>
            <div id="contentSub">
                 <?= $subtitle ?>
            </div>
        <? endif; ?>
</div>
