package com.wikia.webdriver.pageObjects.PageObject.WikiPage;

import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.FindBy;
import org.openqa.selenium.support.PageFactory;
import org.openqa.selenium.support.ui.ExpectedConditions;


import com.wikia.webdriver.Logging.PageObjectLogging;
import com.wikia.webdriver.pageObjects.PageObject.WikiBasePageObject;

public class WikiArticlePageObject extends WikiBasePageObject {
	
	protected String articlename;
	
	@FindBy(css="nav.wikia-menu-button a[accesskey='e']")
	private WebElement EditButton;
	
	private By ImageOnWikiaArticle = By.cssSelector("div.WikiaArticle figure a img");
	

	public WikiArticlePageObject(WebDriver driver, String wikiname,
			String wikiArticle) {
		super(driver, wikiname);
		this.articlename = wikiArticle;
		PageFactory.initElements(driver, this);
	}

	/**
	 * Click Edit button on a wiki article
	 *  
	 * @author Michal Nowierski
	 */
	public WikiArticleEditMode Edit() {
		waitForElementByElement(EditButton);
		PageObjectLogging.log("Edit", "Edit Article: "+articlename+", on wiki: "+wikiname+"", true, driver);
		EditButton.click();
		return new WikiArticleEditMode(driver, wikiname, articlename);
	}

	/**
	 * Verify that the image appears on the page
	 *  
	 * @author Michal Nowierski
	 */
	public void VerifyTheImageOnThePage() {
		PageObjectLogging.log("VerifyTheImageOnThePage", "Verify that the image appears on the page", true, driver);
		waitForElementByBy(ImageOnWikiaArticle);
				
	}

}
