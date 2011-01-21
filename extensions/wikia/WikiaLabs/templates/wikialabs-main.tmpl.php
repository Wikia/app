<ul class="wikiaLabsMainView">
	<?php foreach($projects as $value):   $data = $value->getData();  ?>
		<li>
			<img class="appScreen" src="<?php echo $data['prjscreenurl'] ?>">
			<span class='details' >
			 	<span class="prjname" ><?php echo $value->getName(); ?><span class="data">Nov.11</span> </span>
			 	<?php echo $data['description']; ?>
			</span>
			<span class='buttons'>
				<span class='slider'>
					<span class='button'>
					</span> 
					<span class="textoff">inactive</span>
					<span class="texton" >active</span>
				</span>
	
				<a class="wikia-button secondary feedback">
					<img src="/extensions/wikia/WikiaLabs/images/star-inactive.png">
					<?php echo wfMsg('wikialabs-list-project-add-give-feedback'); ?>
				</a>
				
				<span class="active" >
					<a href="#" class="wikia-button secondary" >1</a>currently active
				</span>
				
				<span class="stars" >
					<img src="/extensions/wikia/WikiaLabs/images/star-inactive.png"/>
					<img src="/extensions/wikia/WikiaLabs/images/star-inactive.png"/>
					<img src="/extensions/wikia/WikiaLabs/images/star-inactive.png"/>
					<img src="/extensions/wikia/WikiaLabs/images/star-inactive.png"/>
					<img src="/extensions/wikia/WikiaLabs/images/star-inactive.png"/>
					<span class="ratings" >
	    				1<br>ratings
	    			</span>
				</span>
			</span>
		</li>
	<?php endforeach; ?>
</ul>