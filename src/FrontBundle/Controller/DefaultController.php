<?php

namespace FrontBundle\Controller;

use HappyR\Google\ApiBundle\Services\GoogleClient;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

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
        $clientService->getGoogleClient()->addScope('https://www.googleapis.com/auth/admin.directory.group');

        $directoryService = new \Google_Service_Directory($clientService->getGoogleClient());

        dump($clientService->getAccessToken());
        die;

        return $this->render('FrontBundle:Default:layout.html.twig');
    }
}
