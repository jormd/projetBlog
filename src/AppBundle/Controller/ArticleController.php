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
        $url = $this->generateUrl('addArticle');

        $form = $this->createForm(
            new ArticleType(),
            $article,
            ["action" => $url]
            )->handleRequest($request);

        $article->setAuteur($this->getUser());

        $em->persist($article);
        $em->flush();

        return $this->render('@App/article/form.html.twig',[
            'form' => $form->createView(),
            'article' => $article
        ]);
    }

    public function addAjaxAction(Request $request, Article $article){
        $em = $this->getDoctrine()->getManager();

        $url = $this->generateUrl('addAjaxArticle', ['article' => $article->getId()]);

        $form = $this->createForm(
            new ArticleType(),
            $article,
            ["action" => $url]
        )->handleRequest($request);



        if ($form->isValid())
        {

            $article->setAuteur($this->getUser());

            $em->persist($article);
            $em->flush();

            return new JsonResponse([
                'code' => "success"
            ]);
        }

        return new JsonResponse([
            'code' => "error"
        ]);
    }

    public function listAction()
    {
        $em = $this->getDoctrine();

        $articles = $em->getRepository('AppBundle:Article')->findByUser($this->getUser());

        $commentaires = $em->getRepository('AppBundle:Commentaire')->findByUser($this->getUser());

        return $this->render('AppBundle:article:list.html.twig', [
            'articles' => $articles,
            'commentaires' => $commentaires
        ]);
    }

    public function OneArticleAction(Article $article)
    {
        $em = $this->getDoctrine()->getManager();

        $theArticle = $em->getRepository('AppBundle:Article')->oneArticlePublish($article);

        $articles = $em->getRepository('AppBundle:Article')->articlePublish();

        return $this->render('@App/homepage/list.html.twig', [
            'article' => $theArticle[0],
            'articles' => $articles
        ]);

    }

    public function publishAction(Article $article)
    {
        $em = $this->getDoctrine()->getManager();

        if($article->getPublier()) {
            $article->setPublier(false);
            $article->setDatePublication(null);

        }
        else{
            $article->setPublier(true);
            $article->setDatePublication(new \DateTime());
        }

        $em->persist($article);
        $em->flush();

        return new JsonResponse([
            'code' => 'success'
        ]);
    }
}