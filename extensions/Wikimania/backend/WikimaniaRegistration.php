<?php
/**
 * Class referring to a specific registration
 */
class WikimaniaRegistration extends HTMLForm {

	/**
	 * @param $wm Wikimania
	 * @param $context ContextSource
	 */
	public function  __construct( Wikimania $wm, $context = null ) {
		parent::__construct( $this->getFields( $wm, $context->getUser() ), $context, 'wikimania' );
	}

	/**
	 * @param $u user
	 * @return string
	 */
	public static function generateRegistrationID( User $u ) {
		$str = $u->getName() . ":" . microtime() . ":" . wfGetIP();
		return substr( sha1( $str ), 0, 5 );
	}

	/**
	 * @param $wm Wikimania
	 * @param $u User
	 * @return array
	 */
	private function getFields( Wikimania $wm, User $u ) {
		static $fields;
		if( !$fields ) {
			$langList = array_flip( LanguageNames::getNames( $u->getOption( 'lang') ) );
			$langListWithEmpty = $langList;
			$langListWithEmpty[''] = '';
			$fields = array(
				/** PERSONAL INFORMATION **/
				'reg_fname' => array(
					'type' => 'text',
					'label-message' => 'wikimania-reg-fname',
					'section' => 'personal-info',
					'required' => true,
				),
				'reg_lname' => array(
					'type' => 'text',
					'label-message' => 'wikimania-reg-lname',
					'section' => 'personal-info',
					'required' => true,
				),
				'reg_gender' => array(
					'type' => 'radio',
					'label-message' => 'wikimania-reg-gender',
					'options' => self::getGenderPossibilities(),
					'section' => 'personal-info',
					'required' => true,
				),
				'reg_country' => array(
					'type' => 'select',
					'options' => array(),
					'section' => 'personal-info',
					'required' => true,
				),
				/** LINGUISTIC ABILItIES **/
				'langn' => array(
					'type' => 'select',
					'label-message' => 'wikimania-reg-langn',
					'options' => $langList,
					'section' => 'linguistic-abilities',
					'required' => true,
				),
				'lang1' => array(
					'type' => 'select',
					'label-message' => 'wikimania-reg-lang1',
					'options' => $langListWithEmpty,
					'section' => 'linguistic-abilities',
				),
				'lang2' => array(
					'type' => 'select',
					'label-message' => 'wikimania-reg-lang2',
					'options' => $langListWithEmpty,
					'section' => 'linguistic-abilities',
				),
				'lang3' => array(
					'type' => 'select',
					'label-message' => 'wikimania-reg-lang3',
					'options' => $langListWithEmpty,
					'section' => 'linguistic-abilities',
				),
			);
		}
		return $fields;
	}

	/**
	 * @static
	 * @return array
	 */
	private static function getGenderPossibilities() {
		return array(
			wfMsg( 'gender-male') => 'male',
			wfMsg( 'gender-female') => 'female',
			wfMsg( 'wikimania-reg-gender-decline') => 'decline'
		);
	}
}
