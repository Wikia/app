@ie6-bug  @ie7-bug  @ie8-bug  @ie9-bug @ie10-bug @en.wikipedia.beta.wmflabs.org @test2.wikipedia.org @login
Feature: Switching between wikitext and Visual Editor modes

  Test for both pathways that allow switching between Visual Editor and wikitext editing modes.

  Background:
    Given I am logged in
      And I am at my user page
    When I click Edit for VisualEditor

  Scenario: Switch editing modes via toolbar
    When I enter the wikitext editor
      And I click Edit for VisualEditor
    Then I should be in Visual Editor editing mode

  Scenario: Switch editing modes via Page Settings drop-down menu
    When I click the Switch to source editing menu option
      And I see the wikitext editor
      And I click Edit for VisualEditor from this page
    Then I should be in Visual Editor editing alternate mode
