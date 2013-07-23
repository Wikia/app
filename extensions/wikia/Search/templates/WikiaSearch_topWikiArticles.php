<?php
// this is just a placeholder, please feel free to blow away all markup
$counter = 0;
?>
<?php if ( !empty( $pages ) ) : ?>
<div id="top-wiki-articles">
    <h2>What's hot now</h2>
    <?php foreach ( $pages as $page ) : ?>
    <?php if ( $counter == 0 ): ?>
    <div class="top-wiki-article" id="hot-article">
        <div class="top-wiki-article-thumbnail">
            <? if ( isset( $page['thumbnail'] ) ) : ?>
            <a href="<?=$page['url']?>">
                <img src="<?= $page['thumbnail'] ?>" />
            </a>
            <? endif; ?>
        </div>
        <div class="top-wiki-article-text">
            <h3><a href="<?= $page['url'] ?>"><?= $page['title'] ?></a></h3>
            <p class="top-wiki-article-text-synopsis subtle"><?= wfShortenText( $page['abstract'], 50 ) ?></p>
        </div>
    </div>
    <?php else: ?>
    <div class="top-wiki-article">
        <div class="top-wiki-article-thumbnail">
            <? if ( isset( $page['thumbnail'] ) ) : ?>
            <a href="<?=$page['url']?>">
                <img src="<?= $page['thumbnail'] ?>" />
            </a>
            <? endif; ?>
        </div>
        <div class="top-wiki-article-text">
            <h3><a href="<?= $page['url'] ?>"><?= $page['title'] ?></a></h3>
            <p class="top-wiki-article-text-synopsis subtle"><?= wfShortenText( $page['abstract'], 50 ) ?></p>
        </div>
    </div>
    <?php endif; ?>
    <?php if ( $counter++ >= 6 ) { break; } ?>
    <?php endforeach; ?>
</div>
<?php endif; ?>