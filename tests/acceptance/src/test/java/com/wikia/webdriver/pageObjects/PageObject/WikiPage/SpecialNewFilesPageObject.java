package com.wikia.webdriver.pageObjects.PageObject.WikiPage;

import java.io.File;
import java.io.IOException;
import java.net.URISyntaxException;

import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.interactions.Actions;
import org.openqa.selenium.remote.LocalFileDetector;
import org.openqa.selenium.support.FindBy;
import org.openqa.selenium.support.PageFactory;
import org.openqa.selenium.remote.RemoteWebElement;
import org.testng.Assert;

import com.wikia.webdriver.Common.CommonFunctions;
import com.wikia.webdriver.pageObjects.PageObject.WikiBasePageObject;

public class SpecialNewFilesPageObject extends WikiBasePageObject{

	private String wikiname;
	@FindBy(css="header[id='WikiaPageHeader'] a.wikia-button") 
	private WebElement AddAphotoButton;
	@FindBy(css="input[name='wpUploadFile']") 
	private WebElement BrowseForFileInput;
	@FindBy(css="div.step-1 input[value*='Upload']") 
	private WebElement UploadFileInput;
	
	public SpecialNewFilesPageObject(WebDriver driver, String wikiname) {
		
		super(driver, wikiname);
		this.wikiname = wikiname;
		PageFactory.initElements(driver, this);
	}

	public String getWikiName() {
		return wikiname;
	}
	
	public void ClickOnAddaPhoto() {
		
		waitForElementByElement(AddAphotoButton);
		click(AddAphotoButton);
	}
	
	public void ClickOnUploadaPhoto() {
		waitForElementByElement(UploadFileInput);
		click(UploadFileInput);
	}
	/**
	 * Selects given image in upload browser. 
	 * Method contains autoit exe file!
	 * Attention: look: at param
	 * 
	 * Eg. TypeInFileToUploadPath(Image001)
	 * 
	 * @author Michal Nowierski
	 * ** @param file First letter must be in upper case! Look at folder acceptance/AutoitScripts. There is e.g BrowserWindowSelectImage001.exe, so to upload image001 you must type Image001 
	 */
	public void TypeInFileToUploadPath(String file){
		this.clickActions(BrowseForFileInput);
		try {
			try {
				Thread.sleep(1000);
			
			} catch (InterruptedException e) {}
			Process proc = Runtime.getRuntime().exec("AutoitScripts/BrowserWindowSelect"+file+".exe");
			try {
				Thread.sleep(2000);
			
			} catch (InterruptedException e) {}	
		} catch (IOException e) {
			
		}
	}
}
