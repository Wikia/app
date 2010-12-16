<?php
/** To get this working you must
* - set a valid path to PEAR
* - check upload size in php.ini: Multipage.tiff needs at least 3M
* - Either upload multipage.tiff when PagedTiffHandler is active or set $wgSeleniumTiffTestUploads = true
* - set the locale to german
*/


if (!defined('MEDIAWIKI') || !defined('SELENIUMTEST')) {
	echo "This script cannot be run standalone";
	exit(1);
}

$wgSeleniumTiffTestUploads = false;
$wgSeleniumTiffTestCheckPrerequistes = true;

class SeleniumCheckPrerequisites extends SeleniumTestCase
{
    public $name = "Check prerequisites";

    public function runTest()
    {
        global $wgSeleniumTestsWikiUrl;
		// check whether Multipage.tiff is already uploaded
        $this->open($wgSeleniumTestsWikiUrl.'/index.php?title=Image:Multipage.tiff');

        $source = $this->getAttribute("//div[@id='bodyContent']//ul@id");
        $this->assertEquals($source, 'filetoc');
		
		//check for language
		$this->open($wgSeleniumTestsWikiUrl.'/index.php/Special:Preferences');
		
		$source = $this->getAttribute("//select[@id='mw-input-language']/option[@value='de']/@selected");
        $this->assertEquals($source, 'selected');
       }
}


class SeleniumUploadTiffTest extends SeleniumTestCase
{
    public function uploadFile($filename)
    {
        global $wgSeleniumTestsWikiUrl;
        $this->open($wgSeleniumTestsWikiUrl.'/index.php?title=Special:Upload');
        $this->type("wpUploadFile", dirname(__FILE__)."\\testImages\\".$filename);
        $this->check("wpIgnoreWarning");
        $this->click("wpUpload");
        $this->waitForPageToLoad(30000);
    }

    public function assertUploaded($filename)
    {
        $this->assertSeleniumHTMLContains('//h1[@class="firstHeading"]', ucfirst($filename));
    }

    public function assertErrorMsg($msg)
    {
        $this->assertSeleniumHTMLContains('//div[@id="bodyContent"]//span[@class="error"]', $msg);
    }

}

class SeleniumUploadWorkingTiffTest extends SeleniumUploadTiffTest
{
    public $name = "Upload working Tiff: ";
    private $filename;

    public function __construct($filename)
    {
        parent::__construct();
        $this->filename = $filename;
        $this->name .= $filename;
    }
    
    public function runTest()
    {
        $this->uploadFile($this->filename);
        $this->assertUploaded(str_replace("_", " ", $this->filename));
    }
}

class SeleniumUploadBrokenTiffTest extends SeleniumUploadTiffTest
{
    public $name = "Upload broken Tiff: ";
    private $filename;
    private $errorMsg;

    public function __construct($filename, $errorMsg)
    {
        parent::__construct();
        $this->filename = $filename;
        $this->name .= $filename;
        $this->errorMsg = $errorMsg;
    }

    public function runTest()
    {
        $this->uploadFile($this->filename);
        $this->assertErrorMsg($this->errorMsg);
    }
}

class SeleniumDeleteTiffTest extends SeleniumTestCase
{
    public $name = "Delete Tiff: ";
    private $filename;

    public function __construct($filename)
    {
        parent::__construct();
        $this->filename = $filename;
        $this->name .= $filename;
    }
    public function runTest()
    {
        global $wgSeleniumTestsWikiUrl;
        $this->open($wgSeleniumTestsWikiUrl.'/index.php?title=Image:'.ucfirst($this->filename).'&action=delete');
        $this->type("wpReason", "Remove test file");
        $this->click("mw-filedelete-submit");
        $this->waitForPageToLoad(10000);

        // Todo: This message is localized
        $this->assertSeleniumHTMLContains('//div[@id="bodyContent"]/p', ucfirst($this->filename).'.*wurde gelöscht.');


    }
}

class SeleniumEmbedTiffTest extends SeleniumTestCase //PHPUnit_Extensions_SeleniumTestCase
{

