<?php $wid = $resultSet->getHeader( 'wid' ) ?>
<? if (! empty( $wid ) ): ?>
<div class="result-top-articles">
    <ul>
    <?php foreach ( $resultSet->getTopPages() as $articleId ): ?>
        <?php $title = GlobalTitle::newFromID( $articleId, $wid ); ?>
        <? if ( $article ): ?>
        <li>
            <a href="<?=$title->getFullUrl()?>"><?=$title->getText()?></a>: <span class="subtle"><?=$title->getContent()?></span>
        </li>
        <? endif; ?>
    <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>