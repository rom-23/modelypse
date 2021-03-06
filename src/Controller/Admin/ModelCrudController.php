<?php

namespace App\Controller\Admin;

use App\Entity\Image;
use App\Entity\Model;
use App\Form\ImageType;
use Doctrine\ORM\Mapping\Id;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Vich\UploaderBundle\Mapping\Annotation\UploadableField;

class ModelCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Model::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $image     = ImageField::new('filename')->setBasePath('/uploads/images/models')->setLabel('Thumbnail');
        $imageFile = TextareaField::new('imageFile')->setFormType(VichImageType::class)->setLabel('Thumbnail');
        $fields    = [
            IdField::new('id', 'ID')->onlyOnIndex(),
            TextField::new('name'),
            NumberField::new('price'),
            DateField::new('createdAt'),
            TextEditorField::new('description'),
            AssociationField::new('categories')->formatValue(function ($value, $entity) {
                $str = $entity->getCategories()[0];
                for ($i = 1; $i < $entity->getCategories()->count(); $i++) {
                    $str = $str . ", " . $entity->getCategories()[$i];
                }
                return $str;
            }),
            AssociationField::new('images')->onlyOnIndex(),
            CollectionField::new('images')
                           ->setEntryType(ImageType::class)
                           ->setFormTypeOption('by_reference', false)
                           ->onlyOnForms(),
            CollectionField::new('images')
                           ->setTemplatePath('admin/images.html.twig')
                           ->onlyOnDetail()
        ];
        if ($pageName === Crud::PAGE_INDEX || $pageName === Crud::PAGE_DETAIL) {
            $fields[] = $image;
        } else {
            $fields[] = $imageFile;
        }

        return $fields;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions->add(CRUD::PAGE_INDEX, 'detail');
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle(Crud::PAGE_INDEX, 'All Models');
    }

}
