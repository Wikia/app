<?php $wid = $resultSet->getHeader( 'wid' ) ?>
<?php if (! empty( $wid ) ): ?>
<div class="result-top-articles">
    <ul>
    <?php foreach ( $resultSet->getTopPages() as $articleId ): ?>
        <?php $title = GlobalTitle::newFromID( $articleId, $wid ); ?>
        <?php if ( $title ): ?>
        <li>
            <a href="<?=$title->getFullUrl()?>"><?=$title->getText()?></a>
        </li>
        <?php endif; ?>
    <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>
