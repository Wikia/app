package com.wikia.webdriver.PageObjects.PageObject.WikiPage;

import org.openqa.selenium.WebDriver;
import org.openqa.selenium.support.PageFactory;

public class WikiArticleRevisionEditMode extends WikiArticleEditMode{

	public WikiArticleRevisionEditMode(WebDriver driver, String Domain,
			String articlename) {
		super(driver, Domain, articlename);
		PageFactory.initElements(driver, this);
		// TODO Auto-generated constructor stub
	}

}
