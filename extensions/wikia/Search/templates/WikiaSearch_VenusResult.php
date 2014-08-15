	<?php if ( $result['ns'] == NS_FILE ) {
		$thumbnailHtml = $result->getThumbnailHtmlForVenus();
	}?>
	<?php if(! empty( $thumbnailHtml ) ): ?>
	<li class="result-entry-file">
		<div class="result-thumbnail-wrapper">
			<div class="result-thumbnail"><div class="image-wrapper"><?= $thumbnailHtml ?></div></div>
		</div>
		<div class="result-thumbnail-description"><? // Open media-text div when there's a thumbnail ?>
	<?php else: ?>
		<li class="result-entry">
	<?php endif; ?>
		<h1 class="headline">
			<?php
				$title = $result->getTitle();
				$href = $result->getEscapedUrl();
				$classes = "result-link";
				$dataPos = $pos . ($result->getVar('isArticleMatch') ? ' data-event="search_click_match"' : '');
				$trackingData = [
					'classes' => $classes,
					'data-pos' => $dataPos
				];
				?>
				<a href="<?= $href ?>" class="<?= $trackingData['classes']?>" data-pos="<?= $trackingData['data-pos']?>"><?= $title ?></a>
		</h1>

		<? if ($redirectTitle = $result->getVar('redirectTitle')): ?>
			<p class="redirect-title subtext">&mdash;
				<?= wfMessage( 'wikiasearch2-results-redirected-from' )->text() ?>
			</p>
			<a href="<?=$result->getVar('redirectUrl')?>" class="<?= $trackingData['classes']?>" data-pos="<?= $trackingData['data-pos']?>"><?= $result->getVar('redirectTitle') ?></a>
		<? endif; ?>

		<? if ($result->getVar('ns') == NS_FILE): ?>
			<p class="subtext">
				<? if (!$result->getVar('created_30daysago')) : ?>
					<span class="timeago abstimeago " title="<?= $result->getVar('fmt_timestamp') ?>" alt="<?= $result->getVar('fmt_timestamp') ?>">&nbsp;</span>
				<? else : ?>
					<span class="timeago-fmt"><?= $result->getVar('fmt_timestamp') ?></span>
				<? endif; ?>
				<?php
					if ( $videoViews = $result->getVideoViews() ) {
						echo '&bull; '.$videoViews;
					}
				?>
			</p>
		<? endif; ?>
		<p class="body-text"><?= $result->getText(); ?></p>

		<?php if(empty($inGroup)): ?>
			<div>
				<a href="<?= $result->getEscapedUrl(); ?>" <?='class="result-link subtext" data-pos="'.$pos.'"' . ( $result->getVar('isArticleMatch') ? ' data-event="search_click_match"' : '' );?> ><?=Language::factory($wg->ContentLanguage)->truncate($result->getTextUrl(), 90);?></a>
			</div>
		<?php endif; ?>
			<?php if(! empty( $thumbnailHtml ) ): ?>
		</div> <? // Close media-text div when there's a thumbnail ?>
<?php endif; ?>
</li>
