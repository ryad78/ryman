<?php

namespace App\Controller\Admin;

use App\Entity\Categories;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;

class CategoriesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Categories::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            // la methode hideOneForm pour dire que je veut pas afficher l'id dans mon formulaire
            IdField::new('id')->hideOnForm(),
            TextField::new('name','Nom'),
            TextEditorField::new('description'),
            ImageField::new('image')->setBasePath('/assets/uploads/categories/')
                                    ->setUploadDir('public/assets/uploads/categories')
        ];
    }
    
}
