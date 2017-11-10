<?php
/**
 * Created by PhpStorm.
 * User: romandjohann
 * Date: 10/11/2017
 * Time: 19:39
 */

namespace UserBundle\Controller;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;


class CompteController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loginAction(Request $request)
    {
        if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            //return $this->redirectToRoute('oc_platform_accueil');
        }

        $authenticationUtils = $this->get('security.authentication_utils');

        return $this->render('UserBundle:Compte:login.html.twig', array(
            'last_username' => $authenticationUtils->getLastUsername(),
            'error'         => $authenticationUtils->getLastAuthenticationError(),
        ));
    }

    public function addAction(Request $request)
    {

    }
}