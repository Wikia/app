package com.wikia.webdriver.PageObjects.PageObject.WikiPage;






import java.util.List;

import org.openqa.selenium.By;
import org.openqa.selenium.Keys;
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
	@FindBy(css="div.cke_wrapper.cke_ltr iframe")
	private WebElement messageWallEditIFrame;
	@FindBy(css="#WallMessageTitle")
	private WebElement messageTitleField;
	@FindBy(css="ul .msg-title textarea:nth-child(2)")
	private WebElement messageTitleEditField2;
	@FindBy(xpath="//ul[@class='comments']//textarea[2]")
	private WebElement messageTitleEditField;
	@FindBy(css="body#bodyContent")
	private WebElement messageBodyField;
	@FindBy(css=".wikia-button.save-edit")
	private WebElement saveEditButton;
	@FindBy(css="#WallMessageSubmit")
	private WebElement postButton;
	@FindBy(css="#WallMessagePreview")
	private WebElement previewButton;
	@FindBy(css=".buttonswrapper .wikia-menu-button.secondary.combined")
	private WebElement moreButton;
	@FindBy(css="a.thread-history")
	private WebElement historyButton;
	@FindBy(css="a.edit-message")
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
	@FindBy(css="span.cke_button.cke_off.cke_button_bold a .cke_icon")
	private WebElement boldButton;
	@FindBy(css="span.cke_button.cke_off.cke_button_itallic a .cke_icon")
	private WebElement italicButton;
	@FindBy(css="div.msg-title a")
	private WebElement messageTitle;
	@FindBy(css="div.edited-by a")
	private WebElement messageAuthor;
	@FindBy(css="div.msg-body p")
	private WebElement messageBody;
	@FindBy(css="a#publish")
	private WebElement publishButton;
	@FindBy(css="input.cke_dialog_ui_input_text")
	private WebElement targetPageOrURL;
	@FindBy(css="p.link-type-note span")
	private WebElement linkPageStatus;
	@FindBy(css="span.cke_dialog_ui_button")
	private WebElement linkModalOkButton;
	@FindBy(css="input[value='ext']")
	private WebElement externalLinkOption;
	@FindBy(css="a.cke_button_ModeSource .cke_icon")
	private WebElement sourceModeButton;
	@FindBy(css="textarea.cke_source")
	private WebElement sourceModeTextarea;
	@FindBy(css=".SortingSelected")
	private WebElement sortingMenu;
	
	By messageList = By.cssSelector("div.msg-body");
	By sortingList = By.cssSelector("ul.SortingList li a");
	
