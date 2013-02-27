<li class="result">
	<article>
		<img src="" alt=""
		     class="wikiPromoteThumbnail" />
		<div>
			<h1>
				<?php /*$title = ( empty($inGroup) && empty( $result['isWikiMatch'] ) ) ? str_replace('$1',
$result->getTitle(), $result->getVar('wikititle')) : $result->getTitle();*/ ?>

				<?php $trackingData = 'class="result-link" data-wid="'.$result->getCityId().'" data-pageid="'
				.$result->getVar('pageId').'" data-pagens="'.$result->getVar('ns').'" data-title="'.$result->getTitle
			().'" data-gpos="'.( !empty($gpos) ? $gpos : 0 ).'" data-pos="'.$pos.'" data-sterm="'.addslashes($query).'" data-stype="'. 'inter' .'" data-rver="'.$relevancyFunctionId.'"' . ( $result->getVar('isArticleMatch') ? ' data-event="search_click_match"' : '' );
				?>

				<?= $debug ? $pos.'. ' : ''; ?><a href="<?= $result->getUrl(); ?>" <?=$trackingData;?> >Lorem ipsum
				Dolor<?//= $title ?></a>
			</h1>

			<!-- TODO: Do we need this in cross wiki search -->
			<? if ($redirectTitle = $result->getVar('redirectTitle')): ?>
				<p class="redirect-title">&mdash; <?= wfMessage( 'wikiasearch2-results-redirected-from' )->text() ?> <a href="<?=$redirectTitle->getFullUrl()?>" <?=$trackingData?>><?= $redirectTitle->getText() ?></a></p>
			<? endif; ?>
			<!-- end -->

			<p class="hub">GAMES</p>
			<p><?= $result->getText(); ?></p>
			<ul>
				<li><a href="<?= $result->getUrl(); ?>" <?=$trackingData;?> ><?=Language::factory($wg->ContentLanguage)->truncate($result->getTextUrl(), 90);?></a></li>
				<li><a href="http://<?= $result['host'] .'/wiki/Special:Search?search='.urlencode($query).'&fulltext=Search'; ?>"><?= wfMsg( 'wikiasearch2-search-on-wiki') ?></a></li>
			</ul>
			<ul class="wiki-statistics">
				<li>19k Pages</li>
				<li>12k Photos</li>
				<li>20 Videos</li>
			</ul>
		</div>

		<!-- TODO: Do we need this in cross wiki search -->
		<?php if($debug): ?>
		<i>[id: <?=$result->getId();?>, score: <?=$result->getVar('score', '?');?>, backlinks: <?=$result->getVar('backlinks', '?');?>, views: <?=$result->getVar('views', '?');?>]</i><br />
		<i>Categories: <?=implode(" | ", $result->getVar('categories', array("NONE")))?></i><br/>
		<?php endif; //debug ?>
		<!-- end -->

	</article>
</li>

