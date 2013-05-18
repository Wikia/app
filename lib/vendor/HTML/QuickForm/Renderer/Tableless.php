<?php
/**
 * A renderer for HTML_QuickForm that only uses XHTML and CSS but no
 * table tags
 *
 * PHP versions 4 and 5
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category   HTML
 * @package    HTML_QuickForm_Renderer_Tableless
 * @author     Alexey Borzov <borz_off@cs.msu.su>
 * @author     Adam Daniel <adaniel1@eesus.jnj.com>
 * @author     Bertrand Mansion <bmansion@mamasam.com>
 * @author     Mark Wiesemann <wiesemann@php.net>
 * @copyright  2005-2006 The PHP Group
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version    CVS: $Id $
 * @link       http://pear.php.net/package/[...]
 */

require_once 'HTML/QuickForm/Renderer/Default.php';

/**
 * A renderer for HTML_QuickForm that only uses XHTML and CSS but no
 * table tags
 * 
 * You need to specify a stylesheet like the one that you find in
 * data/stylesheet.css to make this work.
 *
 * @category   HTML
 * @package    HTML_QuickForm_Renderer_Tableless
 * @author     Alexey Borzov <borz_off@cs.msu.su>
 * @author     Adam Daniel <adaniel1@eesus.jnj.com>
 * @author     Bertrand Mansion <bmansion@mamasam.com>
 * @author     Mark Wiesemann <wiesemann@php.net>
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version    Release: 0.3.0
 * @link       http://pear.php.net/package/[...]
 */
class HTML_QuickForm_Renderer_Tableless extends HTML_QuickForm_Renderer_Default
{
   /**
    * Header Template string
    * @var      string
    * @access   private
    */
    var $_headerTemplate = 
        "\n\t\t<legend>{header}</legend>";

   /**
    * Element template string
    * @var      string
    * @access   private
    */
    var $_elementTemplate = 
        "\n\t\t<div class=\"qfrow\"><label class=\"qflabel\"><!-- BEGIN required --><span style=\"color: #ff0000\">*</span><!-- END required -->{label}</label><div class=\"qfelement<!-- BEGIN error --> error<!-- END error -->\"><!-- BEGIN error --><span class=\"error\">{error}</span><br /><!-- END error -->{element}</div></div><br />";

   /**
    * Form template string
    * @var      string
    * @access   private
    */
    var $_formTemplate = 
        "\n<form{attributes}>\n\t{hidden}\n{content}\n</form>";

   /**
    * Template used when opening a fieldset
    * @var      string
    * @access   private
    */
    var $_openFieldsetTemplate = "\n\t<fieldset>";

   /**
    * Template used when closing a fieldset
    * @var      string
    * @access   private
    */
    var $_closeFieldsetTemplate = "\n\t</fieldset>";

   /**
    * Required Note template string
    * @var      string
    * @access   private
    */
    var $_requiredNoteTemplate = 
        "\n\t\t{requiredNote}";

   /**
    * Whether a fieldset tag is open or not
    * @var      bool
    * @access   private
    */
   var $_fieldsetIsOpen = false;

   /**
    * Array of element names that indicate the end of a fieldset
    * (a new one will be opened when a the next header element occurs)
    * @var      array
    * @access   private
    */
    var $_stopFieldsetElements = array();

   /**
    * Constructor
    *
    * @access public
    */
    function HTML_QuickForm_Renderer_Tableless()
    {
        $this->HTML_QuickForm_Renderer_Default();
    } // end constructor

   /**
    * Called when visiting a header element
    *
    * @param    object     An HTML_QuickForm_header element being visited
    * @access   public
    * @return   void
    */
    function renderHeader(&$header)
    {
        $name = $header->getName();
        if (is_null($header->_text)) {
            $header_html = '';
        }
        elseif (!empty($name) && isset($this->_templates[$name])) {
            $header_html = str_replace('{header}', $header->toHtml(), $this->_templates[$name]);
        } else {
            $header_html = str_replace('{header}', $header->toHtml(), $this->_headerTemplate);
        }
        if ($this->_fieldsetIsOpen) {
            $this->_html .= $this->_closeFieldsetTemplate;
        }
        $this->_html .= $this->_openFieldsetTemplate . $header_html;
        $this->_fieldsetIsOpen = true;
    } // end func renderHeader

