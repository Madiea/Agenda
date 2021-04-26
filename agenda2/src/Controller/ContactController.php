<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index()
    {

        return $this->render('contact/contact.html.twig', [
            'controller_name' => 'ContactController',
        ]);
    }

    /**
     * @Route("/contact/{id}", name="contact")
     */
    public function contact($id)
    {
        $contact = $this->getDoctrine()->getRepository(Contact::class)->find($id);
        return $this->render('contact/contact.html.twig', [
            "id" => $id,
            "contact" => $contact
        ]);
    }


    /**
     * @Route("/admin/add", name="add")
     */
    public function addContact(Request $request)
    {
       $contact = new Contact;
       $form = $this->createForm(ContactType::class, $contact);
       $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->persist($contact);
          $entityManager->flush();

          $this->addFlash("contact_add" ,"Contact ajouté avec succès");

          return $this->redirectToRoute('home');
      } 

      return $this->render('ajouter.html.twig', [
          "form" => $form->createView() 
      ]);
    }

    /**
     * @Route ("admin/contact/edit/{id}", name="edit")
     */
    public function edit($id, Request $request)
    {
       
        $contact = $this->getDoctrine()->getRepository(Contact::class)->find($id);

        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $entityManager = $this->getDoctrine()->getManager();          
            $entityManager->flush();
            
            $this ->addFlash("contact_edit", "Contact modifié avec succès");

            return $this->redirectToRoute('home');
        }
        return $this->render('modifier.html.twig', [
            "form" => $form->createView() 
        ]);
    }

    /**
     * @Route ("admin/contact/delete/{id}", name="delete")
     */
    public function delete($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $contact = $entityManager->getRepository(Contact::class)->find($id);

        $entityManager->remove($contact);
        $entityManager->flush();

        return $this->redirectToRoute('home');
    }
}
