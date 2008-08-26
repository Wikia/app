<?php

if( php_sapi_name() != 'cli' ) {
	die("");
}

if( !isset( $argv[1] ) ) {
	die( "You must provide a vote log file on the command line.\n" );
}

$boardCandidates = array();
/*
$boardCandidates = array(	"John Doe" => "A",
							"Jane Doe" => "B",
							"Joe Bloggs" => "C",
							"John Smith" => "D",
							"A. N. Other" => "E" );
*/

$end = "-----END PGP MESSAGE-----";
$contents = file_get_contents( $argv[1] );
if( $contents === false ) {
	die( "Couldn't open input file.\n" );
}
$entries = explode( $end, $contents );

$infile = tempnam( "/tmp", "gpg" );
$outfile = tempnam( "/tmp", "gpg" );

if( !isset( $argv[2] ) ) {
	$votesfile = "results.txt";
} else {
	$votesfile = $argv[2];
}
$vfs = fopen( $votesfile, "w" );
fwrite( $vfs, "== Candidates ==\n" );
foreach ( $boardCandidates as $name => $index ) {
	fwrite( $vfs, "* Candidate " . $index . " : " . $name . "\n" );
}
fwrite( $vfs, "\n== Votes ==\n" );

foreach ( $entries as $i => $entry ) {
	$entry = trim( $entry.$end );

	if ( $entry == $end ) {
		continue;
	}
#	print "{{{$entry}}}\n\n";
	$file = fopen( $infile, "w" );
	fwrite( $file, trim( $entry ) . "\n" );
	fclose( $file );
	`gpg -q --batch --yes -do $outfile $infile`;
	$lines = file( $outfile );
	$ballot = process_line( $lines[0] );
	$ballots[ $i ] = $ballot;
	
	asort( $ballot );
	$vote = "# ";
	$aliasBallot =& $ballot;
	foreach( $aliasBallot as $cname => $crank ) {
		$vote .= $boardCandidates[ $cname ];
		
		$ncrank = current( $aliasBallot ); // current() return the next element for an array alias inside a foreach()
		if( $ncrank ) {
			$vote .= ( $crank < $ncrank ) ? "," : "";
		}
	}
	fwrite( $vfs, $vote . "\n" );
}

unlink( $infile );
unlink( $outfile );

$defeatMatrix = get_defeat_matrix( $ballots );

$wvMatrix = get_wv_matrix( $defeatMatrix );
$marginMatrix = get_margin_matrix( $defeatMatrix );

$beatpathWVMatrix = $wvMatrix;
$beatpathMMatrix = $marginMatrix;
get_wvm_beatpath_matrix( $beatpathWVMatrix, $beatpathMMatrix );

$orderedCandidates = sort_candidate_by_wins( $boardCandidates, $beatpathWVMatrix, $beatpathMMatrix );

### Output results ###
fwrite( $vfs, "== Pairwise defeats matrix ==\n" );
output_table( $vfs, $defeatMatrix );
fwrite( $vfs, "\nFor the above table, a row beats a column by N votes.\n\n" .
	"== Strengths of the direct paths ==\n=== Winning votes ===\n" );
output_table( $vfs, $wvMatrix );
fwrite( $vfs, "\n=== Margins ===\n" );
output_table( $vfs, $marginMatrix );
fwrite( $vfs, "\n== Strengths of the strongest paths ==\n=== Winning votes ===\n" );
output_table( $vfs, $beatpathWVMatrix );
fwrite( $vfs, "\n=== Modified Margins ===\n" );
output_table( $vfs, $beatpathMMatrix );
fwrite( $vfs, "\n== Ranked results ==\n" );
array_flip( $orderedCandidates );
foreach ( $orderedCandidates as $winner => $l ) {
	fwrite( $vfs, "# " . $winner . "\n" );
}

fclose( $vfs );

#-----------------------------------------------------------

function process_line( $line ) {
	$importantBit = substr( $line, strpos( $line, ":" ) + 1 );
	$set = array_map( "trim", explode( ",", $importantBit ) );

	foreach ( $set as $i ) {
		$rank = substr( $i, strpos( $i, "[" ) + 1 );
		$rank = substr( $rank, 0, -1 );
		
		$ballot[ substr( $i, 0, -( strlen( $rank ) + 2 ) ) ] = (int)$rank;
		//                                          ^^^
		//                                        '[',']'
	}

	return $ballot;
}

function get_defeat_matrix( $ballots ) {
	global $boardCandidates;
	foreach ( $boardCandidates as $c => $ci ) {
		foreach ( $boardCandidates as $opp => $oi ) {
			$defeats[ $c ][ $opp ] = 0;
		}
	}
	
	foreach ( $ballots as $ballot ) {
		foreach ( $ballot as $candidate => $rank ) {
			foreach ( $ballot as $opponent => $oppRank ) {
				if ( $candidate != $opponent ) {
					if ( $rank < $oppRank ) {
						$defeats[ $candidate ][ $opponent ]++;
					}
				}
			}
		}
	}
	
	return $defeats;
}

