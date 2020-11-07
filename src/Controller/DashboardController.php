<?php

namespace App\Controller;

use App\Entity\Car;
use App\Entity\Person;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use App\Service\ObjectService;

/**
 * Class DashboardController
 * @package App\Controller
 * @Route("/dashboard")
 */
class DashboardController extends AbstractController
{

    /**
     * @Route("/")
     * @Template
     */
    public function indexAction(Request $req, EntityManagerInterface $em, ObjectService $os)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $variables['title'] = 'Dashboard';

        return $variables;
    }

    /**
     * @Route("/users")
     * @Template
     */
    public function usersAction(Request $req, EntityManagerInterface $em, ObjectService $os)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $variables['title'] = 'Dashboard | Users';

        return $variables;
    }

    /**
     * @Route("/users/{id}")
     * @Template
     */
    public function userAction(Request $req, EntityManagerInterface $em, ObjectService $os)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $variables['title'] = 'Dashboard | User';

        return $variables;
    }

    /**
     * @Route("/cars")
     * @Template
     */
    public function carsAction(Request $req, EntityManagerInterface $em, ObjectService $os)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $variables['title'] = 'Dashboard | Cars';
        $variables['cars'] = $os->getAll('car');

        $variables['breadcrumbs'][] = [
            'name'=>'Dashboard',
            'path'=>'/dashboard',
            'active'=>false
        ];
        $variables['breadcrumbs'][] = [
            'name'=>'Cars',
            'active'=>true
        ];
        return $variables;
    }

    /**
     * @Route("/cars/{id}")
     * @Template
     */
    public function carAction(Request $req, EntityManagerInterface $em, ObjectService $os, $id)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $variables['title'] = 'Dashboard | Car';
        if ($id != 'new') {
            $variables['car'] = $os->getOne('car', $id);
        } else {
            $variables['car']['name'] = 'New car';
        }

        $variables['breadcrumbs'][] = [
            'name'=>'Dashboard',
            'path'=>'/dashboard',
            'active'=>false
        ];
        $variables['breadcrumbs'][] = [
            'name'=>'Cars',
            'path'=>'/dashboard/cars',
            'active'=>false
        ];
        if ($id != 'new') {
            $variables['breadcrumbs'][] = [
                'name' => $variables['car']->getName(),
                'active' => true
            ];
        } else {
            $variables['breadcrumbs'][] = [
                'name' => 'New car',
                'active' => true
            ];
        }

        return $variables;
    }
}
