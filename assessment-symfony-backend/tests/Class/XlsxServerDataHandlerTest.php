<?php

namespace App\Tests\Class;

use PHPUnit\Framework\TestCase;
use App\Class\XlsxServerDataHandler;

class XlsxServerDataHandlerTest extends TestCase
{
    private $dataHandler;

    protected function setUp(): void
    {
        $this->dataHandler = new XlsxServerDataHandler();
    }

    public function testFormatArrayData()
    {
        $data = [
            ['Model', 'Ram', 'Hdd', 'Location', 'Price'],
            ['Server A', '8GBDDR4', '2x1TBSSD', 'Location A', '1000'],
            ['Server B', '16GBDDR4', '4x2TBSATA', 'Location B', '1200'],
        ];

        $expectedFormattedData = [
            [
                'model' => 'Server A',
                'ram' => '8GBDDR4',
                'ram_capacity' => 8,
                'ram_type' => 'DDR4',
                'hdd' => '2x1TBSSD',
                'hdd_capacity' => 2000,
                'hdd_type' => 'SSD',
                'location' => 'Location A',
                'price' => '1000',
            ],
            [
                'model' => 'Server B',
                'ram' => '16GBDDR4',
                'ram_capacity' => 16,
                'ram_type' => 'DDR4',
                'hdd' => '4x2TBSATA',
                'hdd_capacity' => 8000,
                'hdd_type' => 'SATA',
                'location' => 'Location B',
                'price' => '1200',
            ],
        ];

        $formattedData = $this->dataHandler->formatArrayData($data);

        $this->assertEquals($expectedFormattedData, $formattedData);
    }

    public function testParseRamSpecification()
    {
        $ramSpecification = '8GBDDR4';
        $expectedResult = [
            'ram_capacity' => 8,
            'ram_type' => 'DDR4',
        ];

        $result = $this->dataHandler->parseRamSpecification($ramSpecification);

        $this->assertEquals($expectedResult, $result);
    }

    public function testParseHddSpecifications()
    {
        $hddSpecification = '2x1TBSATA';
        $expectedResult = [
            'hdd_capacity' => 2000,
            'hdd_type' => 'SATA',
        ];

        $result = $this->dataHandler->parseHddSpecifications($hddSpecification);

        $this->assertEquals($expectedResult, $result);
    }

    public function testFilterServersList()
    {
        $servers = [
            [
                'model' => 'Server A',
                'ram_capacity' => 8,
                'hdd_capacity' => 1000,
                'hdd_type' => 'SSD',
                'location' => 'Location A',
            ],
            [
                'model' => 'Server B',
                'ram_capacity' => 16,
                'hdd_capacity' => 2000,
                'hdd_type' => 'SATA',
                'location' => 'Location B',
            ],
            [
                'model' => 'Server C',
                'ram_capacity' => 32,
                'hdd_capacity' => 4000,
                'hdd_type' => 'SSD',
                'location' => 'Location A',
            ],
        ];

        $filters = [
            'ram' => [8, 16],
            'storage' => 2000,
            'hdd_type' => 'SATA',
            'location' => 'Location B',
        ];

        $expectedResult = [
            [
                'model' => 'Server B',
                'ram_capacity' => 16,
                'hdd_capacity' => 2000,
                'hdd_type' => 'SATA',
                'location' => 'Location B',
            ],
        ];

        $result = $this->dataHandler->filterServersList($servers, $filters);

        $this->assertEquals($expectedResult, $result);
    }

    public function testGetLocations()
    {
        $data = [
            ['Model', '8GBDDR4', '2x1TBSSD', 'Location A', 'Price'],
            ['Server A', '8GBDDR4', '2x1TBSSD', 'Location A', '1000'],
            ['Server B', '16GBDDR4', '4x2TBSATA', 'Location B', '1200'],
        ];

        $expectedResult = ['Location A', 'Location B'];

        $result = $this->dataHandler->getLocations($data);

        $this->assertEquals($expectedResult, $result);
    }
}
