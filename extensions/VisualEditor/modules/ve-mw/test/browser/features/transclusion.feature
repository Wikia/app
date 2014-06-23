@ie6-bug  @ie7-bug  @ie8-bug @ie9-bug @ie10-bug @en.wikipedia.beta.wmflabs.org @test2.wikipedia.org @login
Feature: VisualEditor Transclusion

  Background:
    Given I am logged in
      And I am at my user page
      When I click Edit for VisualEditor
      And I click Transclusion

  Scenario: Add template
    Given I can see the Transclusion User Interface
    When I enter N into transclusion Content box
    Then I see a list of template suggestions
      And I click the Add template button

  Scenario: Add parameter to template
    Given I can see the Transclusion User Interface
      And I enter N into transclusion Content box
      And I see a list of template suggestions
      And I click the Add template button
      And I click Add parameter
      And I see an input text area
    When I enter x in the parameter box
    Then I should see the Insert template button

  Scenario: Remove parameter
    Given I can see the Transclusion User Interface
      And I enter N into transclusion Content box
      And I see a list of template suggestions
      And I click the Add template button
      And I click Add parameter
      And I see an input text area
      And I enter q in the parameter box
      And I click the parameter representation containing q
    When I click Remove parameter
    Then I should see the Add parameter link
