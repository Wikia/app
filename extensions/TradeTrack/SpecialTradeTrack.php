<?php

class SpecialTradeTrack extends SpecialPage {


    /**
     * This is an array of the various trademarks that we're watching over.
     */
    private static $TRADEMARK_LIST = array(
    	'wmf',
    	'wikipedia',
    	'wiktionary',
    	'wikiquote',
    	'wikibooks',
    	'wikiversity',
    	'wikispecies',
    	'wikisource',
    	'mediawiki',
    	'wikimediacommons',
    	'wikimediaincubator',
    	'wikinews',
    	'other',
    );

    /**
     * This defines the prefix for (most) all of our form field elements
     */
    private static $VARIABLE_PREFIX = "tradetrack-elements-";

    /**
     * This is our validation framework array.  It is requied by validateField(),
     * below.
     *
     * For each field that we are going to validate, we need an entry in the
     * array.  That entry will contain two additional arrays: 'errmsgs' and
     * 'tests'.
     *
     * The tests array defines each test type for the field and
     * possible thresholds or arguments to the test (e.g., max length).
     *
     * The errmsgs array has named entries for the each test and defines which
     * message string should be shoved into the errors field if the test fails.
     *
     * This could probably better be handled with a single array set, thus:
     *
     * $fieldname => array(
     *       'testname' => array(
     *         'threshold' => $value,
     *         'error' => $value,
     *       ),
     *     );
     *  I will probably refactor to that but want to get it working first.
     *
     *  I would have loved to use a constant here but that threw some
     *  errors so I have to use the real number.
     */
    private static $VALIDATION_FIELDS = array(
      'usage' => array(
        'errmsgs' => array(
          'max' => 'tradetrack-errors-generic-too-long',
          'required' => 'tradetrack-errors-generic-empty',
        ),
        'tests' => array(
          'max' => 5000,
          'required' => true
        ),
      ),
      'mailingaddress' => array(
        'errmsgs' => array(
          'max' => 'tradetrack-errors-generic-too-long',
          'required' => 'tradetrack-errors-generic-empty',
        ),
        'tests' => array(
          'max' => 5000,
          'required' => true
        ),
      ),
      'name' => array(
        'errmsgs' => array(
          'max' => 'tradetrack-errors-generic-too-long',
          'required' => 'tradetrack-errors-generic-empty',
        ),
        'tests' => array(
          'max' => 200,
          'required' => true
        ),
      ),
      'orgname' => array(
        'errmsgs' => array(
          'max' => 'tradetrack-errors-generic-too-long',
          'required' => 'tradetrack-errors-generic-empty',
        ),
        'tests' => array(
          'max' => 200,
          'required' => true
        ),
      ),
      'email' => array(
        'errmsgs' => array(
          'max' => 'tradetrack-errors-generic-too-long',
          'required' => 'tradetrack-errors-generic-empty',
          'equals' => 'tradetrack-errors-e-mails-do-not-match'
        ),
        'tests' => array(
          'max' => 200,
          'required' => true,
          'equals' => 'confirmemail'
        ),
      ),
      'confirmemail' => array(
        'errmsgs' => array(
          'max' => 'tradetrack-errors-generic-too-long',
          'required' => 'tradetrack-errors-generic-empty',
        ),
        'tests' => array(
          'max' => 200,
          'required' => true
        ),
      ),
      'phone' => array(
        'errmsgs' => array(
          'max' => 'tradetrack-errors-generic-too-long',
          'required' => 'tradetrack-errors-generic-empty',
        ),
        'tests' => array(
          'max' => 200,
          'required' => true
        ),
      ),
      'statementagreement' => array(
        'errmsgs' => array(
          'required' => 'tradetrack-errors-no-accept-statement',
        ),
        'tests' => array(
          'required' => true
        ),
      ),
      'otherval' => array(
        'errmsgs' => array(
          'max' => 'tradetrack-errors-generic-too-long',
          'requiredif' => 'tradetrack-errors-missing-other-value',
          'emptyunless' => 'tradetrack-errors-other-set-but-not-checked',
        ),
        'tests' => array(
          'max' => 200,
          'requiredif' => 'tradetrack-which-other',
          'emptyunless' => 'tradetrack-which-other',
        ),
      ),
    );

