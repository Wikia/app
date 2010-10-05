	<section id="wikia-global-hot-spots" style="clear:both; float:none" <?php echo $hidehotspots ?>>
		<h1><?php echo wfMsg('hub-hotspot-header', $data['title']) ?></h1>
		<?php
			if( $wgUser->isAllowed( 'corporatepagemanager' ) ) {
				if( isset($data['var_feeds']['hotspots']) ) {
		?>
		<span class="toggleContainer" id="hotspots">[<a class="toggleFeed" href="#"><?php echo wfMsg('hide') ?></a>]</span>
		<?php
				} else {
		?>
		<span class="toggleContainer" id="hotspots">[<a class="toggleFeed" href="#"><?php echo wfMsg('unhide') ?></a>]</span>
		<?php
				}
			} else {

			}
		?>

		<p><?php echo wfMsg('hub-hotspot-info') ?></p>
		<ol>
			<?php 	$first_hot = true;
							$dspl_type = 'hilite';

			foreach( $data['hotSpots'] as $value ): $first_hot ? $first_hot = false : $dspl_type = ''; ?>
			<li class="<?php echo $dspl_type ?> <?php echo $value['hide'] ? 'hide-blog':''; ?>">
				<div class="page-activity-badge">
					<div class="page-activity-level-<?php echo $value['level']; ?>">
						<?php
							global $wgLang;
							echo wfMsgExt('hub-editors', 'parsemag', $wgLang->formatNum( $value['all_count'] ) ); ?>
					</div>
				</div>
				<span class="page-activity-sources">
					<a class="wikia-page-link" href="<?php echo $value['page_url'] ?>"><?php echo $value['page_name'] ?></a>
					<span>
						<span class="page-activity-wiki"><?php echo wfMsg('hub-hotspot-from') ?></span>
							<a class="wikia-wiki-link" href="<?php echo $value['wikiurl'] ?>"><?php echo $value['wikiname'] ?></a>
							<?php if( $data['is_menager']): ?>
								<?php if( isset($value['hide'] )): ?>
									<a class="wikia-page-link head-hide-link" href="/index.php?action=ajax&rs=AutoHubsPagesHelper::hideFeed&type=article&tag_id=<?php echo $data['tag_id'] ?>&city_id=<?php echo $value['city_id'] ?>&page_id=<?php echo $value['page_id'] ?>&dir=1" ><?php echo wfMsg('hub-show-feed'); ?></a>
								<?php else: ?>
									<a class="wikia-page-link head-hide-link" href="/index.php?action=ajax&rs=AutoHubsPagesHelper::hideFeed&type=article&tag_id=<?php echo $data['tag_id'] ?>&city_id=<?php echo $value['city_id'] ?>&page_id=<?php echo $value['page_id'] ?>" ><?php echo wfMsg('hub-hide-feed'); ?></a>
								<?php endif; ?>
							<?php endif; ?>
					</span>
				</span>
			</li>
			<?php endforeach; ?>

		</ol>
	</section><!-- END: #wikia-global-hot-spots -->
