<?php

namespace App\DataFixtures;

use App\Entity\Contact;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $contact = (new Contact())
            ->setId(1)
            ->setFirstName('Max')
            ->setLastName('Mustermann')
            ->setStreet('Musterstraße 1')
            ->setZip('12345')
            ->setCity('Musterstadt')
            ->setCountry('DE')
            ->setPhone('+49 1234 56 789')
            ->setBirthday((new DateTime())->setTime(0,0))
            ->setEmail('max@mustermann.de')
        ;
         $manager->persist($contact);

        $manager->flush();
    }
}
