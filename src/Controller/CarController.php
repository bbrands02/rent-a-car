<?php

namespace App\Controller;

use App\Entity\Car;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

class CarController extends AbstractController
{

    /**
     * @Route("/cars")
     * @Template
     */
    public function indexAction(Request $req, EntityManagerInterface $em)
    {
        $variables['title'] = 'Cars';
        $repo = $this->getDoctrine()->getRepository(Car::class);

        if ($req->isMethod('POST')) {
            $object = $req->request->all();

            if (!empty($object['newCar'])) {
                $car = new Car();
                if (!empty($object['newCar']['name'])) {
                    $car->setName($object['newCar']['name']);
                }
                if (!empty($object['newCar']['description'])) {
                    $car->setDescription($object['newCar']['description']);
                }
                if (!empty($object['newCar']['color'])) {
                    $car->setColor($object['newCar']['color']);
                }
                $em->persist($car);
                $em->flush();
                $req->request->remove('newCar');
            } elseif (!empty($object['deletedCar'])) {
                $deletedObject = $repo->find($object['deletedCar']['id']);
                $em->remove($deletedObject);
                $em->flush();
                $req->request->remove('deletedCar');
            }
        }

        $variables['cars'] = $repo
            ->findAll();
        
        return $variables;
    }
}