function get_wv_matrix( $defeats ) {
	global $boardCandidates;
	foreach ( $boardCandidates as $c => $ci ) {
		foreach ( $boardCandidates as $opp => $oi ) {
			$matrix[ $c ][ $opp ] = 0;
		}
	}
	
	foreach ( $defeats as $candidate => $opponents ) {
		foreach ( $opponents as $opponent => $votes ) {
			if ( $candidate != $opponent ) {
				if ( $votes > $defeats[ $opponent ][ $candidate ] ) {
					$matrix[ $candidate ][ $opponent ] = $votes;
					$matrix[ $opponent ][ $candidate ] = 0;
				}
			}
		}
	}
	
	return $matrix;
}

function get_margin_matrix( $defeats ) {
	global $boardCandidates;
	foreach ( $boardCandidates as $c => $ci ) {
		foreach ( $boardCandidates as $opp => $oi ) {
			$matrix[ $c ][ $opp ] = 0;
		}
	}

	foreach ( $defeats as $candidate => $opponents ) {
		foreach ( $opponents as $opponent => $votes ) {
			if ( $candidate != $opponent ) {
				if ( $votes > $defeats[ $opponent ][ $candidate ] ) {
					$matrix[ $candidate ][ $opponent ] = $votes - $defeats[ $opponent ][ $candidate ];
					$matrix[ $opponent ][ $candidate ] = 0;
				}
			}
		}
	}
	
	return $matrix;
}

function get_beatpath_matrix( $pairwise ) {
	foreach ( $paths as $c => $opps ) {
		foreach ( $opps as $opp => $dummy1 ) {
			if ( $c != $opp ) {
				foreach ( $opps as $k => $dummy2 ) {
					if ( ( $c != $k ) && ( $opp != $k ) ) {
						$paths[ $opp ][ $k ] = max( $paths[ $opp ][ $k ],
													min( $paths[ $opp ][ $c ], $paths[ $c ][ $k ] ) );
					}
				}
			}
		}
	}
	
	return $paths;
}

# Winning votes determine victory strength, with margins as a tiebreaker.
function get_wvm_beatpath_matrix( &$wvp, &$mp ) {
	foreach ( $wvp as $c => $opps ) {
		foreach ( $opps as $opp => $dummy1 ) {
			if ( $c != $opp ) {
				foreach ( $opps as $k => $dummy2 ) {
					if ( ( $c != $k ) && ( $opp != $k ) ) {
						if ( ( $wvp[ $c ][ $k ] < $wvp[ $opp ][ $c ] ) ||
							   ( ( $wvp[ $c ][ $k ] == $wvp[ $opp ][ $c ] ) &&  
							   ( $mp[ $c ][ $k ] < $mp[ $opp ][ $c ] ) ) ) {
							$wvipath = $wvp[ $c ][ $k ];
							$mipath = $mp[ $c ][ $k ];
						} else {
							$wvipath = $wvp[ $opp ][ $c ];
							$mipath = $mp[ $opp ][ $c ];
						}
						
						if ( ( $wvp[ $opp ][ $k ] < $wvipath ) ||
							   ( ( $wvp[ $opp ][ $k ] == $wvipath ) && 
							   ( $mp[ $opp ][ $k ] < $mipath ) ) ) {
							$wvp[ $opp ][ $k ] = $wvipath;
							$mp[ $opp ][ $k ] = $mipath;
						}
					}
				}
			}
		}
	}
}

function sort_candidate_by_wins( $candidates, $wvpaths, $mpaths ) {
	if ( count ( $candidates ) == 0 ) {
		return array();
	}

	$winners = $candidates;
	
	foreach ( $candidates as $c => $dummy1 ) {
		foreach ( $candidates as $opp => $dummy2 ) {
			if ( $c != $opp ) {
				if ( ( $wvpaths[ $c ][ $opp ] > $wvpaths[ $opp ][ $c ] ) ||
					 ( ( $wvpaths[ $c ][ $opp ] == $wvpaths[ $opp ][ $c ] ) && 
					 ( $mpaths[ $c ][ $opp ] > $mpaths[ $opp ][ $c ] ) ) ) {
					unset( $winners[ $opp ] );
				}
			}
		}
	}
	
	if ( count( $winners ) > 1 ) {
		$ties = "";
		foreach ( $winners as $wname => $wl ) {
			$ties .= ( $wname . ", " );
		}
		$ties = substr( $ties, 0, -2 );
		
		print "Ties between : " . $ties . "\n";
	}

	foreach ( $winners as $w => $l ) {
		unset( $candidates[ $w ] );
	}

	return ( $winners + sort_candidate_by_wins( $candidates, $wvpaths, $mpaths ) );
}

function output_table( &$fs, &$matrix ) {
	global $boardCandidates;
	
	$line = "{| class=\"wikitable\" style=\"text-align:center\"\n|-\n! \n";
	foreach ( $boardCandidates as $name => $idx ) {
		$line .= ( "! " . $idx . "\n" );
	}
	$line .= "|-\n";
	foreach ( $matrix as $c => $opponents ) {
		$line .= ( "| '''" . $boardCandidates[ $c ] . "'''\n" );
		foreach ( $opponents as $o => $val ) {
			if ( $c == $o ) {
				$line .= "| -\n";
			} else {
				$line .= ( "| " . $matrix[ $c ][ $o ] . "\n" );
			}
		}
		$line .= "|-\n";
	}
	$line .= "|}\n";

	fwrite( $fs, $line );
}
