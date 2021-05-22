<?php


namespace App\Doctrine;


use App\Entity\Category;

class CategorySetOwnerListener extends SetOwnerListener
{
    public function prePersist(Category $category)
    {
        $this->setOwnerIfNotSet($category);
    }

}
