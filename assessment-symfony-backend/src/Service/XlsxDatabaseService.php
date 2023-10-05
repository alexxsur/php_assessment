<?php

namespace App\Service;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class XlsxDatabaseService
{
    private $xlsxFilePath;

    public function __construct(string $xlsxFilePath)
    {
        $this->xlsxFilePath = $xlsxFilePath;
    }

    public function readData()
    {
        $spreadsheet = IOFactory::load($this->xlsxFilePath);
        $worksheet = $spreadsheet->getActiveSheet();

        return $worksheet->toArray();
    }

    public function writeData(array $data)
    {
        $spreadsheet = new Spreadsheet();
        $worksheet = $spreadsheet->getActiveSheet();
        $worksheet->fromArray($data);

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save($this->xlsxFilePath);
    }
}
