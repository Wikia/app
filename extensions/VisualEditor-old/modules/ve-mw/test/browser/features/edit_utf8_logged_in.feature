# encoding: UTF-8
@chrome @en.wikipedia.beta.wmflabs.org @firefox @login @test2.wikipedia.org
Feature: VisualEditor

  Background:
    Given I am logged in
      And I go to the browser specific edit page page

  Scenario Outline: Edit with strings
    When I edit the page with <input_string>
      And I click Save page
      And I click This is a minor edit
      And I click Review your changes
      And I click Return to save form
      And I edit the description of the change
      And I click Save page the second time
    Then Page text should contain <output_string>
  Examples:
    | input_string                               | output_string                              |
    | Editing with                               | Editing with                               |
    | Editing with ÀÈÌÒÙ                         | Editing with ÀÈÌÒÙ                         |
    | Editing with ÄËÏÖÜ                         | Editing with ÄËÏÖÜ                         |
    | Editing with ÂÊÎÔÛ                         | Editing with ÂÊÎÔÛ                         |
    | Editing with áéíóú                         | Editing with áéíóú                         |
    | Editing with Déjà vu 北京 <tag & "OK" "end" | Editing with Déjà vu 北京 <tag & "OK" "end" |
