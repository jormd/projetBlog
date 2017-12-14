<?php
/**
 * Created by PhpStorm.
 * User: romandjohann
 * Date: 14/12/2017
 * Time: 15:12
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Image;
use AppBundle\Form\Type\ImageType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ImageController extends Controller
{

    public function addImageAction(Request $request)
    {
        $image = new Image();

        $url = $this->generateUrl('addImage');

        $form = $this->createForm(
            new ImageType(),
            $image,
            ['action' => $url]
        )->handleRequest($request);

        if($form->isValid()){
            $image->setImageName($image->getFile()->getClientOriginalName());

            $em = $this->getDoctrine()->getManager();
            $em->persist($image);
            $em->flush();

            return new JsonResponse([
                'code' => 'success',
                'html' => $this->renderView('AppBundle:image:image.html.twig', [
                    'image' => $image
                ])
            ]);
        }
        else{
            var_dump($form->getErrorsAsString());die();
        }

    }
}