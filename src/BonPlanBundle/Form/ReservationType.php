<?php

namespace BonPlanBundle\Form;

use BonPlanBundle\BonPlanBundle;
use BonPlanBundle\Entity\NoteBonPlan;
use BonPlanBundle\Entity\Reservation;
use BonPlanBundle\Entity\Utilisateur;
use Doctrine\DBAL\Types\IntegerType;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
           //->add('dateReservation' ,DateType::class,array('input'  => 'datetime','widget' => 'single_text','html5' => true,'attr' => ['class' => 'js-datepicker form-control pull-right','placeholder'=>'Entrer la date du reservation']))
            ->add('nbrCoupon',\Symfony\Component\Form\Extension\Core\Type\IntegerType::class,array('attr'=>array('class'=>'js-datepicker form-control pull-right')))
            ->add('startdate', DateTimeType::class, [
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
                'attr' => [
                    'placeholder' => 'Start Date'
                ]
            ])
      //      ->add('enddate', DateTimeType::class, [
        //        'date_widget' => 'single_text',
          //      'time_widget' => 'single_text',
            //    'attr' => [
              //      'placeholder' => 'End Date'
                //]
           // ])
            // ->add('idBonPlan' ,TextType::class,array('data_class'=>null))
           // ->add('idBonPlan',EntityType::class,array('class'=>'BonPlanBundle:BonPlan','label'=>'titre','data_class'=>null,'attr'=>array('class'=>'form-control')))
            ->add('Ajouter',SubmitType::class,array('attr'=>array('class'=>' btn-block btn-warning ')))
        ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BonPlanBundle\Entity\Reservation'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'bonplanbundle_reservation';
    }


}
