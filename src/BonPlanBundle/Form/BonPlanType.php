<?php

namespace BonPlanBundle\Form;

use Gregwar\CaptchaBundle\Type\CaptchaType;
use Gregwar\CaptchaBundle\Validator\CaptchaValidator;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Vich\UploaderBundle\Storage\StorageInterface;
use Ivory\GoogleMapBundle\Form\Type\PlaceAutocompleteType;


class BonPlanType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('titre')
            ->add('description')

            ->add('captcha', CaptchaType::class,array(
                'width' => 200,
                'height' => 50,
                'length' => 6,
                'reload' => true,
                'as_url' => true,
            ))
            ->add('file',FileType::class)
            ->add('valider',SubmitType::class);


    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BonPlanBundle\Entity\BonPlan',
            'image_uri' => true,
            'imagine_pattern' => null,
        ));
        $resolver->setAllowedTypes('image_uri', ['bool', 'string', 'callable']);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'bonplanbundle_bonplan';
    }


}
