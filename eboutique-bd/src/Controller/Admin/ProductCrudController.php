<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField; // Import indispensable
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(), // On cache l'ID lors de la création
            TextField::new('name', 'Nom du produit'),
            TextEditorField::new('description', 'Description'),
            NumberField::new('priceHT', 'Prix HT'),
            
            // C'est ce champ qui permet de lier la catégorie
            AssociationField::new('category', 'Catégorie du produit')
                ->setRequired(true) // Optionnel : rend la sélection obligatoire
                ->setHelp('Choisissez le genre de la bande dessinée'),
            
            BooleanField::new('available', 'Disponible en stock')
            ->renderAsSwitch(true),

            AssociationField::new('media', 'Images du produit')
                ->setFormTypeOptions([
                    'by_reference' => false, // Obligatoire pour les relations collections (ManyToMany/OneToMany)
                ])
                ->autocomplete(),
        ];
    }
}