   /**
    * Renders an element Html
    * Called when visiting an element
    *
    * @param object     An HTML_QuickForm_element object being visited
    * @param bool       Whether an element is required
    * @param string     An error message associated with an element
    * @access public
    * @return void
    */
    function renderElement(&$element, $required, $error)
    {
        // if the element names indicates the end of a fieldset, close the fieldset
        if (in_array($element->getName(), $this->_stopFieldsetElements)) {
            $this->_html .= $this->_closeFieldsetTemplate;
            $this->_fieldsetIsOpen = false;
        }
        if (!$this->_inGroup) {
            $html = $this->_prepareTemplate($element->getName(), $element->getLabel(), $required, $error);
            // the following lines (until the "elseif") were changed / added
            // compared to the default renderer
            $element_html = $element->toHtml();
            if (!is_null($element->getAttribute('id'))) {
                $id = $element->getAttribute('id');
            } else {
                $id = $element->getName();
            }
            $html = str_replace('<label', '<label for="' . $id . '"', $html);
            $element_html = str_replace('name="' . $id . '"',
                                        'id="' . $id . '" name="' . $id . '"',
                                        $element_html);
            $this->_html .= str_replace('{element}', $element_html, $html);

        } elseif (!empty($this->_groupElementTemplate)) {
            $html = str_replace('{label}', $element->getLabel(), $this->_groupElementTemplate);
            if ($required) {
                $html = str_replace('<!-- BEGIN required -->', '', $html);
                $html = str_replace('<!-- END required -->', '', $html);
            } else {
                $html = preg_replace("/([ \t\n\r]*)?<!-- BEGIN required -->(\s|\S)*<!-- END required -->([ \t\n\r]*)?/i", '', $html);
            }
            $this->_groupElements[] = str_replace('{element}', $element->toHtml(), $html);

        } else {
            $this->_groupElements[] = $element->toHtml();
        }
    } // end func renderElement

   /**
    * Called when visiting a form, after processing all form elements
    * Adds required note, form attributes, validation javascript and form content.
    * 
    * @param    object      An HTML_QuickForm object being visited
    * @access   public
    * @return   void
    */
    function finishForm(&$form)
    {
        if ($this->_fieldsetIsOpen) {
            $this->_html .= $this->_closeFieldsetTemplate;
        }
        parent::finishForm($form);
    } // end func finishForm

    /**
     * Sets the template used when opening a fieldset
     *
     * @param       string      The HTML used when opening a fieldset
     * @access      public
     * @return      void
     */
    function setOpenFieldsetTemplate($html)
    {
        $this->_openFieldsetTemplate = $html;
    } // end func setOpenFieldsetTemplate

    /**
     * Sets the template used when closing a fieldset
     *
     * @param       string      The HTML used when closing a fieldset
     * @access      public
     * @return      void
     */
    function setCloseFieldsetTemplate($html)
    {
        $this->_closeFieldsetTemplate = $html;
    } // end func setCloseFieldsetTemplate

    /**
     * Adds one or more element names that indicate the end of a fieldset
     * (a new one will be opened when a the next header element occurs)
     *
     * @param       mixed      Element name(s) (as array or string)
     * @access      public
     * @return      void
     */
    function addStopFieldsetElements($element)
    {
        if (is_array($element)) {
            $this->_stopFieldsetElements = array_merge($this->_stopFieldsetElements,
                                                       $element);
        } else {
            $this->_stopFieldsetElements[] = $element;
        }
    } // end func addStopFieldsetElements

} // end class HTML_QuickForm_Renderer_Default
?>
