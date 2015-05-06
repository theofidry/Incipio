<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Symfony2Extension\Context\KernelAwareContext;
use Behat\Symfony2Extension\Context\KernelDictionary;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\SchemaTool;
use FOS\UserBundle\Doctrine\UserManager;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTManagerInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

/**
 * Defines application features from the specific context.
 *
 * @author Théo FIDRY <theo.fidry@gmail.com>
 */
class FeatureContext extends RawMinkContext implements Context, SnippetAcceptingContext, KernelAwareContext
{
    /**
     * Hook to implement KernelAwareContext
     */
    use KernelDictionary;

    /** @var ManagerRegistry */
    private $doctrine;

    /** @var \Doctrine\Common\Persistence\ObjectManager */
    private $manager;

    /** @var JWTManagerInterface */
    private $jwtManager;

    /** @var UserManager */
    private $userManager;

    /** @var EncoderFactoryInterface */
    private $encoderFactory;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     *
     * @param ManagerRegistry         $doctrine
     * @param JWTManagerInterface     $jwtManager
     * @param UserManager             $userManager
     * @param EncoderFactoryInterface $encoderFactory
     */
    public function __construct(
        ManagerRegistry $doctrine,
        JWTManagerInterface $jwtManager,
        UserManager $userManager,
        EncoderFactoryInterface $encoderFactory)
    {
        $this->doctrine = $doctrine;
        $this->manager = $doctrine->getManager();
        $this->schemaTool = new SchemaTool($this->manager);
        $this->classes = $this->manager->getMetadataFactory()->getAllMetadata();
        $this->jwtManager = $jwtManager;
        $this->userManager = $userManager;
        $this->encoderFactory = $encoderFactory;
    }

    /**
     * @BeforeScenario @createSchema
     */
    public function createDatabase()
    {
        $this->schemaTool->createSchema($this->classes);
    }

    /**
     * @AfterScenario @dropSchema
     */
    public function dropDatabase()
    {
        $this->schemaTool->dropSchema($this->classes);
    }

    /**
     * Authenticate a user via a JWT token.
     *
     * @param $username
     *
     * @Given I authenticate myself as ":username"
     */
    public function authenticateAs($username)
    {
        $user = $this->userManager->findUserByUsername($username);
        if (null === $user) {
            $user = $this->userManager->findUserByEmail($username);
            if (null === $user) {
                throw new \InvalidArgumentException(
                    sprintf('No user with username or email %s can be found', $username)
                );
            }
        }

        $token = $this->jwtManager->create($user);
        $this->getSession()->getDriver()->setRequestHeader(
            'HTTP_AUTHORIZATION',
            sprintf('Bearer %s', $token)
        );
    }

    /**
     * @Then the password for user ":username" should be ":password"
     *
     * @param $username
     * @param $password
     *
     * @throws Exception
     */
    public function thePasswordForUserShouldBe($username, $password)
    {
        $user = $this->userManager->findUserByUsername($username);
        if (null === $user) {
            throw new \InvalidArgumentException(sprintf('No user with username %s can be found', $username));
        }
        $encoder = $this->encoderFactory->getEncoder($user);
        $valid   = $encoder->isPasswordValid($user->getPassword(), $password, $user->getSalt());
        if (false === $valid) {
            throw new \Exception(sprintf('The password for user %s does not match %s', $username, $password));
        }
    }

    /**
     * @Then print the response
     */
    public function printTheResponse()
    {
        $json = $this->getSession()->getPage()->getContent();
        echo json_encode(json_decode($json), JSON_PRETTY_PRINT);
    }
}
