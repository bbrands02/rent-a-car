<?php


namespace App\Controller;


use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $session;

    /**
     * @Route("/")
     * @Template
     */
    public function indexAction(EntityManagerInterface $em)
    {
        $variables['title'] = "Home";

        $variables['images'][0]['src'] = '/images/car_1.jpg';
        $variables['images'][0]['alt'] = 'Car 1';
        $variables['images'][0]['height'] = '600px';
        $variables['images'][0]['active'] = 'true';

        $variables['images'][1]['src'] = '/images/car_2.jpg';
        $variables['images'][1]['alt'] = 'Car 2';
        $variables['images'][1]['height'] = '600px';

        $variables['images'][2]['src'] = '/images/car_3.jpg';
        $variables['images'][2]['alt'] = 'Car 3';
        $variables['images'][2]['height'] = '600px';

        return $variables;
    }
}