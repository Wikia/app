<?php if($show): ?>
	<section class="FormCornerModule module WikiaLabsGraduates">
		<div class="size" ></div>
		<h1 class='title'>
			<img src="<?= $wgExtensionsPath ?>/wikia/WikiaLabs/images/graduated.png"/>
			<?php echo wfMsg( 'wikialabs-graduates-tile' ); ?>	
		</h1>
		<ul>
			<?php foreach($projects as $value): ?>
			<li>
				<img src="<?php echo $value['prjscreenurl'] ?>"  class="appScreen"/>
				<div>
					<?php if( $value['link'] === '#' ): ?>
						<span class="title"><?php echo $value['name']; ?></span>
					<?php else: ?>
						<a class='title' href="<?php echo $value['link']; ?>"><?php echo $value['name']; ?></a>
					<?php endif; ?>
					<p class='description'>
						<?php echo $value['description'] ?>
					</p>
				</div>
			</li>
			<?php endforeach; ?>
		</ul>
	</section>
<?php endif; ?>