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
        $variables['title'] = 'Users';

        return $variables;
    }

    /**
     * @Route("/users/{id}")
     * @Template
     */
    public function userAction(Request $req, EntityManagerInterface $em, ObjectService $os)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $variables['title'] = 'User';

        return $variables;
    }

    /**
     * @Route("/cars")
     * @Template
     */
    public function carsAction(Request $req, EntityManagerInterface $em, ObjectService $os)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $variables['title'] = 'Cars';

        return $variables;
    }

    /**
     * @Route("/cars/{id}")
     * @Template
     */
    public function carAction(Request $req, EntityManagerInterface $em, ObjectService $os)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $variables['title'] = 'Car';

        return $variables;
    }
}
