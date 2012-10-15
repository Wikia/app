<feed xmlns="http://www.w3.org/2005/Atom" xmlns:media="http://search.yahoo.com/mrss" xml:lang="<?=$language; ?>">
		<id><?=$feedId; ?></id>
		<title><?=$title; ?></title>
		<link rel="self" type="application/atom+xml" href="<?=$selfUrl; ?>"/>
		<link rel="alternate" type="text/html" href="<?=$url; ?>"/>
		<updated><?=$timeNow; ?></updated>
		<subtitle><?=$description; ?></subtitle>
		<generator>MediaWiki <?=$version; ?></generator>