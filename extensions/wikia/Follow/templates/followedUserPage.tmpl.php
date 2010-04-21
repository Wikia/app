
<h2 class="dark_text_2" id="userPageFallowedHead"> 

<span>
	<?php if($isLogin): ?>
		<a href="<?php echo $hideUrl; ?>">(<?php echo wfMsg('wikiafollowedpages-userpage-hide'); ?>)</a>
	<?php endif; ?>
</span> 

<?php echo wfMsg('wikiafollowedpages-userpage-heading'); ?>

</h2>
<?php if (!empty($data)): ?>
	<ul class="fallowedList fallowedListFirst" >
		<?php foreach($data as $value): ?>
			<li><a href="<?php echo $value['url']; ?>" ><?php echo $value['wl_title']; ?></a> </li>
		<?php endforeach; ?>
	</ul>
	
	<ul class="fallowedList" >
		<?php foreach($data2 as $value): ?>
			<li><a href="<?php echo $value['url']; ?>" ><?php echo $value['wl_title']; ?></a> </li>
		<?php endforeach; ?>
	</ul> 
	<div style="clear: both;"></div>
	<a class="wikia-button" id="ShowMoreFollowed" href="<?php echo $moreUrl; ?>" rel="nofollow"><?php echo wfMsg('wikiafollowedpages-userpage-more'); ?></a>
<?php else: ?>
	<?php echo wfMsg( 'wikiafollowedpages-userpage-empty' );?>
<?php endif; ?>