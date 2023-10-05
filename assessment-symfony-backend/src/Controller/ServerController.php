<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Service\XlsxDatabaseService;
use App\Class\XlsxServerDataHandler;

class ServerController extends AbstractController
{
    #[Route('/server', name: 'server_list', methods:['GET'])]
    public function list(XlsxDatabaseService $xlsxDatabase)
    {
        // Read data from the xlsx file
        $data = $xlsxDatabase->readData();

        // Format xlsx data
        $xlsx_handler = new XlsxServerDataHandler();
        $formated_data = $xlsx_handler->formatArrayData($data);

        return new Response(serialize($formated_data));
    }
}
