<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Contact;
use App\Form\Type\ContactType;
use App\Repository\ContactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddressbookController extends AbstractController
{
    public function __construct(
        private ContactRepository $contactRepository
    ) {}

    #[Route('/', name: 'addressbook')]
    public function index(): Response
    {
        $contactList = $this->contactRepository->findAll();

        return $this->render(
            'addressbook_view.html.twig',
            [
                'contactList' => $contactList,
            ]
        );
    }

    #[Route('/add', name: 'addressbook_add')]
    public function add(): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);

        return $this->renderForm(
            'addressbook_add.html.twig',
            [
                'form' => $form,
            ]
        );
    }
}
