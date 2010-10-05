<script type="text/javascript">
	activity_tabs = new Array('all', 'media', 'create', 'tend', 'talk');
	function showTab (switch_tab) {
		for (i=0; i<activity_tabs.length; i++) {
			tab = activity_tabs[i];
			id = 'activity-list-' + tab;
	
			e = document.getElementById('activity-list-' + tab);

			if (tab == switch_tab) {
				e.style.display = 'block';
			} else {
				e.style.display = 'none';
			}
		}
	}
</script>

<div id="profile-activity-feed" class="uppBox">
	<h1 class="color1"><?= wfMsg( 'userprofilepage-recent-activity-title' ); ?></h1>
    <div id="activity-controls">
        <span><a href="#" onclick="showTab('all')">All</a></span>
        <span><a href="#" onclick="showTab('media')">Media</a></span>
        <span><a href="#" onclick="showTab('create')">Create</a></span>
        <span><a href="#" onclick="showTab('tend')">Tend</a></span>
        <span><a href="#" onclick="showTab('talk')">Talk</a></span>
    </div>
    <div id="activity-content">
        <!-- Stream content -->
        <?php foreach ($activityFeed['types'] as $type => $content) { ?>
        <div id="activity-list-<?= $type ?>"<?php if ($type != 'all') { ?> style="display: none"<?php } ?>>
			<?= $content ?>
		</div>
		<?php } ?>
    </div>
</div>