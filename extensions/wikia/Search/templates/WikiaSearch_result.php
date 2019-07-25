<li class="result">
	<article>
	<?php
		/** @var \Wikia\Search\UnifiedSearch\UnifiedSearchResultItem $result */
		if ( $result['ns'] == NS_FILE ) {
			$thumbnailHtml = $result->getThumbnailHtml();
		}
		?>
		<?php if(! empty( $thumbnailHtml ) ): ?>
		<div class="grid-1 alpha"><?= $thumbnailHtml ?></div>
		<div class="media-text grid-2"> <? // Open media-text div when there's a thumbnail ?>
	<?php endif; ?>
	<h1>
		<?php $title = $result['title']; ?>

		<?php
			$trackingData = 'class="result-link"'
				. 'data-pos="'.$pos.'"'
				. 'data-page-id="' . $result['pageid'] . '"'
				. ' data-thumbnail="' . !empty($thumbnailHtml) . '"';
//				. ( $result['isArticleMatch'] ? ' data-event="search_click_match"' : '' );
		?>

		<a href="<?= $result->getEscapedUrl() ?>" <?=$trackingData;?>><?= $title ?></a>
	</h1>
	
	<? if ($result['ns'] == NS_FILE): ?>
		<p class="subtle">
			<? if (!$result['created_30daysago']) : ?>
			<span class="timeago abstimeago " title="<?= $result['fmt_timestamp'] ?>" alt="<?= $result['fmt_timestamp'] ?>">&nbsp;</span>
			<? else : ?>
			<span class="timeago-fmt"><?= $result['fmt_timestamp'] ?></span>
			<? endif; ?>
			<?php
				if ( $videoViews = $result->getVideoViews() ) {
					echo '&bull; '.$videoViews;
				}
			?>
		</p>
	<? endif; ?>
	<?= $result->getText(); ?>
	
	<?php if(empty($inGroup)): ?>
		<ul>
			<li><a href="<?= $result->getEscapedUrl(); ?>" <?=$trackingData;?> ><?=Language::factory($wg->ContentLanguage)->truncate($result->getTextUrl(), 90);?></a></li>
		</ul>
	<?php endif; ?>
	
	<?php if(! empty( $thumbnailHtml ) ): ?>
		</div> <? // Close media-text div when there's a thumbnail ?>
	<?php endif; ?>

</article>
</li>

