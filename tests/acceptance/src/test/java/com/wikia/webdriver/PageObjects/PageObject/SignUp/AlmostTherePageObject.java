package com.wikia.webdriver.PageObjects.PageObject.SignUp;

import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.FindBy;
import org.openqa.selenium.support.PageFactory;

import com.wikia.webdriver.Common.Core.MailFunctions;
import com.wikia.webdriver.Common.Logging.PageObjectLogging;
import com.wikia.webdriver.Common.Properties.Properties;
import com.wikia.webdriver.PageObjects.PageObject.BasePageObject;

public class AlmostTherePageObject extends BasePageObject
{

	
	@FindBy(xpath="//h2[contains(text(), 'Almost there')]")
	private WebElement almostThereText; 
	@FindBy(css="h1.wordmark a[href='/Wikia']")
	private WebElement wikiaWordmark;
	@FindBy(css="input.link[value='Send me another confirmation email']")
	private WebElement sendAnotherMail;
	@FindBy(css="a.change-email-link")
	private WebElement changeMyEmail;
	
	
	/**
	 * @author Karol Kujawiak
	 * @param driver
	 */
	public AlmostTherePageObject(WebDriver driver) {
		super(driver);
		PageFactory.initElements(driver, this);
	}
	
	
	/**
	 * @author Karol Kujawiak
	 */
	private void verifyAlmostThereText()
	{
		waitForElementByElement(almostThereText);
		PageObjectLogging.log("verifyAlmostThereText", "Almost there text is visible", true);
	}
	
	
	/**
	 * @author Karol Kujawiak
	 */
	private void verifyEmailSentText()
	{
//		waitForElementByCss("//div[@class='general-messaging']/b[contains(text(), '"+Properties.email+"')]");
		PageObjectLogging.log("verifyEmailSentText", "Email sent text visible", true);
	}
	
	/**
	 * @author Karol Kujawiak
	 */
	private void verifyWikiaWordMark()
	{
		waitForElementByElement(wikiaWordmark);
		PageObjectLogging.log("verifyWikiaWordMark", "Wikia wordmark is visible", true);
	}
	
	/**
	 * @author Karol Kujawiak
	 */
	private void verifySendAnotherMailText()
	{
		waitForElementByElement(sendAnotherMail);
		PageObjectLogging.log("verifySendAnotherMailText", "send another email link is visible", true);
	}
	
	/**
	 * @author Karol Kujawiak
	 */
	private void verifyChangeMyMailText()
	{
		waitForElementByElement(changeMyEmail);
		PageObjectLogging.log("verifyChangeMyMailText", "change my mail link is visible", true);
	}
	
	/**
	 * @author Karol Kujawiak
	 */
	public void verifyAlmostTherePage()
	{
		verifyAlmostThereText();
		verifyEmailSentText();
//		verifyWikiaWordMark();
		verifySendAnotherMailText();
		verifyChangeMyMailText();
	}

	/**
	 * @author Karol Kujawiak
	 */
	private String getActivationLinkFromMail()
	{
		String www = MailFunctions.getActivationLinkFromMailContent(MailFunctions.getFirstMailContent(Properties.email, Properties.emailPassword));
		www = www.replace("=", "");
		PageObjectLogging.log("getActivationLinkFromMail", "activation link is visible in email content: "+www, true);
		return www;
	}
	
	/**
	 * @author Karol Kujawiak
	 */
	public ConfirmationPageObject enterActivationLink()
	{
		System.out.println(getActivationLinkFromMail());
		driver.get(getActivationLinkFromMail());
		PageObjectLogging.log("enterActivationLink", "activation page is displayed", true, driver);
		return new ConfirmationPageObject(driver);
	}
	
}
