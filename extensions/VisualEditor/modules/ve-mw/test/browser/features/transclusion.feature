@chrome @en.wikipedia.beta.wmflabs.org @firefox @login @test2.wikipedia.org
Feature: VisualEditor Transclusion

  Background:
    Given I go to the "Template:Seleniumtest" page with content "Template for selenium testing"
      And I go to the "Transclusion VisualEditor Test" page with content "Transclusion VisualEditor Test"
      And I click in the editable part
      And I click Transclusion
      And I can see the Transclusion User Interface

  Scenario: Add template
    When I enter S into transclusion Content box
    Then I see a list of template suggestions
      And I click the Add template button

  Scenario: Add parameter to template
      And I enter S into transclusion Content box
      And I see a list of template suggestions
      And I click the Add template button
      And I click Add parameter
      And I see an input text area
    When I enter x in the parameter box
    Then I should see the Insert template button

  Scenario: Remove parameter
      And I enter S into transclusion Content box
      And I see a list of template suggestions
      And I click the Add template button
      And I click Add parameter
      And I see an input text area
      And I enter q in the parameter box
      And I click the parameter representation containing q
    When I click Remove parameter
    Then I should see the Add parameter link
