<?php

namespace App\Tests\Form\Type;

use App\Entity\Contact;
use App\Form\Type\ContactType;
use DateTime;
use Symfony\Component\Form\Test\TypeTestCase;

class ContactTypeTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
        $expected = (new Contact())
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
        $formData = [
            'firstName' => $expected->getFirstName(),
            'lastName' => $expected->getLastName(),
            'street' => $expected->getStreet(),
            'zip' => $expected->getZip(),
            'city' => $expected->getCity(),
            'country' => $expected->getCountry(),
            'phone' => $expected->getPhone(),
            'birthday' => [
                'month' => $expected->getBirthday()->format('n'),
                'day' => $expected->getBirthday()->format('j'),
                'year' => $expected->getBirthday()->format('Y'),
            ],
            'email' => $expected->getEmail(),
        ];

        $model = new Contact();
        $form = $this->factory->create(ContactType::class, $model);
        $form->submit($formData);

        self::assertTrue($form->isSynchronized());
        self::assertEquals($expected, $model);
    }
}
