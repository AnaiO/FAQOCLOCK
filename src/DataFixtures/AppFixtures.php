<?php

namespace App\DataFixtures;


use Faker\Factory;
use App\Entity\Role;
use App\Entity\User;
use Faker\ORM\Doctrine\Populator;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        //3 main user roles
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

        
        $generator = \Faker\Factory::create('fr_FR');

        $userAdmin = new User();
        $userAdmin->setRole($roleAdmin);
        $userAdmin->setFirstname('admin');
        $userAdmin->setLastname('admin');
        $userAdmin->setPassword('admin');
        $userAdmin->setEmail($generator->email());
        $userAdmin->setImage($generator->imageUrl());
        $manager->persist($userAdmin);

        $populator = new \Faker\ORM\Doctrine\Populator($generator, $manager);

        $populator->addEntity('App\Entity\User', 10, [
            'firstname' => function() use($generator) { return $generator->firstname(); },
            'lastname' => function() use($generator) { return $generator->lastname(); },
            'email' => function() use($generator) { return $generator->email(); },
            'password' => function() use($generator) { return $generator->password(); },
            'image' => function() use($generator) { return $generator->imageUrl(); },
        ]);
    

        $inserted = $populator->execute();

        $users = $inserted['App\Entity\User'];
        foreach ($users as $user) {
            $user->setRole($roleUser);
        }


        $manager->flush();
    }
}
