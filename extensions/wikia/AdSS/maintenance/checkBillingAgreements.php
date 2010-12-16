<?php

/**
 * @package MediaWiki
 * @addtopackage maintenance
 */

ini_set( "include_path", dirname(__FILE__)."/../../../../maintenance/" );
require_once( "commandLine.inc" );

if ( wfReadOnly() || !empty( $wgAdSS_ReadOnly ) ) {
	echo "Read-only mode - exiting.";
	exit( 1 );
}

if( isset( $options['users'] ) ) {
	$pp = new PaypalPaymentService( array_merge( $wgPayflowProCredentials, array( 'APIUrl' => $wgPayflowProAPIUrl, 'HTTPProxy' => $wgHTTPProxy ) ) );
	$dbw = wfGetDB( DB_MASTER, array(), $wgAdSS_DBname );
	$res = $dbw->select( 'users', '*', 'user_pp_baid IS NOT NULL', __METHOD__ );
	foreach( $res as $row ) {
		$user = AdSS_User::newFromRow( $row );

		$adCount = getActiveAdCount( $user->id );
		echo "{$user->toString()} | {$user->baid} | $adCount ad(s) | ";

		if( $adCount == 0 ) {
			echo "No ads (canceling... ";
			if( !isset( $options['dry-run'] ) ) {
				$pp->cancelBillingAgreement( $user->baid );
				$user->baid = null;
				$user->save();
			}
			echo "done)\n";
		} else {
			$respArr = array();
			if( $pp->checkBillingAgreement( $user->baid, $respArr ) ) {
				echo "ACTIVE!\n";
			} else {
				if( ( $respArr['RESULT'] ==  12 ) && ( $respArr['RESPMSG'] == 'Declined: 10201-Billing Agreement was cancelled' ) ) {
					echo "Canceled (marking in our DB... ";
					if( !isset( $options['dry-run'] ) ) {
						$pp->cancelBillingAgreement( $user->baid );
						$user->baid = null;
						$user->save();
					}
					echo "done)\n";
				} else {
					echo "Failed (skipping...)\n";
				}
			}
		}
	}
	$dbw->freeResult( $res );
} elseif( isset( $options['all'] ) ) {
	$pp = new PaypalPaymentService( array_merge( $wgPayflowProCredentials, array( 'APIUrl' => $wgPayflowProAPIUrl, 'HTTPProxy' => $wgHTTPProxy ) ) );
	$dbw = wfGetDB( DB_MASTER, array(), $pp->getPaypalDBName() );
	$res = $dbw->select(
			array( 'pp_agreements', 'pp_details' ),
		       	array( '*' ),
			array( 
				'ppa_token = ppd_token',
				'ppa_baid IS NOT NULL',
				'ppa_canceled' => null,
			     ),
			__METHOD__,
			array(
				'ORDER BY' => 'ppd_payerid, ppa_responded DESC',
			     )
			);
	$lastActiveUserId = 0;
	foreach( $res as $row ) {
		$user = AdSS_User::newFromPayerId( $row->ppd_payerid );
		if( !$user ) {
			continue;
		}

		$adCount = getActiveAdCount( $user->id );
		echo "{$user->toString()} | {$row->ppd_email} ({$row->ppd_payerid}) | {$row->ppa_baid} | {$row->ppa_responded} | $adCount ad(s) | ";

		if( $adCount == 0 ) {
			echo "No ads (canceling... ";
			$pp->cancelBillingAgreement( $row->ppa_baid );
			if( !isset( $options['dry-run'] ) && ( $user->baid == $row->ppa_baid ) ) {
				$user->baid = null;
				$user->save();
			}
			echo "done)\n";
		} else {
			$respArr = array();
			if( $pp->checkBillingAgreement( $row->ppa_baid, $respArr ) ) {
				if( $lastActiveUserId != $user->id ) {
					echo "ACTIVE!";
					$lastActiveUserId = $user->id;
					if( $user->baid != $row->ppa_baid ) {
						if( !isset( $options['dry-run'] ) ) {
							$user->baid = $row->ppa_baid;
							$user->save();
						}
						echo " (fixed baid)";
					}
					echo "\n";
				} else {
					echo "active (canceling... ";
					$pp->cancelBillingAgreement( $row->ppa_baid );
					echo "done)\n";
				}
			} else {
				if( ( $respArr['RESULT'] ==  12 ) && ( $respArr['RESPMSG'] == 'Declined: 10201-Billing Agreement was cancelled' ) ) {
					echo "Canceled (marking in our DB... ";
					$pp->cancelBillingAgreement( $row->ppa_baid );
					if( !isset( $options['dry-run'] ) && ( $user->baid == $row->ppa_baid ) ) {
						$user->baid = null;
						$user->save();
					}
					echo "done)\n";
				} else {
					echo "Failed (skipping...)\n";
				}
			}
		}
	}
	$dbw->freeResult( $res );
} else {
	echo "Usage: checkBillingAgreements.php [ --users | --all ]\n";
	exit( 1 );
}

function getActiveAdCount( $userId ) {
	global $wgAdSS_DBname;
	$dbw = wfGetDB( DB_MASTER, array(), $wgAdSS_DBname );
	return $dbw->selectField( 'ads', 'count(*)', array( 'ad_user_id' => $userId, 'ad_closed' => null ), __METHOD__ ); 
}
