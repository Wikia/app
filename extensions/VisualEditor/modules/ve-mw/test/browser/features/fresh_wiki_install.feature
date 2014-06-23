@clean
Feature: VisualEditor on a fresh Mediawiki install

  Since this test currently uses a hard-coded
  username and password, the test should only
  be run against a fresh Mediawiki install
  (including the VisualEditor extension).

  Scenario: Create a new user account
    Given I create a new user Selenium_user with password test1234

  Scenario Outline: Article creation and editing
    Given I create a new wiki article <page_title> with content <article_text>
    When I login with username Selenium_user and password test1234
    And I visit <page_title> via the UI
    And I click Edit for VisualEditor
    Then I should see the Visual Editor editing surface
  Examples:
    | page_title                 | article_text                   |
    | User:Selenium_user         | This is my user page           |
    | User:Selenium_user/firefox | This is some wiki article text |
