<h1> <?php echo wfMsg('wikialabs-add-project-title'); ?> </h1>
<form>
<div class="addprjmodal" >	
	<div class="image" >
		<button class="prjscreen" ><?php echo wfMsg('wikialabs-add-project-add-image'); ?> </button>
		<img class="prjscreen" id="projectPrjscreen" src="/extensions/wikia/PageLayoutBuilder/images/picture-placeholder.png" /> <br>
		<input class="prjscreen" name="project[prjscreen]" value=""  type="hidden" />
		<span><?php echo wfMsg('wikialabs-add-project-add-image-info'); ?></span>
	</div>
		
	<div class="label"><?php echo wfMsg('wikialabs-add-project-name') ?></div>
	<div class="input"><input name="project[name]" id="projectName" ></div>
	<div class="label"><?php echo wfMsg('wikialabs-add-project-link') ?></div>
	<div class="input">
		<input name="project[link]" id="projectLink" >
	</div>
	<div class="label"><?php echo wfMsg('wikialabs-add-project-description') ?></div>	
	<div class="input">
		<textarea name="project[description]" id="projectDescription" ></textarea>
	</div>
	
	<div class="label"><?php echo wfMsg('wikialabs-add-project-project') ?></div>
	<div class="input">
		<select name="project[project]" id="projectProject" >
			<option> Project 1 </option>
			<option> Project 2 </option>
			<option> Project 3 </option>
		</select>
	</div>
	
	<div class="label"><?php echo wfMsg('wikialabs-add-project-fogbugz-area') ?></div>
	<div class="input">
		<select name="project[area]" id="projectArea" >
			<option value="1" > Area 1 </option>
			<option value="2" > Area 2 </option>
			<option value="3" > Area 3 </option>
		</select>
	</div>
	
	<div class="label"><?php echo wfMsg('wikialabs-add-project-status') ?></div>
	<div class="input">
		<input name="project[graduates]" id="projectGraduates" class="checkbox" type="checkbox" >		
		<?php echo wfMsg('wikialabs-add-project-show-in-graduates') ?><br>
		<select name="project[status]" id="projectStatus" >
			<option value="1" ><?php echo wfMsg('wikialabs-add-project-status-show') ?></option>
			<option value="2" ><?php echo wfMsg('wikialabs-add-project-status-hide') ?></option>
			<option value="3" ><?php echo wfMsg('wikialabs-add-project-status-hide-alow-to-inactive') ?></option>
			<option value="4" ><?php echo wfMsg('wikialabs-add-project-status-hide-and-inactive') ?></option>
		</select>
	</div>
	<div class="label"><?php echo wfMsg('wikialabs-add-project-warning') ?></div>
	<div class="input">
		<input name="project[enablewarning]" id="projectEnablewarning" class="checkbox" type="checkbox" > 
		<?php echo wfMsg('wikialabs-add-project-enable-warning') ?>
		<br>
		<textarea name="project[warning]" id="projectWarning" ></textarea>
	</div>
	<div class="buttons">
		<button id="saveProject" ><?php echo wfMsg('wikialabs-add-project-status-save'); ?> </button>
		<button id="cancelProject" class="secondary" type="button"><?php echo wfMsg('wikialabs-add-project-status-cancel'); ?> </button>
	</div>
</form>