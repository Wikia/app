<?php if(empty($inGroup)): ?>
	<section class="Result">
<?php endif; ?>

<article>

	<?php if($result->getThumbnail() != null): ?>
		<?= $result->getThumbnail()->toHtml(array('desc-link'=>true)); ?>
	<?php endif; ?>
	
	<header>
		<h1>
			<?php $title = ( empty($inGroup) && $isInterWiki ) ? str_replace('$1', $result->getTitle(), $result->getVar('wikititle')) : $result->getTitle(); ?>
	
			<?php
				$trackingData = 'class="ResultLink" data-wid="'.$result->getCityId().'" data-pageid="'.$result->getVar('pageId').'" data-pagens="'.$result->getVar('ns').'" data-title="'.$result->getTitle().'" data-gpos="'.( !empty($gpos) ? $gpos : 0 ).'" data-pos="'.$pos.'" data-sterm="'.addslashes($query).'" data-stype="'.( $isInterWiki ? 'inter' : 'intra' ).'" data-rver="'.$relevancyFunctionId.'"' . ( $result->getVar('isArticleMatch') ? ' data-event="search_click_match"' : '' );
			?>
	
			<?= $debug ? $pos.'. ' : ''; ?><a href="<?= $result->getUrl(); ?>" <?=$trackingData;?> ><?= $title ?></a>
		</h1>
		<? if ($redirectTitle = $result->getVar('redirectTitle')): ?>
			<h2 class="redirect-title">&mdash; redirected from <a href="<?=$redirectTitle->getFullUrl()?>" <?=$trackingData?>><?= $redirectTitle->getText() ?></a></h2>
		<? endif; ?>
	</header>
	
	<?php if($debug): ?>
		<i>[<?php if(!empty($rank)): ?><font color="red">WikiRank: <?=$rank;?></font> | <?php endif; ?>Score: <?=$result->score?>]</i>
	<?php endif; ?>
	
	<?= $result->getText(); ?>
	
	<?php if(empty($inGroup)): ?>
		<nav>
			<ul>
				<li><a href="<?= $result->getUrl(); ?>" <?=$trackingData;?> ><?=$result->getUrl();?></a></li>
				<?php if($isInterWiki): ?>
					<li><a href="<?= $result->getVar('cityHost') .'/wiki/Special:Search?search='.urlencode($query).'&fulltext=Search'; ?>"><?= wfMsg( 'wikiasearch2-search-on-wiki') ?></a></li>
				<?php endif; ?>
			</ul>
		</nav>
	<?php endif; ?>
	
	<?php if($debug): ?>
		<i>[id: <?=$result->getId();?>, text_relevance: <?=$result->getVar('text_relevance', '?');?>, backlinks: <?=$result->getVar('backlinks', '?');?>]</i><br />
	<?php endif; //debug ?>

</article>

<?php if(empty($inGroup)): ?>
	</section>
<?php endif; ?>
