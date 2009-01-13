<style type="text/css">
	#edit_enhancements_toolbar {
		margin: 5px 0;
		padding: 5px;
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
	#wpSummary {
		width: 200px !important;
	}
	#wpSave {
		min-width: 100px;
	}
</style>

<div class="color1 clearfix" id="edit_enhancements_toolbar">
	<ul>
		<li><?=$summary ?></div></li>
		<li><?=$buttons['save'] ?></li>
		<li><?=$buttons['preview'] ?></li>
		<li><?=$checkboxes['minor'] ?></li>
		<li><?=$checkboxes['watch'] ?></li>
	</ul>
</div>
