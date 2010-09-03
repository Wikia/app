<?php
/**
 * @author Sean Colombo
 *
 * This class represents and ordered list of ranges.  For example, an
 * instance could hold the concept: (1, 5, everything between 7 and 1000 inclusive, 1002 to 1003 inclusive), etc.
 *
 * The immediate use of this class is to create a de-duplicated list of all of the id ranges which
 * need to be refreshed (in the manner done in the refreshLinks2 job) by all of the jobs in the job-queue.
 *
 * NOTE: For now this is class is only designed for positive-integers.  It would not work with decimals,
 * and while it might work as-is for negative-integers, it was not designed with them in mind, nor was that
 * functionality tested so it is very unlikely it would work perfectly for negative integers.
 *
 * TODO: Add a call to this function to our UnitTesting system somewhere.
 * RangeList::runUnitTests();
 */

class RangeList{
	// An array of ranges where the lower-bound of the range is the key and the upper-bound of the range is the value.
	// To be clear, when a single entry is put in, it would be both the lower-bound and the upper-bound.
	var $ranges = array();
	
	// Convenience wrapper for addRange on a single number.
	public function addPoint($number){
		$this->addRange($number, $number);
	}

	/**
	 * Adds a new value or range to the RangeList.
	 *
* TODO TODO TODO TODO: TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO
	 * TODO: Do a binary-search instead of a sequential-scan to find the surrounding
	 * ranges to examine.  This could be extremely important due to the number of times
	 * this function is called and how big the 'ranges' array will probably get during
	 * the use-case of the JobQueueOptimizer.
	 * Make sure all of the unit tests (in RangeList::runUnitTests() at the bottom of this
	 * class) still pass after this change.
* TODO TODO TODO TODO: TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO
	 *
	 */
	public function addRange($min, $max, $debug=false){
		ksort($this->ranges);
		$lowerBounds = array_keys($this->ranges);

		// Try to find the first lower-bound which is greater than or equal to 'min'
		$numRanges = count($lowerBounds);
		$foundExistingRange = false;
		$index = 0;
		if($debug){print "\tTrying to merge $min - $max range into $numRanges existing ranges.\n";}
		while((!$foundExistingRange) && ($index < $numRanges) &&
			  ( (!isset($prevLower)) || ($prevLower < $min) )
		){
			// For clarity, the terminology is min and max are for the new data, but
			// lower and upper are for the ranges we are examining.
			$lower = $lowerBounds[$index];
			$upper = $this->ranges[$lower];

			if($debug){print "\tComparing against $lower - $upper.\n";}
			if($lower >= $min){
				if($debug){print "\t$lower is greater than $min, so we'll attempt to store the range.\n";}
				$foundExistingRange = true;

				// If max is more than upper, then overwrite this whole range.
				if($max > $upper){
					// Replace the range since the old range falls completely within the new range.
					$this->ranges[$min] = $max;
					// Make sure to delete the previous the range (but they might have the same
					// lower-bound, so don't delete in that case).
					if($lower != $min){
						unset($this->ranges[$lower]);
					}

					if($debug){print "\tOverwrote $lower-$upper with $min-$max\n";}
				} else if($max < $lower){
					// If the max of the new range is lower than the lower of the old range, then this range must
					// fall completely between two existing ranges, so just add the new range.
					$this->ranges[$min] = $max;
					if($debug){print "\tAdded new range $min-$max\n";}
				} else if($lower != $min){
					$this->ranges[$min] = $upper;
					unset($this->ranges[$lower]);
					if($debug){print "\tSet new lower bound so that $lower-$upper was replaced with $min-$max\n";}
				}

				// Handle when the previous range had an upper greater than this min.
				if(isset($prevUpper) && $prevUpper > $min){
					// After this assignment, there are two (or more) overlapping ranges at this point.
					$this->ranges[$prevLower] = max($max, $prevUpper);
				}
			}

			//if($debug){print "\tPreparing to examine next range.\n";}
			$prevLower = $lower;
			$prevUpper = $upper;
			$index++;
		}
		if($foundExistingRange === false){
			if($debug){print "\tNo existing range was found that was greater than the range we're adding.\n";}
			if(count($lowerBounds) == 0){
				if($debug){print "\tRangeList is empty.  Adding this range as the first range.\n";}
				$this->ranges[$min] = $max;
			} else {
				$lastMin = $lowerBounds[count($lowerBounds)-1];
				$lastMax = $this->ranges[$lastMin];
				if($debug){print "\tChecking to see if $min - $max is completely a subset of $lastMin - $lastMax\n";}

				// At this point, the min/max range could be completely a subset of the last range in the list.
				if(! (($min > $lastMin) && ($max < $lastMax))){
					if($debug){print "\tNot a subset.  Adding $min - $max to the RangeList.\n";}
					
					// We've found a new range to add to the end of the list.
					$this->ranges[$min] = $max;
				}
			}
		}
		if($debug){print "\tDone adding ranges... assuring that the keys are still ordered.\n";}
		ksort($this->ranges); // we may have added another range, assure it is in the correct order now.
		if($debug){print "\tAbout to merge any overlapping/adjacent ranges.\n";}
		if($debug){print "\t".$this->toString()."\n";}

		// Clean up overlapping and adjacent ranges.
		$this->mergeRanges($debug);
		if($debug){print "\tDone merging ranges.\n";}
		if($debug){print "\t".$this->toString()."\n";}
	} // end addRange()

