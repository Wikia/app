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
	
				<a class="wikia-button secondary feedback" data-id="<?php echo $value->getId(); ?>" >
					<img src="/extensions/wikia/WikiaLabs/images/star-inactive.png">
					<?php echo wfMsg('wikialabs-list-project-add-give-feedback'); ?>
				</a>
				
				<span class="active" >
					<a href="#" class="wikia-button secondary" ><?php echo $value->getActivationsNum(); ?></a><?php echo wfMsg('wikialabs-list-project-currently-active'); ?>
				</span>
				
				<span class="stars" >
					<?php for($i = 1; $i < 6; $i ++): ?> 
						<img data-index="<?php echo $i; ?>" src="<?= wfBlankImgUrl() ;?>"/>
					<?php endfor; ?>
					<span class="ratings" >
	    				1<br>ratings
	    			</span>
				</span>
			</span>
		</li>
	<?php endforeach; ?>
</ul>

<div style="display:none" id="feedbackmodal" class="feedbackmodal" >
	<form>
		<span class="title" ><?php echo wfMsg( 'wikialabs-feedback-title' ); ?></span>
		<span class="project" ><?php echo wfMsg( 'wikialabs-feedback-rating' ); ?></span>		
				
		<span class="stars" >
			<?php for($i = 1; $i < 6; $i ++): ?> 
				<img data-index="<?php echo $i; ?>" src="<?= wfBlankImgUrl() ;?>"/>
			<?php endfor; ?>
		</span>		
		<span class="comments" ><?php echo wfMsg( 'wikialabs-feedback-comments' ); ?></span>
		<textarea name="feedbacktext" class="feedbacktext" ></textarea>
		<input name="rating" class="rating" type="hidden"  />
		<button class="okbutton" ><?php echo wfMsg('wikialabs-feedback-submit'); ?></button>
	</form>
</div>
