<?php
// function calculateMinimumSumWithExplanation($values) {
//     sort($values); // Sort for predictable processing
//     $memo = [];

//     function helper($arr, &$memo, &$steps) {
//         $key = implode(',', $arr);
//         if (isset($memo[$key])) return $memo[$key];

//         $n = count($arr);
//         if ($n == 0) return 0;

//         $minSum = PHP_INT_MAX;
//         $bestSteps = [];

//         // Case: 5 or more → group of 5 → pay top 2
//         if ($n >= 5) {
//             for ($i = 0; $i <= $n - 5; $i++) {
//                 $combo = array_slice($arr, $i, 5);
//                 rsort($combo);
//                 $paid = $combo[0] + $combo[1];
//                 $groupInfo = "Group of 5: Paid {$combo[0]} + {$combo[1]}, Free " . implode(", ", array_slice($combo, 2));
//                 $remaining = $arr;
//                 array_splice($remaining, $i, 5);
//                 $localSteps = [];
//                 $newSum = $paid + helper($remaining, $memo, $localSteps);
//                 if ($newSum < $minSum) {
//                     $minSum = $newSum;
//                     $bestSteps = [$groupInfo, ...$localSteps];
//                 }
//             }
//         }

//         // Case: 2 → group of 2 → pay top 1
//         if ($n >= 2) {
//             for ($i = 0; $i <= $n - 2; $i++) {
//                 $combo = array_slice($arr, $i, 2);
//                 $paid = max($combo);
//                 $free = min($combo);
//                 $groupInfo = "Group of 2: Paid $paid, Free $free";
//                 $remaining = $arr;
//                 array_splice($remaining, $i, 2);
//                 $localSteps = [];
//                 $newSum = $paid + helper($remaining, $memo, $localSteps);
//                 if ($newSum < $minSum) {
//                     $minSum = $newSum;
//                     $bestSteps = [$groupInfo, ...$localSteps];
//                 }
//             }
//         }

//         // Case: 1 item → pay 60%
//         if ($n == 1) {
//             $val = $arr[0];
//             $paid = round($val * 0.6);
//             $groupInfo = "Single Item: $val → Paid 60% = $paid";
//             $minSum = $paid;
//             $bestSteps = [$groupInfo];
//         }

//         $steps = $bestSteps;
//         return $memo[$key] = $minSum;
//     }

//     $steps = [];
//     $total = helper($values, $memo, $steps);

//     echo "Steps used in calculation:\n";
//     foreach ($steps as $step) {
//         echo "- $step\n";
//     }

//     echo "Total Minimum Sum: $total\n";
//     return $total;
// }



// $values = [
//     2999, 2199, 2199, 2199, 1999,
//     1999, 1999, 1999, 1999, 1999,
//     1799, 1799
// ];
// calculateMinimumSumWithExplanation($values);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Price Discount Optimizer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Price Discount Optimizer</h4>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <div class="mb-3">
                            <label for="prices" class="form-label">Enter prices (comma separated)</label>
                            <input type="text" name="prices" id="prices" class="form-control" placeholder="Example: 2999,2199,1999,1799" required>
                        </div>
                        <button type="submit" class="btn btn-success">Calculate Minimum Sum</button>
                    </form>
                </div>
            </div>

            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $input = $_POST['prices'];
                $values = array_map('intval', explode(',', $input));

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

                        // Group of 5 → pay top 2
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

                        // Group of 2 → pay top 1
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

                        // Single item → 60%
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

                    echo '<div class="card mt-4 shadow">';
                    echo '<div class="card-header bg-info text-white"><h5>Calculation Steps</h5></div>';
                    echo '<div class="card-body">';
                    echo '<ul class="list-group">';
                    foreach ($steps as $step) {
                        echo '<li class="list-group-item">' . htmlspecialchars($step) . '</li>';
                    }
                    echo '</ul>';
                    echo '<div class="mt-3"><strong>Total Minimum Sum: </strong> ₹' . $total . '</div>';
                    echo '</div></div>';
                }

                calculateMinimumSumWithExplanation($values);
            }
            ?>

        </div>
    </div>
</div>
</body>
</html>