    public function tearDown()
    {
        global $wgSeleniumTestsWikiUrl;
        parent::tearDown();
        //Clear EmbedTiffTest page for future tests
        $this->open($wgSeleniumTestsWikiUrl.'/index.php?title=EmbedTiffTest&action=edit');
        $this->type("wpTextbox1", "");
        $this->click("wpSave");
    }

    public function preparePage($text)
    {
        global $wgSeleniumTestsWikiUrl;
        $this->open($wgSeleniumTestsWikiUrl.'/index.php?title=EmbedTiffTest&action=edit');
        $this->type("wpTextbox1", $text);
        $this->click("wpSave");
        $this->waitForPageToLoad(10000);
    }

}

class SeleniumTiffPageTest extends SeleniumTestCase
{
    public function tearDown()
    {
        parent::tearDown();
        //Clear EmbedTiffTest page for future tests
        $this->open($wgSeleniumTestsWikiUrl.'/index.php?title=Image:'.$this->image.'&action=edit');
        $this->type("wpTextbox1", "");
        $this->click("wpSave");
    }

   public function prepareImagePage($image, $text)
    {
        global $wgSeleniumTestsWikiUrl;
        $this->image = $image;
        $this->open($wgSeleniumTestsWikiUrl.'/index.php?title=Image:'.$image.'&action=edit');
        $this->type("wpTextbox1", $text);
        $this->click("wpSave");
        $this->waitForPageToLoad(10000);

    }
}

class SeleniumDisplayInCategoryTest extends SeleniumTiffPageTest
{
    public $name = "Display in category";

    public function runTest()
    {
        $this->prepareImagePage("Multipage.tiff","[[Category:Wiki]]\n");
        
        global $wgSeleniumTestsWikiUrl;
        $this->open($wgSeleniumTestsWikiUrl.'/index.php?title=Category:Wiki');

        //Ergebnis chekcen
        $source = $this->getAttribute("//div[@class='gallerybox']//a[@class='image']//img@src");
        $correct = strstr($source, "/page1-");
        $this->assertEquals($correct, true);

       }
}

class SeleniumDisplayInGalleryTest extends SeleniumEmbedTiffTest
{
    public $name = "Display in gallery";

    public function runTest()
    {
        $this->preparePage("<gallery>\nImage:Multipage.tiff\n</gallery>\n");

        //global $wgSeleniumTestsWikiUrl;
        //$this->open($wgSeleniumTestsWikiUrl.'/index.php?title=GalleryTest');

        //Ergebnis chekcen
        //$source = $this->getAttribute("//div[@class='gallerybox']//a[@title='Multipage.tiff']//img@src");
        $source = $this->getAttribute("//div[@class='gallerybox']//a[@class='image']//img@src");
        $correct = strstr($source, "/page1-");
        $this->assertEquals($correct, true);

       }
}

class SeleniumEmbedTiffInclusionTest extends SeleniumEmbedTiffTest
{
    public $name = "Include Tiff Images";

    public function runTest()
    {
        $this->preparePage("[[Image:Multipage.tiff]]\n");

        $this->assertSeleniumAttributeEquals("//div[@id='bodyContent']//img@height", "768");
        $this->assertSeleniumAttributeEquals("//div[@id='bodyContent']//img@width", "1024");
    }
}

class SeleniumEmbedTiffThumbRatioTest extends SeleniumEmbedTiffTest
{
    public $name = "Include Tiff Thumbnail Aspect Ratio";

    public function runTest()
    {
        $this->preparePage("[[Image:Multipage.tiff|200px]]\n");
        //$this->selenium->type("wpTextbox1", "[[Image:Pc260001.tif|thumb]]\n");

        $this->assertSeleniumAttributeEquals("//div[@id='bodyContent']//img@height", "150");
        $this->assertSeleniumAttributeEquals("//div[@id='bodyContent']//img@width", "200");
    }
}

class SeleniumEmbedTiffBoxFitTest extends SeleniumEmbedTiffTest
{
    public $name = "Include Tiff Box Fit";

    public function runTest()
    {
        $this->preparePage("[[Image:Multipage.tiff|200x75px]]\n");

        $this->assertSeleniumAttributeEquals("//div[@id='bodyContent']//img@height", "75");
        $this->assertSeleniumAttributeEquals("//div[@id='bodyContent']//img@width", "100");
    }
}


