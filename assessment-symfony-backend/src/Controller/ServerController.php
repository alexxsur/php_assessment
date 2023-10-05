<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\XlsxDatabaseService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ServerController extends AbstractController
{
    #[Route('/server', name: 'server_list', methods:['GET'])]
    public function list(XlsxDatabaseService $xlsxDatabase)
    {
        // Read data from the XLSX file
        $data = $xlsxDatabase->readData();

        return new Response(serialize($data));
    }
}
