<?php
class DumpReader
{
	# 
	# open the index files and lookup the chunk.  Load article source.
	#
	static function load_article($title)
	{
		$article_wml = null;
		$results = self::index_search($title);
		if (count($results) > 0) {
			$archive_file = $results[0][0];
			$plaintext_offset = $results[0][1];
			$title = $results[0][2];

			$article_wml = self::load_all_data($title, $archive_file);
		} else {
			$article_wml = ""; //TODO or null?
		}
		$article_wml = htmlspecialchars_decode($article_wml);
		return $article_wml;
	}

	static function load_all_data($title, $file_name)
	{
		wfDebug("loading chunk [$file_name] to find article [$title]");
		$article_wml = "";
		$matches = array();
		$all_chunk_data = self::load_bz($file_name);
		if (preg_match("/<title>".preg_quote($title, '/')."<\/title>.*?<text[^>]*>(.*)/s",
				$all_chunk_data, $matches))
		{
			$all_chunk_data = $matches[1];
			while (isset($all_chunk_data)) {
				$end_pos = strpos($all_chunk_data, '</text>');
				if ($end_pos !== FALSE) {
					$article_wml .= substr($all_chunk_data, 0, $end_pos);
					break;
				}
				$article_wml .= $all_chunk_data;

				wfDebug('continuing into next bz2 chunk');
				$file_name = self::increment_file($file_name);
				$all_chunk_data = self::load_bz($file_name);
			}
		}
		return $article_wml;
	}

	#
	# open chosen bz2 split, decompress and return
	# TODO begin bzcat at chunk, let pipe load in the bg process.
	#
	static function load_bz($file_name)
	{
		global $wgOfflineWikiPath;
		$path = "$wgOfflineWikiPath/$file_name";
		if (strlen($file_name) < 1) return null; #strange that bzopen doesn't choke on dir.
		$bz = bzopen($path, "r");
		if (!$bz)  return null;

		$out = "";
		while ($bz && !feof($bz)) {
			$out .= bzread($bz, 8192);
		}
		bzclose($bz);
		return $out;
	}

	#
	# use the index files 
	#
	static function index_search($title)
	{
		$title = strtr($title, '_', ' ');
		$title = strtolower(trim($title));
		#wfDebug("looking up word [$title]");

		global $wgOfflineWikiPath;
		try {
			$indexer = new XapianFulltextIndex("$wgOfflineWikiPath/db");
			return $indexer->search($title);
		} catch (Exception $e) {
			wfDebug(__METHOD__.':'.$e->getMessage());
			return null;
		}
	}

	static function increment_file($fname)
	{
		// XXX assuming a lot
		$matches = array();
  // TODO fails on 99 ...
		if (preg_match('/(.*?)([1-9][0-9]*)(.*?)$/', $fname, $matches)) {
			$i = $matches[2];
			return preg_replace("/$i/", $i + 1, $fname);
		} else {
			wfDebug('Failed to grok your wiki-splits filename pattern');
			return false;
		}
	}
}
