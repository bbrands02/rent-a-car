<?php


namespace App\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Routing\Annotation\Route;

class CarController
{
    private $session;

    /**
     * @Route("/cars")
     * @Template
     */
    public function indexAction() {
        $variables['title'] = "Cars";

        return $variables;
    }
}