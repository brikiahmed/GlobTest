<?php

class IntervalMerger {

    /**
     * sort of intervals
     * @param $intervals
     * @return void
     */
    private function sortIntervals(&$intervals) {
        usort($intervals, function($a, $b) {
            return $a[0] - $b[0];
        });
    }


    /** merge of intervals
     * @param $intervals
     * @return array
     */
    public function mergeIntervals($intervals): array
    {
        if (empty($intervals)) {
            return [];
        }

        self::sortIntervals($intervals);


        //garder le premier interval comme reference
        $result = [$intervals[0]];

        foreach ($intervals as $interval) {
            //vérifier si l'element 0 du premier interval et inférieur à l'element 0 du deuxieme intervalle
            //et vérifier aussi si l'element 1 du premier interval et suppérieur à l'element 1 du deuxieme intervalle
            //alors on met à ajour l'interval avec l'element 0 du premier element et l'element 1 du deuxieme element
            if (($interval[0] <= end($result)[1]) && ($interval[1] > end($result)[1])) {
                $result[array_key_last($result)][1] = $interval[1];
            } elseif ($interval[0] > end($result)[1]) {
                $result[] = $interval;
            }
        }
        return  $result;
    }
}

// Exemples d'utilisation
$intervals1 = [[0, 3], [6, 10]];
$intervals2 = [[0, 5], [3, 10]];
$intervals3 = [[0, 5], [2, 4]];
$intervals4 = [[7, 8], [3, 6], [2, 4]];
$intervals5 = [[3, 6], [3, 4], [15, 20], [16, 17], [1, 4], [6, 10], [3, 6]];

echo "Résultat 1: " . json_encode(IntervalMerger::mergeIntervals($intervals1)) . "\n";
echo "Résultat 2: " . json_encode(IntervalMerger::mergeIntervals($intervals2)) . "\n";
echo "Résultat 3: " . json_encode(IntervalMerger::mergeIntervals($intervals3)) . "\n";
echo "Résultat 4: " . json_encode(IntervalMerger::mergeIntervals($intervals4)) . "\n";
echo "Résultat 5: " . json_encode(IntervalMerger::mergeIntervals($intervals5)) . "\n";
