<? if ( $isMiniEditorEnabled ): ?>
	<?= $app->renderView( 'MiniEditorController', 'Setup' ) ?>
<? endif ?>
<section id="WikiaArticleComments" class="WikiaArticleComments noprint" data-page="<?= htmlspecialchars($page) ?>">
	<? if ( empty( $isLoadingOnDemand ) ): ?>
		<?= $app->renderView( 'ArticleCommentsController', 'Content' ) ?>
	<? else: ?>
	<ul class="controls">
		<li id="article-comments-counter-recent"></li>
	</ul>
	<h1 id="article-comments-counter-header"></h1>
	<div id="article-comments" class="article-comments">
		<div class="article-comments-pagination upper-pagination"></div>
		<ul id="article-comments-ul" class="comments"></ul>
		<div class="article-comments-pagination"></div>
	</div>
	<? endif; ?>
</section>
