<aside id="recentWikiActivity" class="recent-wiki-activity">
	<header><?= wfMessage('recent-wiki-activity-header'); ?></header>
	<ul>
		<? foreach ($changeList as $change): ?>
			<?
			if ( in_array( $change['type'], ['new', 'edit', 'delete'] ) ) {
				$message = wfMessage("recent-wiki-activity-{$change['type']}-details")
					->params(
						AvatarService::renderLink($change['username']),
						wfTimeFormatAgoOnlyRecent($change['timestamp'])
					)
					->text();
			} else {
				$message = wfTimeFormatAgoOnlyRecent($change['timestamp']);
			}
			?>
			<li>
				<a class="recent-wiki-activity-link" href="<?= $change['url']; ?>"><?= $change['title']?></a>
				<span><?= $message ?></span>
			</li>
		<? endforeach?>
	</ul>

	<?= Wikia::specialPageLink('WikiActivity', 'recent-wiki-activity-see-more', 'more') ?>
</aside>
