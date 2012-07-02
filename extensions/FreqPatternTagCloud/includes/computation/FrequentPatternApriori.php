<?php

/**
 * Frequent Pattern Tag Cloud Plug-in
 * Frequent pattern algorithm 'Apriori'
 * 
 * @author Tobias Beck, University of Heidelberg
 * @author Andreas Fay, University of Heidelberg
 * @version 1.0
 */

include_once("FrequentPatternAlgorithm.php");
include_once("FrequentItemset.php");

class FrequentPatternApriori extends FrequentPatternAlgorithm {
	protected function computeFrequentItemsets(array $items, array $transactions, $minSupport) {
		$numTransactions = count($transactions);
		$allFrequentItemsets = array();
		
		if ($numTransactions == 0) {
			return array(); 
		}
		else {
		// Get all 1-frequent itemsets
		foreach ($items as $item) {
			$freq = 0;
			foreach ($transactions as $transaction) {
				if (in_array($item, $transaction)) {
					$freq++;
				}
			}
			
			if ((float)$freq / $numTransactions >= $minSupport) {
				$allFrequentItemsets[] = new FrequentItemset(array($item), (float)$freq / $numTransactions);
			}
		}
		
		// Now compute all k-frequent itemsets
		$freqK_1Itemsets = $allFrequentItemsets;
		while (count($freqK_1Itemsets) > 0) {
			$freqKItemsets = $this->generateCandidates($freqK_1Itemsets);
			
			$freqK_1Itemsets = array();
			
			// Check support for each candidate
			foreach ($freqKItemsets as $freqItemset) {
				$freq = 0;
				foreach ($transactions as $transaction) {
					$inArray = true;
					foreach ($freqItemset->getItems() as $item) {
						if (!in_array($item, $transaction)) {
							$inArray = false;
							break;
						}
					}
					
					if ($inArray) {
						$freq++;
					}
				}
				
				if ((float)$freq / $numTransactions >= $minSupport) {
					$freqItemset->setSupport((float)$freq / $numTransactions);
					$freqK_1Itemsets[] = $allFrequentItemsets[] = $freqItemset;
				} else {
					unset($freqItemset);
				}
			}
		}
		
		return $allFrequentItemsets;
		}
	}
	
	
	/**
	 * Generates k-frequent itemsets candidates
	 *
	 * @param array $freqK_1Itemsets Array of FrequentItemset
	 * @return array Array of FrequentItemset
	 */
	private function generateCandidates($freqK_1Itemsets) {
		$candidates = array();
		for ($a = 0; $a < count($freqK_1Itemsets); $a++) {
			$freqItemsetA = $freqK_1Itemsets[$a];
			
			for ($b = $a + 1; $b < count($freqK_1Itemsets); $b++) {
				$freqItemsetB = $freqK_1Itemsets[$b];
				
				// Check whether they have i=k-2 items in common
				$i = count($freqItemsetA->getItems()) - 1;
				if (array_slice($freqItemsetA->getItems(), 0, $i) == array_slice($freqItemsetB->getItems(), 0, $i)) {
					// Join both items by adding both tails
					$newFreqItemset = new FrequentItemset(array_merge($freqItemsetA->getItems(), array_slice($freqItemsetB->getItems(), $i, 1)), 0);
					
					// Check whether each other possible k-1 subset is frequent (i.e. in $freqK_1Itemsets)
					// Do this via deleting each of the items of the common prefix (the last two items can be ignored since we know via $freqItemsetA and $freqItemsetB already that they are frequent)
					$allSubsetsFrequent = true;
					for ($j = 0; $j < $i; $j++) {
						$subsetFrequent = false;
						foreach ($freqK_1Itemsets as $freqItemset) {
							$subFreqItemset = $newFreqItemset->getItems();
							array_splice($subFreqItemset, $j, 1);
							if ($subFreqItemset == $freqItemset->getItems()) {
								$subsetFrequent = true;
								continue;
							}
						}
						
						if (!$subsetFrequent) {
							$allSubsetsFrequent = false;
							break;
						}
					}
					
					// Identified frequent itemset is candidate
					if ($allSubsetsFrequent) {
						$candidates[] = $newFreqItemset;
					} else {
						unset($newFreqItemset);
					}
				}
			}
		}
		
		return $candidates;
	}
}
