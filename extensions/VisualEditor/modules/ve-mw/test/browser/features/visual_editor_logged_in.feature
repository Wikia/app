@ie6-bug  @ie7-bug  @ie8-bug @ie9-bug @ie10-bug @test2.wikipedia.org @en.wikipedia.beta.wmflabs.org
Feature: VisualEditor

  @login
  Scenario: Basic edit
    Given I am logged in
      And I am at my user page
    When I edit the page with a string
      And I click Save page
      And I click This is a minor edit
      And I click Review your changes
      And I click Return to save form
      And I edit the description of the change
      And I click Save page the second time
    Then Page text should contain the string
