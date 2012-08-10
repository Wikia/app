package com.wikia.webdriver.pageObjects.PageObject.WikiPage;

import java.io.File;
import java.io.IOException;
import java.net.URISyntaxException;
import java.util.List;

import org.junit.runner.RunWith;
import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.browserlaunchers.Sleeper;
import org.openqa.selenium.interactions.Actions;
import org.openqa.selenium.remote.LocalFileDetector;
import org.openqa.selenium.support.FindBy;
import org.openqa.selenium.support.PageFactory;
import org.openqa.selenium.remote.RemoteWebElement;
import org.testng.Assert;

import com.wikia.webdriver.Common.CommonFunctions;
import com.wikia.webdriver.pageObjects.PageObject.WikiBasePageObject;

public class SpecialNewFilesPageObject extends WikiBasePageObject{


	@FindBy(css="header[id='WikiaPageHeader'] a.wikia-button") 
	private WebElement AddAphotoButton;
	@FindBy(css="input[name='wpUploadFile']") 
	private WebElement BrowseForFileInput;
	@FindBy(css="div.step-1 input[value*='Upload']") 
	private WebElement UploadFileInput;
	@FindBy(css="div.advanced a") 
	private WebElement MoreOrFewerOptions;
	@FindBy(css="div.toggles input[name='wpIgnoreWarning']") 
	private WebElement IgnoreAnyWarnings;
	@FindBy(css="section[id='UploadPhotosWrapper']") 
	private WebElement UploadPhotoDialog;

	public SpecialNewFilesPageObject(WebDriver driver, String wikiname) {
		
		super(driver, wikiname);
		
		PageFactory.initElements(driver, this);
	}


	
	public void ClickOnAddaPhoto() {
		
		waitForElementByElement(AddAphotoButton);
		click(AddAphotoButton);
	}
	
	public void ClickOnUploadaPhoto() {
		waitForElementByElement(UploadFileInput);
		click(UploadFileInput);
	}
	
	public void ClickOnMoreOrFewerOptions() {
		waitForElementByElement(MoreOrFewerOptions);
		click(MoreOrFewerOptions);
		
	}
	public void CheckIgnoreAnyWarnings() {
		waitForElementByElement(IgnoreAnyWarnings);
		click(IgnoreAnyWarnings);
		
	}

	/**
	 * Selects given image in upload browser. 
	 * 
	 * 
	 * @author Michal Nowierski
	 * ** @param file Look at folder acceptance/ImagesForUploadTests. 
	 *  */
	public void TypeInFileToUploadPath(String file){
	sendKeys(BrowseForFileInput, System.getProperty("user.dir")+"\\ImagesForUploadTests\\"+file);
	}

	public void waitForFile(String FileName) {
		
		waitForValueToBePresentInElementsAttributeByCss("div.wikia-gallery span.wikia-gallery-item img", "src", FileName);

		
	}













	
}
