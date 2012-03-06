<!-- single search result -->
<?php if(!is_object($result)) { var_dump($result); exit; } ?>
<?php if($result->hasCanonical()): ?>
	<strong><?=$debug?$pos.'. ':'';?><a href="<?= $result->getUrl(); ?>"><?=$result->getTitle();?></a></strong> (Redirect: <?=$result->getCanonical();?>)<br />
<?php else: ?>
	<strong><?=$debug?$pos.'. ':'';?><a href="<?= $result->getUrl(); ?>"><?=$result->getTitle();?></a></strong><br />
<?php endif; ?>
<div style="width: 80%">
	<?= $result->getText(); ?>
</div>
<?php if(empty($hideUrl)): ?>
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
