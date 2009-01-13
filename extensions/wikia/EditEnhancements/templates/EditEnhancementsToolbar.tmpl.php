<style type="text/css">
	#edit_enhancements_toolbar {
		margin: 5px 0;
		padding: 5px;
	}
	.edit_enhancements_toolbar_fixed {
		position: fixed;
		bottom: 0px;
		margin: 0px !important;
		z-index: 500;
	}

	* html .edit_enhancements_toolbar_fixed {
		position: absolute;
		top: expression( ((e=document.documentElement.scrollTop+document.documentElement.clientHeight)?e:document.body.scrollTop+document.documentElement.clientHeight) - 100  +'px') !important;
		left: 0 !important;
	}

	.edit_enhancements_toolbar_static {
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
