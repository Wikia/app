@en.wikipedia.beta.wmflabs.org @firefox @internet_explorer_10 @login @safari @test2.wikipedia.org
Feature: VisualEditor References

  Mothballed scenario pending updates to ui:
  cenario: Reusing an existing reference
    hen I edit the page with Some content related to existing reference
    nd I create a reference using existing reference
    hen first link to reference should be visible
    nd second link to reference should be visible

  Background:
    Given I go to a page that has references
      And I click in the editable part

  Scenario: Creating VisualEditor Reference
    Given I click Reference
      And I can see the References User Interface
    When I click Insert references list
    Then link to Insert menu should be visible



