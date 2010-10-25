<style type="text/css">
	#edit_enhancements_toolbar {
		margin: 5px 0;
		padding: 5px;
		clear: both;
		z-index: 1000;
	}
	#editform > .edit_enhancements_toolbar_fixed {
		position: fixed;
		bottom: 0px;
		margin: 0px !important;
		z-index: 500;
	}
	#editform > .edit_enhancements_toolbar_static {
		position: static;
		width: auto;
	}
	#edit_enhancements_toolbar ul {
		margin: 0;
	}
	#edit_enhancements_toolbar li {
		float: left;
		line-height: 25px;
		list-style: none;
		margin: 0 5px 0 0;
	}
	#editOptions #wpSummary {
		width: 200px !important;
	}
	#wpSave {
		min-width: 100px;
	}
	#wpDiff {
		cursor: pointer;
		margin: 0 0 0 0.5em !important;
	}
	#edit_enhancements_toolbar #scroll_down_arrow {
		font-weight: bold;
		width: 12px;
		cursor: pointer;
		float: right;
	}
</style>

<!--[if IE]>
<style type="text/css">
	/* RT #37691 */
	#wpSave {
		min-width: auto;
		padding-left: 15px;
		padding-right: 15px;
	}
</style>
<![endif]-->

<script type="text/javascript">
	$(function() {
		if($("#wpDiff").length > 0) {
			$('#wpDiff').addClass('secondary');
			$('.editHelp').prepend(' | ');
		}
	});
</script>

<div class="<?= ($skinname == 'SkinMonaco' ? 'accent clearfix' : '') ?>" id="edit_enhancements_toolbar">
	<ul>
		<li><?=$summary ?></div></li>
		<?php foreach($buttons as $value): ?>
			<li><?=$value ?></li>
		<?php endforeach; ?>
		<li class="minor"><?=$checkboxes['minor'] ?></li>
		<li><?=$checkboxes['watch'] ?></li>
		<?php if ($action != 'edit' || $undo) { ?>
		<li id="scroll_down_arrow"><span onclick="window.scrollTo(0,document.getElementById('editform').offsetTop);WET.byStr('EditEnhancements/scrollArrow');" title="<?= $arrowTitle ?>">&darr;</span></li>
		<?php } ?>
	</ul>
</div>
