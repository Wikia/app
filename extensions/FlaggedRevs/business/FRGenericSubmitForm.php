<?php
/**
 * Class containing generic form business logic
 * Note: edit tokens are the responsibility of the caller
 * Usage: (a) set ALL form params before doing anything else
 *        (b) call ready() when all params are set
 *        (c) call preload() OR submit() as needed
 */
abstract class FRGenericSubmitForm {
	const FOR_SUBMISSION = 1;               # Notify functions when we are submitting
	/* Internal form state */
	const FORM_UNREADY = 0;                 # Params not given yet
	const FORM_READY = 1;                   # Params given and ready to submit
	const FORM_PRELOADED = 2;               # Params pre-loaded (likely from slave DB)
	const FORM_SUBMITTED = 3;               # Form submitted
	private $state = self::FORM_UNREADY;    # Form state (disallows bad operations)

	protected $user = null;                 # User performing the action

	final public function __construct( User $user ) {
		$this->user = $user;
		$this->initialize();
	}

	/**
	 * Initialize any parameters on construction
	 * @return void
	 */
	protected function initialize() {}

	/**
	 * Get the submitting user
	 * @return User
	 */
	final public function getUser() {
		return $this->user;
	}

	/**
	 * Get the internal form state
	 * @return int
	 */
	final protected function getState() {
		return $this->state;
	}

	/**
	 * Signal that inputs are all given (via accessors)
	 * @return mixed (true on success, error string on target failure)
	 */
	final public function ready() {
		if ( $this->state != self::FORM_UNREADY ) {
			throw new MWException( __CLASS__ . " ready() already called.\n");
		} 
		$this->state = self::FORM_READY;
		$status = $this->doCheckTargetGiven();
		if ( $status !== true ) {
			return $status; // bad target
		}
		return $this->doBuildOnReady();
	}

	/**
	 * Load any objects after ready() called
	 * NOTE: do not do any DB hits here, just build objects
	 * @return mixed (true on success, error string on failure)
	 */
	protected function doBuildOnReady() {
		return true;
	}

	/**
	 * Set a member field to a value if the fields are unlocked
	 * @param mixed &$field Field of this form
	 * @param mixed $value Value to set the field to
	 * @return void
	 */
	final protected function trySet( &$field, $value ) {
		if ( $this->state != self::FORM_UNREADY ) {
			throw new MWException( __CLASS__ . " fields cannot be set anymore.\n");
		} else {
			$field = $value; // still allowing input
		} 
	}

	/*
	 * Check that a target is given (e.g. from GET/POST request)
	 * NOTE: do not do any DB hits here, just check if there is a target
	 * @return mixed (true on success, error string on failure)
	 */
	protected function doCheckTargetGiven() {
		return true;
	}

	/*
	 * Check that the target is valid (e.g. from GET/POST request)
	 * @param int $flags FOR_SUBMISSION (set on submit)
	 * @return mixed (true on success, error string on failure)
	 */
	protected function doCheckTarget( $flags = 0 ) {
		return true;
	}

	/*
	 * Check that a target is and it is valid (e.g. from GET/POST request)
	 * NOTE: do not do any DB hits here, just check if there is a target
	 * @return mixed (true on success, error string on failure)
	 */
	final public function checkTarget() {
		if ( $this->state != self::FORM_READY ) {
			throw new MWException( __CLASS__ . " input fields not set yet.\n");
		}
		$status = $this->doCheckTargetGiven();
		if ( $status !== true ) {
			return $status; // bad target
		}
		return $this->doCheckTarget();
	}

	/*
	 * Validate and clean up target/parameters (e.g. from POST request)
	 * @return mixed (true on success, error string on failure)
	 */
	final protected function checkParameters() {
		$status = $this->checkTarget( self::FOR_SUBMISSION );
		if ( $status !== true ) {
			return $status; // bad target
		}
		return $this->doCheckParameters();
	}

	/*
	 * Verify and clean up parameters (e.g. from POST request)
	 * @return mixed (true on success, error string on failure)
	 */
	protected function doCheckParameters() {
		return true;
	}

	/*
	 * Preload existing params for the target from the DB (e.g. for GET request)
	 * NOTE: do not call this and then submit()
	 * @return mixed (true on success, error string on failure)
	 */
	final public function preload() {
		if ( $this->state != self::FORM_READY ) {
			throw new MWException( __CLASS__ . " input fields not set yet.\n");
		}
		$status = $this->checkTarget();
		if ( $status !== true ) {
			return $status; // bad target
		}
		$status = $this->doPreloadParameters();
		if ( $status !== true ) {
			return $status; // bad target
		}
		$this->state = self::FORM_PRELOADED;
		return true;
	}

	/*
	 * Preload existing params for the target from the DB (e.g. for GET request)
	 * @return mixed (true on success, error string on failure)
	 */
	protected function doPreloadParameters() {
		return true;
	}

	/**
	 * Submit the form parameters for the page config to the DB
	 * @return mixed (true on success, error string on failure)
	 */
	final public function submit() {
		if ( $this->state != self::FORM_READY ) {
			throw new MWException( __CLASS__ . " input fields preloaded or not set yet.\n");
		}
		$status = $this->checkParameters();
		if ( $status !== true ) {
			return $status; // cannot submit - broken target or params
		}
		$status = $this->doSubmit();
		if ( $status !== true ) {
			return $status; // cannot submit
		}
		$this->state = self::FORM_SUBMITTED;
		return true;
	}

	/**
	 * Submit the form parameters for the page config to the DB
	 * @return mixed (true on success, error string on failure)
	 */
	protected function doSubmit() {
		return true;
	}
}
