<?php echo $wiki->city_description; ?>
<?php global $wgUser; ?>
<ul>
	<li>
		Wiki was created on <strong><?php echo $wiki->city_created ?></strong>
	</li>
	<li>
		Founder id: #<strong><?php echo $founder_id; ?></strong>
		<? if( !empty( $founder_id ) ): ?>
			<ul>
				<li>Current name:
					<strong><?php echo $founder_username ?></strong>
					<sup>
						<a href="<?php print $wikiFactoryUrl . "/Metrics?founder=". rawurlencode($founder_username) ?>">more by this username</a>
						<?php if( $wgUser->isAllowed( 'lookupuser' ) ): ?> |
							<a href="<?= Title::newFromText( "LookupUser", NS_SPECIAL)->getFullURL(array("target" => $founder_username)); ?>">lookup username</a>
						<?php endif; ?>
					</sup>
				</li>
				<li>Current email:
				<?php if( empty( $founder_usermail ) ) :?>
					<i>empty</i>
				<?php else: ?>
					<strong><?= $founder_usermail; ?></strong>
					<sup>
						<a href="<?= $wikiFactoryUrl; ?>/Metrics?email="<?php echo urlencode($founder_usermail); ?>">more by this email</a>
						<?php if( $wgUser->isAllowed( 'lookupuser' ) ): ?> |
							<a href="<?= Title::newFromText( "LookupUser", NS_SPECIAL)->getFullURL(array("target" => $founder_usermail)); ?>">lookup email</a>
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
				<a href="<?= $wikiFactoryUrl?>/Metrics?email="<?= urlencode($founder_email)?>">more by this email</a>
				<?php if( $wgUser->isAllowed( 'lookupuser' ) ): ?> |
					<a href="<?= Title::newFromText( "LookupUser", NS_SPECIAL)->getFullURL(array("target" => $founder_email)); ?>">lookup email</a>
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
