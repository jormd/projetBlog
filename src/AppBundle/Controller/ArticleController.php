<?php
/**
 * Created by PhpStorm.
 * User: romandjohann
 * Date: 11/11/2017
 * Time: 19:21
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Article;
use AppBundle\Form\Type\ArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ArticleController extends Controller
{

    public function addAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $article = new Article();

        $form = $this->createForm(
            new ArticleType(),
            $article
            )->handleRequest($request);

        if ($form->isValid())
        {
            $em->persist($article);
            $em->flush();

            return new JsonResponse([
                'code' => "success"
            ]);
        }

        return $this->render('@App/article/form.html.twig',[
            'form' => $form->createView()
        ]);
    }
}