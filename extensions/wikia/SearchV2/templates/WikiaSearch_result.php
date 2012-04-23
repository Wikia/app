<!-- single search result -->
<?php if(empty($inGroup)): ?>
	<section class="Result">
<?php endif; ?>
<article>
<header>
<h1>
	<?php if($result->hasCanonical()): ?>
		<?= $debug ? $pos.'. ' : ''; ?><a href="<?= $result->getUrl(); ?>"><?= $result->getTitle(); ?></a> (Redirect: <?= $result->getCanonical(); ?>)
	<?php else: ?>
		<?= $debug ? $pos.'. ' : ''; ?><a href="<?= $result->getUrl(); ?>"><?= $result->getTitle(); ?></a>
	<?php endif; ?>
</h1>
</header>

<?php if($debug): ?>
	<i>[<?php if(!empty($rank)): ?><font color="red">WikiRank: <?=$rank;?></font> | <?php endif; ?>Score: <?=$result->score?>]</i>
<?php endif; ?>

<?= $result->getText(); ?>

<?php if(empty($inGroup)): ?>
	<nav>
		<ul>
			<li><a href="<?= $result->getUrl(); ?>"><?=$result->getUrl();?></a></li>
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