class SeleniumEmbedTiffPage2InclusionTest extends SeleniumEmbedTiffTest
{
    public $name = "Include Tiff Images: Page 2";

    public function runTest()
    {
        $this->preparePage("[[Image:Multipage.tiff|page=2]]\n");
        //$this->selenium->type("wpTextbox1", "[[Image:Pc260001.tif|thumb]]\n");

        $this->assertSeleniumAttributeEquals("//div[@id='bodyContent']//img@height", "564");
        $this->assertSeleniumAttributeEquals("//div[@id='bodyContent']//img@width", "640");
    }
}

class SeleniumEmbedTiffPage2ThumbRatioTest extends SeleniumEmbedTiffTest
{
    public $name = "Include Tiff Thumbnail Aspect Ratio: Page 2";

    public function runTest()
    {
        $this->preparePage("[[Image:Multipage.tiff|320px|page=2]]\n");

        $this->assertSeleniumAttributeEquals("//div[@id='bodyContent']//img@height", "282");
        $this->assertSeleniumAttributeEquals("//div[@id='bodyContent']//img@width", "320");
    }
}

class SeleniumEmbedTiffPage2BoxFitTest extends SeleniumEmbedTiffTest
{
    public $name = "Include Tiff Box Fit: Page 2";

    public function runTest()
    {
        $this->preparePage("[[Image:Multipage.tiff|200x108px|page=2]]\n");

        $this->assertSeleniumAttributeEquals("//div[@id='bodyContent']//img@height", "108");
        $this->assertSeleniumAttributeEquals("//div[@id='bodyContent']//img@width", "123");
    }
}

class SeleniumEmbedTiffNegativePageParameterTest extends SeleniumEmbedTiffTest
{
    public $name = "Include Tiff: negative page parameter";

    public function runTest()
    {
        $this->preparePage("[[Image:Multipage.tiff|page=-1]]\n");

        $source = $this->getAttribute("//div[@id='bodyContent']//img@src");
        $correct = strstr($source, "/page1-");
        $this->assertEquals($correct, true);
    }
}

class SeleniumEmbedTiffPageParameterTooHighTest extends SeleniumEmbedTiffTest
{
    public $name = "Include Tiff: too high page parameter";

    public function runTest()
    {
        $this->preparePage("[[Image:Multipage.tiff|page=8]]\n");

        $source = $this->getAttribute("//div[@id='bodyContent']//img@src");
        $correct = strstr($source, "/page7-");
        $this->assertEquals($correct, true);
    }
}

// actually run tests
// create test suite
$wgSeleniumTestSuites['PagedTiffHandler'] = new SeleniumTestSuite('Paged TIFF Images');
// add tests
if ($wgSeleniumTiffTestCheckPrerequistes)
{
    $wgSeleniumTestSuites['PagedTiffHandler']->addTest(new SeleniumCheckPrerequisites());
}

