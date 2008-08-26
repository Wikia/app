<li id="<?= $id ?>_wg" class="widget WidgetGamespot">
    <div id="<?= $id ?>" class="sidebar WidgetGamespot">
	<h1 id="<?= $id ?>_header"><a href="http://www.gamespot.com"><img style="float:left;" src="http://images.wikia.com/common/skins/quartz/gamespot/images/gamespot_logo_box.gif"/></a>&nbsp; updates</h1>
	<div id="<?= $id ?>_content" class="widgetGamespot widgetContent">
<ul>
<?php if (!count($data)): ?>
	<li>no updates available</li>
<?php else: ?>

	<?php $i = 0; ?>
	<?php foreach ($data as $row): ?>
		<li>
			<a href="<?php echo htmlspecialchars($row['gs_story_link']); ?>" title="<?php echo htmlspecialchars($row['headline']); ?>"><?php echo htmlspecialchars($row['headline']); ?></a>
			<br />
			<?php if (0 == $i): ?>
				<?php echo htmlspecialchars($row['deck']); ?>
				<div class="widgetGamespotDate">
					<?php echo wfTimestamp(TS_RFC2822, $row['post_date']); ?>
				</div>
			<?php endif; ?>
			<?php $i++; ?>
		</li>
	<?php endforeach; ?>

<?php endif; ?>
</ul>

<?php if (!empty($more)): ?>
	<a href="<?php echo htmlspecialchars($more); ?>">See more GameSpot Updates &raquo;</a>
<?php endif; ?>

</div></div></li>