	/**
	 * Goes through the ranges and reduces them to be the fewest number of entries
	 * possible by merging overlapping and adjacent ranges.
	 */
	public function mergeRanges($debug=false){
		// Need to recreate the lowerBounds array now that there have been some new assignments.
		ksort($this->ranges); // there were changes, need to re-order
		$lowerBounds = array_keys($this->ranges);
		$numRanges = count($lowerBounds);

		$somethingWasChanged = false;
		for($cnt=0; $cnt < $numRanges; $cnt++){
			if(!isset($lastLower) || !isset($lastUpper)){
				$lastLower = $lowerBounds[$cnt];
				$lastUpper = $this->ranges[$lastLower];
			} else {
				$currLower = $lowerBounds[$cnt];
				$currUpper = $this->ranges[$currLower];

				// If this range overlaps the previous, combine them.
				if($debug){print "Testing if $lastLower-$lastUpper should merge with $currLower - $currUpper\n";}
				if(self::rangesShouldBeMerged($lastLower, $lastUpper, $currLower, $currUpper)){
					if($debug){print "MERGING\n";}
					$min = min($lastLower, $currLower);
					$max = max($lastUpper, $currUpper);

					// Merge the ranges in the results (delete both, then add the merged range).
					unset($this->ranges[$lastLower]);
					unset($this->ranges[$currLower]);
					$this->ranges[$min] = $max;
					$somethingWasChanged = true;

					// Update what this range is (for the next iteration).
					$currLower = $min;
					$currUpper = $max;
				}

				$lastLower = $currLower;
				$lastUpper = $currUpper;
			}
		}
		
		// Keep calling until everything is merged.
		if($somethingWasChanged){
			if($debug){
				print "Something was changed.  About to merge-again to make sure it all worked.\n";
				print "State after this merge and before the next: \n";
				print $this->toString()."\n";
			}
			$this->mergeRanges();
		} else if($debug){
			print "Nothing was merged.\n";
		}
	} // end mergeRanges()
	
	/**
	 * Returns true if the two ranges overlap at any point or are adjacent. If the
	 * ranges even share a boundary, they are considered to be overlapping.
	 * If the maximum value of the lower range is the integer one below the miniumum
	 * value of the higher range, then the ranges are considered to be adjacent.
	 */
	public static function rangesShouldBeMerged($min_first, $max_first, $min_second, $max_second){
		$shouldMerge = false;
		
		// Make sure that the minimums are actually lower than the maxes.
		if($min_first > $max_first){
			$temp = $max_first;
			$max_first = $min_first;
			$min_first = $temp;
		}
		if($min_second > $max_second){
			$temp = $max_second;
			$max_second = $min_second;
			$min_second = $temp;
		}

		// For simplicity, make the first range the one with the lower min.
		if($min_second < $min_first){
			$temp_min = $min_second;
			$temp_max = $max_second;
			$min_second = $min_first;
			$max_second = $max_first;
			$min_first = $temp_min;
			$min_second = $temp_max;
		}

		// Test to see if the ranges overlap.
		if($max_first >= $min_second){
			$shouldMerge = true;
		}
		
		// Test to see if the ranges are adjacent.
		if($max_first + 1 == $min_second){
			$shouldMerge = true;
		}

		return $shouldMerge;
	} // end rangesShouldBeMerged()

	/**
	 * Returns the number of distinct ranges in the list.
	 */
	public function numRanges(){
		return count($this->ranges);
	}
	
