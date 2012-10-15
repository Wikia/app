package com.wikia.selenium.tests;

import org.testng.annotations.Test;
import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertTrue;
import static org.testng.AssertJUnit.assertFalse;
import com.thoughtworks.selenium.*;
import org.testng.annotations.*;

/**
 * Experimental test for controlling two browsers in a test.
 * Do not run it under Cruise Control
 * Please contact QA before using this prototype code
 */
public class ChatTest {
	public boolean isChatOneDone = false;
	public boolean isChatTwoDone = false;
	private ChatOne chatOne;
	private ChatTwo chatTwo;

	class ChatOne implements Runnable {
		private ChatTest test;
		private Selenium selenium;
		
		ChatOne(ChatTest sharedTest) {
			System.out.println("ChatOne constructor");
			test = sharedTest;
		}
		
		public void startSelenium(String seleniumHost, int seleniumPort,
				String browser, String webSite, String timeout, String noCloseAfterFail) throws Exception {
			this.selenium = new DefaultSelenium(seleniumHost, seleniumPort, browser, webSite);
			this.selenium.start();
			this.selenium.open(webSite);
		}
		
		public void stopSelenium() {
			this.selenium.stop();
		}
		
		public void run() {
			System.out.println("Running test one");
			
			selenium.open("/");
			selenium.waitForPageToLoad("30000");
			selenium.click("//li[@class='WikiaLogo']/a");
			selenium.waitForPageToLoad("30000");
			assertFalse(selenium.getLocation().contains("http://www.wikia.com/Special:LandingPage"));
			assertTrue(selenium.getLocation().contains("http://www.wikia.com/Wikia"));
			assertFalse(selenium.isElementPresent("//section[@class='LandingPage']"));
			
			try {
				Thread.sleep(5000);
			} catch (Exception e) {
				System.out.println("Caught exception in chat one");
			}
			isChatOneDone = true;
			
			System.out.println("Thread chat one should be done");
		}
	}
	
	class ChatTwo implements Runnable {
		private ChatTest test;
		private Selenium selenium;
		
		ChatTwo(String ignore) {
		}
		
		ChatTwo(ChatTest sharedTest) {
			System.out.println("ChatTwo constructor");
			test = sharedTest;
		}
		
		public void startSelenium(String seleniumHost, int seleniumPort,
				String browser, String webSite, String timeout, String noCloseAfterFail) throws Exception {
			this.selenium = new DefaultSelenium(seleniumHost, seleniumPort, browser, webSite);
			this.selenium.start();
			this.selenium.open(webSite);
		}
		
		public void stopSelenium() {
			this.selenium.stop();
		}
		
		public void run() {
			System.out.println("Running test two");
			
			do {
				selenium.open("/");
				selenium.waitForPageToLoad("30000");
				try {
					Thread.sleep(1000);
				} catch (Exception e) {
					return;
				}
				System.out.println(test.isChatOneDone);
			} while (!test.isChatOneDone);
			
			selenium.click("//li[@class='WikiaLogo']/a");
			selenium.waitForPageToLoad("30000");
			assertFalse(selenium.getLocation().contains("http://www.wikia.com/Special:LandingPage"));
			assertTrue(selenium.getLocation().contains("http://www.wikia.com/Wikia"));
			assertFalse(selenium.isElementPresent("//section[@class='LandingPage']"));
			
			test.isChatTwoDone = true;
			
			System.out.println("Thread chat two should be done");
		}
	}
	
	public ChatTest() {
	}
	
	//@Test(groups={"broken"})
	//@Parameters( { "seleniumHost", "seleniumPort", "browser", "webSite", "timeout", "noCloseAfterFail" })
	public void testFoo(String seleniumHost, int seleniumPort,
			String browser, String webSite, String timeout, String noCloseAfterFail) throws Exception {
		ChatOne chatOne = this.new ChatOne(this);
		ChatTwo chatTwo = this.new ChatTwo(this);
		
		chatOne.startSelenium(seleniumHost, seleniumPort, browser, webSite, timeout, noCloseAfterFail);
		chatTwo.startSelenium(seleniumHost, seleniumPort, browser, webSite, timeout, noCloseAfterFail);
		
		new Thread(chatOne).start();
		new Thread(chatTwo).start();
		
		do {
			Thread.sleep(1000);
		} while (!isChatTwoDone);
	}

	//@AfterMethod(alwaysRun=true)
	public void stopSelenium() {
		chatOne.stopSelenium();
		chatTwo.stopSelenium();
	}
}
