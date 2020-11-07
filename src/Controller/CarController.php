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
use App\Service\ObjectService;


class CarController extends AbstractController
{

    /**
     * @Route("/cars")
     * @Template
     */
    public function indexAction(Request $req, EntityManagerInterface $em, ObjectService $os)
    {
        $variables['title'] = 'Cars';
        $variables['cars'] = $os->getAll('car');

        return $variables;
    }

    /**
     * @Route("/cars/{id}")
     * @Template
     */
    public function carAction(Request $req, EntityManagerInterface $em, ObjectService $os, $id)
    {
        $variables['car'] = $os->getOne('car', $id);
        $variables['title'] = $variables['car']->getName();

        $variables['breadcrumbs'][] = [
            'name'=>'Cars',
            'path'=>'/cars',
            'active'=>false
        ];
        $variables['breadcrumbs'][] = [
            'name'=>$variables['car']->getName(),
            'active'=>true
        ];

        return $variables;
    }

    /**
     * @Route("/upload-car")
     */
    public function uploadCarAction(Request $req, EntityManagerInterface $em, ObjectService $os)
    {
        if ($req->isMethod('POST')) {
            $object = $req->request->all();
            if (empty($object['name'])) {
                // Needs to be a flash with a return
                throw new \Exception('Please fill in the name!');
            }

            $object['image'] = $req->files->get('image');
            if (!empty($object['image']) && !in_array($object['image']->guessExtension(), array("png", "jpeg", "gif"))) {
                // Needs to be a flash with a return
                throw new \Exception('This is not a image!');
            }

            $os->uploadObject($object);
        }

        return $this->redirectToRoute('app_car_index');
    }

    /**
     * @Route("/delete-car")
     */
    public function deleteCarAction(Request $req, EntityManagerInterface $em, ObjectService $os)
    {
        if ($req->isMethod('POST')) {
            $repo = $this->getDoctrine()->getRepository(Car::class);
            $object = $req->request->all();

            if (!empty($object)) {
                $deletedObject = $repo->find($object['id']);

                $em->remove($deletedObject);
                $em->flush();
            }
        }

        return $this->redirectToRoute('app_car_index');
    }
}
