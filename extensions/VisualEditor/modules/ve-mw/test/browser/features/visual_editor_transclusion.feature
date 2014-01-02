@ie6-bug  @ie7-bug  @ie8-bug @ie9-bug @ie10-bug @test2.wikipedia.org @en.wikipedia.beta.wmflabs.org @login
Feature: VisualEditor Transclusion

  Background:
    Given I am logged in
      And I am at my user page
      When I click Edit for VisualEditor
      And I click Transclusion

  Scenario: Add template
    Given I can see the Transclusion User Interface
    When I enter S into transclusion Content box
    Then I should see a list of template suggestions
      And I should be able to click the Add template button

  Scenario: Add parameter to template
    Given I can see the Transclusion User Interface
      And I enter S into transclusion Content box
      And I should see a list of template suggestions
      And  I should be able to click the Add template button
    When I enter x in the parameter box
      And I add the parameter
    Then I should see an input text area
      And I should see the Apply changes button

  Scenario: Remove parameter
    Given I can see the Transclusion User Interface
      And I enter S into transclusion Content box
      And I should see a list of template suggestions
      And I should be able to click the Add template button
      And I enter x in the parameter box
      And I add the parameter
    When I click Remove parameter
      And I click Remove template
    Then I should not be able to see parameter named S
