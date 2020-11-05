<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;
use App\Service\ObjectService;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
         if ($this->getUser()) {
             return $this->redirectToRoute('app_security_user');
         }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @Route("/register", name="app_register")
     * @Template
     */
    public function registerAction()
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_security_user');
        }
        $variables['title'] = 'Sign up';

        return $variables;
    }

    /**
     * @Route("/me")
     * @Template
     */
    public function userAction() {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $variables['title'] = 'Profile';

        return $variables;
    }

    /**
     * @Route("/create-user")
     */
    public function makeUserAction(Request $req, EntityManagerInterface $em, ObjectService $os) {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_security_user');
        }

        if ($req->isMethod('POST')) {
            $object = $req->request->all();

            if(!empty($object['email']) && !empty($object['password']) && !empty($object['passwordConfirm'])) {
                if($object['password'] === $object['passwordConfirm']) {
                    $os->uploadObject($object);
                } else {
                    throw new \Exception('Please make sure the passwords are identical.');
                }
            } else {
                throw new \Exception('Please fill in all required fields.');
            }
        }

        return $this->redirectToRoute('app_login');
    }


}