	/**
	 * Accessor which returns the associative array of ranges.
	 */
	public function getRanges(){
		// Part of the definition of this class is that the data is ordered, so
		// make sure to sort before returning the ranges.
		ksort($this->ranges);

		return $this->ranges;
	} // end getRanges()
	
	public function setRanges($rangeListArray){
		$this->ranges = $rangeListArray;
	} // end setRanges()

	/**
	 * Returns all of the integers that are in any of the ranges (the ranges are inclusive).
	 * This may be an extremely large result, so this function is recommended mainly for testing.
	 */
	public function getAllValues(){
		$retVal = array();
		ksort($this->ranges);
		foreach($this->ranges as $min=>$max){
			for($cnt=$min; $cnt<=$max; $cnt++){
				$retVal[] = $cnt;
			}
		}
		return $retVal;
	} // end getAllValues()

	/**
	 * Returns the sum of all of the numbers contained in the ranges.
	 */
	public function totalSizeOfAllRanges(){
		$sum =  0;
		foreach($this->ranges as $min=>$max){
			$sum += $max - $min + 1;
		}
		return $sum;
	}

	/**
	 * (Used for unit-testing).  Makes sure that the 'ranges' of this RangeList are exactly
	 * equal to the array passed in.
	 *
	 * Returns the number of tests failed (either 0 or 1).  So if the test was successful,
	 * this will return 0.
	 */
	public function assertEqualTo($exampleRange, $comment){
		$numFails = 0;
		// Test that they're the same.
		if(!self::array_identical($this->ranges, $exampleRange)){
			$numFails++;
			print "-----\nTEST FAILED. ";
			print "\nACTUAL: ";
			var_dump($this->ranges);
			print "\nEXPECTED: ";
			var_dump($exampleRange);
			print "\nCOMMENT: $comment\n";
			print "-----\n";
		} else {
			print "Test passed.\n";
		}
		return $numFails;
	}

	/**
	 * Outputs a human-readable version of the RangeList.
	 */
	public function toString(){
		ksort($this->ranges);

		$retVal = "";
		foreach($this->ranges as $min => $max){
			$retVal .= ($retVal==""?"":", ");
			if($min == $max){
				$retVal .= $min;
			} else {
				$retVal .= "$min-$max";
			}
		}
		$retVal = "($retVal)";

		return $retVal;
	}

	// From 'bishop' on PHP man page comments for comparators.
	public static function array_identical($a, $b) {
		return (is_array($a) && is_array($b) && array_diff_assoc($a, $b) === array_diff_assoc($b, $a));
	} // end array_identical()

	// Unit testing for addRange.  It's got a ton of opportunities for off-by-one errors.
	public static function runUnitTests(){
		print "Starting unit tests...\n";
		$numFails = 0;
		$rangeList = new RangeList();
		$rangeList->addRange(1, 1);
		$numFails += $rangeList->assertEqualTo(array(1 => 1), "Simple add.");
	
		$rangeList->addRange(3, 5);
		$numFails += $rangeList->assertEqualTo(array(1=>1, 3=>5), "Simple add of different range.");
		
		$rangeList->addRange(6, 6);
		$numFails += $rangeList->assertEqualTo(array(1=>1, 3=>6), "Merging of adjacents.");
		
		$rangeList->addRange(2, 2);
		$numFails += $rangeList->assertEqualTo(array(1=>6), "Merging of multiple adjacents at once.");
		
		$rangeList->addRange(4, 5);
		$numFails += $rangeList->assertEqualTo(array(1=>6), "Adding of a range that's already completely contained.");
		
		$rangeList->addRange(6, 8);
		$numFails += $rangeList->assertEqualTo(array(1=>8), "Adding overlapping range to right side.");
		
		$rangeList->addRange(10, 10);
		$numFails += $rangeList->assertEqualTo(array(1=>8, 10=>10), "Adding separate single item.");
		
		$rangeList = new RangeList();
		$rangeList->addRange(6, 7);
		$numFails += $rangeList->assertEqualTo(array(6=>7), "Adding simple range to empty RangeList.");
		
		$rangeList->addRange(2, 2);
		$numFails += $rangeList->assertEqualTo(array(2=>2, 6=>7), "Adding single entry away from a range.");
		$rangeList->addRange(5, 8);
		$numFails += $rangeList->assertEqualTo(array(2=>2, 5=>8), "Adding of a range which subsumes another.");
		
		$rangeList->addRange(3, 9);
		$numFails += $rangeList->assertEqualTo(array(2=>9), "Adding subsuming range w/a merge afterwards.");
		
		$rangeList = new RangeList();
		$rangeList->addRange(4, 7);
		$rangeList->addRange(3, 5);
		$numFails += $rangeList->assertEqualTo(array(3=>7), "Addition of a range overlapping left edge of range.");
		
		// Display summary.
		if($numFails == 0){
			print "All tests passed.\n";
		} else {
			print "$numFails TESTS FAILED! SEE DETAILS ABOVE!\n";
		}
	} // end test_addRange()
	
