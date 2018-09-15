<?php

namespace App\DataFixtures;

use App\Entity\JobCategory;
use App\Entity\Location;
use App\Entity\User;
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
            $jobCategory = new JobCategory();
            $jobCategory->setId($category["id"]);
            $jobCategory->setName($category["name"]);

            $manager->persist($jobCategory);
        }

        /* Job locations fixtures */
        $locations = [
            ["zipcode" => "10115", "city" => "Berlin"],
            ["zipcode" => "32457", "city" => "Porta Westfalica"],
            ["zipcode" => "01623", "city" => "Lommatzsch"],
            ["zipcode" => "21521", "city" => "Hamburg"],
            ["zipcode" => "06895", "city" => "Bülzig"],
            ["zipcode" => "01612", "city" => "Diesbar-Seußlitz"],
        ];

        foreach ($locations as $location) {
            $jobLocation = new Location();
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
            $jobUser = new User();
            $jobUser->setId($user["id"]);
            $jobUser->setName($user["name"]);

            $manager->persist($jobUser);
        }

        $manager->flush();
    }
}

