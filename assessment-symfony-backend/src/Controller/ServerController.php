<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Service\XlsxDatabaseService;
use App\Class\XlsxServerDataHandler;

class ServerController extends AbstractController
{
    #[Route('/server', name: 'server_list', methods:['GET'])]
    public function list(Request $request, XlsxDatabaseService $xlsxDatabase) : Response
    {
        try {
            // Read data from the xlsx file
            $data = $xlsxDatabase->readData();

            // Format xlsx data
            $xlsx_handler = new XlsxServerDataHandler();
            $formated_data = $xlsx_handler->formatArrayData($data);

            // Get filters
            $filters['storage']  = $request->query->get('storage');
            $filters['hdd_type'] = $request->query->get('hdd_type');
            $filters['location'] = $request->query->get('location');
            $filters['ram']      = $request->query->all('ram');

            $filtered_data = $xlsx_handler->filterServersList($formated_data, $filters);

            return new JsonResponse($filtered_data);
        } catch (\Exception $e) {

            return new Response('An error occurred: ' . $e->getMessage(), 500);
        }
    }

    #[Route('/server/locations', name: 'server_locations', methods:['GET'])]
    public function getServerLocations(XlsxDatabaseService $xlsxDatabase) : Response
    {
        try {
            // Read data from the xlsx file
            $data = $xlsxDatabase->readData();

            // Format xlsx data
            $xlsx_handler = new XlsxServerDataHandler();
            $locations = $xlsx_handler->getLocations($data);

            return new JsonResponse($locations);

        } catch (\Exception $e) {

            return new Response('An error occurred: ' . $e->getMessage(), 500);
        }
    }
}
