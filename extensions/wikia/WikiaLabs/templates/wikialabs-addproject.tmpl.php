<h1> <?php echo wfMsg('wikialabs-add-project-title'); ?> </h1>
<form>
<input type="hidden" value="<?php echo $project->getId(); ?>" name="project[id]" id="projectId" >
<div class="addprjmodal" >
	<div id='errorBox' >
		<div id="wpError"></div>
	</div>
	<div class="image" >
		<button class="prjscreen" ><?php echo wfMsg('wikialabs-add-project-add-image'); ?> </button>
		<img class="prjscreen" id="projectPrjscreen" src="<?php echo isset($projectdata['prjscreenurl']) ? $projectdata['prjscreenurl']:($wgExtensionsPath . '/wikia/WikiaLabs/images/picture-placeholder.png') ?>" /> <br>
		<input class="prjscreen" name="project[prjscreen]" value="<?php echo isset($projectdata['prjscreen']) ? $projectdata['prjscreen']:'' ?>"  type="hidden" />
		<span><?php echo wfMsg('wikialabs-add-project-add-image-info'); ?></span>
	</div>

	<div class="label"><?php echo wfMsg('wikialabs-add-project-name') ?></div>
	<div class="input"><input value="<?php echo $project->getName(); ?>" name="project[name]" id="projectName" ></div>
	<div class="label"><?php echo wfMsg('wikialabs-add-project-link') ?></div>
	<div class="input">
		<input  value="<?php echo isset($projectdata['link']) ? $projectdata['link']:'' ?>" name="project[link]" id="projectLink" >
	</div>
	<div class="label"><?php echo wfMsg('wikialabs-add-project-description') ?></div>
	<div class="input">
		<textarea name="project[description]" id="projectDescription" ><?php echo isset($projectdata['description']) ? $projectdata['description']:'' ?></textarea>
	</div>

	<div class="label"><?php echo wfMsg('wikialabs-add-project-project') ?></div>
	<div class="input">
		<select name="project[extension]" id="projectExtension" >
			<?php foreach($extensions as $value): ?>
				<option <?php echo ($project->getExtension() == $value ? 'selected':'')  ?> value="<?php echo $value; ?>" ><?php echo $value; ?></option>
			<?php endforeach;?>
		</select>
	</div>

	<div class="label"><?php echo wfMsg('wikialabs-add-project-fogbugz-area') ?></div>
	<div class="input">
		<select name="project[area]" id="projectArea" >
			<?php foreach($areas as $area): ?>
				<option <?php echo ($project->getFogbugzProject() == $area['id'] ? 'selected':'')  ?> value="<?php echo $area['id']; ?>" ><?php echo $area['name']; ?></option>
			<?php endforeach;?>
		</select>
	</div>

	<div class="label"><?php echo wfMsg('wikialabs-add-project-status') ?></div>
	<div class="input">
		<input <?php echo $project->isGraduated() ? 'checked="checked"':'' ?> name="project[graduates]" id="projectGraduates" class="checkbox" type="checkbox" >
		<?php echo wfMsg('wikialabs-add-project-show-in-graduates') ?><br>
		<select name="project[status]" id="projectStatus" >
			<?php foreach($status as $key => $value): ?>
				<option <?php echo ($project->getStatus() == $key ? 'selected':'')  ?> value="<?php echo $key; ?>" ><?php echo $value; ?></option>
			<?php endforeach;?>
		</select>
	</div>
	<div class="label"><?php echo wfMsg('wikialabs-add-project-warning') ?></div>
	<div class="input">
		<input <?php echo empty($projectdata['enablewarning']) ? '':'checked="checked"' ?> name="project[enablewarning]" id="projectEnablewarning" class="checkbox" type="checkbox" >
		<?php echo wfMsg('wikialabs-add-project-enable-warning') ?>
		<br>
		<textarea name="project[warning]" id="projectWarning" ><?php echo isset($projectdata['warning']) ? $projectdata['warning']:'' ?></textarea>
	</div>

	<div class="buttons">
		<button id="saveProject" ><?php echo wfMsg('wikialabs-add-project-add-save'); ?> </button>
		<button id="cancelProject" class="secondary" type="button"><?php echo wfMsg('wikialabs-add-project-add-cancel'); ?> </button>
	</div>
</form>