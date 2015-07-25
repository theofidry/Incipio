Feature: Testing JSONContext

    Scenario: Should be higher than
      Given I am on "/json-context-1.json"
      Then the response should be in JSON
      And the JSON node "intValue" should be greater than 0
      And the JSON node "intValue" should be less than 0
