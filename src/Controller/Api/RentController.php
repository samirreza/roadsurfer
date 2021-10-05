<?php

namespace App\Controller\Api;

use App\Request\Rent\CreateRentRequest;
use App\Service\Rent\CreateRentService;
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
    public function create(CreateRentRequest $request, CreateRentService $createRentService)
    {
        $createRentService->create($request->toCommand());

        return $this->json([
            'message' => 'Rent created successfully'
        ], Response::HTTP_CREATED);
    }
}
