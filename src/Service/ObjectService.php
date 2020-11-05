<?php


namespace App\Service;

use App\Entity\Car;
use App\Entity\User;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Uid\Uuid;

class ObjectService extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var UserPasswordEncoderInterface
     */
    private $pe;

    public function __construct
    (
        EntityManagerInterface $em,
        UserPasswordEncoderInterface $pe
    )
    {
        $this->em = $em;
        $this->pe = $pe;
    }

    // Fetches the right repository for this type
    public function fetchRepo($type)
    {
        $type = "App\\Entity\\" . ucwords($type);
        $repo = $this->getDoctrine()->getRepository($type);

        return $repo;
    }

    // Fetches all objects of a given entity
    public function getAll($type, $limit = null)
    {
        $repo = $this->fetchRepo($type);

        // Actual fetching of objects
        if ($limit != null && $limit > 0) {
            $objects = $repo->findBy(array(), array(), 5);

            $criteria = new Criteria();
            $criteria->where(Criteria::expr()->neq('image', null));

            $objects = $repo->matching($criteria);
        } else {
            $objects = $repo->findAll();
        }
        return $objects;
    }


    // Fetches one object of a given entity
    public function getOne($type, $id)
    {
        $repo = $this->fetchRepo($type);

        // Actual fetching of objects
        $object = $repo->find($id);

        return $object;
    }

    // Uploads object (needs type from html form)
    public function uploadObject($object)
    {
        $type = $object['type'];
        $object['type'] = "App\\Entity\\" . ucwords($object['type']);

        $newObject = $this->createProperties($object);

        $this->em->persist($newObject);
        $this->em->flush();
//        if() {
//            $this->addFlash('succes', ucwords($type).' successfully created');
//        };

        return;
    }

    public function createProperties($obj)
    {
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
        if (!empty($obj['image'])) {
            $uuid = Uuid::v4();
            move_uploaded_file($obj['image'], 'images/' . $uuid . '.jpg');
            $obj['image'] = 'images/' . $uuid . '.jpg';
            $newObject->setImage($obj['image']);
        }
        if (!empty($obj['email'])) {
            $newObject->setEmail($obj['email']);
        }
        if (!empty($obj['password'])) {
            $newObject->setPassword($this->pe->encodePassword($newObject, $obj['password']));
        }

        return $newObject;
    }

}