<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture{
    public function load(ObjectManager $manager): void{

         $this->loadMainCategories($manager);
        $this->loadSubcategories($manager, 'Goals', 1);
    }

    private function loadMainCategories($manager){

        foreach($this->getMainCategoriesData() as [$name]){

            $category = new Category();
            $category->setName($name);
            $manager->persist($category);
        }

        $manager->flush();
    }

    private function loadSubcategories($manager, $category, $parent_id){

        $parent = $manager->getRepository(Category::class)->find($parent_id);
        $methodName = "get{$category}Data";

        foreach($this->$methodName() as [$name]){

            $category = new Category();
            $category->setName($name);
            $category->setParent($parent);
            $manager->persist($category);
        }

        $manager->flush();
    }

    private function getMainCategoriesData(){

        return [
            ['Goals', 1],
            ['Saves', 2],
            ['Skills', 3],
            ['Tackles', 4],
        ];
    }

    private function getGoalsData(){

        return [
            ['LongRange', 5],
            ['TapIns', 6],
            ['Corners', 7],
        ];
    }
}
