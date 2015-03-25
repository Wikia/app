@firefox @login
Feature: Language Screenshot

  @language_screenshot
  Scenario: VisualEditor_Toolbar_Headings
    Given I am editing language screenshot page
    When I click the down arrow on Headings interface
    Then I should see Headings pull-down menu

  @language_screenshot
  Scenario: VisualEditor_Toolbar_Formatting
    Given I am editing language screenshot page
    When I click the text style menu
    Then I should see Formatting pull-down menu

  @language_screenshot
  Scenario: VisualEditor_More_Settings
    Given I am editing language screenshot page
    When I click the hamburger menu
    Then I should see pull-down menu containing Page Settings

  @language_screenshot
  Scenario: VisualEditor_Insert_Menu
    Given I am editing language screenshot page
    When I click on the Insert menu
    Then I should see Insert pull-down menu

  @language_screenshot
  Scenario: VisualEditor_Toolbar_SpecialCharacters
    Given I am editing language screenshot page
    When I click on the Special character option in Insert menu
    Then I should see Special character Insertion window

  @language_screenshot
  Scenario: VisualEditor_save_dialog
    Given I am logged in
      And I am edit language screenshot page with Testing Save
    When I click Save page
    Then I should see save changes dialog box

  @language_screenshot
  Scenario: VisualEditor_Page_Settings
    Given I am editing language screenshot page
      And I click the hamburger menu
    When I click on Page settings option
    Then I should see Page settings dialog box

  Scenario: VisualEditor_Toolbar_Lists_and_indentation
    Given I go to the "Indent Outdent Screenshot" page with source content "Indent Outdent Screenshot"
      And I make the text "Indent Outdent" be selected
    When I click Bullets
      And I click on list and indentation dropdown
    Then I should see list and indentation dropdown

  Scenario: VisualEditor_External_link
    Given I go to the "Links VisualEditor Screenshot" page with source content "Links VisualEditor Screenshot"
      And I click in the editable part
      And I click the Link button
    When I enter http://www.mediawiki.org into link Content box
    Then I should see link Content box with dropdown options

  Scenario: VisualEditor_Link_editing_inline
    Given I go to the "Links VisualEditor Screenshot" page with source content "Links VisualEditor Screenshot"
      And I click in the editable part
      And I click the Link button
    When I enter VisualEditor into link Content box
    Then I should see link Content box with dropdown options

  Scenario: VisualEditor_Link_editing_inline_icon
    Given I go to the "Links VisualEditor LanguageScreenshot Test" page with source content "[[VisualEditor]] is a extension."
      And I click in the editable part
    Then I should see link icon

  Scenario: VisualEditor_Media_editing
    Given I go to the "Media Interface Screenshot" page with source content "Media Interface Screenshot"
      And I click in the editable part
      And I click Media
    When I enter San Francisco into media Search box
    Then I should see media editing dialog box

  Scenario: VisualEditor_Media_caption_editing
    Given I go to the "Media Interface Screenshot" page with source content "Media Interface Screenshot"
      And I select an image by searching San Francisco in Media option
      And I enter "San Francisco" in alternative text
    When I enter "San Francisco is located on the West Coast of the United States" in caption text box
    Then I should see media caption dialog box

  Scenario: VisualEditor_Media_advanced_settings
    Given I go to the "Media Interface Screenshot" page with source content "Media Interface Screenshot"
      And I select an image by searching San Francisco in Media option
    When I click on Advanced Settings tab
    Then I should see media advanced settings dialog box

  Scenario: VisualEditor_Media_icon
    Given I go to the "Media Interface Screenshot" page which has a media image
      And I select the image in VisualEditor
    Then I should see media in VisualEditor

  Scenario: VisualEditor_Cite_Pulldown
    Given I am editing language screenshot page
    When I click on Cite menu
    Then I should see Cite dropdown menu

  Scenario: VisualEditor_References_icon
    Given I go to "Reference VisualEditor Screenshot" page which has references
    When I send right arrow times 39
    Then I should see Reference icon

  Scenario: VisualEditor_References_edit
    Given I go to the "Reference VisualEditor Screenshot" page with source content "VisualEditor is a MediaWiki extension"
      And I click on Cite menu
    When I click on Basic Reference in Cite menu dropdown
    Then I should see Basic Reference dialog box

  @language_screenshot
  Scenario: VisualEditor_edit_tab
    Given I am logged in
    When I go to language screenshot page
    Then I should see the right edit tab

  @language_screenshot
  Scenario: VisualEditor_toolbar
    Given I am logged in
    When I am editing language screenshot page
    Then I should see the VisualEditor tool-bar

  @language_screenshot
  Scenario: VisualEditor_category_editing
    Given I am editing language screenshot page
    When I click on category in hamburger menu
    Then I should see category dialog box

  Scenario: VisualEditor_formula
    Given I go to the "Formula Screenshot" page with source content ""
    When I click on Formula option in Insert menu
      And I type a formula
    Then I should see the formula insertion menu

  @language_screenshot
  Scenario: VisualEditor_toolbar_actions
    Given I am logged in
    When I am edit language screenshot page with Testing toolbar
    Then I should see action buttons in the end of the VisualEditor toolbar

  @language_screenshot
  Scenario: VisualEditor_references_list
    Given I go to the "Reference VisualEditor Screenshot" page with source content "VisualEditor is a MediaWiki extension"
    When I click on References list in Insert menu
    Then I should see References list dialog box
