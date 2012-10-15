<h1>
	<?= wfMsgExt( 'campfire-page-header', array( 'parseinline' ), $wgSitename ); ?>
</h1>
<?= $afterBodyHtml ?>

<section id="WikiaPage" class="WikiaPage">
	<article id="WikiaMainContent" class="WikiaMainContent">
		<?php
			// render UserPagesHeader or PageHeader or nothing...
			if (empty($wgSuppressPageHeader) && $headerModuleName) {
				echo F::app()->renderView($headerModuleName, $headerModuleAction, $headerModuleParams);
			}
		?>
		<div id="WikiaArticle" class="WikiaArticle">
			<?= $bodytext ?>

		</div>

		<?php
		if (empty($wgSuppressArticleCategories)) {
			echo F::app()->renderView('CampfireCategories', 'Index');
		} ?>
		<?= F::app()->renderView('ArticleInterlang', 'Index') ?>

	</article><!-- WikiaMainContent -->
</section><!--WikiaPage-->

<?= F::app()->renderView( 'CampfireFooter', 'Index' ) ?>
