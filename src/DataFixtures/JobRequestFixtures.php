<?php

namespace App\DataFixtures;

use App\Entity\JobCategoryEntity;
use App\Entity\JobLocationEntity;
use App\Entity\JobUserEntity;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class JobRequestFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        /* Job categories fixtures */
        $categories = [
            ["id" => 804040, "name" => "Sonstige Umzugsleistungen"],
            ["id" => 802030, "name" => "Abtransport, Entsorgung und Entrümpelung"],
            ["id" => 411070, "name" => "Fensterreinigung"],
            ["id" => 402020, "name" => "Holzdielen schleifen"],
            ["id" => 108140, "name" => "Kellersanierung"],
        ];

        foreach ($categories as $category) {
            $jobCategory = new JobCategoryEntity();
            $jobCategory->setId($category["id"]);
            $jobCategory->setName($category["name"]);

            $manager->persist($jobCategory);
        }

        /* Job locations fixtures */
        $locations = [
            ["id" => 1 , "zipcode" => "10115", "city" => "Berlin"],
            ["id" => 2, "zipcode" => "32457", "city" => "Porta Westfalica"],
            ["id" => 3, "zipcode" => "01623", "city" => "Lommatzsch"],
            ["id" => 4, "zipcode" => "21521", "city" => "Hamburg"],
            ["id" => 5, "zipcode" => "06895", "city" => "Bülzig"],
            ["id" => 6, "zipcode" => "01612", "city" => "Diesbar-Seußlitz"],
        ];

        foreach ($locations as $location) {
            $jobLocation = new JobLocationEntity();
            $jobLocation->setId($location["id"]);
            $jobLocation->setZipcode($location["zipcode"]);
            $jobLocation->setCity($location["city"]);

            $manager->persist($jobLocation);
        }

        /* Job users fixtures */
        $users = [
            ["id" => 524, "name" => "Die Anna"],
            ["id" => 3459, "name" => "Max Damage"],
        ];

        foreach ($users as $user) {
            $jobUser = new JobUserEntity();
            $jobUser->setId($user["id"]);
            $jobUser->setName($user["name"]);

            $manager->persist($jobUser);
        }

        $manager->flush();
    }
}

