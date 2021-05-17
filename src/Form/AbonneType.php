<?php

namespace App\Form;

use App\Entity\Abonne;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Regex;

class AbonneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //Récupérer la variable abonné passé en paramètre pour construire le formulaire
        $abonne = $options["data"];//$abonne est un objet de la classe App\Entity\Abonne
        $builder
            ->add('pseudo')
            ->add('roles', ChoiceType::class,[
                "choices" => [
                    "Directeur" => "ROLE_ADMIN",
                    "Bibliothécaire" => "ROLE_BIBLIO",
                    "Lecteur" => "ROLE_LECTEUR"
                ],
                "multiple" => true, //multiple=> true necessaire  car on est dans un array et qu'il y a plusieur option
                // doit ètre true ,parce que 'roles' est un array et donc peut avoir plusieur valeurs
                "expanded" => true //pour afficher sous forme de cases à cocher
            ])
            ->add('password', TextType::class,[
                "mapped" => false, //pour ne pas selectionner tous les inputs (quel ne soit pas relié a l'objet automatiquement pour ne pas avoir un objet en claire enregistrer tel le mot de passe) notament le motdepasse  explication a 11h43 le 12/05/2021 
                "constraints" => [
                    new Regex([
                        "pattern" => "/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[-+!*$@%_])([-+!*$@%_\w]{6,10})$/",
                        "message" => "Le mot de passe doit contenir au moins 1 majuscule, 1 minuscule,1chiffre,1 caractères special et doit faire entre 6 et 10 caractères "
                    ])
                ],
                "help"=> "Le mot de passe doit contenir au moins 1 majuscule, 1 minuscule,1chiffre,1 caractères special parmi -+!*$@%_ et doit faire entre 6 et 10 caractères ",
                    
                "required"=> $abonne->getId() ? false : true

            ])
            ->add('prenom')
            ->add('nom')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Abonne::class,
        ]);
    }
}
