<?php if( !empty($is_hide) &&  $is_hide): ?>
	<span class="hideInfoSpan" ><?php echo wfMsg('wikiafollowedpages-special-hidden'); ?></span>
	<form action="<?php echo $show_link; ?>" method="post" >
		<input type="hidden" value="1" name="show_followed" />
		<input class="secondary" type="submit" value="<?php echo wfMsg("wikiafollowedpages-special-hidden-unhide"); ?>" />
	</form>
<?php endif; ?>
<?php
	global $wgServer,$wgScript, $wgUser;
	$sk = RequestContext::getMain()->getSkin();
?>
<?php foreach ($data as $key => $value): ?>
	<?php if(empty($more)): ?>
		<h2 class="firstHeading"><?php echo wfMsg($value['ns'] , array("$1" => $value['count']) ) ?>

		</h2>
                <input type="hidden" id="count-<? echo $value['ns']; ?>" value="<?php echo $value['count'] ?>" />
		<ul id="<? echo $value['ns']; ?>" style="margin-top: 5px;" class="clearfix watched-list">
	<?php endif; ?>
	<?php foreach ($value['data'] as $key => $value2): ?>
		<li>
			<?php $title = Title::newFromText( $value2[1], $value2['wl_namespace'] ); ?>
			<?php if ($owner): ?>
			<a  class="ajax-unwatch" title="<?php echo $title->getPrefixedText() ?>" >
				<?php
				global $wgBlankImgUrl;
				?>
				<img alt="<?php echo wfMsg( 'wikiafollowedpages-special-delete-tooltip' ); ?>" class="<?= ( F::app()->checkSkin( 'oasis' ) ) ? 'sprite-small close' : 'sprite delete' ?>" id="" src="<?php print $wgBlankImgUrl; ?>"/>
			</a>
			<?php endif; ?>
			<span>
				<?php echo $sk->link( $title , $value2['wl_title'], array( 'class' => 'title-link' ) ); ?>
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
		<div style="clear: both; height:30px;text-align: right">
                    	<?php if($value['show_more']): ?>
				<a  id="more-<? echo $value['ns']; ?>" style="display:none;" class="ajax-show-more" href="<?php echo
$wgServer.$wgScript."?action=ajax&rs=FollowHelper::showAll&head=".$value['ns']."&user_id=".$user_id ?>"><?php echo
wfMsg('wikiafollowedpages-special-showmore'); ?></a>
			<?php endif;?>
                </div>
	<?php endif; ?>
<?php endforeach; ?>
