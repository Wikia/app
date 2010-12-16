<?php

$messages = array();
$messages['en'] = array (
			 'wgTrustVote' => 
			 "I believe this information is correct",
			 'wgTrustVoteDone' => "Thank you for your vote",
			 'wgTrustTabText' => "wikitrust", 
			 'wgTrustExplanation' => 
			 '{| border="1" cellpadding="5" cellspacing="0" style="background:lightgreen; color:black; margin-top: 10px; margin-bottom: 10px;" id="wt-expl"
  |-
  | The article text is colored according to how much it has been revised.  An orange background indicates new, unrevised, text;  white is for text that has been revised by many reputed authors.  If you click on a word, you will be redirected to the diff corresponding to the edit where the word was introduced.
  |-
  | The text color and origin are computed by [http://wikitrust.soe.ucsc.edu/ WikiTrust]; if you notice problems, you can submit a bug report [http://code.google.com/p/wikitrust/issues here].
  |}',
			 'wgNoTrustExplanation' => 
			 '{| border="1" cellpadding="5" cellspacing="0" style="background:lightgreen; color:black"
  |-
  | There is no trust information available for this text yet.
  |}',
			 'wgNotPartExplanation' => 
			 '{| border="1" cellpadding="5" cellspacing="0" style="background:lightgreen; color:black"
  |-
  | This page is not part of the trust experement yet.
  |}',
			 );
?>
