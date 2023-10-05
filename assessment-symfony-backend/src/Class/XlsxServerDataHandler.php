<?php

namespace App\Class;

class XlsxServerDataHandler
{
    public function formatArrayData(array $data) : array
    {
        unset($data[0]);

        foreach ($data as $value) {

            $splittedRamSpecification = $this->splitRamSpecification($value[1]);

            $formated_data[] = [
                'model'        => $value[0],
                'ram'          => $value[1],
                'hdd'          => $value[2],
                'location'     => $value[3],
                'price'        => $value[4],
                'ram_capacity' => $splittedRamSpecification['ram_capacity'],
                'ram_type'     => $splittedRamSpecification['ram_type']
            ];
        }

        return $formated_data;
    }

    public function splitRamSpecification(string $ramSpecification) : array
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
}

