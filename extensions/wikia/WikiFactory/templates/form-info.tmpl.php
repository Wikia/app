<?php echo $wiki->city_description; ?>
<ul>
	<li>
		Wiki was created on <strong><?= $wiki->city_created ?></strong>
	</li>
	<li>
		Founder id: #<strong><?= $founder_id; ?></strong>
		<? if( !empty( $founder_id ) ): ?>
			<ul>
				<li>Current name:
					<strong><?= $founder_username ?></strong>
					<sup>
						<a href="<?= $founder_metrics_url ?>">more by this username</a>
						<?php if(!empty( $lookupuser_by_founder_username_url )): ?> |
							<a href="<?= $lookupuser_by_founder_username_url ?>">lookup username</a>
						<?php endif; ?>
					</sup>
				</li>
				<li>Current email:
				<?php if( empty( $founder_usermail ) ) :?>
					<i>empty</i>
				<?php else: ?>
					<strong><?= $founder_usermail; ?></strong>
					<sup>
						<a href="<?= $founder_usermail_metrics_url ?>">more by this email</a>
						<?php if( !empty( $lookupuser_by_founder_usermail_url ) ): ?> |
							<a href="<?= $lookupuser_by_founder_usermail_url; ?>">lookup email</a>
						<?php endif; ?>
					</sup>
				<?php endif; ?>
				</li>
			</ul>
		<? endif; ?>
	</li>
	<li>
		Founder email:
		<?php if( empty( $founder_email ) ) : ?>
			<i>empty</i>
		<?php else: ?>
			<strong><?= $founder_email ?></strong>
			<sup>
				<a href="<?= $founder_email_metrics_url; ?>">more by this email</a>
				<?php if( !empty( $lookupuser_by_founder_email_url ) ): ?> |
					<a href="<?= $lookupuser_by_founder_email_url ?>">lookup email</a>
				<?php endif; ?>
			</sup>
		<?php endif; ?>
	</li>
	<li>
		Tags: <?php if( is_array( $tags ) ): echo "<strong>"; foreach( $tags as $id => $tag ): echo "{$tag} "; endforeach; echo "</strong>"; endif; ?>
		<sup><a href="<?php echo "{$wikiFactoryUrl}/{$wiki->city_id}"; ?>/tags">edit</a></sup>
	</li>
	<?php if ($wiki->city_public <= 0) : ?><li>
		<div>Disabled reason: <?php echo wfMsg('closed-reason')?> (<?php echo $wiki->city_additional?>)</div>
	</li><?php endif ?>
	<li>
		<?php $pstats = GlobalTitle::newFromText("PhalanxStats/wiki/" . $wiki->city_id, NS_SPECIAL, 177);
		print "<a href=\"". $pstats->getFullURL() ."\">Phalanx activity</a>\n"; ?>
	</li>
</ul>
