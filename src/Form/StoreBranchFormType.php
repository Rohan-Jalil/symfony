<?php


namespace App\Form;


use App\Entity\Store;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Type;

/**
 * Class StoreBranchFormType
 * @package App\Form
 */
class StoreBranchFormType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $storeBranch = $options['storeBranch'];
        $builder->add('id', HiddenType::class, [
            'data' => $storeBranch->getId() ? $storeBranch->getId() : null
        ]);
        $builder->add('store', EntityType::class, [
            'class' => Store::class,
            'data' => $storeBranch->getStore() ? $storeBranch->getStore() : null,
            'choice_label' => 'storeName',
            'label' => 'Select Store',
            'placeholder' => 'Select Store',
            'constraints' => [
                new NotNull()
            ]
        ]);
        $builder->add('name', TextType::class, [
            'data' => $storeBranch->getName() ? $storeBranch->getName() : null,
            'constraints' => [
                new NotNull(),
                new Length(['min' => '2', 'max' => '200'])
            ]
        ]);
        $builder->add('street', TextType::class, [
            'data' => $storeBranch->getStreet() ? $storeBranch->getStreet() : null,
            'constraints' => [
                new NotNull(),
                new Length(['min' => '2', 'max' => '200'])
            ]
        ]);
        $builder->add('county', TextType::class, [
            'data' => $storeBranch->getCounty() ? $storeBranch->getCounty() : null,
            'constraints' => [
                new NotNull(),
                new Length(['min' => '2', 'max' => '200'])
            ]
        ]);
        $builder->add('state', TextType::class, [
            'data' => $storeBranch->getState() ? $storeBranch->getState() : null,
            'constraints' => [
                new NotNull(),
                new Length(['min' => '2', 'max' => '200'])
            ]
        ]);
        $builder->add('zipcode', IntegerType::class, [
            'data' => $storeBranch->getZipcode() ? $storeBranch->getZipcode() : null,
            'attr' => [
                'min' => 0
            ],
            'constraints' => [
                new NotNull(),
                new Type('integer'),
                new Length(['min' => '3', 'max' => '5']),
                new GreaterThanOrEqual(00000),
                new LessThanOrEqual(99999)
            ]
        ]);
        $builder->add('numberOfEmployees', IntegerType::class, [
            'data' => $storeBranch->getNumberOfEmployees() ? $storeBranch->getNumberOfEmployees() : null,
            'attr' => [
                'min' => 0
            ],
            'constraints' => [
                new NotNull(),
                new GreaterThanOrEqual(0)
            ]
        ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'storeBranch' => null
        ]);
    }
}