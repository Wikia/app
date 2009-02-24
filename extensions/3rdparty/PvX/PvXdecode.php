<?php
if (!defined('MEDIAWIKI'))
    die();
/**
 * A Special Page sample that can be included on a wikipage like
 * {{Special:Inc}} as well as being accessed on [[Special:Inc]]
 *
 * @addtogroup Extensions
 *
 * @author Ævar Arnfjörð Bjarmason <avarab@gmail.com>
 * @copyright Copyright © 2005, Ævar Arnfjörð Bjarmason
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */
$wgExtensionFunctions[] = 'wfPvXDecode';
$wgExtensionCredits['specialpage'][] = array(
	'name' => 'PvX Decode',
	'url' => 'http://www.gcardinal.com/',
    'description' => 'Decode from Guild Wars template to PvXcode. by-nc-nd/3.0.', 
	'author' => 'gcardinal');

if (!defined('GWBBCODE_ROOT')) define('GWBBCODE_ROOT', 'gwbbcode');
require_once(GWBBCODE_ROOT.'/gwbbcode.inc.php');

function wfPvXDecode()
{
    global $IP, $wgMessageCache;

    $wgMessageCache->addMessage('pvxdecode', 'PvXDecode');

    require_once "$IP/includes/SpecialPage.php";
    class SpecialPvXDecode extends SpecialPage
    {
        /**
         * Constructor
         */
        function SpecialPvXDecode()
        {
            SpecialPage::SpecialPage('PvXDecode');
            $this->includable(true);
        }

        /**
         * main()
         */
        function execute($par = null)
        {
            global $wgOut;
            global $wgRequest;
            global $wgScript;
            $name = $wgRequest->getText('wpName');
            $build = $wgRequest->getText('wpBuild');
            if ($this->including())
			{
                $out = "I'm being included... :(";
			} else {
                if ($build)
                {
					if (strlen($name)>1)
					{
						$rout = template_to_gwbbcode($name . ";" . $build); 
					} else {
						$rout = template_to_gwbbcode($build); 
					}
					
					$wgOut->addWikiText("== Preview ==");
					$wgOut->addWikiText("<pvxbig>" . $rout . "</pvxbig>");
					$wgOut->addHtml("<br>");
					$wgOut->addWikiText("== PvXcode ==");
					$out = "<p><textarea cols='80' rows='10' wrap='virtual'>\n<pvxbig>\n" . $rout . "\n</pvxbig>\n</textarea></p>";
					
                }
                else
                {
                    $out = '<p>
							This decoder can process Guild Wars template and return PvXcode style template.	Sample input:<br>
							<code>
							Hard Mode Farming;OQMU0QnEZpKpF4rUQl/MSik8AA
							<br>-- OR --<br>
							OANWQiiYkD3yXG1DkdJPqRkyTfA
							</code>
							<p>Enter Guild Wars template code:</p>
							<form action="" method="get">
							<input name="title" type="hidden" value="Special:PvXDecode" />
							<p><input name="wpBuild" type="text" size="80" maxlength="60" /></p>
							<p>Give new build template a name (optional):</p>
							<p><input name="wpName" type="text" size="80" maxlength="60" /></p>
							<p><input name="Go" type="submit" /></p>
							</form>';
                }
                $this->setHeaders();
            }
            $wgOut->addHtml($out);
        }
    }

    SpecialPage::addPage(new SpecialPvXDecode);
}
