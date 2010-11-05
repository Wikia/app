<?php echo $wiki->city_description; ?>
<ul>
	<li>
		Wiki was created on <strong><?php echo $wiki->city_created ?></strong>
	</li>
	<li>
		Founder name: <strong><?php echo $user_name ?></strong> (id <?php echo $wiki->city_founding_user ?>)
			<? if($wiki->city_founding_user): ?>
			<sup><a href="<?php echo $wikiFactoryUrl; ?>/Metrics?founder=<?php echo urlencode($user_name); ?>">more by user</a></sup><? endif; ?>
	</li>
	<li>
		Founder email: <?php if( empty( $wiki->city_founding_email) ) :
			print "<i>empty</i>";
		else:
			print "<strong>" . $wiki->city_founding_email . "</strong>";
			print " <sup><a href=\"{$wikiFactoryUrl}/Metrics?email=". urlencode($wiki->city_founding_email) . "\">more by email</a></sup>";
		endif; ?>
	</li>
	<li>
		Tags: <?php if( is_array( $tags ) ): echo "<strong>"; foreach( $tags as $id => $tag ): echo "{$tag} "; endforeach; echo "</strong>"; endif; ?>
		<sup><a href="<?php echo "{$wikiFactoryUrl}/{$wiki->city_id}"; ?>/tags">edit</a></sup>
	</li>
	<?php if ($statuses[$wiki->city_public] == 'disabled') : ?><li>
		<div>Disabled reason: <?=wfMsg('closed-reason')?> (<?=$wiki->city_additional?>)</div>
	</li><?php endif ?>
</ul>
