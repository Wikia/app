	<section id="wikia-global-hot-spots" class="module" style="" <?= $hidehotspots ?>>
		<h1><?php echo wfMsg('hub-hotspot-header', $data['title']) ?></h1>
		<?php
			if( $data['is_manager'] ) {
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
			<li class="<?php echo $dspl_type ?> <?php echo !empty($value['hide']) ? 'hide-blog':''; ?>">
				<div class="page-activity-badge">
					<div class="page-activity-level-<?php echo $value['level']; ?>">
						<?php
							echo wfMsgExt('hub-editors', 'parsemag', $wg->Lang->formatNum( $value['all_count'] ) ); ?>
					</div>
				</div>
				<span class="page-activity-sources">
					<a class="wikia-page-link" href="<?php echo $value['page_url'] ?>"><?php echo $value['page_name'] ?></a>
					<span>
						<span class="page-activity-wiki"><?php echo wfMsg('hub-hotspot-from') ?></span>
							<a class="wikia-wiki-link" href="<?php echo $value['wikiurl'] ?>"><?php echo $value['wikiname'] ?></a>
					</span>
				</span>
			</li>
			<?php endforeach; ?>

		</ol>
	</section><!-- END: #wikia-global-hot-spots -->
