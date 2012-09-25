package com.wikia.webdriver.PageObjects.PageObject.WikiPage;

import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.FindBy;
import org.openqa.selenium.support.PageFactory;

import com.wikia.webdriver.Common.Core.Global;
import com.wikia.webdriver.Common.Logging.PageObjectLogging;
import com.wikia.webdriver.PageObjects.PageObject.WikiBasePageObject;

public class MessageWallPageObject extends WikiBasePageObject{

	@FindBy(css="#cke_contents_WallMessageBody iframe")
	private WebElement messageWallIFrame;
	@FindBy(css="#WallMessageTitle")
	private WebElement messageTitle;
	@FindBy(css="#bodyContent")
	private WebElement messageBody;
	@FindBy(css="#WallMessageSubmit")
	private WebElement postButton;
	
	
	public MessageWallPageObject(WebDriver driver, String Domain) {
		super(driver, Domain);
		PageFactory.initElements(driver, this);
	}
	
	public MessageWallPageObject openMessageWall(String userName)
	{
		driver.get(Global.DOMAIN+"wiki/Message_Wall:"+userName);
		waitForElementByXPath("//h1[@itemprop='name' and contains(text(), '"+userName+"')]");
		PageObjectLogging.log("openMessageWall", "message wall for user "+userName+" was opened", true, driver);
		return new MessageWallPageObject(driver, userName);
	}
	
	private void triggerMessageArea()
	{
		jQueryFocus("#WallMessageBody");
		waitForElementByElement(messageWallIFrame);
	}
	
	public void writeMessage(String title, String message)
	{
		//verify message area before populating fields
//		waitForElementByElement(messageTitle);
//		driver.switchTo().frame(messageWallIFrame);
//		waitForElementByElement(messageBody);
//		driver.switchTo().defaultContent();
		//
//		triggerMessageArea();
		messageTitle.click();
		messageTitle.sendKeys(title);
		triggerMessageArea();
		waitForElementByElement(messageWallIFrame);
		driver.switchTo().frame(messageWallIFrame);
		messageBody.sendKeys(message);
		driver.switchTo().defaultContent();
		PageObjectLogging.log("writeMessage", "message is written, title: "+title+" body: "+message, true, driver);
	}
	
	public void clickPostButton()
	{
		waitForElementByElement(postButton);
		jQueryClick("#WallMessageSubmit");
		PageObjectLogging.log("clickPostButton", "post button is clicked", true, driver);		
	}
	
	public void verifyPostedMessageWithTitle(String title, String message)
	{
		waitForElementByXPath("//div[@class='msg-title']/a[contains(text(), '"+title+"')]");
		waitForElementByXPath("//div[@class='msg-body']/p[contains(text(), '"+message+"')]");
		PageObjectLogging.log("verifyPostedMessageWithTitle", "message with title verified", true, driver);		
	}
	
	public void verifyPostedMessageWithoutTitle(String userName, String message)
	{
		waitForElementByXPath("//div[@class='msg-title']/a[contains(text(), 'Message from "+userName+"')]");
		waitForElementByXPath("//div[@class='msg-body']/p[contains(text(), '"+message+"')]");
		PageObjectLogging.log("verifyPostedMessageWithTitle", "message without title verified", true, driver);		
	}
	
}
