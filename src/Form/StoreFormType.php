<?php


namespace App\Form;


use App\Entity\Branch;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;

/**
 * Class StoreFormType
 * @package App\Form
 */
class StoreFormType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $store = $options['store'];
        $builder->add('id', HiddenType::class, [
            'data' => $store->getId() ? $store->getId() : null
        ]);
        $builder->add('storeName', TextType::class, [
            'data' => $store->getStoreName() ? $store->getStoreName() : null,
            'constraints' => [
                new NotNull(),
                new Length(['min' => '10', 'max' => '200'])
            ]
        ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'store' => null
        ]);
    }
}