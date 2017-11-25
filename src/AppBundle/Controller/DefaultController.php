<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{


    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine();

        $lastArticle = $em->getRepository('AppBundle:Article')->lastArticlePublish()?:null;
        $articles = $em->getRepository('AppBundle:Article')->articlePublish();

        return $this->render('@App/default/list.html.twig', [
            'article' => $lastArticle[0],
            'articles' => $articles
        ]);
        // replace this example code with whatever you need
       /* return $this->render('@App/default/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ));*/
    }
}
