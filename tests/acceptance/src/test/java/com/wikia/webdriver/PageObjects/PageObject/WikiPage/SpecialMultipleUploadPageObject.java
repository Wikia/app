package com.wikia.webdriver.PageObjects.PageObject.WikiPage;



import java.util.List;

import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.FindBy;
import org.openqa.selenium.support.PageFactory;

import com.wikia.webdriver.Common.Logging.PageObjectLogging;
import com.wikia.webdriver.PageObjects.PageObject.WikiBasePageObject;

public class SpecialMultipleUploadPageObject extends WikiBasePageObject {

	@FindBy(css="input[name='wpIgnoreWarning']")
	private WebElement IgnoreAnyWarnings;
	@FindBy(css="input[name='wpUpload']")
	private WebElement UploadFileButton;
	@FindBy(css="form[id='mw-upload-form']")
	private WebElement MultipleUploadForm;

	
	private By FileInputs = By.cssSelector("tr.mw-htmlform-field-UploadSourceField td.mw-input input");
	private By UploadedFiles = By.cssSelector("tr.mw-htmlform-field-UploadSourceField td.mw-input input");
	private By UploadedFilesListContener = By.cssSelector("div[id='mw-content-text']");
	private By UploadedFilesList = By.cssSelector("div[id='mw-content-text'] ul li a");
		
	public SpecialMultipleUploadPageObject(WebDriver driver, String Domain) {
		
		super(driver, Domain);
		
		PageFactory.initElements(driver, this);
	}

	/**
	 * Selects given files in upload browser. 
	 * 
	 * 
	 * @author Michal Nowierski
	 * ** @param FilesNamesList List of files to be uploaded 
	 * <p> Look at folder acceptancesrc/src/test/resources/ImagesForUploadTests - this is where those files are stored
	 *  */
	public void TypeInFilesToUpload(String[] FilesNamesList) {
		if (FilesNamesList==null) {
			PageObjectLogging.log("TypeInFilesToUpload", "File names list can not be null", false, driver);
								}
		else if (FilesNamesList.length>10 || FilesNamesList.length == 0) {
			PageObjectLogging.log("TypeInFilesToUpload", "You can upload from 1 to 10 files using MultipleUpload. "+FilesNamesList.length+" files is unaccpetable", false, driver);
					}
		else {
		waitForElementByElement(MultipleUploadForm);
		List<WebElement> FileInputsLits = driver.findElements(FileInputs);
		for (int i = 0; i < FilesNamesList.length; i++) {
			FileInputsLits.get(i).sendKeys(System.getProperty("user.dir")+"\\src\\test\\resources\\ImagesForUploadTests\\"+FilesNamesList[i]);
		}
		PageObjectLogging.log("TypeInFilesToUpload", "Upload "+FilesNamesList.length+" files, specified in FilesNamesList", true, driver);	
		}
	}

	public void CheckIgnoreAnyWarnings() {
		waitForElementByElement(IgnoreAnyWarnings);
		click(IgnoreAnyWarnings);
		PageObjectLogging.log("CheckIgnoreAnyWarnings", "Check 'Ignore Any Warnings' option", true, driver);
		
	}

	public void ClickOnUploadFile() {
		waitForElementByElement(UploadFileButton);
		click(UploadFileButton);
		PageObjectLogging.log("ClickOnUploadFile", "Click on Upload File button", true, driver);
		
	}

	/**
	 * Checks if the upload have been succesful. 
	 * <p> The method checks if the uploaded files correspond to those in FilesNamesList. FFilesNamesList is a parameter of the method
	 *
	 *  @author Michal Nowierski
	 ** @param FilesNamesList list of expected names of files 
	 */
	public void VerifySuccessfulUpload(String[] FilesNamesList) {
		waitForElementByBy(UploadedFilesListContener);
		
		List<WebElement> UploadedFileslist = driver.findElements(UploadedFilesList);
		for (int i = 0; i < FilesNamesList.length; i++) {
			if (!UploadedFileslist.get(i).getText().contains(FilesNamesList[i])) {
				PageObjectLogging.log("VerifySuccessfulUpload", "the uploaded list element number "+(i+1)+"does not contain expected string: "+FilesNamesList[i]+"<br> The element Text is: "+UploadedFileslist.get(i).getText(), false, driver);
							}
		}
		PageObjectLogging.log("VerifySuccessfulUpload", "Verify that the upload was succesful by checking the list of uploaded files", true, driver);
		
	}


}
