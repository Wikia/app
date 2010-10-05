	<section id="hub-top-wikis"<?php echo $hidetopwikis ?>>
		<h1><?php echo wfMsg('hub-featured', $data['title']) ?></h1>
		<?php
			global $wgUser, $wgStylePath;
			if( $wgUser->isAllowed( 'corporatepagemanager' ) ) {
				if( isset($data['var_feeds']['topwikis'] )) {
		?>
		<span class="toggleContainer" id="topwikis">[<a class="toggleFeed" href="#"><?php echo wfMsg('hide') ?></a>]</span>

		<?php
				} else {
		?>
		<span class="toggleContainer" id="topwikis">[<a class="toggleFeed" href="#"><?php echo wfMsg('unhide') ?></a>]</span>

		<?php
				}
			} else {

			}
		?>

		<div id="top-wikis-lists-box" class="clearfix">
			<ul id="top-wikis-list-1">
				<?php $lp = 1;?>
				<?php foreach ($data['topWikis1'] as $value): ?>
				<li class="clearfix  <?php echo $value['hide'] ? 'hide-blog':''; ?>">
					<span class="green-box"><?php echo $lp; ?></span>
					<div class="top-wiki-data">
						<h2><a href="<?php echo $value['city_url'] ?>" class="top-wiki-link"><?php echo $value['city_title'] ?></a></h2>
						<p><?php echo $value['city_description'] ?></p>
						<?php if( $data['is_menager']): ?>
							<?php if(isset($value['hide'])): ?>
								<a class="wikia-page-link head-hide-link" href="/index.php?action=ajax&rs=AutoHubsPagesHelper::hideFeed&type=city&tag_id=<?php echo $data['tag_id'] ?>&city_id=<?php echo $value['city_id'] ?>&dir=delete"><?php echo wfMsg('hub-show-feed'); ?></a>
							<?php else: ?>
								<a class="wikia-page-link head-hide-link" href="/index.php?action=ajax&rs=AutoHubsPagesHelper::hideFeed&type=city&tag_id=<?php echo $data['tag_id'] ?>&city_id=<?php echo $value['city_id'] ?>"><?php echo wfMsg('hub-hide-feed'); ?></a>
							<?php endif; ?>
						<?php endif; ?>
					</div>
				</li>
				<?php $lp ++;?>
				<?php endforeach ;?>
			</ul>

  	</div><!-- END: #top-wikis-lists-box -->

	</section><!-- END: #hub-top-wikis -->
