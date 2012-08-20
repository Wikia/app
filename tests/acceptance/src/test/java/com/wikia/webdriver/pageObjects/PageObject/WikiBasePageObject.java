package com.wikia.webdriver.pageObjects.PageObject;

import org.openqa.selenium.WebDriver;

import com.wikia.webdriver.pageObjects.PageObject.CreateNewWiki.CreateNewWikiPageObjectStep1;
import com.wikia.webdriver.pageObjects.PageObject.WikiPage.SpecialMultipleUploadPageObject;
import com.wikia.webdriver.pageObjects.PageObject.WikiPage.SpecialNewFilesPageObject;
import com.wikia.webdriver.pageObjects.PageObject.WikiPage.SpecialUploadPageObject;
import com.wikia.webdriver.pageObjects.PageObject.WikiPage.WikiArticlePageObject;

public class WikiBasePageObject extends BasePageObject {
	protected String Domain;

	public WikiBasePageObject(WebDriver driver, String Domain) {
		super(driver);
		this.Domain = Domain;
		}

	public String getWikiName() {
		return Domain;
	}
	
	public SpecialNewFilesPageObject OpenSpecialNewFiles() {
		driver.get(Domain+"Special:NewFiles");
		return new SpecialNewFilesPageObject(driver, Domain);
	}


	public SpecialUploadPageObject OpenSpecialUpload() {
		driver.get(Domain+"Special:Upload");
		return new SpecialUploadPageObject(driver, Domain);
	}

	public SpecialMultipleUploadPageObject OpenSpecialMultipleUpload() {
		driver.get(Domain+"Special:MultipleUpload");
		return new SpecialMultipleUploadPageObject(driver, Domain);
		
	}

	public WikiArticlePageObject OpenArticle(String wikiArticle) {
		driver.get(Domain+"wiki/"+wikiArticle);
		return new WikiArticlePageObject(driver, Domain, wikiArticle);
		
	}
	
	public CreateNewWikiPageObjectStep1 startAWiki()
	{
		return null;
		
	}
	
}