if ($wgSeleniumTiffTestUploads)
{
    $wgSeleniumTestSuites['PagedTiffHandler']->addTest(new SeleniumUploadBrokenTiffTest("caspian.tif", 'Die hochgeladene Datei ist fehlerhaft.'));
    $wgSeleniumTestSuites['PagedTiffHandler']->addTest(new SeleniumUploadWorkingTiffTest("cramps.tif"));
    $wgSeleniumTestSuites['PagedTiffHandler']->addTest(new SeleniumUploadWorkingTiffTest("cramps-tile.tif"));
    $wgSeleniumTestSuites['PagedTiffHandler']->addTest(new SeleniumUploadWorkingTiffTest("dscf0013.tif"));
    $wgSeleniumTestSuites['PagedTiffHandler']->addTest(new SeleniumUploadWorkingTiffTest("fax2d.tif"));
    $wgSeleniumTestSuites['PagedTiffHandler']->addTest(new SeleniumUploadWorkingTiffTest("g3test.tif"));
    $wgSeleniumTestSuites['PagedTiffHandler']->addTest(new SeleniumUploadWorkingTiffTest("Jello.tif"));
    $wgSeleniumTestSuites['PagedTiffHandler']->addTest(new SeleniumUploadBrokenTiffTest("jim___ah.tif", 'Die errechnete Größe der Datei stimmt nicht mit der tatsächlichen überein.'));
    $wgSeleniumTestSuites['PagedTiffHandler']->addTest(new SeleniumUploadWorkingTiffTest("jim___cg.tif"));
    $wgSeleniumTestSuites['PagedTiffHandler']->addTest(new SeleniumUploadBrokenTiffTest("jim___dg.tif", 'Die errechnete Größe der Datei stimmt nicht mit der tatsächlichen überein.'));
    $wgSeleniumTestSuites['PagedTiffHandler']->addTest(new SeleniumUploadBrokenTiffTest("jim___gg.tif", 'Die errechnete Größe der Datei stimmt nicht mit der tatsächlichen überein.'));
    $wgSeleniumTestSuites['PagedTiffHandler']->addTest(new SeleniumUploadWorkingTiffTest("ladoga.tif"));
    $wgSeleniumTestSuites['PagedTiffHandler']->addTest(new SeleniumUploadWorkingTiffTest("off_l16.tif"));
    $wgSeleniumTestSuites['PagedTiffHandler']->addTest(new SeleniumUploadWorkingTiffTest("off_luv24.tif"));
    $wgSeleniumTestSuites['PagedTiffHandler']->addTest(new SeleniumUploadWorkingTiffTest("off_luv24.tif"));
    $wgSeleniumTestSuites['PagedTiffHandler']->addTest(new SeleniumUploadWorkingTiffTest("oxford.tif"));
    $wgSeleniumTestSuites['PagedTiffHandler']->addTest(new SeleniumUploadWorkingTiffTest("pc260001.tif"));
    $wgSeleniumTestSuites['PagedTiffHandler']->addTest(new SeleniumUploadBrokenTiffTest("quad-jpeg.tif", 'Die hochgeladene Datei konnte nicht verarbeitet werden. ImageMagick ist nicht verfügbar.'));
    $wgSeleniumTestSuites['PagedTiffHandler']->addTest(new SeleniumUploadWorkingTiffTest("quad-lzw.tif"));
    $wgSeleniumTestSuites['PagedTiffHandler']->addTest(new SeleniumUploadWorkingTiffTest("quad-tile.tif"));
    $wgSeleniumTestSuites['PagedTiffHandler']->addTest(new SeleniumUploadBrokenTiffTest("smallliz.tif", 'Die hochgeladene Datei konnte nicht verarbeitet werden. ImageMagick ist nicht verfügbar.'));
    $wgSeleniumTestSuites['PagedTiffHandler']->addTest(new SeleniumUploadWorkingTiffTest("strike.tif"));
    $wgSeleniumTestSuites['PagedTiffHandler']->addTest(new SeleniumUploadBrokenTiffTest("text.tif", 'Die hochgeladene Datei ist fehlerhaft.'));
    $wgSeleniumTestSuites['PagedTiffHandler']->addTest(new SeleniumUploadWorkingTiffTest("ycbcr-cat.tif"));
    $wgSeleniumTestSuites['PagedTiffHandler']->addTest(new SeleniumUploadBrokenTiffTest("zackthecat.tif", 'Die hochgeladene Datei konnte nicht verarbeitet werden. ImageMagick ist nicht verfügbar.'));
    $wgSeleniumTestSuites['PagedTiffHandler']->addTest(new SeleniumUploadWorkingTiffTest("multipage.tiff"));
}
//$wgSeleniumTestSuites['PagedTiffHandler']->addTest(new SeleniumUploadWorkingTiffTest("multipage.tiff"));

$wgSeleniumTestSuites['PagedTiffHandler']->addTest(new SeleniumEmbedTiffInclusionTest());
$wgSeleniumTestSuites['PagedTiffHandler']->addTest(new SeleniumEmbedTiffThumbRatioTest());
$wgSeleniumTestSuites['PagedTiffHandler']->addTest(new SeleniumEmbedTiffBoxFitTest());

$wgSeleniumTestSuites['PagedTiffHandler']->addTest(new SeleniumEmbedTiffPage2InclusionTest());
$wgSeleniumTestSuites['PagedTiffHandler']->addTest(new SeleniumEmbedTiffPage2ThumbRatioTest());
$wgSeleniumTestSuites['PagedTiffHandler']->addTest(new SeleniumEmbedTiffPage2BoxFitTest());

