package com.wikia.selenium.tests;

import java.io.File;

import org.testng.annotations.Parameters;
import org.testng.annotations.Test;
import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertFalse;
import static org.testng.AssertJUnit.assertTrue;

public class UploadImageTest extends BaseTest {
	private String uploadFileUrl = "http://images.wikia.com/wikiaglobal/images/b/bc/Wiki.png";
	
	

	@Test(groups={"CI", "legacy", "envProduction", "fileUpload"})
	public void testNormalUploadImage() throws Exception {
		// keep file extensions consistent (uploaded image can be either PNG or JPG)
		String fileNameExtenstion = uploadFileUrl.substring(uploadFileUrl.length() - 3, uploadFileUrl.length());
		String destinationFileName = uploadFileUrl.substring(uploadFileUrl.lastIndexOf("/") + 1);

		loginAsStaff();

		openAndWait("index.php?title=Special:Upload");
		waitForElement("wpUploadFile");

		// bug - hidden fields
		assertTrue("Form field should not be hidden", session().isVisible("wpUploadFile"));
		assertTrue("Form field should not be hidden", session().isVisible("wpDestFile"));
		assertTrue("Form field should not be hidden", session().isVisible("wpUploadDescription"));
		assertTrue("Form field should not be hidden", session().isVisible("wpWatchthis"));
		assertTrue("Form field should not be hidden", session().isVisible("wpIgnoreWarning"));

		session().attachFile("wpUploadFile", uploadFileUrl);
		session().type("wpDestFile", destinationFileName);
		session().type("wpUploadDescription", "WikiaBot automated test.");
		session().uncheck("wpWatchthis");
		session().check("wpIgnoreWarning");

		clickAndWait("wpUpload");

		assertFalse(session().isTextPresent("Upload error"));

		// upload warning - duplicate ...
		if (session().isTextPresent("Upload warning")) {
			clickAndWait("wpUpload");
		}
		assertTrue(session().isTextPresent("Image:" + destinationFileName)
				|| session().isTextPresent("File:" + destinationFileName));

		logout();
	}

	/*Delete file is removed as is deleting source file http://images.wikia.com/wikiaglobal/images/b/bc/Wiki.png Needs investigating
	 * @Test(groups={"CI", "legacy", "envProduction", "fileUpload"},dependsOnMethods="testNormalUploadImage")
	public void testDeleteUploadedImage() throws Exception {
		// keep file extensions consistent (uploaded image can be either PNG or JPG)
		String fileNameExtenstion = uploadFileUrl.substring(uploadFileUrl.length() - 3, uploadFileUrl.length());
		String destinationFileName = uploadFileUrl.substring(uploadFileUrl.lastIndexOf("/") + 1);

		loginAsStaff();
		openAndWait("index.php?title=File:" + destinationFileName);
		if (session().isElementPresent("link=delete all")) {
			clickAndWait("link=delete all");
		} else {
			clickAndWait("//a[@data-id='delete']");
		}
		waitForElement("wpReason");
		session().type("wpReason", "this was for test");
		session().uncheck("wpWatch");
		clickAndWait("mw-filedelete-submit");
		waitForTextPresent("has been deleted");
	}*/
}
