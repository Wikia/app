<?php $last_date = ''; ?>
<?php	foreach ($data as $row): ?>
	<?php echo tmpl_keep_track_of_ul_and_last_date($row['timestamp'], &$last_date); ?>
	<li>
		<?php if (0 == $row['old_revid']): ?>
			(diff)
		<?php else: ?>
			(<a href="http://<?php echo $row['wiki']; ?>/wiki/<?php echo $row['title']; ?>?curid=<?php echo $row['pageid']; ?>&diff=<?php echo $row['revid']; ?>&oldid=<?php echo $row['old_revid']; ?>">diff</a>)
		<?php endif; ?>
		<?php if (0 == $row['pageid']): ?>
			(hist)
		<?php else: ?>
			(<a href="http://<?php echo $row['wiki']; ?>/wiki/<?php echo $row['title']; ?>?curid=<?php echo $row['pageid']; ?>&action=history">hist</a>)
		<?php endif; ?>
		. .
		<?php if (array_key_exists('new', $row)): ?>N<?php endif; ?>
		<?php if (array_key_exists('minor', $row)): ?>m<?php endif; ?>
		(<?php echo preg_replace('/\.wikia\.com$/', '', $row['wiki']); ?>)
		<a href="http://<?php echo $row['wiki']; ?>/wiki/<?php echo $row['title']; ?>"><?php echo $row['title']; ?></a>;
		<?php global $wgLang; echo $wgLang->time(wfTimestamp(TS_MW, $row['timestamp']), true, true); ?>
		. .
		<!-- (+size) -->
		<!-- . . -->
		<a href="http://<?php echo $row['wiki']; ?>/wiki/User:<?php echo $row['user']; ?>"><?php echo $row['user']; ?></a>
		(<a href="http://<?php echo $row['wiki']; ?>/wiki/User_talk:<?php echo $row['user']; ?>">Talk</a>
		| <a href="http://<?php echo $row['wiki']; ?>/wiki/Special:Contributions/<?php echo $row['user']; ?>">contribs</a>
		| <a href="http://<?php echo $row['wiki']; ?>/wiki/Special:Blockip/<?php echo $row['user']; ?>">block</a>)
		<?php if (array_key_exists('comment', $row)): ?>(<?php echo htmlspecialchars($row['comment']); ?>)<?php endif; ?>
	</li>
<?php endforeach; ?>
<?php echo tmpl_keep_track_of_ul_and_last_date(null, &$last_date); ?>

<?php

function tmpl_keep_track_of_ul_and_last_date($timestamp, &$last_date)
{
	$output = '';
	if (empty($timestamp) && !empty($last_date))
	{
		$output .= '</ul>';
	} else
	{
		global $wgLang;
		$date = $wgLang->date(wfTimestamp(TS_MW, $timestamp), true, true);

		if ($last_date != $date)
		{
			if (!empty($last_date))
			{
				$output .= '</ul>';
			}
			$output .= "<h4>{$date}</h4>\n<ul class=\"special\">";

			$last_date = $date;
		}
	}

	return $output;
}

?>
