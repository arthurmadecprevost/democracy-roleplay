<?php

namespace App\Controller;

use App\Entity\VehicleModel;
use App\Form\VehicleModel1Type;
use App\Repository\VehicleModelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/vehicle_model')]
class VehicleModelController extends AbstractController
{
    #[Route('/', name: 'app_vehicle_model_index', methods: ['GET'])]
    public function index(VehicleModelRepository $vehicleModelRepository): Response
    {
        return $this->render('vehicle_model/index.html.twig', [
            'vehicle_models' => $vehicleModelRepository->findAll(),
        ]);
    }

    #[Route('/vehicle_model/new', name: 'app_vehicle_model_new', methods: ['GET', 'POST'])]
    public function new(Request $request, VehicleModelRepository $vehicleModelRepository): Response
    {
        $vehicleModel = new VehicleModel();
        $form = $this->createForm(VehicleModel1Type::class, $vehicleModel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $vehicleModelRepository->add($vehicleModel);
            return $this->redirectToRoute('app_vehicle_model_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('vehicle_model/new.html.twig', [
            'vehicle_model' => $vehicleModel,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_vehicle_model_show', methods: ['GET'])]
    public function show(VehicleModel $vehicleModel): Response
    {
        return $this->render('vehicle_model/show.html.twig', [
            'vehicle_model' => $vehicleModel,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_vehicle_model_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, VehicleModel $vehicleModel, VehicleModelRepository $vehicleModelRepository): Response
    {
        $form = $this->createForm(VehicleModel1Type::class, $vehicleModel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $vehicleModelRepository->add($vehicleModel);
            return $this->redirectToRoute('app_vehicle_model_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('vehicle_model/edit.html.twig', [
            'vehicle_model' => $vehicleModel,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_vehicle_model_delete', methods: ['POST'])]
    public function delete(Request $request, VehicleModel $vehicleModel, VehicleModelRepository $vehicleModelRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$vehicleModel->getId(), $request->request->get('_token'))) {
            $vehicleModelRepository->remove($vehicleModel);
        }

        return $this->redirectToRoute('app_vehicle_model_index', [], Response::HTTP_SEE_OTHER);
    }
}
