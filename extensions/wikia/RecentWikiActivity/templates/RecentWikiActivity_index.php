<section class="recent-wiki-activity">
	<header><?= wfMessage('oasis-activity-header'); ?></header>
	<ul>
		<? foreach ($changeList as $change): ?>
			<li>
				<a class="recent-wiki-activity-link" href="<?= $change['url']; // TODO articleComments & userprofile?>"><?= $change['title']?></a>
				<span>edited by <a  href="#">fdsfsdfas</a> 10 timeago</span>
			</li>
		<? endforeach?>
	</ul>

	<? if ( !empty( $userName ) ) :?>
		<?= Wikia::specialPageLink('Contributions/' . $userName, 'recent-wiki-activity-see-more', 'more') ;?>
	<? else: ?>
		<?= Wikia::specialPageLink('WikiActivity', 'recent-wiki-activity-see-more', 'more') ?>
	<? endif ;?>
</section>
