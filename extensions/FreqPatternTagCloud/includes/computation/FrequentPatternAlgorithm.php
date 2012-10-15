<?php

/**
 * Frequent Pattern Tag Cloud Plug-in
 * Interface for frequent pattern algorithms
 * 
 * @author Tobias Beck, University of Heidelberg
 * @author Andreas Fay, University of Heidelberg
 * @version 1.0
 */

include_once("FrequentPatternRule.php");

abstract class FrequentPatternAlgorithm {
	
	/**
	 * Checks and sets confidence of rule <code>$rule</code>
	 *
	 * @param FrequentPatternRule $rule 
	 * @param array $transactions 
	 * @param float $minConfidence
	 * @return mixed Confidence (float) if confidence >= minConfidence; false otherwise
	 */
	private function checkConfidence(FrequentPatternRule $rule, array $transactions, $minConfidence) {
		// To check confidence, one has to iterate over transactions
		$numerator = 0;
		$denominator = 0;
		foreach ($transactions as $transaction) {
			// For each occurence of the assumption -> increase denominator
			// If the conclusion occurs too -> increase numerator
			
			// Check if transaction contains assumption
			$assumptionContained = true;
			foreach ($rule->getAssumption() as $item) {
				if (!in_array($item, $transaction)) {
					$assumptionContained = false;
					break;
				}
			}
			
			if ($assumptionContained) {
				$denominator++;
				
				// Check if transaction also contains conclusion 
				$conclusionContained = true;
				foreach ($rule->getConclusion() as $item) {
					if (!in_array($item, $transaction)) {
						$conclusionContained = false;
						break;
					}
				}
				
				if ($conclusionContained) {
					$numerator++;
				}
			}
		}
		
		$confidence = $denominator == 0 ? 0 : ($numerator / $denominator);
		if ($confidence >= $minConfidence) {
			return $confidence;
		} else {
			return false;
		}
	}
	
	/**
	 * Computes frequent itemsets
	 *
	 * @param array $items 
	 * @param array $transactions 
	 * @param float $minSupport 
	 * @return array Array of FrequentItemset
	 */
	abstract protected function computeFrequentItemsets(array $items, array $transactions, $minSupport);
	
	/**
	 * Computes power set of itemset <code>$itemset</code>
	 *
	 * @param array $itemset 
	 * @return array $powerset, Array of arrays of items
	 */
	private function computePowerSet(array $itemset) {
	   	$count = count($itemset);
	   	$members = pow(2,$count);
	   	$powerset = array();
	   	for ($i = 0; $i < $members; $i++) {
	      	$b = sprintf("%0".$count."b",$i);
	      	$out = array();
	      	for ($j = 0; $j < $count; $j++) {
	         	if ($b{$j} == '1') {
	         		$out[] = $itemset[$j];
	         	}
	      	}
	      	if (count($out) >= 1) {
	         	$powerset[] = $out;
	      	}
	   }
	   return $powerset;
	}
	
	/**
	 * Computes rules
	 *
	 * @param array $items 
	 * @param array $transactions 
	 * @param float $minSupport 
	 * @param float $minConfidence 
	 * @return array Array of FrequentPatternRule
	 */
	public function computeRules(array $items, array $transactions, $minSupport, $minConfidence) {
		// Compute all frequent itemsets
		$frequentItemsets = $this->computeFrequentItemsets($items, $transactions, $minSupport);
		
		// Generate rules
		$rules = array();
		foreach ($frequentItemsets as $itemset) {
			if (count($itemset->getItems()) == 1) {
				// Only one subset
				continue;
			}
			
			// Generate subset A of X where X is frequent itemset such that A => (X-A)
			foreach ($this->computePowerSet($itemset->getItems()) as $subsetOfX) {
				if (count($subsetOfX) == 0 || $subsetOfX == $itemset->getItems()) {
					// Ignore empty set and identity
					continue;
				}
				
				// Check for confidence
				$rule = new FrequentPatternRule($subsetOfX, array_diff($itemset->getItems(), $subsetOfX), $itemset->getSupport());
				if (($confidence = $this->checkConfidence($rule, $transactions, $minConfidence)) !== false) {
					// Rule matches confidence -> add to output
					$rule->setConfidence($confidence);
					$rules[] = $rule;
				}
			}
		}
		
		return $rules;
	}
}