    /**
     * Some private arrays to point to our resources.
     */
    private static $styleFiles = array(
        array( 'src' => 'css/TradeTrack', 'version' => 1 ),
    );

    private static $scriptFiles = array(
        array( 'src' => 'js/TradeTrack.js', 'version' => 1 ),
        array( 'src' => 'js/jquery.tipsy.js', 'version' => 1 ),
        array( 'src' => 'js/jquery.NobleCount.js', 'version' => 1 ),
    );

    /**
     * This is our errors array.
     */
    private $errors = array();

    function __construct() {
        parent::__construct( 'TradeTrack' );
    }

    /**
     * Adds an error to the local error stack for later display. The local errors array is
     * actually a matrix where each "key" points to another array.
     *
     * Note that we need to be adding *parsed* error messages here.  Why?  Because there isn't an easy
     * way to send $1, $2, etc. down the pipe and into the templates.
     *
     * @param target The named target for the error (a single target can have multiple errors)
     * @param errorString The message to throw into the error.  This should be an i18n pointer.
     */
    function addError($target, $errorString) {
        $eList = $errorsArray[$target];
        if (!$eList) { $eList = array( ); }
        array_push($eList, $errorString);

        $this->errors[$target] = $eList;
    }

    /**
     * Simply returns true or false if there have been errors thrown during the run
     *
     * @return true if there are errors; false otherwise.
     */
    function hasErrors() {
        if ( count( $this->errors ) != 0 ) { return true; }
        return false;
    }


