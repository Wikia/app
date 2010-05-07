<?php if( !empty($is_hide) &&  $is_hide): ?>
	<span class="hideInfoSpan" ><?php echo wfMsg('wikiafollowedpages-special-hidden'); ?></span>
	<form action="<?php echo $show_link; ?>" method="post" >
		<input type="hidden" value="1" name="show_followed" />
		<input class="secondary" type="submit" value="<?php echo wfMsg("wikiafollowedpages-special-hidden-unhide"); ?>" />
	</form>
<?php endif; ?>
<?php
	global $wgServer,$wgScript, $wgUser;
	$sk = $wgUser->getSkin();
?>
<?php foreach ($data as $key => $value): ?> 
	<?php if(empty($more)): ?>	
		<h2 class="firstHeading"><?php echo wfMsg($value['ns'] , array("$1" => $value['count']) ) ?>
			<?php if($value['show_more']): ?>
				<a  id="more-<? echo $value['ns']; ?>" style="display:none;" class="ajax-show-more" href="<?php echo 
$wgServer.$wgScript."?action=ajax&rs=FollowHelper::showAll&head=".$value['ns']."&user_id=".$user_id ?>"><?php echo 
wfMsg('wikiafollowedpages-special-showall'); ?></a> 
			<?php endif;?>
		</h2> 
		<ul id="<? echo $value['ns']; ?>" style="margin-top: 5px;" class="clearfix watched-list">
	<?php endif; ?>
	<?php foreach ($value['data'] as $value2): ?>
		<li>
			<?php if ($owner): ?>
			<a  class="ajax-unwatch" href="<?php echo $value2['hideurl'] ?>" >
				<img alt="<?php echo wfMsg( 'wikiafollowedpages-special-delete-tooltip' ); ?>" class="sprite delete" id="" src="http://images1.wikia.nocookie.net/__cb20015/common/skins/common/blank.gif"/>
			</a> 
			<?php endif; ?>
			<span>
				<?php echo $sk->link( Title::newFromText( $value2['wl_title'], $value2['wl_namespace'] ), $value2['wl_title'], array( 'class' => 'title-link' ) ); ?>
				<?php if(!empty($value2['by_user'])): ?>
					<?php echo wfMsg('wikiafollowedpages-special-blog-by', array("$1" => $value2['by_user']) ) ?>
				<?php endif;?>		 
			</span>
			<?php if(!empty($value2['other_namespace'])): ?>
			<span class="otherNs" >
					<?php echo wfMsg('wikiafollowedpages-special-namespace', array("$1" => $value2['other_namespace']) ) ?>
			</span>
			<?php endif;?>		
		</li>
	<?php endforeach;?>	
	<?php if(empty($more)): ?>	
		</ul>
		<div style="clear: both; height:30px;"></div>
	<?php endif; ?>
<?php endforeach; ?>
