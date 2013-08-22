<li class="result">
	<article>
		<?php
		$thumbnailHtml = $result->getThumbnailUrl();
		$thumbTracking = 'data-pos="' . $pos . '" ' . ( $result->getVar('isArticleMatch') ?  'data-event="search_click_match"' : '' );
		?>
			<?php if(! empty( $thumbnailHtml ) ): ?>

				<a class="grid-1 alpha thumb-tracking" href="<?= $result->getUrl() ?>" title="<?= $result->getTitle() ?>" <?=
					$thumbTracking ?>>
					<img src="<?= $thumbnailHtml ?>" class="thumbimage"/>
				</a>
				<div class="media-text grid-2"> <? // Open media-text div when there's a thumbnail ?>

			<?php endif; ?>
			<h1>
				<?php $title = $result->getTitle(); ?>

				<?php
				$trackingData = 'class="result-link" data-pos="'.$pos.'"' . ( $result->getVar('isArticleMatch') ? ' data-event="search_click_match"' : '' );
				?>

				<a href="<?= $result->getUrl() ?>" <?= $trackingData ?> ><?= $title ?></a>
			</h1>
			<? if ($redirectTitle = $result->getVar('redirectTitle')): ?>
				<p class="redirect-title">&mdash; <?= wfMessage( 'wikiasearch2-results-redirected-from' )->text() ?> <a href="<?=$result->getVar('redirectUrl')?>" <?=$trackingData?>><?= $result->getVar('redirectTitle') ?></a></p>
			<? endif; ?>

			<? if ($result->getVar('ns') == NS_FILE): ?>
				<p class="subtle">
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
			<?= $result->getText() ?>

			<?php if(empty($inGroup)): ?>
				<ul>
					<li><a href="<?= $result->getUrl() ?>" <?=$trackingData?> ><?=Language::factory($wg->ContentLanguage)->truncate($result->getTextUrl(), 90)?></a></li>
				</ul>
			<?php endif; ?>

			<?php if(! empty( $thumbnailHtml ) ): ?>
		</div> <? // Close media-text div when there's a thumbnail ?>
	<?php endif; ?>

	</article>
</li>

