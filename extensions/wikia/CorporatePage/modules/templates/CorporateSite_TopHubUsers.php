	<section id="hub-top-contributors"<?php echo $hidetopeditors ?>>
		<h1><?php echo wfMsg('hub-topusers-header', $data['title']) ?></h1>
		<?php
			global $wgUser;
			if( $wgUser->isAllowed( 'corporatepagemanager' ) ) {
				if( isset($data['var_feeds']['topeditors'] )) {
		?>
		<span class="toggleContainer" id="topeditors">[<a class="toggleFeed" href="#"><?php echo wfMsg('hide') ?></a>]</span>
		<?php
				} else {
		?>
		<span class="toggleContainer" id="topeditors">[<a class="toggleFeed" href="#"><?php echo wfMsg('unhide') ?></a>]</span>
		<?php
				}
			} else {

			}
		?>

		<p><?php echo wfMsg('hub-contributors-info') ?></p>

		<ul>
			<?php foreach( $data['topEditors'] as $value ): ?>
			<li>
				<?php if (isset($value['avatar'])) echo $value['avatar']; ?>
				<span class="topuser-info h2"><a href="<?php echo $value['userpage'] ?>"><?php echo $value['username'];	?></a></span>
				<span class="userEditPoints clearfix"><nobr  class="txt"><?php
					global $wgLang;
					echo wfMsgExt('hub-topusers-editpoints', 'parsemag', $wgLang->formatNum( $value['all_count'] ) ) ?></nobr></span>
			</li>
			<?php endforeach; ?>
		</ul>
	</section><!-- END: #hub-blogs -->
