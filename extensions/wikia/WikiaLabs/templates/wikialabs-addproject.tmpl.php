<h1> <?php echo wfMsg('wikialabs-add-project-title'); ?> </h1>
<form>
<div class="addprjmodal" >	
	<div class="image" >
		<button type="submit"><?php echo wfMsg('wikialabs-add-project-add-image'); ?> </button>
		<img class="appScreen" style="width: 150px" src="/extensions/wikia/PageLayoutBuilder/images/picture-placeholder.png" /> <br>
		<span><?php echo wfMsg('wikialabs-add-project-add-image-info'); ?></span>
	</div>
		
	<div class="label"><?php echo wfMsg('wikialabs-add-project-name') ?></div>
	<div class="input"><input name="name" id="projectName" ></div>
	<div class="label"><?php echo wfMsg('wikialabs-add-project-link') ?></div>
	<div class="input">
		<input name="link" id="projectLink" >
	</div>
	<div class="label"><?php echo wfMsg('wikialabs-add-project-description') ?></div>	
	<div class="input">
		<textarea name="description" id="projectDescription" ></textarea>
	</div>
	
	<div class="label"><?php echo wfMsg('wikialabs-add-project-project') ?></div>
	<div class="input">
		<select name="project" id="projectProject" >
			<option> Project 1 </option>
			<option> Project 2 </option>
			<option> Project 3 </option>
		</select>
	</div>
	
	<div class="label"><?php echo wfMsg('wikialabs-add-project-fogbugz-area') ?></div>
	<div class="input">
		<select name="area" id="projectArea" >
			<option> Area 1 </option>
			<option> Area 2 </option>
			<option> Area 3 </option>
		</select>
	</div>
	
	<div class="label"><?php echo wfMsg('wikialabs-add-project-status') ?></div>
	<div class="input">
		<input name="graduates" id="projectGraduates" class="checkbox" type="checkbox" >		
		<?php echo wfMsg('wikialabs-add-project-show-in-graduates') ?><br>
		<select name="project" id="projectStatus" >
			<option value="1" ><?php echo wfMsg('wikialabs-add-project-status-show') ?></option>
			<option value="2" ><?php echo wfMsg('wikialabs-add-project-status-hide') ?></option>
			<option value="3" ><?php echo wfMsg('wikialabs-add-project-status-hide-alow-to-inactive') ?></option>
			<option value="4" ><?php echo wfMsg('wikialabs-add-project-status-hide-and-inactive') ?></option>
		</select>
	</div>
	<div class="label"><?php echo wfMsg('wikialabs-add-project-warning') ?></div>
	<div class="input">
		<input name="enablewarning" id="projectEnablewarning" class="checkbox" type="checkbox" > 
		<?php echo wfMsg('wikialabs-add-project-enable-warning') ?>
		<br>
		<textarea name="warning" id="projectWarning" ></textarea>
	</div>
	<div class="buttons">
		<button type="submit"><?php echo wfMsg('wikialabs-add-project-status-save'); ?> </button>
		<button class="secondary" type="button"><?php echo wfMsg('wikialabs-add-project-status-cancel'); ?> </button>
	</div>
</form>