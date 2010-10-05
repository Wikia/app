	<section id="hub-blogs"<?php echo $hidetopblogs ?>>
		<h1><?php echo wfMsg('hub-blog-header', $data['title']) ?></h1>
		<?php
			if( $wgUser->isAllowed( 'corporatepagemanager' ) ) {
				if( isset($data['var_feeds']['staffblogs'] )) {

		?>
		<span class="toggleContainer" id="staffblogs">[<a class="toggleFeed" href="#"><?php echo wfMsg('hide') ?></a>]</span>
		<?php
				} else {
		?>
		<span class="toggleContainer" id="staffblogs">[<a class="toggleFeed" href="#"><?php echo wfMsg('unhide') ?></a>]</span>
		<?php
				}
			} else {

			}
		?>

		<ul id="hub-blog-articles">
			<?php foreach( $data['staffBlogs'] as $value ): ?>
			<li class="clearfix <?php echo $value['hide'] ? 'hide-blog':''; ?>">
				<h2 class="hub-blog-artlink"><a href="<?php echo $value['page_url'] ?>"><?php echo $value['page_name'] ?></a></h2>
				<cite><?php echo $value['date']; ?> <span class="user-info"><a href="<?php echo $value['user_page'] ?>"><?php echo $value['user_name'] ?></a></span></cite>
				<div class="clearfix">
					<img src="<?php echo $value['logo'] ?>" class="blog-image" />
					<p><?php echo $value['description']; ?></p>
				</div>
				<p class="blog-jump">
					<a href="<?php echo $value['page_url'] ?>#blog-comments-ul"><img src="<?= wfBlankImgUrl() ?>" class="sprite talk" /> <span><?php
						global $wgLang;
						echo wfMsgExt( 'hub-blog-comments', 'parsemag', $wgLang->formatNum( $value['all_count']) ) ?></span></a></p>
					<?php if( $data['is_menager']): ?>
						<?php if (isset($value['hide'] )): ?>
							<a class="wikia-page-link head-hide-link" href="/index.php?action=ajax&rs=AutoHubsPagesHelper::hideFeed&type=blog&tag_id=<?php echo $data['tag_id'] ?>&city_id=<?php echo $value['city_id'] ?>&page_id=<?php echo $value['page_id'] ?>&dir=delete" ><?php echo wfMsg('hub-show-feed'); ?></a>
						<?php else: ?>
							<a class="wikia-page-link head-hide-link" href="/index.php?action=ajax&rs=AutoHubsPagesHelper::hideFeed&type=blog&tag_id=<?php echo $data['tag_id'] ?>&city_id=<?php echo $value['city_id'] ?>&page_id=<?php echo $value['page_id'] ?>" ><?php echo wfMsg('hub-hide-feed'); ?></a>
						<?php endif;?>
					<?php endif; ?>
					<div class="clear-fix"></div>
			</li>
			<?php endforeach; ?>
		</ul>
	</section><!-- END: #hub-blogs -->