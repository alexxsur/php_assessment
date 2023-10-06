<?php

namespace App\Class;

class XlsxServerDataHandler
{
    public function formatArrayData(array $data) : array
    {
        // Unset header xlsx row
        unset($data[0]);

        foreach ($data as $value) {

            $parsedRamSpecification = $this->parseRamSpecification($value[1]);
            $parsedHddSpecification = $this->parseHddSpecifications($value[2]);

            $formated_data[] = [
                'model'        => $value[0],
                'ram'          => $value[1],
                'ram_capacity' => $parsedRamSpecification['ram_capacity'],
                'ram_type'     => $parsedRamSpecification['ram_type'],
                'hdd'          => $value[2],
                'hdd_capacity' => $parsedHddSpecification['hdd_capacity'],
                'hdd_type'     => $parsedHddSpecification['hdd_type'],
                'location'     => $value[3],
                'price'        => $value[4],
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

    public function filterServersList(array $servers, array $filters) : array
    {
        $filters['ram'] = empty($filters['ram']) ? null : $filters['ram'];

        // Apply the filters to the data array
        $filteredServersList = [];
        foreach ($servers as $server) {
            // Check each filter criterion
            $passLocationFilter = $filters['location'] === null || $server['location']     === $filters['location'];
            $passStorageFilter  = $filters['storage']  === null || $server['hdd_capacity'] <= $filters['storage'];
            $passRamFilter      = $filters['ram']      === null || in_array($server['ram_capacity'], $filters['ram']);
            $passHddTypeFilter  = $filters['hdd_type'] === null || str_contains($server['hdd_type'], $filters['hdd_type']);

            // If all filters pass, add the server to the filtered array
            if ($passStorageFilter && $passRamFilter && $passHddTypeFilter && $passLocationFilter) {
                $filteredServersList[] = $server;
            }
        }

        return $filteredServersList;
    }

    public function getLocations(array $data) : array
    {
        // Unset header xlsx row
        unset($data[0]);

        // location column 3
        $locations = array_column($data, 3);

        // remove duplicates and return
        return array_values(array_unique($locations));
    }

}

