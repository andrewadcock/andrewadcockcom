<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactFormType;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{

    /**
     * @Route("/contact", name="app_contact")
     */
    public function page(EntityManagerInterface $em, Request $request)
    {

        $form = $this->createForm(ContactFormType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            /** @var Contact $contact */
            $contact = $form->getData();

            $em->persist($contact);
            $em->flush();

            $this->addFlash('success', 'Thank you for contacting me! I\'ll be in touch shortly!');

            // Todo: Create Thank you page or something
            return $this->redirectToRoute('app_contact');
        }

        return $this->render('single/contact.html.twig', [
            'contactForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/contact", name="admin_contact_list")
     */
    public function list(ContactRepository $contactRepository) {

        // Get all contacts
        $contacts = $contactRepository->findBy([], ['id' => 'DESC']);

        return $this->render('admin/contact-list.html.twig', [
            'contacts' => $contacts,
        ]);
    }

    /**
     * @Route("/admin/contact/{id}", name="admin_contact_single")
     */
    public function showSingle(ContactRepository $contactRepository, int $id)
    {

        $contact = $contactRepository->findOneBy(['id' => $id]);

        return $this->render('admin/contact-single.html.twig', [
            'contact' => $contact,
        ]);
    }
}