	/**
	 * This function is to help find problems in a dataset which has known-errors when being added to a RangeList.
	 */
	public static function test_exampleData(){
		$rangeList = new RangeList();
		$exampleData = array(
			7236, 242748, 298844, 460970, 474758, 480648, 501229, 512169, 518695,
			525959, 526874, 764498, 765675, 779359, 779361, 939362, 941241, 958663,
			1810544, 435681, 436434, 752887, 781363, 1822767, 1823062, 1823064, 1823069,
			1823074, 1823076, 1823081, 1823664, 1826151, 1826155, 1826162, 1826163,
			469566, 767737, 767741, 768008, 768047, 768060, 768064, 768069, 1519524,
			1814601, 1814608, 1814609, 1814611, 1814670, 1814671, 1814675, 1814680,
			1814684, 1814685, 1814686, 1814687, 1814688, 1814696, 1814601, 1814608,
			1814609, 1814611, 1814670, 1814671, 1814675, 1814680, 1814684, 1814685,
			1814686, 1814687, 1814688, 1814696, 1148148, 1148526, 1148533, 1149317,
			1149323, 1328278, 1382047, 1382048, 1434440, 1778992, 1779032, 1782040,
			1782302, 1784875, 1784878, 1778992, 1779032, 1782040, 1782302, 1784875,
			1784878, 1778992, 1779032, 1782040, 1782302, 1784875, 1784878, 1494721,
			1494722, 1778992, 1779032, 1782040, 1782302, 1784875, 1784878, 1494721,
			1494722, 1778992, 1779032, 1782040, 1782302, 1784875, 1784878, 1490732,
			1166101, 1440234, 1166101, 1440234, 1166101, 1440234, 1166101, 1440234,
			1166101, 1440234, 1166101, 1440234, 1166101, 1440234, 1166101, 1166101,
			1166101, 1166101, 1166101, 1166101, 525936, 1335358, 1522670, 1821834,
			880785, 1779032, 1778992, 1784875, 236640, 746473, 746475, 746478, 746481,
			746483, 746484, 746947, 761452, 769691, 773565, 781677, 781679, 789891,
			800303, 810903, 828358, 839866, 846610, 860057, 880928, 902117, 918220,
			934960, 952786, 973754, 995975, 1124800, 1147200, 1160679, 1162432, 1195372,
			1208913, 1436094, 1442521, 1517640, 1625563, 1800838, 1812148, 1826497,
			1444577, 1444631, 1128540, 1826364, 1826364, 242610, 1435182, 1830579,
			1493326, 788529, 788680, 1829623, 1826371, 766494, 1799531
		);

		$valuesAdded = array();

		$failed = false;
		foreach($exampleData as $currentId){
			$valuesAdded[] = $currentId;
			$rangeList->addPoint($currentId);
			asort($valuesAdded);

			//if($valuesAdded != $rangeList->getAllValues()){
			if(count(array_diff($rangeList->getAllValues(), $valuesAdded)) > 0){
				$failed = true;
				print "ERROR OCCURRED WHEN ADDING $currentId\n";
				print "RAW IDS ADDED:\n(".implode(", ", $valuesAdded).")\n";
				//print "ALL VALUES:\n(".implode(", ", $rangeList->getAllValues()).")\n";
				
				$prevRangeList = new RangeList();
				$prevRangeList->setRanges($prevRanges);
				print "PREV-RANGELIST:\n".$prevRangeList->toString()."\n";
				
				print "RANGELIST:\n".$rangeList->toString()."\n";
				
				print "Repeating last operation but in debug mode...\n";
				$prevRangeList->addRange($currentId, $currentId, false);
				print "RE-CALCULATED RANGELIST:\n".$prevRangeList->toString()."\n";
				break;
			}
			$prevRanges = $rangeList->getRanges();
		}

		if(!$failed){
			print "TEST PASSED.\n";
		}
	} // end test_exampleData()

} // end class RangeList


// TODO: REMOVE AFTER FIXING.
//RangeList::test_exampleData();
