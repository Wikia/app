<ul class="wikiaLabsMainView">
	<?php foreach($projects as $value):   $data = $value->getData();  ?>
		<li>
			<img class="appScreen" src="<?php echo $data['prjscreenurl'] ?>">
			<span class='details' >
			 	<span class="prjname" ><?php echo $value->getName(); ?><span class="data"><?php echo $contLang->date($value->getReleaseDateMW()); ?></span> </span>
			 	<?php echo $data['description']; ?>
			</span>
			<span class='buttons'>
				<span data-id="<?php echo $value->getId(); ?>" class='slider <?php echo $value->isEnabled($cityId) ? "on":""; ?>'>
					<span class='button  <?php echo $value->isEnabled($cityId) ? "on":""; ?>'>
					</span>
					<span class="textoff  <?php echo $value->isEnabled($cityId) ? "on":""; ?>">inactive</span>
					<span class="texton  <?php echo $value->isEnabled($cityId) ? "on":""; ?>" >active</span>
					<?php if($data['enablewarning']): ?>
						<div class="warning" style="display:none" >
						<h1><?php echo wfMsg( 'wikialabs-list-project-warning' ); ?></h2>
							<?php echo $data['warning']; ?>
							<div class="buttons">
								<button type="button" class="secondary cancelbutton" id="cancelProject"><?php echo wfMsg('wikialabs-list-project-warning-cancel'); ?></button>
								<button class="okbutton" ><?php echo wfMsg('wikialabs-list-project-warning-ok'); ?></button>
							</div>
						</div>
					<?php endif;?>
				</span>

				<a class="wikia-button secondary feedback">
					<img src="/extensions/wikia/WikiaLabs/images/star-inactive.png">
					<?php echo wfMsg('wikialabs-list-project-add-give-feedback'); ?>
				</a>

				<span class="active" >
					<a href="#" class="wikia-button secondary" ><?php echo $value->getActivationsNum(); ?></a><?php echo wfMsg('wikialabs-list-project-currently-active'); ?>
				</span>

				<span class="stars" >
					<img src="/extensions/wikia/WikiaLabs/images/star-inactive.png"/>
					<img src="/extensions/wikia/WikiaLabs/images/star-inactive.png"/>
					<img src="/extensions/wikia/WikiaLabs/images/star-inactive.png"/>
					<img src="/extensions/wikia/WikiaLabs/images/star-active.png"/>
					<img src="/extensions/wikia/WikiaLabs/images/star-active.png"/>
					<span class="ratings" >
	    				1<br>ratings
	    			</span>
				</span>
			</span>
		</li>
	<?php endforeach; ?>
</ul>