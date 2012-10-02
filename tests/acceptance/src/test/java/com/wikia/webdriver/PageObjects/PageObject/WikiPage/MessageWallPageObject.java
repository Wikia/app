package com.wikia.webdriver.PageObjects.PageObject.WikiPage;

import org.openqa.selenium.By;
import org.openqa.selenium.Keys;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.FindBy;
import org.openqa.selenium.support.PageFactory;

import com.google.inject.Key;
import com.wikia.webdriver.Common.Core.Global;
import com.wikia.webdriver.Common.Logging.PageObjectLogging;
import com.wikia.webdriver.PageObjects.PageObject.WikiBasePageObject;

public class MessageWallPageObject extends WikiBasePageObject{

	@FindBy(css="#cke_contents_WallMessageBody iframe")
	private WebElement messageWallIFrame;
	@FindBy(css=".cke_wrapper.cke_ltr iframe")
	private WebElement messageWallEditIFrame;
	@FindBy(css="#WallMessageTitle")
	private WebElement messageTitleField;
	@FindBy(xpath="//ul[@class='comments']//textarea[2]")
	private WebElement messageTitleEditField;
	@FindBy(css="#bodyContent")
	private WebElement messageBodyField;
	@FindBy(css=".wikia-button.save-edit")
	private WebElement saveEditButton;
	@FindBy(css="#WallMessageSubmit")
	private WebElement postButton;
	@FindBy(css=".buttonswrapper .wikia-menu-button.secondary.combined")
	private WebElement moreButton;
	@FindBy(css=".edit-message")
	private WebElement editMessageButton;
	@FindBy(css=".WikiaMenuElement .remove-message")
	private WebElement removeMessageButton;
	@FindBy(css="#WikiaConfirm")
	private WebElement removeMessageOverLay;
	@FindBy(css="#reason")
	private WebElement removeMessageReason;
	@FindBy(css="#WikiaConfirmOk")
	private WebElement removeMessageConfirmButton;
	@FindBy(css=".speech-bubble-message-removed")
	private WebElement removeMessageConfirmation;
	@FindBy(css=".RTEImageButton .cke_icon")
	private WebElement addImageButton;
	@FindBy(css="img.image.thumb")
	private WebElement imageInMessageEditMode;
	@FindBy(css="img.video.thumb")
	private WebElement videoInMessageEditMode;
	@FindBy(css=".RTEVideoButton .cke_icon")
	private WebElement addVideoButton;
	@FindBy(css="span.cke_button.cke_off.cke_button_link a .cke_icon")
	private WebElement addLinkButton;
	
	
	By messageTitle = By.cssSelector(".msg-title");
	
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
		PageObjectLogging.log("triggerMessageArea", "message area is triggered", true, driver);
	}
	
	public void writeMessage(String title, String message)
	{
		messageTitleField.click();
		messageTitleField.sendKeys(title);
		triggerMessageArea();
		waitForElementByElement(messageWallIFrame);
		messageTitleField.sendKeys(Keys.TAB);
		driver.switchTo().frame(messageWallIFrame);
		waitForElementByElement(messageBodyField);
		messageBodyField.sendKeys(message);
		driver.switchTo().defaultContent();
		PageObjectLogging.log("writeMessage", "message is written, title: "+title+" body: "+message, true, driver);
	}

	public void writeMessageNoTitle(String message)
	{
		messageTitleField.click();
		triggerMessageArea();
		waitForElementByElement(messageWallIFrame);
		messageTitleField.sendKeys(Keys.TAB);
		driver.switchTo().frame(messageWallIFrame);
		messageBodyField.sendKeys(message);
		driver.switchTo().defaultContent();
		PageObjectLogging.log("writeMessage", "message is written, body: "+message, true, driver);
	}
	
	private void verifyImageInMessageEditMode()
	{
		waitForElementByElement(messageWallIFrame);
		driver.switchTo().frame(messageWallIFrame);
		waitForElementByElement(imageInMessageEditMode);
		driver.switchTo().defaultContent();
	}
	
	private void verifyVideoInMessageEditMode()
	{
		waitForElementByElement(messageWallIFrame);
		driver.switchTo().frame(messageWallIFrame);
		waitForElementByElement(videoInMessageEditMode);
		driver.switchTo().defaultContent();
	}
	
	public void writeMessageImage(String title)
	{
		messageTitleField.click();
		messageTitleField.sendKeys(title);
		triggerMessageArea();
		waitForElementByElement(addImageButton);
		addImageButton.click();
		waitForModalAndClickAddThisPhoto();
		clickOnAddPhotoButton2();
		verifyImageInMessageEditMode();
		PageObjectLogging.log("writeMessageImage", "message is written, with image "+title, true, driver);
	}
	
	
	public void writeMessageVideo(String title, String url)
	{
		messageTitleField.click();
		messageTitleField.sendKeys(title);
		triggerMessageArea();
		waitForElementByElement(addVideoButton);
		addVideoButton.click();
		waitForVideoModalAndTypeVideoURL(url);
		clickVideoNextButton();
		waitForVideoDialog();
		clickAddAvideo();
		waitForSuccesDialogAndReturnToEditing();
		verifyVideoInMessageEditMode();
		PageObjectLogging.log("writeMessageVideo", "message is written, with video "+title, true, driver);
	}
	
	
	public void writeMessageLink(String title, String url)
	{
		messageTitleField.click();
		messageTitleField.sendKeys(title);
		triggerMessageArea();
		waitForElementByElement(addLinkButton);
		addLinkButton.click();
		
		waitForVideoModalAndTypeVideoURL(url);
		clickVideoNextButton();
		waitForVideoDialog();
		clickAddAvideo();
		waitForSuccesDialogAndReturnToEditing();
		verifyVideoInMessageEditMode();
		PageObjectLogging.log("writeMessageVideo", "message is written, with video "+title, true, driver);
	}
	
	
	public void clickPostButton()
	{
		waitForElementByElement(postButton);
		jQueryClick("#WallMessageSubmit");
		PageObjectLogging.log("clickPostButton", "post button is clicked", true, driver);		
	}
	
	public void clickPostNotitleButton()
	{
		waitForElementByElement(postButton);
		jQueryClick("#WallMessageSubmit");
		waitForElementByXPath("//button[@id='WallMessageSubmit' and contains(text(), 'Post without a title')]");
		waitForElementByXPath("//div[@class='no-title-warning' and contains(text(), 'You did not specify any title')]");
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
	
	
	
	
	public void verifyPostedMessageVideo(String title)
	{
		waitForElementByXPath("//div[@class='msg-title']/a[contains(text(), '"+title+"')]/../../div[@class='editarea']//a[@class='image video']");
		PageObjectLogging.log("verifyPostedMessageImage", "message with image title verified", true, driver);		
	}
	
	public void verifyPostedMessageImage(String title)
	{
		waitForElementByXPath("//div[@class='msg-title']/a[contains(text(), '"+title+"')]/../../div[@class='editarea']//img[@class='thumbimage']");
		PageObjectLogging.log("verifyPostedMessageImage", "message with image title verified", true, driver);		
	}
	
	public void removeMessage(String reason)
	{
		executeScript("document.getElementsByClassName(\"buttons\")[1].style.display = \"block\"");
		waitForElementByElement(moreButton);
		moreButton.click();
		waitForElementByElement(removeMessageButton);
		jQueryClick(".WikiaMenuElement .remove-message");
		waitForElementByElement(removeMessageOverLay);
		waitForElementByElement(removeMessageConfirmButton);
		removeMessageReason.sendKeys(reason);
		removeMessageConfirmButton.click();
		waitForElementByElement(removeMessageConfirmation);
		driver.navigate().refresh();
//		waitForElementNotVisibleByBy(messageTitle);
		PageObjectLogging.log("removeMessage", "message is removed", true, driver);
	}
	
	private void clickEditMessage()
	{
		executeScript("document.getElementsByClassName(\"buttons\")[1].style.display = \"block\"");
		waitForElementByElement(moreButton);
		moreButton.click();
		waitForElementByElement(editMessageButton);
		jQueryClick(".edit-message");
		waitForElementByElement(messageWallEditIFrame);
		PageObjectLogging.log("clickEditMessage", "edit message button is clicked", true, driver);
	}
	
	private void writeEditMessage(String title, String message)
	{
		waitForElementByElement(messageWallEditIFrame);
		driver.switchTo().frame(messageWallEditIFrame);
		waitForElementByElement(messageBodyField);
		messageBodyField.clear();
		messageBodyField.sendKeys(message);
		driver.switchTo().defaultContent();
		waitForElementByElement(messageTitleEditField);
		messageTitleEditField.clear();
		messageTitleEditField.sendKeys(title);
		waitForElementByElement(saveEditButton);
		saveEditButton.click();
	}
	
	public void editMessage(String title, String message)
	{
		clickEditMessage();
		writeEditMessage(title, message);
		
	}
	
}
