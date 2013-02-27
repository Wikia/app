<?php if(empty($inGroup)): ?>
	<li class="result">
<?php endif; ?>

<article>
	<?php 
	if ( $result['ns'] == NS_FILE ) {
		$thumbnailHtml = $result->getThumbnailHtml();
	}
	?>
	<?php if(! empty( $thumbnailHtml ) ): ?>
		<div class="grid-1 alpha"><?= $thumbnailHtml ?></div>
		<div class="media-text grid-2"> <? // Open media-text div when there's a thumbnail ?>
	<?php endif; ?>
	
	<h1>
		<?php $title = ( empty($inGroup) && $isInterWiki && empty( $result['isWikiMatch'] ) ) ? str_replace('$1', $result->getTitle(), $result->getVar('wikititle')) : $result->getTitle(); ?>

		<?php
			$trackingData = 'class="result-link" data-wid="'.$result->getCityId().'" data-pageid="'.$result->getVar('pageId').'" data-pagens="'.$result->getVar('ns').'" data-title="'.$result->getTitle().'" data-gpos="'.( !empty($gpos) ? $gpos : 0 ).'" data-pos="'.$pos.'" data-sterm="'.addslashes($query).'" data-stype="'.( $isInterWiki ? 'inter' : 'intra' ).'" data-rver="'.$relevancyFunctionId.'"' . ( $result->getVar('isArticleMatch') ? ' data-event="search_click_match"' : '' );
		?>

		<?= $debug ? $pos.'. ' : ''; ?><a href="<?= $result->getUrl(); ?>" <?=$trackingData;?> ><?= $title ?></a>
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
	<?= $result->getText(); ?>
	
	<?php if(empty($inGroup)): ?>
		<ul>
			<li><a href="<?= $result->getUrl(); ?>" <?=$trackingData;?> ><?=Language::factory($wg->ContentLanguage)->truncate($result->getTextUrl(), 90);?></a></li>
			<?php if($isInterWiki): ?>
				<li><a href="http://<?= $result['host'] .'/wiki/Special:Search?search='.urlencode($query).'&fulltext=Search'; ?>"><?= wfMsg( 'wikiasearch2-search-on-wiki') ?></a></li>
			<?php endif; ?>
		</ul>
	<?php endif; ?>
	
	<?php if($debug): ?>
		<i>[id: <?=$result->getId();?>, score: <?=$result->getVar('score', '?');?>, backlinks: <?=$result->getVar('backlinks', '?');?>, views: <?=$result->getVar('views', '?');?>]</i><br />
		<i>Categories: <?=implode(" | ", $result->getVar('categories', array("NONE")))?></i><br/>
	<?php endif; //debug ?>

	<?php if(! empty( $thumbnailHtml ) ): ?>
		</div> <? // Close media-text div when there's a thumbnail ?>
	<?php endif; ?>

</article>

<?php if(empty($inGroup)): ?>
	</li>
<?php endif; ?>
