@en.wikipedia.beta.wmflabs.org @firefox @internet_explorer_10 @login @safari @test2.wikipedia.org
Feature: Switching between wikitext and Visual Editor modes

  Test for both pathways that allow switching between Visual Editor and wikitext editing modes.

  Background:
    Given I am logged in
      And I go to the browser specific edit page page
    When I edit the page with Switch edit mode test

  Scenario: Switch editing modes via toolbar
    When I enter the wikitext editor
      And I click Edit for VisualEditor
    Then I should be in Visual Editor editing mode

  Scenario: Switch editing modes via Page Settings drop-down menu
    When I click the Switch to source editing menu option
      And I see the Cancel option
      And I see the Discard option
      And I clear the confirm dialog by clicking Keep changes
      And I see the wikitext editor
      And I click Edit for VisualEditor from this page
    Then I should be in Visual Editor editing alternate mode