    function execute( $par ) {
        global $wgRequest, $wgOut;

        global $wgExtensionAssetsPath;

        foreach ( self::$scriptFiles as $script ) {
            $wgOut->addScriptFile( $wgExtensionAssetsPath . "/TradeTrack/{$script['src']}", $script['version'] );
        }

        foreach ( self::$styleFiles as $style ) {
            $wgOut->addExtensionStyle( $wgExtensionAssetsPath . "/TradeTrack/{$style['src']}?{$style['version']}" );
        }


        $wgOut->setPageTitle( wfMsg( 'tradetrack-header' ) );

        // This is our template data array.
        $tData = array();
        $tData['formURL'] = $this->getTitle()->getLinkURL( );

        // First, see if it's supplied from the page.
        $doaction = $wgRequest->getVal( 'doaction' );


        $success = false;

        // open wide.
        ob_start();


        switch( $doaction ) {
            case 'route':
                /*
                 * The user has selected (or failed to select) the first step on their way to Mordor.
                 * Are we going overland, or through the Mines of Moria?
                 */
                $purpose = $wgRequest->getVal( 'tradetrack-purpose' );
                if ( !isset( $purpose ) ) {
                    $this->addError( 'tradetrack-purpose', wfMsg( 'tradetrack-errors-no-route' ) );
                } elseif ( ( $purpose != 'Commercial' )
                        && ( $purpose != 'Non-Commercial' )
                        && ( $purpose != 'Media' ) ) {
                    $this->addError( 'tradetrack-purpose', wfMsg( 'tradetrack-errors-invalid-route' ) );
                }

                if ( $this->hasErrors() ) {
                    $tmp = new TradeTrackScreenRouting();
                } else {
                    $tData['purpose'] = $purpose;
                    if ( $purpose == 'Non-Commercial' ) {
                        $tmp = new TradeTrackScreenNonComAgreement();
                    } else {
                        $tmp = new TradeTrackScreenDetailsForm();
                    }
                }
                break;
            case 'noncomroute':
                /*
                 * Over land it is.
                 * This is an interleave screen, only available if you select "Non-Commercial."
                 * This is mostly for data collection.
                 * The user will still be forced to deal with the Orks in Moria.
                 */
                $purpose = $wgRequest->getVal( 'tradetrack-purpose' );
                if ( !isset( $purpose ) ) {
                    // Ensure we still know what we're doing.  If not, bail with the wah-wah sound.
                    $this->addError( 'global', wfMsg( 'tradetrack-errors-pacman-death' ) );
                    $tmp = new TradeTrackScreenRouting();
                    break;
                }

                $tData['purpose'] = $purpose;

                $agreementType = $wgRequest-> getVal( 'tradetrack-elements-agreement' );
                if ( !isset( $agreementType ) ) {
                    $this->addError( 'tradetrack-elements-agreement', wfMsg( 'tradetrack-errors-noncom-no-selection' ) );
                } elseif ( ( $agreementType != 'Yes' )
                            && ( $agreementType != 'No' )
                            && ( $agreementType != 'Mistake' ) ) {
                    $this->addError( 'tradetrack-elements-agreement', wfMsg( 'tradetrack-errors-noncom-invalid-selection' ) );
                }
                if ( $this->hasErrors() ) {
                    // Oh no!  The thing in the lake grabbed Frodo!
                    $tmp = new TradeTrackScreenNonComAgreement();
                } elseif ( $agreementType == 'Mistake' ) {
                    // For completeness' sake, we must give the user an escape route.
                    // Frodo decides to ditch the entire process and marry some poor hobbit back
                    // in the Shire.
                    $tmp = new TradeTrackScreenRouting();
                } else {
                    // Why yes, I do know the Elvish word for "Friend".
                    // No errors of any kind, we're going in.
                    $tData['agreementType'] = $agreementType;
                    $tmp = new TradeTrackScreenDetailsForm();
                }
                break;
            case 'details':
                /*
                 * This is the final screen.  This has several fields, all of which are required.
                 *
                 * You are in a maze of twisty passages, all alike. You may be eaten by a Balrog.
                 */

                $purpose = $wgRequest->getVal( 'tradetrack-purpose' );
                if ( !isset( $purpose )  ) {
                    // Ensure we still know what we're doing.  If not, bail with the wah-wah sound.
                    $this->addError( 'global', wfMsg( 'tradetrack-errors-pacman-death' ) );
                    $tmp = new TradeTrackScreenRouting();
                    break;
                }
                $tData['purpose'] = $purpose;

                // Handle lost agreement type, if required.
                $agreementType = $wgRequest-> getVal( 'tradetrack-elements-agreement' );
                if ( ( !$agreementType) && ( $purpose == 'Non-Commercial' ) ) {
                    $this->addError( 'global', wfMsg( 'tradetrack-errors-pacman-death' ) );
                    $tmp = new TradeTrackScreenRouting();
                    break;
                }
                $tData['agreementType'] = $agreementType;

                // Let's get the easy fields out of the way first.


                $checkElements = array(
                    'usage',
                    'mailingaddress',
                    'name',
                    'orgname',
                    'email',
                    'confirmemail',
                    'phone',
                    'statementagreement',
                    'otherval'
                );


                // This runs validation on the bulk of our fields.
                foreach ( $checkElements as $e ) {
                    $this->validateField( $e, $wgRequest );
                    $tData[$e] = $wgRequest->getVal(self::$VARIABLE_PREFIX . $e); // Shove into template data array
                }


                // Now we cycle through the trademarks list and see if any of them are set.
                $tData['trademarks'] = array();

                foreach ( self::$TRADEMARK_LIST as $property ) {
                    if ( $wgRequest->getBool( "tradetrack-which-$property" ) ) {
                        $tData['trademarks'][$property] = $property;
                    }
                }

                if ( count( $tData['trademarks'] ) == 0 ) {
                    // Didn't select a single mark
                    $this->addError( 'tradetrack-element-list', wfMsg( 'tradetrack-errors-zero-marks' ) );
                }


                // Now, if errors, kick back.
                if ( $this->hasErrors() ) {
                    // Still stuck in the mines.
                    $tmp = new TradeTrackScreenDetailsForm();
                } else {
                    // Yay! Now we get to frolic with the Elves.
                    $success = true;
                    $tmp = new TradeTrackScreenThanks();
                }

                break;
            default:
                /*
                 * This is the first time to the page, or there has been some sort of
                 * unrecoverable error.  Ladies and gentlemen, I give you the first screen.
                 */
                $tmp = new TradeTrackScreenRouting();
                break;
        }

        if ( ( isset( $tmp ) ) && ( $tmp instanceof QuickTemplate ) ) {

            // Stick the trademark list into the template's data space.
            $tData['TRADEMARK_LIST'] = self::$TRADEMARK_LIST;

            // Add in spices.
            $tmp->set( 'tData', $tData );
            $tmp->set( 'errors', $this->errors );

            // Bake at 300 degrees for 20 minutes.
            $tmp->execute();
        }

        $wgOut->addHtml( ob_get_clean() );

        if ( $success ) {

            // Change the page title
            $wgOut->setPageTitle( wfMsg( 'tradetrack-thanks-header' ) );


            // Insert to the database.
            $this->insertTradeTrackRequest( $tData );

            // Now build the email
            global $wgTradeTrackEmailCommercial;
            global $wgTradeTrackEmailNonCommercial;
            global $wgTradeTrackEmailMedia;
            global $wgTradeTrackEmailSubject;
            global $wgTradeTrackFromEmail;

            $toEmail = "";

            // Who gets the email?
            switch ( $tData['purpose'] ) {
                case 'Commercial':
                    $toEmail = $wgTradeTrackEmailCommercial;
                    break;
                case 'Non-Commercial':
                    $toEmail = $wgTradeTrackEmailNonCommercial;
                    break;
                case 'Media':
                    $toEmail = $wgTradeTrackEmailMedia;
                    break;
                default:
                    $toEmail = $wgTradeTrackEmailNonCommercial;
                    break;
            }

            ob_start();

            $emailTmp = new TradeTrackEmail();
            $emailTmp->set( 'tData', $tData );
            $emailTmp->execute();
            $generatedEmail = ob_get_clean();
            $mailer = new UserMailer();

            $mailer->send( new MailAddress( $toEmail ) , new MailAddress( $wgTradeTrackFromEmail ), $wgTradeTrackEmailSubject, $generatedEmail);

            // debug line to dump this to the end screen.
            $wgOut->addHtml( "<pre>" );
            $wgOut->addHtml( $generatedEmail );
            $wgOut->addHtml( "</pre>" );

        }

    }

