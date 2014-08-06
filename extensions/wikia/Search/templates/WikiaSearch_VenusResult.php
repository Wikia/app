<section class="result">
	<div class="row">
		<?php if ( $result['ns'] == NS_FILE ) {
			$thumbnailHtml = $result->getThumbnailHtmlForVenus();
		}?>
		<?php if(! empty( $thumbnailHtml ) ): ?>
			<div class="thumbnail small-4 medium-3 large-3 columns">
				<div class="thumbnail-wrapper"><div class="image-wrapper"><?= $thumbnailHtml ?></div></div>
			</div>
			<div><? // Open media-text div when there's a thumbnail ?>
		<?php endif; ?>
		<section class="result-description small-6 medium-7 large-7 columns">
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
				<a href="<?= $href ?>"
					class="<?= $trackingData['classes']?>"
					data-pos="<?= $trackingData['data-pos']?>"
				><?= $title ?></a>
			</h1>

			<? if ($redirectTitle = $result->getVar('redirectTitle')): ?>
				<p class="redirect-title subtext">&mdash;
					<?= wfMessage( 'wikiasearch2-results-redirected-from' )->text() ?>
				</p>
				<a href="<?=$result->getVar('redirectUrl')?>"
					class="<?= $trackingData['classes']?>"
					data-pos="<?= $trackingData['data-pos']?>"
				><?= $result->getVar('redirectTitle') ?></a>
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
			<section class="body-text">
				<?= $result->getText(); ?>
			</section>

			<?php if(empty($inGroup)): ?>
				<div>
					<span><a href="<?= $result->getEscapedUrl(); ?>" <?='class="result-link subtext" data-pos="'.$pos.'"' . ( $result->getVar('isArticleMatch') ? ' data-event="search_click_match"' : '' );?> ><?=Language::factory($wg->ContentLanguage)->truncate($result->getTextUrl(), 90);?></a></span>
				</div>
			<?php endif; ?>
			<?php if(! empty( $thumbnailHtml ) ): ?>
		</section>
		</div> <? // Close media-text div when there's a thumbnail ?>
	<?php endif; ?>
	</div>
</section>

