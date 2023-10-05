<?php

namespace App\Class;

class XlsxServerDataHandler
{
    public function formatArrayData(array $data) : array
    {
        unset($data[0]);

        foreach ($data as $value) {

            $parsedRamSpecification = $this->parseRamSpecification($value[1]);

            $formated_data[] = [
                'model'        => $value[0],
                'ram'          => $value[1],
                'hdd'          => $value[2],
                'location'     => $value[3],
                'price'        => $value[4],
                'ram_capacity' => $parsedRamSpecification['ram_capacity'],
                'ram_type'     => $parsedRamSpecification['ram_type'],
            ];
        }

        return $formated_data;
    }

    public function parseRamSpecification(string $ramSpecification) : array
    {
        // Define a regular expression pattern to match the capacity and type
        $pattern = '/^(\d+)GB(\w+)/';

        // Use preg_match to extract the values
        if (preg_match($pattern, $ramSpecification, $matches)) {

            return [
                'ram_capacity' => $matches[1]*1,
                'ram_type' => $matches[2]
            ];

        } else {
            return false;
        }
    }

    public function parseHddSpecifications(string $hddSpecification) : array
    {
        // Define a regular expression pattern to match the capacity and type
        $pattern = '/(\d+)x(\d+)([TtGg][Bb])(\w+)/';

        // Use preg_match to extract the values
        if (preg_match($pattern, $hddSpecification, $matches)) {

            $multiplier = (strtolower($matches[3]) === 'tb') ? 1000 : 1;
            $capacity = $matches[1] * $matches[2] * $multiplier;

            return [
                'hdd_capacity' => $capacity,
                'hdd_type' => $matches[4]
            ];
        } else {
            return false;
        }

    }

}

