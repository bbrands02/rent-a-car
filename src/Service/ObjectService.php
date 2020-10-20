<?php


namespace App\Service;

use App\Entity\Car;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

class ObjectService extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct
    (
        EntityManagerInterface $em
    )
    {
        $this->em = $em;
    }

    // Fetches the right repository for this type
    public function fetchRepo($type)
    {
        $type = "App\\Entity\\".ucwords($type);
        $repo = $this->getDoctrine()->getRepository($type);

        return $repo;
    }

    // Fetches all objects of a given class
    public function getAll($type)
    {
        $repo = $this->fetchRepo($type);

        // Actual fetching of objects
        $objects = $repo->findAll();

        return $objects;
    }

    // Uploads object (needs type from html form)
    public function uploadObject($object)
    {
        $object['type'] = "App\\Entity\\".ucwords($object['type']);

        $newObject = $this->createProperties($object);

        $this->em->persist($newObject);
        $this->em->flush();

        return;
    }


    public function createProperties($obj) {
        $newObject = new $obj['type']();

        // For each possible property this row of if statements needs to be expanded
        if (!empty($obj['name'])) {
            $newObject->setName($obj['name']);
        }
        if (!empty($obj['description'])) {
            $newObject->setDescription($obj['description']);
        }
        if (!empty($obj['color'])) {
            $newObject->setColor($obj['color']);
        }

        return $newObject;
    }

}