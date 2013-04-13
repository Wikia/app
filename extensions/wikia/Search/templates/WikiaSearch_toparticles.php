<div class="result-top-articles">
    <ul>
    <?php foreach ( $resultSet->getTopPages() as $articleId ): ?>
        <?php $article = Article::newFromID( $articleId ); ?>
        <? if ( $article ): ?>
        <li>
            <a href="<?=$article->getTitle()->getFullUrl()?>"><?=$article->getTitle()->getText()?></a>: <span class="subtle"><?=(new ArticleService( $article ))->getTextSnippet( 60 )?></span>
        </li>
        <? endif; ?>
    <?php endforeach; ?>
    </ul>
</div>