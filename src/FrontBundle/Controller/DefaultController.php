<?php

namespace FrontBundle\Controller;

use Google_Auth_AppIdentity;
use Guzzle\Service\Client;
use HappyR\Google\ApiBundle\Services\GoogleClient;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class DefaultController.
 *
 * @author Théo FIDRY <theo.fidry@gmail.com>
 */
class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction() {

        /** @var GoogleClient $clientService */
        $clientService = $this->get('happyr.google.api.client');

        $auth = new Google_Auth_AppIdentity($clientService->getGoogleClient());
        $token = $auth->authenticateForScope(\Google_Service_Directory::ADMIN_DIRECTORY_USER);

        dump($token);
        die;
        
        if (!$token) {
            die("Could not authenticate to AppIdentity service");
        }
        $clientService->getGoogleClient()->setAuth($auth);

        $directoryService = new \Google_Service_Directory($clientService->getGoogleClient());

        $results = $directoryService->members->listMembers('CdP');

        dump($results);
        die;

        return $this->render('FrontBundle:Default:layout.html.twig');
    }
}
