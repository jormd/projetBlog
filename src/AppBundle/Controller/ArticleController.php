<?php
/**
 * Created by PhpStorm.
 * User: romandjohann
 * Date: 11/11/2017
 * Time: 19:21
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Article;
use AppBundle\Entity\Image;
use AppBundle\Form\Type\ArticleType;
use AppBundle\Form\Type\ImageType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ArticleController extends Controller
{

    /**
     * Création d'un article par un bloggeur
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
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

        $url = $this->generateUrl('addImage');

        $formImage = $this->createForm(
            new ImageType(),
            new Image(),
            ['action' => $url]
        );

        return $this->render('@App/article/form.html.twig',[
            'form' => $form->createView(),
            'article' => $article,
            'images' => $em->getRepository('AppBundle:Image')->findAll(),
            'formImage' => $formImage->createView()
        ]);
    }

    /**
     * Edition d'un article
     *
     * @param Request $request
     * @param Article $article
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editArticleAction(Request $request, Article $article)
    {
        if($article->getAuteur()->getId() == $this->getUser()->getId() ||
            $this->container->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            $url = $this->generateUrl('addArticle');

            $form = $this->createForm(
                new ArticleType(),
                $article,
                ["action" => $url]
            )->handleRequest($request);

            return $this->render('@App/article/editionArticle.twig', [
                'form' => $form->createView(),
                'article' => $article
            ]);
        }
        return new JsonResponse([
            'code' => "error"
        ]);
    }

    public function deleteArticleAction(Article $article)
    {
        if($article->getAuteur()->getId() == $this->getUser()->getId() ||
            $this->container->get('security.authorization_checker')->isGranted('ROLE_ADMIN'))
        {
            $em = $this->getDoctrine()->getManager();

            $em->remove($article);
            $em->flush();

            return new JsonResponse([
                'code' => 'success',
            ]);
        }

        return new JsonResponse([
            'code' => 'error',
        ]);
    }

    /**
     * Sauveaarde automatique d'un article tous les 10 secondes
     *
     * @param Request $request
     * @param Article $article
     * @return JsonResponse
     */
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

    /**
     * Affiche tous les articles par rapport à un utilisateur
     *
     * un bloggeur voient tous ces article publier ou non avec les dernier commentaire
     *
     * un admin voient tous les articles et tous les commentaires
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction()
    {
        $em = $this->getDoctrine();

        if($this->container->get('security.authorization_checker')->isGranted('ROLE_ADMIN')){
            $articles = $em->getRepository('AppBundle:Article')->findAll();
            $commentaires = $em->getRepository('AppBundle:Commentaire')->findAll();
        }
        else{
            $articles = $em->getRepository('AppBundle:Article')->findByUser($this->getUser());
            $commentaires = $em->getRepository('AppBundle:Commentaire')->findByUser($this->getUser());
        }



        return $this->render('AppBundle:article:list.html.twig', [
            'articles' => $articles,
            'commentaires' => $commentaires
        ]);
    }

    /**
     * affiche le dernier article publier (doit utiliser un dateTime !!!) avec ses commentaires ainsi que les autres article publier
     *
     * @param Article $article
     * @return \Symfony\Component\HttpFoundation\Response
     */
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

    /**
     * Permet de publier ou dépublier un article
     *
     * @param Article $article
     * @return JsonResponse
     */
    public function publishAction(Article $article)
    {
        $em = $this->getDoctrine()->getManager();

        if($article->getAuteur()->getId()){
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

        return new JsonResponse([
            'code' => 'error'
        ]);
    }
}