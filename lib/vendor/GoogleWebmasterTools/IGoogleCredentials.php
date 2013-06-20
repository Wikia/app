<?php
/**
 * User: artur
 * Date: 18.04.13
 * Time: 13:33
 */

/**
 * Class IGoogleCredentials
 * represents user credentials for Google account.
 */
interface IGoogleCredentials {
	/**
	 * @return string
	 */
	function getEmail();

	/**
	 * @return string
	 */
	function getPassword();
}
