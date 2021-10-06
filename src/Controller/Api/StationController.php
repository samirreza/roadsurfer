<?php

namespace App\Controller\Api;

use App\Service\Station\EquipmentReportGenerator;
use DateTime;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("station", name="station_")
 */
class StationController extends AbstractController
{
    /**
     * @Route("/equipment-report/{stationId}/{date}", methods={"GET"}, name="equipment-report")
     */
    public function getEquipmentReport(int $stationId, DateTime $date, EquipmentReportGenerator $equipmentReportGenerator)
    {
        return $this->json($equipmentReportGenerator->generate($stationId, $date));
    }
}
