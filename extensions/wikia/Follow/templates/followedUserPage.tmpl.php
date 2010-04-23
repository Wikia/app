<h2 class="dark_text_2" id="userPageFallowedHead"> 

<span>
	<?php if($isLogin): ?>
		<a id="follow_hide_link" href="<?php echo $hideUrl; ?>">(<?php echo wfMsg('wikiafollowedpages-userpage-hide'); ?>)</a>
	<?php endif; ?>
</span> 

<?php echo wfMsg('wikiafollowedpages-userpage-heading'); ?>

</h2>
<?php if (!empty($data)): ?>
	<ul class="followedList followedListFirst" >
		<?php foreach($data as $value): ?>
			<li><a href="<?php echo $value['url']; ?>" ><?php echo $value['wl_title']; ?></a> </li>
		<?php endforeach; ?>
	</ul>
	<?php if (!empty($data2)): ?>
		<ul class="followedList" >
			<?php foreach($data2 as $value): ?>
				<li><a href="<?php echo $value['url']; ?>" ><?php echo $value['wl_title']; ?></a> </li>	
			<?php endforeach; ?>
		</ul> 
	<?php endif; ?>
	<div style="clear: both;"></div>
	<a id="follow_more_link" class="wikia-button" id="ShowMoreFollowed" href="<?php echo $moreUrl; ?>" rel="nofollow"><?php echo wfMsg('wikiafollowedpages-userpage-more'); ?></a>
<?php else: ?>
	<?php echo wfMsg( 'wikiafollowedpages-userpage-empty' );?>
<?php endif; ?>
