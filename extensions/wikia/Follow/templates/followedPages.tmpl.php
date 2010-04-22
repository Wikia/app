<?php global  $wgServer,$wgScript;?>
<?php foreach ($data as $key => $value): ?> 
	<?php if(empty($more)): ?>	
		<h2 class="firstHeading"><?php echo wfMsg($value['ns'] , array("$1" => $value['count']) ) ?>
			<?php if($value['show_more']): ?>
				<a style="display:none;" class="ajax-show-more" href="<?php echo 
$wgServer.$wgScript."?action=ajax&rs=FollowHelper::showAll&head=".$value['ns']."&user_id=".$user_id ?>"><?php echo 
wfMsg('wikiafollowedpages-special-showall'); ?></a> 
			<?php endif;?>
		</h2> 
		<ul id="<? echo $key; ?>" style="margin-top: 5px;" class="clearfix watched-list">
	<?php endif; ?>
	<?php foreach ($value['data'] as $value2): ?>
		<li>
			<?php if ($owner): ?>
			<a  class="ajax-unwatch" href="<?php echo $value2['hideurl'] ?>" >
				<img alt="<?php echo wfMsg( 'wikiafollowedpages-special-delete-tooltip' ); ?>" class="sprite delete" id="" src="http://images1.wikia.nocookie.net/__cb20015/common/skins/common/blank.gif"/>
			</a>
			<?php endif; ?>
			<span>
				<a rel="nofollow" class="title" href="<?php echo $value2['url']; ?>"><?php echo $value2['wl_title']; ?></a>
				<?php if(!empty($value2['by_user'])): ?>
					<?php echo wfMsg('wikiafollowedpages-special-by',array("$1" => $value2['by_user']) ); ?>
				<?php endif;?>
				<?php if(!empty($value2['other_namespace'])): ?>
					(<?php echo $value2['other_namespace']; ?>)
				<?php endif;?>				 
			</span>
		</li>
	<?php endforeach;?>	
	<?php if(empty($more)): ?>	
		</ul>
		<div style="clear: both; height:30px;"></div>
	<?php endif; ?>
<?php endforeach; ?>
