<h2 class="dark_text_2" id="userPageFollowedHead"> 

<span>
	<?php if($isLogin): ?>
		<a id="follow_hide_link" href="<?php echo $hideUrl; ?>">(<?php echo wfMsg('wikiafollowedpages-userpage-hide'); ?>)</a>
	<?php endif; ?>
</span> 

<?php echo wfMsg('wikiafollowedpages-userpage-heading'); ?>

</h2>
<?php if (!empty($data)): ?>
	<ul class="followedList followedListFirst" >
		<?php 
		global $wgUser;
		$sk = $wgUser->getSkin();
		foreach($data as $value):
			$title = Title::newFromText( $value['wl_title'], $value['wl_namespace'] );
			if ( !$title->exists() ) continue;
		?>
			<li>
				<?php echo $sk->link( $title, $value['wl_title'] ); ?>
			</li>
		<?php endforeach; ?>
	</ul>
	<div style="clear: both;"></div>
	<a id="follow_more_link" class="wikia-button" id="ShowMoreFollowed" href="<?php echo $moreUrl; ?>" rel="nofollow"><?php echo wfMsg('wikiafollowedpages-userpage-more'); ?></a>
<?php else: ?>
	<?php echo wfMsg( 'wikiafollowedpages-userpage-empty' );?>
<?php endif; ?>
