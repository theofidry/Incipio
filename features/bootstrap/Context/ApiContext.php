<?php

/*
 * This file is part of the Incipio package.
 *
 * (c) Théo FIDRY <theo.fidry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Incipio\Tests\Behat\Context;

use ApiBundle\Entity\User;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Symfony2Extension\Context\KernelAwareContext;
use Behat\Symfony2Extension\Context\KernelDictionary;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\SchemaTool;
use FOS\UserBundle\Doctrine\UserManager;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTManagerInterface;
use Sanpi\Behatch\Json\JsonInspector;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

/**
 * @author Théo FIDRY <theo.fidry@gmail.com>
 */
class ApiContext extends RawMinkContext implements Context, SnippetAcceptingContext, KernelAwareContext
{
    /*
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

    /** @var JsonInspector */
    private $inspector;

    /**
     * @var \Doctrine\ORM\Mapping\ClassMetadata[]|array All class metadata registered by Doctrine.
     */
    private $metadata = [];

    /**
     * @var array Array for which the key is the alias and the value the entity.
     */
    private $aliases = [];

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
        EncoderFactoryInterface $encoderFactory
    ) {
        $this->doctrine = $doctrine;
        $this->manager = $doctrine->getManager();
        $this->schemaTool = new SchemaTool($this->manager);
        $this->metadata = $this->manager->getMetadataFactory()->getAllMetadata();
        $this->jwtManager = $jwtManager;
        $this->userManager = $userManager;
        $this->encoderFactory = $encoderFactory;
        $this->inspector = new JsonInspector('javascript');
    }

    /**
     * @param string $name User username or email.
     *
     * @return User
     *
     * @Transform :user
     */
    public function castToUser($name)
    {
        $user = $this->userManager->findUserByUsernameOrEmail($name);
        if (!$user) {
            throw new \InvalidArgumentException(sprintf('No user was found.'));
        }

        return $user;
    }

    /**
     * @BeforeScenario @resetSession
     */
    public function resetSession()
    {
        $this->getSession()->reset();
        $client = $this->getSession()->getDriver()->getClient();
        $client->setServerParameter('HTTP_AUTHORIZATION', '');
    }

    /**
     * Authenticate a user via a JWT token.
     *
     * @param User $user
     *
     * @Given I authenticate myself as :user
     */
    public function authenticateAs(User $user)
    {
        $client = $this->getSession()->getDriver()->getClient();
        $token = $this->jwtManager->create($user);
        $client->setServerParameter('HTTP_AUTHORIZATION', sprintf('Bearer %s', $token));
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
        $valid = $encoder->isPasswordValid($user->getPassword(), $password, $user->getSalt());
        if (false === $valid) {
            throw new \Exception(sprintf('The password for user %s does not match %s', $username, $password));
        }
    }

    /**
     * Is a debug helper, should not be left used in Behat features.
     *
     * @Then print the response
     */
    public function printTheResponse()
    {
        $json = $this->getSession()->getPage()->getContent();
        echo json_encode(json_decode($json), JSON_PRETTY_PRINT);
    }

    /**
     * @Given I have :alias which is a :entityClass with the following properties:
     *
     * @param string $alias       alias to use to save the entity. Is stored as an array key.
     * @param string $entityClass FQCN
     *                            
     * @throws InvalidArgumentException When unknown entity
     * @throws \Exception               When no identifier has been found for the given entity.
     */
    public function assertEntityIsEqualTo($alias, $entityClass, TableNode $properties)
    {
//
//
//
//
//        // Add alias
//        $this->aliases[$alias] = $this->getId($entityClass);

        // Normalize properties
        $normalizedProperties = $this->normalizeProperties($properties);
        
    }

    /**
     * @param array $metadata
     *
     * @return mixed                    Doctrine Identifier.
     * @throws InvalidArgumentException If no metadata has been found for the given entity.
     * @throws \Exception               When no identifier has been found.
     */
    private function getId($entityClass)
    {
        $metadata = null;
        foreach ($this->metadata as $classMetadata) {
            if ($entityClass === $classMetadata->getName()) {
                $metadata = $classMetadata;
            }
        }
        if (null === $metadata) {
            throw new InvalidArgumentException(sprintf('Unkown entity %s.', $entityClass));
        }

        $identifier = $metadata->getIdentifier();

        if (0 === count($identifier)) {
            throw new \Exception('No identifier found..');
        }

        return $identifier[0];
    }
    
    private function normalizeProperties(TableNode $properties)
    {
        $normalizedProperties = [];

        $rows = $properties->getRows();
        foreach ($rows as $row) {

        }


        $x = $properties->getColumnsHash();

        echo "lol";
    }
}
