<div class='warningBox' >
	<?php if($isAdmin): ?>
		<?php echo wfMsg('wikialabs-list-project-warning-box'); ?>
	<?php else: ?>
		<?php echo wfMsg('wikialabs-list-project-warning-box-no-admin'); ?>
	<?php endif; ?>
</div>
<ul class="wikiaLabsMainView">
	<?php foreach($projects as $value):   $data = $value->getData();  ?>
		<li>
			<img class="appScreen" src="<?php echo $data['prjscreenurl'] ?>">
			<span class='details' >
			 	<h2 class="prjname" >
					<?php echo $value->getTextFor('name'); ?>
					<span class="data"><?php echo $lang->date($value->getReleaseDateMW()); ?></span>
			 	</h2>
				<?php echo $value->getTextFor('description'); ?>
			</span>
			<span class='buttons'>
				<?php if($isAdmin): ?>
					<span data-id="<?php echo $value->getId(); ?>" class='slider <?php echo $value->isEnabled($cityId) ? "on":""; ?>'>
						<span class='button  <?php echo $value->isEnabled($cityId) ? "on":""; ?>'></span>
						<span class="textoff  <?php echo $value->isEnabled($cityId) ? "on":""; ?>"><?php echo wfMsg('wikialabs-list-project-inactive'); ?></span>
						<span class="texton  <?php echo $value->isEnabled($cityId) ? "on":""; ?>" ><?php echo wfMsg('wikialabs-list-project-active'); ?></span>
						<span class="loading"></span>
						<?php if($data['enablewarning']): ?>
							<div class="warning" style="display:none" >
							<h1><?php echo wfMsg( 'wikialabs-list-project-warning' ); ?></h2>
								<?php echo $value->getTextFor('warning'); ?>
								<div class="buttons">
									<button type="button" class="secondary cancelbutton" id="cancelProject"><?php echo wfMsg('wikialabs-list-project-warning-cancel'); ?></button>
									<button class="okbutton" ><?php echo wfMsg('wikialabs-list-project-warning-ok'); ?></button>
								</div>
							</div>
						<?php endif;?>
					</span>
				<?php endif; ?>
				<a class="wikia-button secondary feedback" data-user-feedback="<?php echo $value->getRatingByUser( $userId ); ?>"  data-id="<?php echo $value->getId(); ?>" >
					<img src="<?= $wgExtensionsPath ?>/wikia/WikiaLabs/images/star-inactive.png">
					<?php echo wfMsg('wikialabs-list-project-add-give-feedback'); ?>
				</a>
				
				<span class="stars" >
					<?php for($i = 1; $i < 6; $i ++): ?>
						<?php if(round($value->getRating()) >= $i): ?>
							<img class="staractive" data-index="<?php echo $i; ?>" src="<?= wfBlankImgUrl() ;?>"/>
						<?php else: ?>
							<img data-index="<?php echo $i; ?>" src="<?= wfBlankImgUrl() ;?>"/>
						<?php endif; ?>
					<?php endfor; ?>
				</span>
				
				<span class="active" >
					<?php $numMsg = wfMsgExt('wikialabs-list-project-currently-active-on-wikis', array('parsemag'), $value->getActivationsNumFormated() ); ?>
					<?php if( $isWikiaLabsAdmin ): ?>
						<a href="<?php echo $wikilistUrl.'&project_id='.$value->getId(); ?>"><?php echo $numMsg; ?></a>
					<?php else: ?>
						<?php echo $numMsg; ?>
					<?php endif; ?>
				</span>
			</span>
		</li>
	<?php endforeach; ?>
</ul>

<div style="display:none" id="feedbackmodal" class="feedbackmodal" >
	<form>
		<div class='errorBox' >
			<div id="wpError"></div>
		</div>
		<h2 class="title" ><?php echo wfMsg( 'wikialabs-feedback-title' ); ?></h2>
		<p><?php echo wfMsg('wikialabs-feedback-we-love-getting-feedback'); ?></p>
		<span class="stars" >
			<?php echo wfMsg( 'wikialabs-feedback-rating' ); ?>
			<ul>
				<?php for($i = 1; $i < 6; $i ++): ?>
					<li><img data-index="<?php echo $i; ?>" src="<?= wfBlankImgUrl() ;?>"/></li>
				<?php endfor; ?>
			</ul>
		</span>
		<span class="categories" >
			<?php echo wfMsg( 'wikialabs-feedback-category' ); ?>
			<select name="feedbackcategory">
				<?php foreach($categories as $cat): ?>
					<option value="<?php echo $cat['priority']; ?>"><?php echo wfMsg($cat['msg']); ?></option>
				<?php endforeach; ?>
			</select>
		</span>
		<br class="clear" />
		<label class="comments" ><?php echo wfMsg( 'wikialabs-feedback-comments' ); ?></label>
		<textarea name="feedbacktext" class="feedbacktext" ></textarea>
		<button class="okbutton" ><?php echo wfMsg('wikialabs-feedback-submit'); ?></button>
	</form>
</div>
