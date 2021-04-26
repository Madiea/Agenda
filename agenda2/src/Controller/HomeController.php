<?php

namespace App\Controller;

use App\Entity\Contact;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        $minAge = 18;
        $contact = $this->getDoctrine()->getRepository(Contact::class)->findAllGreaterThanAge($minAge);

        return $this->render('home.html.twig', [
            'contacts' => $contact,
        ]);
    }
}
