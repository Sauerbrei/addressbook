<?php

namespace App\Tests\Manager;

use App\Entity\Contact;
use App\Manager\ContactManager;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class ContactManagerTest extends TestCase
{
    private ContactManager $contactManager;

    protected function setUp(): void
    {
        parent::setUp();

        $contactRepository = $this->createMock(ContactRepository::class);
        $contactRepository->method('find')->willReturn(null);
        $this->contactManager = new ContactManager(
            $this->createMock(EntityManagerInterface::class),
            $contactRepository
        );
    }

    public function testGetById(): void
    {
        $contact = $this->contactManager->getById('0');

        self::assertInstanceOf(Contact::class, $contact);
        self::assertSame(0, $contact->getId());
        self::assertFalse($contact->isPresent());
    }

}
