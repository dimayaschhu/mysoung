<?php

namespace App\Controller\Admin;

use App\Entity\Advertising;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class AdvertisingCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Advertising::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
