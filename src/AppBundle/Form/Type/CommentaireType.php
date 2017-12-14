<?php
/**
 * Created by PhpStorm.
 * User: romandjohann
 * Date: 23/11/2017
 * Time: 20:07
 */

namespace AppBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class CommentaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('texte', TextType::class, [
            'attr' => [
                'class' => 'tinymce'
            ],
            'label' => false
        ])
        ->add('save', SubmitType::class, array('label' => 'Sauvegarder'));

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Commentaire',
            'csrf_protection' => false,
        ]);
    }

    public function getName()
    {
        return "Commentaire";
    }

}