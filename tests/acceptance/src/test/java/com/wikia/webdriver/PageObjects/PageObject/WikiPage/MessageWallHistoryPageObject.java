package com.wikia.webdriver.PageObjects.PageObject.WikiPage;

import java.util.List;

import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.FindBy;
import org.openqa.selenium.support.PageFactory;

import com.wikia.webdriver.Common.Logging.PageObjectLogging;
import com.wikia.webdriver.PageObjects.PageObject.WikiBasePageObject;

public class MessageWallHistoryPageObject extends WikiBasePageObject {

	@FindBy(css="#WallThreadHistory")
	private WebElement wallThreadHistory;
	@FindBy(css="div.BreadCrumbs a")
	private WebElement messageWallLink;
	
	public MessageWallHistoryPageObject(WebDriver driver, String Domain) {
		super(driver, Domain);
		PageFactory.initElements(driver, this);
	}
	
	public void verifyThreadHistory() {
		waitForElementByElement(wallThreadHistory);
		PageObjectLogging.log("verifyThreadHistory", "thread history table is visible", true, driver);
	}
	
	public void verifyThreadHistoryElements() {
		waitForElementByElement(wallThreadHistory);
		List<WebElement> list = wallThreadHistory.findElements(By.cssSelector("td"));
		waitForElementByElement(list.get(0).findElement(By.cssSelector("a")));
		waitForElementByElement(list.get(1).findElement(By.cssSelector("img")));
		waitForElementByElement(list.get(2).findElement(By.cssSelector("a")));
		waitForElementByElement(list.get(3).findElement(By.cssSelector("span")));
		PageObjectLogging.log("verifyThreadHistoryElements", "elements of the history table verified", true, driver);
	}
	
	public MessageWallPageObject navigateBackToMessageWall() {
		waitForElementByElement(messageWallLink);
		messageWallLink.click();	
		return new MessageWallPageObject(driver, Domain);
		
	}
	
}
