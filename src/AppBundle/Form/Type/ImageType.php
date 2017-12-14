<?php
/**
 * Created by PhpStorm.
 * User: romandjohann
 * Date: 14/12/2017
 * Time: 15:20
 */

namespace AppBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class ImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('file', FileType::class, [
            'label' => 'insertion d\'image'
        ])
            ->add('submit', SubmitType::class);
    }

}