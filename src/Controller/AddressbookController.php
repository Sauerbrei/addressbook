<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Contact;
use App\Form\Type\ContactType;
use App\Repository\ContactRepository;
use App\Service\FileUploadService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddressbookController extends AbstractController
{
    public function __construct(
        private FileUploadService $fileUploadService,
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
    public function add(Request $request, EntityManagerInterface $doctrine): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $picture = $form->get('picture')->getData();

            if ($picture instanceof UploadedFile) {
                $storeDirectory = $this->getParameter('picture_upload_directory');
                $storedFile = $this->fileUploadService->storeUpload($picture, $storeDirectory);
                $contact->setPicture($storedFile->getFilename());

                $doctrine->persist($contact);
                $doctrine->flush();
            }

            return $this->redirectToRoute('addressbook');
        }

        return $this->renderForm(
            'addressbook_add.html.twig',
            [
                'form' => $form,
            ]
        );
    }
}
