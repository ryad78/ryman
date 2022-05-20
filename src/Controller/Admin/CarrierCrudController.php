<?php

namespace App\Controller\Admin;

use App\Entity\Carrier;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;

class CarrierCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Carrier::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [//hideOnForm() pour ne pas lafficher dans mon formulaire de dashbord
            IdField::new('id')->hideOnForm(),
            TextField::new('name'),
            TextField::new('description'),
            MoneyField::new('price')->setCurrency('EUR'),
            DateTimeField::new('createdAt')
        ];
    }
    
}