    /**
     * This does field validation.  It looks up fields in the VALIDATION_FIELDS array
     * and runs tests on them.  This, combined with VALIDATION_FIELDS, is really a
     * crude validation framework.
     *
     * Entries in the VALIDATION_FIELDS array must be named the same as the field in the
     * html form, *minus* the value of $VARIABLE_PREFIX.
     *
     * This method takes the $wgRequest object as a variable rather than the possible
     * value supplied by the form.  The reason for this is that one of the tests is
     * "equals", which makes sure two form values are the same (e.g., email and
     * emailconfirm).
     *
     * This method *also* takes the supplied values and sticks them back into the
     * page's global "data" array, so that they can be redisplayed if there are errors.
     *
     * This could (should) probably be pulled out into a separate class.
     *
     * @param fieldName the name of the form field to validate
     * @param $request the $wgRequest object.
     */
    function validateField( $fieldName, $request ) {
        global $wgLang;
        $value = $request->getVal( self::$VARIABLE_PREFIX . $fieldName );

        // No need to validate. This field has no tests.
        if ( !isset ( self::$VALIDATION_FIELDS[$fieldName] ) ) {
            return true;
        }

        foreach ( self::$VALIDATION_FIELDS[$fieldName]['tests'] as $vType => $vThreshold ) {

            switch ( $vType ) {
                case 'max':
                    // Tests that the value does not exceed a threshold, defined in the array (max => threshold)
                    if ( ( isset( $value ) ) && ( strlen( $value ) > $vThreshold ) ) {
                        $this->addError( "tradetrack-elements-$fieldName", wfMsgExt( self::$VALIDATION_FIELDS[$fieldName]['errmsgs'][$vType], 'parsemag', $wgLang->formatNum( $vThreshold ) ) );
                    }
                    break;
                case 'required':
                    // Tests to ensure that the value exists.
                    if ( !$value ) {
                        $this->addError( "tradetrack-elements-$fieldName", wfMsg( self::$VALIDATION_FIELDS[$fieldName]['errmsgs'][$vType] ) );
                    }
                    break;
                case 'requiredif':
                    // This field is only required if another field is set as well.
                    // Note that we do NOT use variable prefix here.
                    $required = $request->getVal( $vThreshold );
                    if ( ( !$value ) && ( isset( $required ) ) ) {
                        $this->addError( "tradetrack-elements-$fieldName", wfMsg( self::$VALIDATION_FIELDS[$fieldName]['errmsgs'][$vType] ) );
                    }
                    break;
                case 'emptyunless':
                    // This field should be empty unless another field is set.
                    $unless = $request->getVal( $vThreshold );
                    if ( ( $value ) && ( !isset( $unless ) ) ) {
                        $this->addError( "tradetrack-elements-$fieldName", wfMsg( self::$VALIDATION_FIELDS[$fieldName]['errmsgs'][$vType] ) );
                    }
                    break;
                case 'equals':
                    // Tests that the field value is equal to the value of another feild ('equals' => comparison field)
                    if ( isset( $value ) ) {
                        $compare = $request->getVal( self::$VARIABLE_PREFIX . $vThreshold );
                        if ( ( !isset( $compare ) ) || ( $value !== $compare ) ) {
                            $this->addError( "tradetrack-elements-$fieldName", wfMsg( self::$VALIDATION_FIELDS[$fieldName]['errmsgs'][$vType] ) );
                        }
                    }
                    break;
                default:
                    break;
            }
        }
        return true;
    }


