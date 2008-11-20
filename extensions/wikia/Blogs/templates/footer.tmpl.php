<div id="blog-footer">
	<ul>
		<li>
			<?php echo wfMsg("blog-last-edited", array( $edited ) ) ?>
		</li>
		<li>
<?php if ( $voting_enabled ): ?>
			<!-- stars rating / copied from Monaco skin -->
			<div id="star-rating-wrapper">
				<ul id="star-rating" class="star-rating">
					<li style="width: <?php echo $ratingPx ?>px;" id="current-rating" class="current-rating"><span><?= $rating ?>/5</span></li>
					<li><a class="one-star" id="star1" title="1/5"<?=$hidden_star?>><span>1</span></a></li>
					<li><a class="two-stars" id="star2" title="2/5"<?=$hidden_star?>><span>2</span></a></li>
					<li><a class="three-stars" id="star3" title="3/5"<?=$hidden_star?>><span>3</span></a></li>
					<li><a class="four-stars" id="star4" title="4/5"<?=$hidden_star?>><span>4</span></a></li>
					<li><a class="five-stars" id="star5" title="5/5"<?=$hidden_star?>><span>5</span></a></li>
				</ul>
				<span style="<?= ($voted ? '' : 'display: none;') ?>" id="unrateLink"><a id="unrate" href="#"><?= wfMsg( 'unrate_it' ) ?></a></span>
			</div>
<?php endif ?>
		</li>
	</ul>
</div>
