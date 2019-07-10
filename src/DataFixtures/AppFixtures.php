<?php

namespace App\DataFixtures;


use Faker\Factory;
use App\Entity\Role;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $roleAdmin = new Role();
        $roleAdmin->setCode('ROLE_ADMIN');
        $roleAdmin->setName('Admin');
        $manager->persist($roleAdmin);

        $roleModerator = new Role();
        $roleModerator->setCode('ROLE_MODERATOR');
        $roleModerator->setName('Moderator');
        $manager->persist($roleModerator);

        $roleUser = new Role();
        $roleUser->setCode('ROLE_USER');
        $roleUser->setName('user');
        $manager->persist($roleUser);

        



   
       

        $manager->flush();
    }
}
