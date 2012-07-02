<?php
class Bewertungen extends SpecialPage
{
	function Bewertungen() {
		SpecialPage::SpecialPage("Bewertungen");
	}
	
	function execute( $par ) {
		global $wgRequest, $wgOut;

		$this->setHeaders();

		# Get request data from, e.g.
		$param = $wgRequest->getText('param');

		# Do stuff
		$output = "Hier findet Ihr die Top 100 der Webseiten, für die Bewertungen abgegeben wurden.<p>
		<strong>Website (Bewertung 1-5 / Anzahl Stimmen)</strong><p>\n<ol>\n";

		$dbw = wfGetDB( DB_MASTER );

		$qr=$dbw->query("SELECT id, total_value/total_votes as rate, total_votes FROM ratings WHERE total_votes > 0 and total_value > 0 order by rate desc, total_votes desc, id limit 100;") or die("Error: ".mysql_error());
		$res = $qr->result;

		while(list($id, $rate, $votes) = mysql_fetch_row($res))
		{
			$id{0} = strtoupper($id{0});
			$output .= "<li><a href=\"/$id\">$id</a> ($rate / $votes)\n";
		}

		$output .= "</ol>\n";

		# Output
		$wgOut->addHTML( $output );
	}
}

