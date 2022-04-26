<?php

namespace App\Controller;

use App\Entity\Citizen;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CitizenController extends AbstractController
{
    #[Route('/citizen', name: 'app_citizen')]
    public function index(): Response
    {
        return $this->render('citizen/index.html.twig', [
            'controller_name' => 'CitizenController',
        ]);
    }

    /**
     * @Route("/create_citizen", name="create_citizen")
     */
    public function createCitizen(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $citizen = new Citizen();
        $citizen->setName('Gau');
        $citizen->setSurname('Frette');
        $citizen->setPhoneNumber('333-4513');

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($citizen);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new Citizen with id '.$citizen->getId());
    }

    /**
     * @Route("/citizen/{id}", name="citizen_show")
     */
    public function show(ManagerRegistry $doctrine, int $id): Response
    {
        $citizen = $doctrine->getRepository(Citizen::class)->find($id);

        if (!$citizen) {
            throw $this->createNotFoundException(
                'No citizen with id '.$id
            );
        }

        return new Response('Name: '.$citizen->getName().' Surname: '.$citizen->getSurname());

        // or render a template
        // in the template, print things with {{ product.name }}
        // return $this->render('product/show.html.twig', ['product' => $product]);
    }

    /**
     * @Route("/allcitizen", name="homepage")
     */
    public function showAll(ManagerRegistry $doctrine): Response
    {
        $citizens = $doctrine->getRepository(Citizen::class)->findAll();

        if(!$citizens) {
            throw $this->createNotFoundException('No citizens found');
        }

        return $this->render('citizen/list.html.twig', [
            'controller_name' => 'CitizenController',
            'citizens' => $citizens,
        ]);
    }
}
