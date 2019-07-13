<?php

namespace App\DataFixtures;


use Faker\Factory;
use App\Entity\Tag;
use App\Entity\Role;
use App\Entity\User;
use App\Entity\Answer;
use App\Entity\Question;
use Faker\ORM\Doctrine\Populator;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{

    private $passwordEncoder;
   
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
       
    }

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

        //the user admin 
        $userAdmin = new User();
        $userAdmin->setRole($roleAdmin);
        $userAdmin->setFirstname('admin');
        $userAdmin->setLastname('admin');
        $encodedPassword = $this->passwordEncoder->encodePassword($userAdmin, 'admin');
        $userAdmin->setPassword($encodedPassword);
        $userAdmin->setEmail('admin@admin.com');
        $userAdmin->setImage($generator->unique()->imageUrl());
        $manager->persist($userAdmin);


        $populator = new \Faker\ORM\Doctrine\Populator($generator, $manager);

        $populator->addEntity(User::class, 10, [
            'firstname' => function() use($generator) { return $generator->unique()->firstname(); },
            'lastname' => function() use($generator) { return $generator->unique()->lastname(); },
            'email' => function() use($generator) { return $generator->unique()->email(); },
            'password' => function() use($generator) { return $generator->unique()->password(); },
            'image' => function() use($generator) { return $generator->unique()->imageUrl(); },
        ]);

        $populator->addEntity(Question::class, 20, [
            'title' => function() use($generator) { return $generator->unique()->sentence(1); },
            'content' => function() use($generator) { return $generator->realText(200); },
            'status' => function() use($generator) { return $generator->numberBetween(0,1); },
        ]);

        $populator->addEntity(Answer::class, 40, [
            'content' => function() use($generator) { return $generator->realText(200); },
            'status' => function() use($generator) { return $generator->numberBetween(0,1); },
        ]);

        $populator->addEntity(Tag::class, 12, [
            'name' => function() use($generator) { return $generator->unique()->jobTitle(); },
        ]);

        $inserted = $populator->execute();

//Add tags to questions in manytomany relation : 
        $tags = $inserted['App\Entity\Tag'];
        $questions = $inserted['App\Entity\Question'];

        foreach ($questions as $question){
            shuffle($tags);
            // dd($tags[1]);
            $question->addTag($tags[1]);
            $question->addTag($tags[2]);
            $question->addTag($tags[3]);

            $manager->persist($question);
        }

//Setting all users as ROLE_USER
        $users = $inserted['App\Entity\User'];

        foreach ($users as $user) {
            $user->setRole($roleUser);

            $manager->persist($user);
        }


        $manager->flush();
    }
}
