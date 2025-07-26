<?php
function calculateMinimumSumWithExplanation($values) {
    sort($values); // Sort for predictable processing
    $memo = [];

    function helper($arr, &$memo, &$steps) {
        $key = implode(',', $arr);
        if (isset($memo[$key])) return $memo[$key];

        $n = count($arr);
        if ($n == 0) return 0;

        $minSum = PHP_INT_MAX;
        $bestSteps = [];

        // Case: 5 or more → group of 5 → pay top 2
        if ($n >= 5) {
            for ($i = 0; $i <= $n - 5; $i++) {
                $combo = array_slice($arr, $i, 5);
                rsort($combo);
                $paid = $combo[0] + $combo[1];
                $groupInfo = "Group of 5: Paid {$combo[0]} + {$combo[1]}, Free " . implode(", ", array_slice($combo, 2));
                $remaining = $arr;
                array_splice($remaining, $i, 5);
                $localSteps = [];
                $newSum = $paid + helper($remaining, $memo, $localSteps);
                if ($newSum < $minSum) {
                    $minSum = $newSum;
                    $bestSteps = [$groupInfo, ...$localSteps];
                }
            }
        }

        // Case: 2 → group of 2 → pay top 1
        if ($n >= 2) {
            for ($i = 0; $i <= $n - 2; $i++) {
                $combo = array_slice($arr, $i, 2);
                $paid = max($combo);
                $free = min($combo);
                $groupInfo = "Group of 2: Paid $paid, Free $free";
                $remaining = $arr;
                array_splice($remaining, $i, 2);
                $localSteps = [];
                $newSum = $paid + helper($remaining, $memo, $localSteps);
                if ($newSum < $minSum) {
                    $minSum = $newSum;
                    $bestSteps = [$groupInfo, ...$localSteps];
                }
            }
        }

        // Case: 1 item → pay 60%
        if ($n == 1) {
            $val = $arr[0];
            $paid = round($val * 0.6);
            $groupInfo = "Single Item: $val → Paid 60% = $paid";
            $minSum = $paid;
            $bestSteps = [$groupInfo];
        }

        $steps = $bestSteps;
        return $memo[$key] = $minSum;
    }

    $steps = [];
    $total = helper($values, $memo, $steps);

    echo "Steps used in calculation:\n";
    foreach ($steps as $step) {
        echo "- $step\n";
    }

    echo "Total Minimum Sum: $total\n";
    return $total;
}

$values = [1799, 1799, 1799, 1799, 1799, 1999, 1799, 1799, 2999, 2599];
calculateMinimumSumWithExplanation($values);