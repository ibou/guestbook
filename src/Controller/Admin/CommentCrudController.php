<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Comment;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CommentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Comment::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('email');
        yield TextField::new('author');
        yield TextField::new('state');
        yield ImageField::new('photoFilename')
            ->setBasePath('/uploads/photos/')
            ->setUploadDir('/public/uploads/photos/')
            ;
        yield TextEditorField::new('text');
        yield AssociationField::new('conference')->autocomplete();
    }
}
