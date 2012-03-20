<!-- single search result -->
<?php if($result->hasCanonical()): ?>
	<?=$debug?$pos.'. ':'';?><a href="<?= $result->getUrl(); ?>"><?=$result->getTitle();?></a> (Redirect: <?=$result->getCanonical();?>)
<?php else: ?>
	<?=$debug?$pos.'. ':'';?><a href="<?= $result->getUrl(); ?>"><?=$result->getTitle();?></a>
<?php endif; ?>

<?php if(empty($inGroup) && ($result->getVar('cityHost', false) !== false)): ?>
	| <a href="<?= $result->getVar('cityHost') .'/wiki/Special:Search?search='.urlencode($query).'&fulltext=Search';?>"><?= wfMsg( 'wikiasearch2-search-on-wiki')?></a>
<?php endif; ?>


<?php if($debug): ?>
<br/>
<?php if(!empty($rank)): ?>
	<font color="red">WikiRank: <?=$rank;?></font> |
<?php endif; ?>
	Score: <?=$result->score?>
<?php endif; ?>

<br />
<div <?=empty($inGroup)?'class="searchresult"':'';?>>
	<?= $result->getText(); ?>
</div>
<?php if(empty($inGroup)): ?>
	<a href="<?= $result->getUrl(); ?>"><?=$result->getUrl();?></a><br />
<?php endif; ?>

<?php if($debug): ?>
	<?php
		switch($rankExpr) {
			case '-indextank':
				$rankValue = $result->getVar('rank_indextank');
				break;
			case '-bl':
				$rankValue = $result->getVar('rank_bl');
				break;
			case '-bl2':
				$rankValue = $result->getVar('rank_bl2');
				break;
			case '-bl3':
				$rankValue = $result->getVar('rank_bl3');
				break;
			default:
				$rankValue = '?';
		}
	?>
	<i>[id: <?=$result->getId();?>, text_relevance: <?=$result->getVar('text_relevance', '?');?>, backlinks: <?=$result->getVar('backlinks', '?');?>, rank: <?= $rankValue; ?>]</i><br />
<?php endif; //debug ?>
<br />
