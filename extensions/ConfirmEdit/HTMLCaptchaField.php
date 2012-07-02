<?php
/**
 * HTMLFormField for inserting Captchas into a form.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @class
 */
class HTMLCaptchaField extends HTMLFormField {

	/**
	 * @var Captcha
	 */
	private $captcha;

	public $prefix = '';

	/**
	 * @var Bool|Array
	 */
	private $validationResult;

	public function __construct( $params ) {
		parent::__construct( $params );

		// For differentiating the type of form, mainly
		if ( isset( $params['prefix'] ) ) {
			$this->prefix = $params['prefix'];
		}
	}

	/**
	 * Get the captcha body.  Don't include any of the surrounding table cells/rows
	 *
	 * @param  $value String
	 * @return String
	 */
	public function getInputHTML( $value ) {
		# TODO
	}

	public function validate( $data, $alldata ) {
		// We sent back the exists status of the captcha before.  If it *doesn't* exist
		// we actually want to validate this as true, because we don't want an angry red
		// error message, just for the user to put the captcha in again
		if ( $data === false ) {
			return true;
		}


	}

	/**
	 * @param  $request WebRequest
	 * @return void
	 */
	public function loadDataFromRequest( $request ) {
		$this->captcha = Captcha::factory();
		$this->captcha->loadFromRequest( $request, $this );
		if ( !$this->captcha->exists() ) {
			// The captcha doesn't exist; probably because it's already been used and
			// then deleted for security.  Load the field up with a new captcha which
			// will be shown to the user when the validation of said new object fails
			$this->captcha = Captcha::newRandom();
		}

		// This will be useful as the difference between "the captcha doesn't exist" and
		// "you answered the captcha wrongly"
		return $this->captcha->exists();
	}
}