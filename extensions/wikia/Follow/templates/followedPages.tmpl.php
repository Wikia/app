<?php if( !empty( $is_hide ) &&  $is_hide): ?>
	<span class="hideInfoSpan" ><?= wfMessage( 'wikiafollowedpages-special-hidden' )->escaped(); ?></span>
	<form action="<?= $show_link; ?>" method="post" >
		<input type="hidden" value="1" name="show_followed" />
		<input class="secondary" type="submit" value="<?= wfMessage( 'wikiafollowedpages-special-hidden-unhide' )->escaped(); ?>" />
	</form>
<?php endif; ?>
<?php $sk = RequestContext::getMain()->getSkin(); ?>
<?php foreach ( $data as $key => $value ): ?>
	<?php if( empty( $more ) ): ?>
		<h2 class="firstHeading"><?= wfMessage( $value['ns'] , $value['count'] )->escaped() ?>

		</h2>
                <input type="hidden" id="count-<?= $value['ns']; ?>" value="<?= $value['count'] ?>" />
		<ul id="<?= $value['ns']; ?>" style="margin-top: 5px;" class="clearfix watched-list">
	<?php endif; ?>
	<?php foreach ( $value['data'] as $key => $value2 ): ?>
		<li>
			<?php $title = Title::newFromText( $value2[1], $value2['wl_namespace'] ); ?>
			<?php if ( $owner ): ?>
			<a class="ajax-unwatch" title="<?= htmlspecialchars( $title->getPrefixedText() ) ?>" >
				<?php
				global $wgBlankImgUrl;
				?>
				<img alt="<?= wfMessage( 'wikiafollowedpages-special-delete-tooltip' )->escaped(); ?>" class="<?= ( F::app()->checkSkin( 'oasis' ) ) ? 'sprite-small close' : 'sprite delete' ?>" id="" src="<?php print $wgBlankImgUrl; ?>"/>
			</a>
			<?php endif; ?>
			<span>
				<?php
				$title = !empty( $value2['wl_title_obj'] ) ? $value2['wl_title_obj'] : $title;
				echo $sk->link( $title, $value2['wl_title'], array( 'class' => 'title-link' ) );
				?>
				<?php if( !empty( $value2['by_user'] ) ): ?>
					<?= wfMessage( 'wikiafollowedpages-special-blog-by', $value2['by_user'] )->escaped() ?>
				<?php endif; ?>
				<?php if ( !empty( $value2['on_board'] ) ): ?>
					<?= wfMessage( 'wikiafollowedpages-special-board' )->rawParams( $value2['on_board'] )->escaped() ?>
				<?php endif; ?>
			</span>
			<?php if( !empty( $value2['other_namespace'] ) ): ?>
			<span class="otherNs">
					<?= wfMessage( 'wikiafollowedpages-special-namespace', $value2['other_namespace'] )->escaped() ?>
			</span>
			<?php endif; ?>
                </li>
	<?php endforeach; ?>
	<?php if( empty( $more ) ): ?>
		</ul>
		<div style="clear:both; height:30px; text-align:right;">
                    	<?php if( $value['show_more'] ): ?>
				<a data-ns="<?= $value['ns'] ?>" data-userid="<?= $user_id ?>" id="more-<?= $value['ns']; ?>" style="display:none;" class="ajax-show-more" href="#"><?=
wfMessage( 'wikiafollowedpages-special-showmore' )->escaped(); ?></a>
			<?php endif; ?>
                </div>
	<?php endif; ?>
<?php endforeach; ?>
