<section class="ControlCenter" id="ControlCenter">
	<section class="control-center-content ">
		<div id="ControlCenterGeneral" style="display:<?= $tab == 'general' ? 'block' : 'none'?>">
			<section class="control-section wiki">
				<header>
					<h1><?= wfMsg("controlcenter-controls-wiki-header") ?></h1><span class="tooltip"></span>
				</header>
				<ul class="controls">
					<li class="control" data-tooltip="<?= wfMsg("controlcenter-control-page-layout-builder-tooltip") ?>">
						<div class="representation">
							<div class="icon"></div>
						</div>
						<?= wfMsg("controlcenter-control-page-layout-builder-label") ?>
					</li>
					<? for($i = 0; $i < 12; $i++) { ?>
						<li class="control" data-tooltip="This is <?= $i ?>">
							<div class="representation">
								<div class="icon"></div>
							</div>
							Theme Designer
						</li>
					<? } ?>
				</ul>
			</section>
			<section class="control-section community">
				<header>
					<h1><?= wfMsg("controlcenter-controls-community-header") ?></h1><span class="tooltip"></span>
				</header>
				<ul class="controls">
					<li class="control" data-tooltip="<?= wfMsg("controlcenter-control-user-list-tooltip") ?>" data-control="ListUsers">
						<span class="representation">
							<span class="icon"></span>
						</span>
						<?= wfMsg("controlcenter-control-user-list-label") ?>
					</li>
					<li class="control" data-tooltip="<?= wfMsg("controlcenter-control-user-rights-tooltip") ?>" data-control="UserRights">
						<div class="representation">
							<div class="icon"></div>
						</div>
						<?= wfMsg("controlcenter-control-user-rights-label") ?>
					</li>
					<li class="control" data-tooltip="<?= wfMsg("controlcenter-control-group-rights-tooltip") ?>">
						<div class="representation">
							<div class="icon"></div>
						</div>
						<?= wfMsg("controlcenter-control-group-rights-label") ?>
					</li>
					<li class="control" data-tooltip="<?= wfMsg("controlcenter-control-invite-tooltip") ?>">
						<div class="representation">
							<div class="icon"></div>
						</div>
						<?= wfMsg("controlcenter-control-invite-label") ?>
					</li>
				</ul>
			</section>
			<section class="control-section content">
				<header>
					<h1><?= wfMsg("controlcenter-controls-content-header") ?></h1><span class="tooltip"></span>
				</header>
				<ul class="controls">
					<li class="control" data-tooltip="<?= wfMsg("controlcenter-control-community-corner-tooltip") ?>">
						<a href="<?= $urlCommunityCorner ?>" class="set">
							<span class="representation">
								<span class="icon"></span>
							</span>
							<?= wfMsg("controlcenter-control-community-corner-label") ?>
						</a>
					</li>
					<li class="control" data-tooltip="<?= wfMsg("controlcenter-control-categories-list-tooltip") ?>" data-control="Categories">
						<span class="representation">
							<span class="icon"></span>
						</span>
						<?= wfMsg("controlcenter-control-categories-list-label") ?>
					</li>
					<? for($i = 0; $i < 4; $i++) { ?>
						<li class="control" data-tooltip="This is <?= $i ?>">
							<div class="representation">
								<div class="icon"></div>
							</div>
							Theme Designer
						</li>
					<? } ?>
				</ul>
			</section>
		</div>
		<section id="ControlCenterAdvanced" style="display:<?= $tab == 'advanced' ? 'block' : 'none'?>">
			Advanced section here
		</section>
		<section id="ControlCenterContentArea">
			Loading...
		</section>
	</section>
</section>