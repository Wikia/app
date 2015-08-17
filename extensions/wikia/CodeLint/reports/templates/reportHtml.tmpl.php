<!doctype html>
<html lang="en" dir="ltr">
<head>
	<meta charset="utf-8">
	<title>Code lint report</title>
	<style type="text/css">
		body {
			color: #333;
			font-family: sans;
			font-size: 12px;
		}

		a {
			color: #1f75Fe;
			font-weight: normal;
		}

		.report {
			background: #f9f9f9;
			border-collapse: collapse;
		}

		.report caption {
			font-size: 1.3em;
			text-align: left;
			line-height: 2em;
		}

		.report th {
			background: #eaeaea;
			color: #555;
			line-height: 2em;
			text-align: left;
		}

		.report tr {
			border: solid 1px #aaa;
			border-left: none;
			border-right: none;
			line-height: 1.5em;
		}

		.report .odd {
			background: #f5f5f5;
		}

		.report .important {
			background: #FFCF48;
		}

		.report .important.odd {
			background: #EFBF38;
		}

		.report td {
			padding: 2px 8px;
			vertical-align: top;
		}

		.report th {
			padding: 4px 8px;
		}

		.report thead th {
			background: #dedede;
			font-weight: bold;
			text-align: center;
		}

		address {
			line-height: 3em;
			color: #666;
		}

		/* toggling of important-only errors */
		#show-important:target tr {
			display: none;
		}
		#show-important:target tr.important {
			display: table-row;
		}
		.report caption a[href='#show-all'] {
			display: none;
		}
		.report caption a[href='#show-important'] {
			display: inline;
		}
		#show-important:target caption a[href='#show-all'] {
			display: inline;
		}
		#show-important:target caption a[href='#show-important'] {
			display: none;
		}
	</style>
</head>
<body>
	<table id="show-important" class="report" width="100%">
		<caption>
			Code lint report for <?= count($results) ?> file(s) / <?= $stats['errorsCount'] ?> issue(s) found (<?= $stats['importantErrorsCount'] ?> important ones)
			<div>
				<a href="#show-all">[Show all errors]</a>
				<a href="#show-important">[Show only important errors]</a>
			</div>
		</caption>
		<colgroup>
			<col width="25">
			<col width="*">
			<col width="100">
			<col width="200">
		</colgroup>
		<thead>
			<tr>
				<th>No</th>
				<th>Error</th>
				<th>Lines</th>
				<th>Blame</th>
			</tr>
		</thead>
		<tbody>
<?php
	foreach($results as $fileEntry) {

		// skip files without errors
		if ($fileEntry['errorsCount'] == 0) {
			continue;
		}

		$importantClass = '';
		foreach ($fileEntry['errors'] as $n => $entry) {
			if (!empty($entry['isImportant'])) {
				$importantClass = ' class="important"';
				break;
			}
		}
?>
			<tr<?= $importantClass ?>>
				<th colspan="3"><?= $fileEntry['fileChecked'] ?></th>
				<th><a href="<?= htmlspecialchars($fileEntry['blameUrl']) ?>">Blame</a></th>
			</tr>
<?php
		foreach ($fileEntry['errors'] as $n => $entry) {
			$className = !($n%2) ? 'odd' : '';

			if (!empty($entry['isImportant'])) {
				$className .= ' important';
			}

			$className = trim($className);
			$classAttr = ($className != '') ? ' class="' . $className .'"' : '';

			// link each line number to trac blame link
			$blameLinks = array();
			foreach ($entry['lines'] as $lineNo) {
				$blameLinks[] = Xml::element('a', array(
					'href' => "{$fileEntry['blameUrl']}#L{$lineNo}",
					'title' => 'Blame'
				), $lineNo);
			}
?>
			<tr<?= $classAttr ?>>
				<td><?= ($n+1) ?></td>
				<td><?= htmlspecialchars($entry['error']) ?></td>
				<td><?= implode(', ', $blameLinks) ?></td>
				<td><?= $entry['blame']['author'] ?> @ <a href="<?= CodeLint::GITHUB_ROOT ?>/commit/<?= $entry['blame']['rev'] ?>"><?= $entry['blame']['rev'] ?></a></td>
			</tr>
<?php
		}
	}
?>
		</tbody>
	</table>

	<address>Generated on <?= $stats['generationDate'] ?> in <?= $stats['totalTime'] ?> s<?= !empty($stats['tool']) ? " using {$stats['tool']}": '' ?></address>
</body>
</html>
