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

#  Scenario: It should be possible to get all the enabled jobs.
    #TODO

#  Scenario: It should be possible to order jobs by ID, title or abbreviation.
    #TODO

#  Scenario: It should be possible to find a job by its ID or title.
    #TODO

#  Scenario: It shoud be possible to find jobs by their abbreviation (an abbreviation may have several jobs).
    #TODO

#END -----Filter validation-----

#START -----Crud validation-----

#  Scenario: It should be possible to create a new job
#  When I send a POST request to "/api/jobs"

#  Scenario: When creating a new job, it must have at least one mandate. By default is for the ongoing mandate.
    #TODO

#  Scenario: It shoud be possible to see job's informations
#  When I send a POST request to "/api/jobs/5"
    #TODO

#  Scenario: It should be possible to update a job.
#  When I send a PUT request to "/api/jobs/5" with body:
    #TODO

#  Scenario: It should be possible to delete a job.
#  When I send a DELETE request to "/api/jobs/5"
    #TODO

#END -----Crud validation-----