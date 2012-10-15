<?php echo $wiki->city_description; ?>
<ul>
	<li>
		Wiki was created on <strong><?php echo $wiki->city_created ?></strong>
	</li>
	<li>
		Founder id: #<strong><?php echo $founder_id; ?></strong>
		<? if( !empty( $founder_id ) ): ?>
			<ul>
				<li>Current name: <?php 
					print "<strong>" . $founder_username . "</strong>";
					print " <sup><a href=\"{$wikiFactoryUrl}/Metrics?founder=". rawurlencode($founder_username) . "\">more by this username</a></sup>";
					?></li>
				<li>Current email: <?php 
				if( empty( $founder_usermail ) ) :
					print "<i>empty</i>";
				else:
					print "<strong>" . $founder_usermail . "</strong>";
					print " <sup><a href=\"{$wikiFactoryUrl}/Metrics?email=". urlencode($founder_usermail) . "\">more by this email</a></sup>";
				endif; ?></li>
			</ul>
		<? endif; ?>
	</li>
	<li>
		Founder email: <?php if( empty( $founder_email ) ) :
			print "<i>empty</i>";
		else:
			print "<strong>" . $founder_email . "</strong>";
			print " <sup><a href=\"{$wikiFactoryUrl}/Metrics?email=". urlencode($founder_email) . "\">more by this email</a></sup>";
		endif; ?>
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
