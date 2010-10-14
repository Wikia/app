<!-- s:<?= __FILE__ ?> -->
<!-- MAIN-PAGE -->
<ul>
	<? if ( $displayAchievements ){ ?>
	<li>
		<a href="?feed=rss&type=RecentBadges">
			<?=wfMsg('partner-feed-earned-badges'); ?>
		</a>
	</li>
	<? } ?>
	<? if ( $displayBlogs ){ ?>
	<li>
		<a href="?feed=rss&type=RecentBlogPosts&listing=Recent posts">
			<?=wfMsg('partner-feed-recent-blog-posts'); ?>
		</a>
	</li>
	<? } ?>
	<? if ( $displayAchievements ){ ?>
	<li>
		<a href="?feed=rss&type=AchivementsLeaderboard">
			<?=wfMsg('partner-feed-achievements-leaderboard'); ?>
		</a>
	</li>
	<? } ?>
	<li>
		<a href="?feed=rss&type=RecentImages">
			<?=wfMsg('partner-feed-latest-images'); ?>
		</a>
	</li>
	<li>
		<a href="?feed=rss&type=HotContent&hub=tv">
			<?=wfMsg('partner-feed-hotcontent'); ?>
		</a>
	</li>
	<? if ( $displayBlogs ){ ?>
	<li>
		<a href="?feed=rss&type=RecentBlogComments&blogpost=user/post">
			<?=wfMsg('partner-feed-recent-blog-comments'); ?>
		</a>
	</li>
	<? } ?>
</ul>

<!-- END OF MAIN-PAGE -->
<!-- e:<?= __FILE__ ?> -->
