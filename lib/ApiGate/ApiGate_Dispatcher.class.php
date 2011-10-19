<?php
/**
 * @author Sean Colombo
 * @date 20111011
 *
 * This class is for dispatching requests which will result in HTML responses.
 * It calls templates and returns HTML.  It does NOT return full pages in most cases though.
 * The entry-point in the code for pages such as "pages/registration" is actually /pages/index.php.
 *
 * Both /pages/index.php and other external page files (such as MediaWiki Special pages in the case of Wikia)
 * will call this ApiGate_Dispatcher to run their data through the templates and get pages or parts of pages back.
 */


class ApiGate_Dispatcher {

	/**
	 * Given an associative array of data and a template name renders the template with all of the data extract()ed to it.
	 *
	 * @param templateName - string - The name of the template, without extension or path. The file must be a .php file
	 *                                in ApiGate/templates/. For example, "register" will load "ApiGate/templates/register.php".
	 * @param data - array - associative array of var names and their values. Will be passed to extract().
	 * @return string - the rendered output of the template (typically HTML).
	 */
	public static function renderTemplate( $templateName, $data=array() ) {
		extract( $data ); // turns		$data['name'] = "Sean";		into		$name == "Sean";

		$templateFileName = dirname( __FILE__ ) . "/templates/$templateName.php";

		ob_start();
		require $templateFileName;
		$out = ob_get_clean();

		return $out;
	} // end renderTemplate()

} // end class ApiGate_Dispatcher
