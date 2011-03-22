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
				<a class='title' href="<?php echo $value['link']; ?>" ><?php echo $value['name']; ?></a>
				<?php echo $value['description'] ?>
				
				</div>
			</li>
			<?php endforeach; ?>
		</ul>
	</section>
<?php endif;?>