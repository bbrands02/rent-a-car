<?php


namespace App\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UserController
 * @Route("/user")
 */
class UserController
{
    private $session;

    /**
     * @Route("/login")
     * @Template
     */
    public function loginAction() {
        $variables['title'] = "Login";

        return $variables;
    }
}