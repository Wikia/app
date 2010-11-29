package com.wikia.selenium.tests;

import java.io.File;

import org.testng.annotations.Parameters;
import org.testng.annotations.Test;
import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertFalse;
import static org.testng.AssertJUnit.assertTrue;

public class UploadImageTest extends BaseTest {
    private String uploadFileUrl = "http://images.wikia.com/wikiaglobal/images/b/bc/Wiki.png";

	@Test(groups={"CI"})
	public void testNormalUploadImage() throws Exception {
		// keep file extensions consistent (uploaded image can be either PNG or JPG)
		String fileNameExtenstion = uploadFileUrl.substring(uploadFileUrl.length() - 3, uploadFileUrl.length());
		String destinationFileName = uploadFileUrl.substring(uploadFileUrl.lastIndexOf("/") + 1);

		login();

		session().open("index.php?title=Special:Upload");
		session().waitForPageToLoad(TIMEOUT);
		session().attachFile("wpUploadFile", uploadFileUrl);
		session().type("wpDestFile", destinationFileName);
		session().type("wpUploadDescription", "WikiaBot automated test.");
		session().uncheck("wpWatchthis");
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

	@Test(groups={"CI"},dependsOnMethods="testNormalUploadImage")
	public void testDeleteUploadedImage() throws Exception {
		// keep file extensions consistent (uploaded image can be either PNG or JPG)
		String fileNameExtenstion = uploadFileUrl.substring(uploadFileUrl.length() - 3, uploadFileUrl.length());
		String destinationFileName = uploadFileUrl.substring(uploadFileUrl.lastIndexOf("/") + 1);

		loginAsStaff();
		session().open("index.php?title=File:" + destinationFileName);
		session().waitForPageToLoad(TIMEOUT);
		clickAndWait("//a[@data-id='delete']");
		session().type("wpReason", "this was for test");
		session().uncheck("wpWatch");
		clickAndWait("mw-filedelete-submit");
		assertTrue(session().isTextPresent("\"File:" + destinationFileName + "\" has been deleted."));
	}
}
