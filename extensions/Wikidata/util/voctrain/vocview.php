<?php
require_once("exercise.php");
require_once("functions.php");

class VocView {
	/** hack to Just Get A Question from current dmid, using Excercise class
	 * to do our factorying for us. 
	 * Obviously the factory code needs to be refactored to ElseWhere, but not on Sunday 
	 * :-P
	 * (Sun 15 Jun 2008)
	 */
	function getQuestion($dmid, $questionLanguages, $answerLanguages) {
		if (!$questionLanguages) 
			throw new Exception("Vocview: no question (original) languages provided!");

		if (!$answerLanguages) 
			throw new Exception("Vocview: no answer (translation) languages provided!");
		/* 3 men walked into a bar^wExercise
		 * fullset, fetcher, and subset
		 */

		/* our regular fetcher is provided by functions.php 
		 * I suppose if I were tidier, I could use fetchers for
		 * persistence
		 */
		$fetcher=new OWFetcher();

		/* fullset is a domdocument containing a <collection> of
		 * empty <defined-meanings/> (just their defined-meaning-id
		 * attribute is set)
		 * This format makes sense on some days, it's just
		 * massive nukular overkill today, specially since
		 * we only have 1 element :-P
		 * Still, if Exercise wants this as a dom, we can oblige.
		 */
		$xmlString="
			<collection>
				<defined-meaning defined-meaning-id=\"$dmid\" />
			</collection>
		";
		$xml=simplexml_load_string($xmlString);
		$fullset=dom_import_simplexml($xml)->ownerDocument;
		#et voila. 

		/* subset is a selection of stuff we are actually
		 * interested in, from the above, as an array of 
		 * dmid's .... Oh look! We have just one!
		 */
		$subset=array($dmid); #:-P
		#(ok, to be honest, it does also get auto-generated
		# from the fullset, if we say nothing... but
		# then where would the joke be? )

		#and we already had the fetcher.
		# So the fullset said to the fetcher: let's do this! 

		$exercise=new Exercise($fetcher, $fullset, $subset);
		$exercise->setQuestionLanguages($questionLanguages);
		$exercise->setAnswerLanguages($answerLanguages);
		
		# Ok, now let's see. which question did we need?
		# (and setting selfcheck to false)
		$question=$exercise->getQuestion($dmid, false);
		# Oh REALLY! And we needed to go through all that?
		
		#well, let's return it, before people start asking
		#more difficult questions.

		return $question;
		
	}



}

?>
