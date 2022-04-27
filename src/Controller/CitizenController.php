<?php

namespace App\Controller;

use App\Entity\Citizen;
use App\Form\CitizenType;

use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/citizen/show/{id}", name="citizen_show")
     */
    public function show(ManagerRegistry $doctrine, int $id): Response
    {
        $citizen = $doctrine->getRepository(Citizen::class)->find($id);

        if (!$citizen) {
            throw $this->createNotFoundException(
                'No citizen with id '.$id
            );
        }

        // return new Response('Name: '.$citizen->getName().' Surname: '.$citizen->getSurname());

        // or render a template
        // in the template, print things with {{ citizen.name }}
        return $this->render('citizen/citizen.html.twig', ['citizen' => $citizen]);
    }

    #[Route('/citizen/showAll', name: 'all_citizen')]
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

    #[Route('/citizen/register', name: 'create_citizen')]
    public function create(Request $request, EntityManagerInterface $em) : Response
    {
        // creates a task object and initializes some data for this example
        $citizen = new Citizen();

        $form = $this->createForm(CitizenType::class, $citizen);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$citizen` variable has also been updated
            $citizen = $form->getData();

            $em->persist($citizen);
            $em->flush();

            return $this->redirectToRoute('index');
        }

        return $this->renderForm('citizen/new.html.twig', [
            'form' => $form,
        ]);
    }
}
