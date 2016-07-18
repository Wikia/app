<div class="AdminDashboardGeneralHeader AdminDashboardArticleHeader">
	<h1><?= htmlspecialchars( $headerText ) ?></h1>
</div>
<? if ( !empty($subtitle) ) : ?>
<div class="AdminDashboardStub">
        <div id="contentSub">
             <?= $subtitle ?>
        </div>
</div>
<? endif; ?>
