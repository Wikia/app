<?php $wid = $resultSet->getHeader( 'wid' ) ?>
<? if (! empty( $wid ) ): ?>
<div class="result-top-articles">
    <ul>
    <?php foreach ( $resultSet->getTopPages() as $articleId ): ?>
        <?php $title = GlobalTitle::newFromIdAndCityId( $articleId, $wid ); ?>
        <? if ( $title ): ?>
        <li>
            <a href="<?=$title->getFullUrl()?>"><?=$title->getText()?></a>
        </li>
        <? endif; ?>
    <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>