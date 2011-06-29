<h1>
	<?= wfMsgExt( 'campfire-page-header', array( 'parseinline' ), $wgSitename ); ?>
</h1>
<?= $afterBodyHtml ?>

<section id="WikiaPage" class="WikiaPage">
	<article id="WikiaMainContent" class="WikiaMainContent">
		<?php
			// render UserPagesHeader or PageHeader or nothing...
			if (empty($wgSuppressPageHeader) && $headerModuleName) {
				echo wfRenderModule($headerModuleName, $headerModuleAction, $headerModuleParams);
			}
		?>
		<div id="WikiaArticle" class="WikiaArticle">
			<?= $bodytext ?>

		</div>

		<?php
		if (empty($wgSuppressArticleCategories)) {
			echo wfRenderModule('CampfireCategories');
		} ?>
		<?= wfRenderModule('ArticleInterlang') ?>

	</article><!-- WikiaMainContent -->
</section><!--WikiaPage-->

<?= wfRenderModule( 'CampfireFooter' ) ?>