$wgSeleniumTestSuites['PagedTiffHandler']->addTest(new SeleniumEmbedTiffNegativePageParameterTest());
$wgSeleniumTestSuites['PagedTiffHandler']->addTest(new SeleniumEmbedTiffPageParameterTooHighTest());

$wgSeleniumTestSuites['PagedTiffHandler']->addTest(new SeleniumDisplayInCategoryTest());
$wgSeleniumTestSuites['PagedTiffHandler']->addTest(new SeleniumDisplayInGalleryTest());

if ($wgSeleniumTiffTestUploads)
{
    $wgSeleniumTestSuites['PagedTiffHandler']->addTest(new SeleniumDeleteTiffTest("cramps.tif"));
    $wgSeleniumTestSuites['PagedTiffHandler']->addTest(new SeleniumDeleteTiffTest("cramps-tile.tif"));
    $wgSeleniumTestSuites['PagedTiffHandler']->addTest(new SeleniumDeleteTiffTest("dscf0013.tif"));
    $wgSeleniumTestSuites['PagedTiffHandler']->addTest(new SeleniumDeleteTiffTest("fax2d.tif"));
    $wgSeleniumTestSuites['PagedTiffHandler']->addTest(new SeleniumDeleteTiffTest("g3test.tif"));
    $wgSeleniumTestSuites['PagedTiffHandler']->addTest(new SeleniumDeleteTiffTest("Jello.tif"));
    //$wgSeleniumTestSuites['PagedTiffHandler']->addTest(new SeleniumDeleteTiffTest("jim___ah.tif"));
    $wgSeleniumTestSuites['PagedTiffHandler']->addTest(new SeleniumDeleteTiffTest("jim___cg.tif"));
    //$wgSeleniumTestSuites['PagedTiffHandler']->addTest(new SeleniumDeleteTiffTest("jim___dg.tif"));
    //$wgSeleniumTestSuites['PagedTiffHandler']->addTest(new SeleniumDeleteTiffTest("jim___gg.tif"));
    $wgSeleniumTestSuites['PagedTiffHandler']->addTest(new SeleniumDeleteTiffTest("ladoga.tif"));
    $wgSeleniumTestSuites['PagedTiffHandler']->addTest(new SeleniumDeleteTiffTest("off_l16.tif"));
    $wgSeleniumTestSuites['PagedTiffHandler']->addTest(new SeleniumDeleteTiffTest("off_luv24.tif"));
    $wgSeleniumTestSuites['PagedTiffHandler']->addTest(new SeleniumDeleteTiffTest("off_luv24.tif"));
    $wgSeleniumTestSuites['PagedTiffHandler']->addTest(new SeleniumDeleteTiffTest("oxford.tif"));
    $wgSeleniumTestSuites['PagedTiffHandler']->addTest(new SeleniumDeleteTiffTest("pc260001.tif"));
    //$wgSeleniumTestSuites['PagedTiffHandler']->addTest(new SeleniumDeleteTiffTest("quad-jpeg.tif"));
    $wgSeleniumTestSuites['PagedTiffHandler']->addTest(new SeleniumDeleteTiffTest("quad-lzw.tif"));
    $wgSeleniumTestSuites['PagedTiffHandler']->addTest(new SeleniumDeleteTiffTest("quad-tile.tif"));
    //$wgSeleniumTestSuites['PagedTiffHandler']->addTest(new SeleniumDeleteTiffTest("smallliz.tif"));
    $wgSeleniumTestSuites['PagedTiffHandler']->addTest(new SeleniumDeleteTiffTest("strike.tif"));
    //$wgSeleniumTestSuites['PagedTiffHandler']->addTest(new SeleniumDeleteTiffTest("text.tif"));
    $wgSeleniumTestSuites['PagedTiffHandler']->addTest(new SeleniumDeleteTiffTest("ycbcr-cat.tif"));
    //$wgSeleniumTestSuites['PagedTiffHandler']->addTest(new SeleniumDeleteTiffTest("zackthecat.tif"));
    $wgSeleniumTestSuites['PagedTiffHandler']->addTest(new SeleniumDeleteTiffTest("multipage.tiff"));
}

