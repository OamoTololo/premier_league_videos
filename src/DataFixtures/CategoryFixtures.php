<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture{
    public function load(ObjectManager $manager): void{

         $this->loadMainCategories($manager);
        $this->loadGoals($manager);
        $this->loadSaves($manager);
        $this->loadSaves2($manager);
        $this->loadSkills($manager);
        $this->loadTackles($manager);
        $this->loadTackles2($manager);

    }

    private function loadMainCategories($manager){

        foreach($this->getMainCategoriesData() as [$name]){

            $category = new Category();
            $category->setName($name);
            $manager->persist($category);
        }

        $manager->flush();
    }

    private function loadGoals($manager){
        $this->loadSubcategories($manager, 'Goals', 1);
    }

    private function loadSaves($manager){
        $this->loadSubcategories($manager, 'Saves', 6);
    }

    private function loadSaves2($manager){
        $this->loadSubcategories($manager, "CloseRange", 8);
    }

    private function loadSkills($manager){
        $this->loadSubcategories($manager, "Skills", 3);
    }

    private function loadTackles($manager){
        $this->loadSubcategories($manager, "Tackles", 4);
    }

    private function loadTackles2($manager){
        $this->loadSubcategories($manager, "DirtyTackles", 18);
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

    private function getSavesData(){

        return [
            ['CloseRange', 8],
            ['UnbelievableSaves', 9],
        ];
    }

    private function getCloseRangeData(){

        return [
            ['WithFeet', 10],
            ['WithHands', 11],
            ['WithHead', 12],
            ['WithBodyPart', 13],
            ['TippedOverTheBar', 14],
        ];
    }

    private function getSkillsData(){

        return [
            ['JogaBonito', 15],
            ['CloseControl', 16],
        ];
    }

    private function getTacklesData(){

        return [
            ['CleanTackles', 17],
            ['DirtyTackles', 18],
        ];
    }

    private function getDirtyTacklesData(){

        return [
            ['FunnyDirtyTackles', 19],
            ['SeriousDirtyTackles', 20],
        ];
    }
}
