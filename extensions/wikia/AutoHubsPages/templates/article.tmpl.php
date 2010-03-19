<?php wfSuppressWarnings(); ?>
<input type="hidden" id="autohubTagDB" name="autohubTagDB" value="<?php echo $data['tagname'] ?>" />
<h1 id="hub-name"><?php echo wfMsg('hub-header', $data['title']) ?></h1>

<div id="hub-featured-box">
	<section id="spotlight-slider">
		<ul>
		<?php //TODO: PROVIDE DATA ?>
		<?php foreach($data['slider'] as $key => $value): ?>

			<li id="spotlight-slider-<?php echo $key; ?>">
				<a href="<?php echo $value['href'] ?>">
					<img width="620" height="250" src="<?php echo $value['imagename'] ?>" class="spotlight-slider">
				</a>
				<div class="description">
					<h2><?php echo $value['title'] ?></h2>
					<p><?php echo $value['desc'] ?></p>
					<a href="<?php echo $value['href'] ?>" class="wikia-button secondary">
						<span><?php echo wfMsg('corporatepage-go-to-wiki',$value['title']); ?></span>
					</a>
				</div>
				<p class="nav">
					<img width="50" height="25" alt="" src="<?php echo $value['imagethumb'] ?>">
				</p>
			</li>
		<?php endforeach;?>
		</ul>
	</section><!-- END: #spotlight-slider -->

	<?php
	global $wgUser;
	$hidetopwikis = '';
	if( !$wgUser->isAllowed( 'corporatepagemanager' ) ) { // normal user that will have it disabled/enabled
		if( !$data['var_feeds']['topwikis'] ) {
			$hidetopwikis = 'class="hiddenSection"';
		}
	}
	?>
	
	<section id="hub-top-wikis"<?php echo $hidetopwikis ?>>
		<h1><?php echo wfMsg('hub-featured', $data['title']) ?></h1>
		<?php
			global $wgUser, $wgStylePath;	
			if( $wgUser->isAllowed( 'corporatepagemanager' ) ) {
				if( $data['var_feeds']['topwikis'] ) {
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

		<div id="top-wiki-info" style="display:none;">			
			<div class="shrinkwrap">
				<div id="stuff-it">&nbsp;</div>
				<div class="clearfix">
					<img src="<?php echo $data['topWikisOne']['logo']; ?>" />
	
					<div id="top-wiki-meta-box">
						<h2><?php echo $data['topWikisOne']['city_title']; ?></h2>
						<div id="center-me">
							<ul id="top-wiki-meta" class="clearfix">
								<li><span><?php echo number_format( $data['topWikisOne']['pages'] ); ?></span> <?php echo wfMsg('hub-featured-articles') ?></li>
								<li><span><?php echo number_format( $data['topWikisOne']['count'] ); ?> </span>  <?php echo wfMsg('hub-featured-pageviews') ?></li>
							</ul>
						</div>
					</div>																										
				</div>
			
			</div>
		</div>
	
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
							<?php if($value['hide']): ?>
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

</div><!-- END: #hub-featured-box -->

<div id="hub-side-box">
	<?php
	$hidetopblogs = '';
	if( !$wgUser->isAllowed( 'corporatepagemanager' ) ) { // normal user that will have it disabled/enabled
		if( !$data['var_feeds']['topblogs'] ) {
			$hidetopblogs = 'class="hiddenSection"';
		}
	}
	?>

	<section id="hub-blogs"<?php echo $hidetopblogs ?>>
		<h1><?php echo wfMsg('hub-blog-header', $data['title']) ?></h1>
		<?php
			if( $wgUser->isAllowed( 'corporatepagemanager' ) ) {
				if( $data['var_feeds']['topblogs'] ) {
	
		?>
		<span class="toggleContainer" id="topblogs">[<a class="toggleFeed" href="#"><?php echo wfMsg('hide') ?></a>]</span>
		<?php
				} else {
		?>
		<span class="toggleContainer" id="topblogs">[<a class="toggleFeed" href="#"><?php echo wfMsg('unhide') ?></a>]</span>
		<?php
				} 
			} else {
	
			}
		?>
			
		<ul id="hub-blog-articles">
			<?php foreach( $data['topBlogs'] as $value ): ?>
			<li class="clearfix <?php echo $value['hide'] ? 'hide-blog':''; ?>">
				<h2 class="hub-blog-artlink"><a href="<?php echo $value['page_url'] ?>"><?php echo $value['page_name'] ?></a></h2>
				<cite><?php echo $value['date']; ?> <span class="user-info"><a href="<?php echo $value['user_page'] ?>"><?php echo $value['user_name'] ?></a></span></cite>
				<div class="clearfix">
					<img src="<?php echo $value['logo'] ?>" class="blog-image" />
					<p><?php echo $value['description']; ?></p>
				</div>
				<p class="blog-jump">
					<a href="<?php echo $value['page_name'] ?>#blog-comments-ul"><img src="<?= $wgStylePath ?>/common/blank.gif" class="sprite talk" /> <span><?php echo wfMsg( 'hub-blog-comments', $value['all_count']) ?></span></a></p>
					<?php if( $data['is_menager']): ?>
						<?php if ($value['hide'] ): ?>
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

	<?php
	$hidehotspots = '';
	if( !$wgUser->isAllowed( 'corporatepagemanager' ) ) { // normal user that will have it disabled/enabled
		if( !$data['var_feeds']['hotspots'] ) {
			$hidehotspots = 'class="hiddenSection"';
		}
	}
	?>
	
	<section id="wikia-global-hot-spots"<?php echo $hidehotspots ?>>
		<h1><?php echo wfMsg('hub-hotspot-header', $data['title']) ?></h1>
		<?php
			if( $wgUser->isAllowed( 'corporatepagemanager' ) ) {
				if( $data['var_feeds']['hotspots'] ) {
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
						<strong><?php echo $value['all_count']; ?></strong>
						<span>editors</span>
					</div>
				</div>
				<span class="page-activity-sources">
					<a class="wikia-page-link" href="<?php echo $value['page_url'] ?>"><?php echo $value['page_name'] ?></a>
					<span>
						<span class="page-activity-wiki"><?php echo wfMsg('hub-hotspot-from') ?></span>
							<a class="wikia-wiki-link" href="<?php echo $value['wikiurl'] ?>"><?php echo $value['wikiname'] ?></a>
							<?php if( $data['is_menager']): ?>
								<?php if( $value['hide'] ): ?>
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


	<?php
	$hidetopeditors = '';
	if( !$wgUser->isAllowed( 'corporatepagemanager' ) ) { // normal user that will have it disabled/enabled
		if( !$data['var_feeds']['topeditors'] ) {
			$hidetopeditors = 'class="hiddenSection"';
		}
	}
	?>

	<section id="hub-top-contributors"<?php echo $hidetopeditors ?>>
		<h1><?php echo wfMsg('hub-topusers-header', $data['title']) ?></h1>
		<?php
			global $wgUser;
			if( $wgUser->isAllowed( 'corporatepagemanager' ) ) {
				if( $data['var_feeds']['topeditors'] ) {
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
				<?php echo $value['avatar'] ?>
				<span class="h2"><a href="<?php echo $value['userpage'] ?>"><?php echo $value['username'];	?></a></span>
				<span class="userEditPoints clearfix"><nobr><span class="userPoints"><?php echo $value['all_count'];	?></span><span class="txt"><?php echo wfMsg('hub-topusers-editpoints') ?></span></nobr></span>
			</li>
			<?php endforeach; ?>
		</ul>
	</section><!-- END: #hub-blogs -->
</div><!-- END: #hub-side-box -->
<div class="clear-fix"></div>