//	By messageTitle = By.cssSelector(".msg-title");
	
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
	
	
	public void writeBoldMessage(String title, String message) {
		writeSpecialMessage(title, message, "Bold");
	}
	public void writeItalicMessage(String title, String message) {
		writeSpecialMessage(title, message, "Italic");
	}
	
	public void writeSpecialMessage(String title, String message, String special) {	
		String specialKey = "Not Initialized";
		if (special.equals("Bold")) {
			specialKey = "b";
		}
		if (special.equals("Italic")) {
			specialKey = "i";
		}
		messageTitleField.sendKeys(title);		
		triggerMessageArea();
		waitForElementByElement(messageWallIFrame);
		jQueryClick("span.cke_button.cke_off.cke_button_bold a .cke_icon");
		messageTitleField.sendKeys(Keys.TAB);
		driver.switchTo().frame(messageWallIFrame);
		waitForElementByElement(messageBodyField);
		messageBodyField.sendKeys(message);
		messageBodyField.sendKeys(Keys.LEFT_CONTROL + "a" );
		messageBodyField.sendKeys(Keys.LEFT_CONTROL + specialKey );	
		driver.switchTo().defaultContent();
		PageObjectLogging.log("write"+special+"Message", special + " message is written, title: "+title+" body: "+message, true, driver);		
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
	
	public void clickPreviewButton() {
		waitForElementByElement(previewButton);
		previewButton.click();
		PageObjectLogging.log("clickPreviewButton", "preview button is clicked", true, driver);
		
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
		waitForTextToBePresentInElementByElement(messageTitle, title);
		waitForTextToBePresentInElementByElement(messageBody, message);
//		waitForElementByXPath("//div[@class='msg-title']/a[contains(text(), '"+title+"')]");
//		waitForElementByXPath("//div[@class='msg-body']/p[contains(text(), '"+message+"')]");
		PageObjectLogging.log("verifyPostedMessageWithTitle", "message with title verified", true, driver);		
	}
	public void verifyPostedBoldMessageWithTitle(String title, String message) {
		waitForTextToBePresentInElementByElement(messageTitle, title);
		waitForTextToBePresentInElementByElement(messageBody.findElement(By.cssSelector("b")), message);
		PageObjectLogging.log("verifyPostedBoldMessageWithTitle", "bold message with title verified", true, driver);		
	}
	
	public void verifyPostedItalicMessageWithTitle(String title, String message) {
		waitForTextToBePresentInElementByElement(messageTitle, title);
		waitForTextToBePresentInElementByElement(messageBody.findElement(By.cssSelector("i")), message);
		PageObjectLogging.log("verifyPostedItalicMessageWithTitle", "italic message with title verified", true, driver);		
	}
	
	public void verifyPostedMessageWithLinks(String internallink, String externallink) {
		List<WebElement> links = messageBody.findElements(By.cssSelector("a"));
		waitForTextToBePresentInElementByElement(links.get(0), internallink);
		waitForTextToBePresentInElementByElement(links.get(1), externallink);
		
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
		waitForElementByCss("div.msg-toolbar");
		executeScript("document.getElementsByClassName(\"buttons\")[1].style.display = \"block\"");
		waitForElementByElement(moreButton);
//		moreButton.click();
		moreButton.click();
	
		waitForElementByElement(editMessageButton);
		editMessageButton.click();
//		jQueryClick(".edit-message");
//		waitForElementByElement(messageWallEditIFrame);
		PageObjectLogging.log("clickEditMessage", "edit message button is clicked", true, driver);
	}
	
	public MessageWallHistoryPageObject openHistory() {
		waitForElementByCss("div.msg-toolbar");
		executeScript("document.getElementsByClassName(\"buttons\")[1].style.display = \"block\"");
		waitForElementByElement(moreButton);
		moreButton.click();
		waitForElementByElement(historyButton);
		historyButton.click();
		PageObjectLogging.log("openHistory", "open History page of the newest thread", true, driver);
		return new MessageWallHistoryPageObject(driver, Domain);
	}
	
	private void writeEditMessage(String title, String message)
	{
		WebElement elem = driver.switchTo().activeElement();
		messageWallIFrame = elem;

		driver.switchTo().frame(messageWallIFrame);

		messageBodyField.clear();
		messageBodyField.sendKeys(message);
		driver.switchTo().defaultContent();
		
		waitForElementByElement(messageWallIFrame);
		messageTitleEditField2.click();
		messageTitleEditField2.sendKeys(Keys.TAB);
		driver.switchTo().frame(messageWallIFrame);
		messageBodyField.sendKeys(message);
		
		driver.switchTo().defaultContent();
		
		waitForElementByElement(messageTitleEditField);
		messageTitleEditField2.clear();
		messageTitleEditField2.sendKeys(title);
		waitForElementByElement(saveEditButton);
		saveEditButton.click();
		PageObjectLogging.log("writeEditMessage", "message edited", true, driver);
	}
	
	public void editMessage(String title, String message)
	{
		clickEditMessage();
		writeEditMessage(title, message);
		
	}

	public void clickPublishButton() {
		waitForElementByElement(publishButton);
		publishButton.click();
		PageObjectLogging.log("clickPublishButton", "publish button is clicked", true, driver);	
		
	}

	public void writeMessageWithLink(String internallink, String externallink, String title) {
		messageTitleField.click();
		messageTitleField.sendKeys(title);
		triggerMessageArea();
		// add internal wikia link
		waitForElementByElement(addLinkButton);
		addLinkButton.click();
		waitForElementByElement(targetPageOrURL);
		targetPageOrURL.sendKeys(internallink);
		waitForTextToBePresentInElementByElement(linkPageStatus, "Page exists");
		waitForElementByElement(linkModalOkButton);
		linkModalOkButton.click();
		// add external link
		waitForElementByElement(addLinkButton);
		addLinkButton.click();
		waitForElementByElement(externalLinkOption);
		externalLinkOption.click();
		targetPageOrURL.sendKeys(externallink);
		waitForTextToBePresentInElementByElement(linkPageStatus, "External link");
		linkModalOkButton.click();
		PageObjectLogging.log("writeMessageWithLink", "internal and external links: "+internallink+" and" +externallink+ "added", true, driver);
		
	}

	public void writeMessageSourceMode(String title, String message) {
		messageTitleField.click();
		messageTitleField.sendKeys(title);
		triggerMessageArea();
		waitForElementByElement(messageWallIFrame);
		sourceModeButton.click();
		waitForElementByElement(sourceModeTextarea);
		sourceModeTextarea.sendKeys(message);
		PageObjectLogging.log("writeMessageSourceMode", "message in source mode is written, title: "+title+" body: "+message, true, driver);

		
	}

	/**
	 * verifies order of first two messages
	 * 
	 * @author Michal Nowierski
	 * @param message1 - first message to be checked
	 * @param message2 - second message to be checked
	 * 	 */
	public void verifyMessagesOrderIs(String message1, String message2) {
		List<WebElement> list = driver.findElements(messageList);
		waitForTextToBePresentInElementByElement(list.get(0), message1);
		waitForTextToBePresentInElementByElement(list.get(1), message2);
		PageObjectLogging.log("verifyMessagesOrderIs", "order of messages is appropriate: "+message1+", then "+message2, true, driver);
		
		
	}

	/**
	 * sort threads (wall messages = threads) in specified order<br>
	 * 
	 * @author Michal Nowierski
	 * @param order - specifies order of sorting <br><br> possible values: <br> "NewestThreads", "OldestThreads", "NewestReplies"}
	 * 	 */
	public void sortThreads(String order) {
		sortingMenu.click();
		List<WebElement> list = driver.findElements(sortingList);
		if (order.equals("NewestThreads")) {
			waitForElementByElement(list.get(0));
			list.get(0).click();
		}
		if (order.equals("OldestThreads")) {
			waitForElementByElement(list.get(1));
			list.get(1).click();
		}
		if (order.equals("NewestReplies")) {
			waitForElementByElement(list.get(2));
			list.get(2).click();
		}
		PageObjectLogging.log("sortThreads", "order of messages sorted: "+order, true, driver);
	}


	}












	

