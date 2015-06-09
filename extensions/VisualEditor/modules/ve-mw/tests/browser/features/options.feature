@en.wikipedia.beta.wmflabs.org @firefox @internet_explorer_10 @safari @test2.wikipedia.org
Feature: VisualEditor Options

  Background:
    Given I go to the "Options VisualEditor Test" page with content "Options VisualEditor Test"
      And I click in the editable part
      And I click the hamburger menu

  Scenario: Options
    When I click Options
    Then I should see the options overlay

  Scenario: Advanced Settings
    When I click Advanced Settings
    Then I should see the options overlay
      And the options overlay should display Advanced Settings

  Scenario: Page Settings
    When I click Page Settings
    Then I should see the options overlay
      And the options overlay should display Page Settings

  Scenario: Categories
    When I click Categories
    Then I should see the options overlay
      And the options overlay should display Categories

  Scenario: Advanced Settings setting fields
    When I click Advanced Settings
      And I click Yes for Indexed by Search Engines
      And I click Yes for showing tab for adding new section
      And I check the option for Enable display title
      And I type "automated test" for display title textbox
      And I click Apply Changes button
      And I click Save page
      And I click Review your changes
    Then the options set in Advanced Settings panel should appear in diff view