	private function insertTradeTrackRequest( array $tData ) {
		$dbw = wfGetDB( DB_MASTER );

		// Ugly.
		$markMapping = array();

		$res = $dbw->select(
			'tradetrack_trademarks',
			array ('tt_mark_id', 'tt_mark')
		);
		foreach ( $res as $row ) {
		    $markMapping[$row->tt_mark] = $row->tt_mark_id;
		}

		$timestamp = $dbw->timestamp();

		$dbw->insert(
			'tradetrack_requests',
			array(
				'tt_purpose' => $tData['purpose'],
				'tt_agreement' => $tData['agreementType'],
				'tt_name' => $tData['name'],
				'tt_email' => $tData['email'],
				'tt_orgname' => $tData['orgname'],
				'tt_otherval' => $tData['otherval'],
				'tt_phone' => $tData['phone'],
				'tt_usage' => $tData['usage'],
				'tt_mailingaddress' => $tData['mailingaddress'],
				'tt_timestamp' => $timestamp,
			),
			__METHOD__,
			 array( 'IGNORE' )
		);

        $lastId = $dbw->insertId();
        // Now we insert rows for every mark requested.

        foreach ( $tData['trademarks'] as $trademark ) {
		    $dbw->insert(
				'tradetrack_mark_requests',
				array(
					'tt_request_id' => $lastId,
					'tt_mark_id' => $markMapping[$trademark],
					'tt_timestamp' => $timestamp,
			    ),
			    __METHOD__,
			    array( 'IGNORE' )
		    );

        }


	}


}
