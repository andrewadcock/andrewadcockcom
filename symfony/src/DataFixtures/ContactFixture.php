<?php

namespace App\DataFixtures;

use App\Entity\Contact;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ContactFixture extends BaseFixture
{
    public function loadData(ObjectManager $manager)
    {
        $this->createMany(10, 'main_contact', function() {
            $contact = new Contact();
            $contact->setEmail($this->faker->email());
            $contact->setName($this->faker->firstName() . " " . $this->faker->lastName());
            $contact->setSubject($this->faker->text('20'));
            $contact->setMessage($this->faker->text(rand(120, 3000)));

            return $contact;
        });
        $manager->flush();
    }
}
