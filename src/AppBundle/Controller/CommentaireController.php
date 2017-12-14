<?php
/**
 * Created by PhpStorm.
 * User: romandjohann
 * Date: 23/11/2017
 * Time: 19:58
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Article;
use AppBundle\Entity\Commentaire;
use AppBundle\Form\Type\CommentaireType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CommentaireController extends Controller
{
    /**
     * @param Request $request
     * @param Article $article
     * @return JsonResponse
     */
    public function addAction(Request $request, Article $article)
    {
        $em = $this->getDoctrine()->getManager();

        $commentaire = new Commentaire();

        $url = $this->generateUrl('addCommentaire', ['article' => $article->getId()]);

        $form = $this->createForm(
            new CommentaireType(),
            $commentaire,
            ['action' => $url]
        )->handleRequest($request);

        if ($form->isValid()) {
            $commentaire->setArticle($article);
            $em->persist($commentaire);
            $em->flush();

            return new JsonResponse([
                'code' => 'success',
                'html' => $this->renderView('@App/homepage/lineCommentaire.html.twig', [
                    'commentaire' => $commentaire
                ])
            ]);
        }

        return new JsonResponse([
            'code' => 'error'
        ]);
    }

    /**
     * @param Commentaire $commentaire
     * @return JsonResponse
     */
    public function deleteAction(Commentaire $commentaire)
    {
        if ($commentaire->getArticle()->getAuteur()->getId() ||
            $this->container->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            $em = $this->getDoctrine()->getManager();
            $id = $commentaire->getId();

            $em->remove($commentaire);
            $em->flush();

            return new JsonResponse([
                'code' => 'success',
                'id' => $id
            ]);
        }

        return new JsonResponse([
            'code' => 'error'
        ]);
    }

    public function editAction(Request $request, Commentaire $commentaire)
    {
        if ($commentaire->getArticle()->getAuteur()->getId() ||
            $this->container->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {

            $em = $this->getDoctrine()->getManager();

            $url = $this->generateUrl('editCommentaire', ['commentaire' => $commentaire->getId()]);

            $form = $this->createForm(
                new CommentaireType(),
                $commentaire,
                ['action' => $url]
            )->handleRequest($request);

            if ($form->isValid()) {
                $em->persist($commentaire);
                $em->flush();

                return new JsonResponse([
                    'code' => 'success',
                    'id' => 'commentaire'.$commentaire->getId(),
                    'html' => $this->renderView('AppBundle:article:lineCommentaireEditDelete.html.twig', [
                        'commentaire' => $commentaire
                    ])
                ]);
            }

            return new JsonResponse([
                'code' => 'edition',
                'id' => 'commentaire'.$commentaire->getId(),
                'html' => $this->renderView('AppBundle:commentaire:form.html.twig', [
                    'form' => $form->createView()
                ])
            ]);


        }
        return new JsonResponse([
            'code' => 'error'
        ]);
    }
}