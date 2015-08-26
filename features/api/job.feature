@job
Feature: Jobs management
  The job of a user is the job he has occupied for a given mandate.
  A job must belong to a mandate.
  At each new mandate, the jobs available are the job enabled.
  A job may be left empty.
  New jobs are created for the current mandate.

  Background:
    Given I authenticate myself as admin

  Scenario: It should be possible to get all the jobs.
    When I send a GET request to "/api/jobs"
    Then I should get a paged collection with the context "/api/contexts/Job"
    And the JSON node "hydra:totalItems" should be greater than 55

    #TODO

#START -----Filter validation-----

  Scenario: It should be possible to get all the enabled jobs.
   When I send a GET request to "/api/jobs?filter[order][enable]=true"
  Then the response status code should be 200
  And I should get a paged collection with the context "/api/contexts/Job"
  And the JSON node "hydra:totalItems" should be equal to #TODO
  And the job should have a enabled with the value "true"
      #TODO

  Scenario: It should be possible to order jobs by ID, title or abbreviation.
  When I send a GET request to "/api/jobs?filter[order][id]"
  Then the response status code should be 200
  When I send a GET request to "/api/jobs?filter[order][abbreviation]"
  Then the response status code should be 200
  When I send a GET request to "/api/jobs?filter[order][title]"
  Then the response status code should be 200
    #TODO

  Scenario: It should be possible to find a job by its ID or title.
  When I send a GET request to "/api/jobs?filter[where][title]=User Experience Connector"
  Then the response status code should be 200
  And I should get a paged collection with the context "/api/contexts/Job"
  And the JSON node "hydra:totalItems" should be equal to #TODO
  And the job should have a title with the value "User Experience Connector"
    #TODO

  Scenario: It shoud be possible to find jobs by their abbreviation (an abbreviation may have several jobs).
  When I send a GET request to "/api/jobs?filter[where][abbreviation]=DEPT"
  Then the response status code should be 200
  And I should get a paged collection with the context "/api/contexts/Job"
  And the JSON node "hydra:totalItems" should be equal to #TODO
  And the job should have an abbreviation with the value "DEPT"
    #TODO

#END -----Filter validation-----

#START -----Crud validation-----

  Scenario: It should be possible to create a new job
  When I send a POST request to "/api/jobs" with body:
    | | |
    #TODO

  Scenario: When creating a new job, it must have at least one mandate. By default is for the ongoing mandate.
    #TODO

  Scenario: It shoud be possible to see job's informations
  When I send a GET request to "/api/jobs/5"
  Then the response status code should be 200
    #TODO

  Scenario: It should be possible to update a job.
  When I send a PUT request to "/api/jobs/5" with body:
    #TODO

  Scenario: It should be possible to delete a job.
  When I send a DELETE request to "/api/jobs/5"
  Then the response status code should be 202
    #TODO

#END -----Crud validation-----