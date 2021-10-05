<?php

namespace App\Controller\Api;

use App\Request\Rent\GetRentRequest;
use App\Service\Rent\GetRentService;
use App\Request\Rent\CreateRentRequest;
use App\Service\Rent\CreateRentService;
use App\Request\Rent\DeliverRentRequest;
use App\Service\Rent\DeliverRentService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("rent", name="rent_")
 */
class RentController extends AbstractController
{
    /**
     * @Route("", methods={"POST"}, name="create")
     */
    public function createRent(CreateRentRequest $request, CreateRentService $createRentService)
    {
        $createRentService->create($request->toCommand());

        return $this->json([
            'message' => 'Rent created successfully.'
        ], Response::HTTP_CREATED);
    }

    /**
     * @Route("/deliver", methods={"PATCH"}, name="deliver")
     */
    public function deliverRent(DeliverRentRequest $request, DeliverRentService $deliverRentService)
    {
        $deliverRentService->deliver($request->toCommand());

        return $this->json([
            'message' => 'Rent delivered successfully.'
        ], Response::HTTP_CREATED);
    }

    /**
     * @Route("/get", methods={"PATCH"}, name="get")
     */
    public function getRent(GetRentRequest $request, GetRentService $getRentService)
    {
        $getRentService->deliver($request->toCommand());

        return $this->json([
            'message' => 'Rent get successfully.'
        ], Response::HTTP_CREATED);
    }
}
