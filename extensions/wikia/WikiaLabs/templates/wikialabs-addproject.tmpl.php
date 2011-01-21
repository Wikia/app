<h1> <?php echo wfMsg('wikialabs-add-project-title'); ?> </h1>
<form>
<div class="addprjmodal" >
	<div id='errorBox'  class="display: block;" >
		<div id="wpError">You have not specified a valid user name.</div>
	</div>
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
		<select name="project[extension]" id="projectExtension" >
			<?php foreach($extensions as $value): ?>
				<option value="<?php echo $value; ?>" ><?php echo $value; ?></option>
			<?php endforeach;?>
		</select>
	</div>

	<div class="label"><?php echo wfMsg('wikialabs-add-project-fogbugz-area') ?></div>
	<div class="input">
		<select name="project[area]" id="projectArea" >
			<?php foreach($areas as $area): ?>
				<option value="<?php echo $area['id']; ?>" ><?php echo $area['name']; ?></option>
			<?php endforeach;?>
		</select>
	</div>

	<div class="label"><?php echo wfMsg('wikialabs-add-project-status') ?></div>
	<div class="input">
		<input name="project[graduates]" id="projectGraduates" class="checkbox" type="checkbox" >
		<?php echo wfMsg('wikialabs-add-project-show-in-graduates') ?><br>
		<select name="project[status]" id="projectStatus" >
			<?php foreach($status as $key => $value): ?>
				<option value="<?php echo $key; ?>" ><?php echo $value; ?></option>
			<?php endforeach;?>
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