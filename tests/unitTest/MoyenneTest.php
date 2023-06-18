<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;

class MoyenneTest extends TestCase
{
    // I create a set of test data
    // It's an array with different cases
    // Each case has an expected result and the data
    private const TEST_CASES = [
        [
            "data" => [1,3,4,5],
            "result" => 3.3
        ],
        [
            "data" => [5,5,5],
            "result" => 5
        ],
        [
            "data" => [1,1],
            "result" => 1
        ]
    ];

    public function testCalculMoyenne(): void
    {

        // I want to add up all the grades
        // I create an empty variable

        // Loop through the test cases
        foreach(self::TEST_CASES as $test){
            // Recreate the average calculation algorithm used in the application
            $allNotes = null;
            foreach($test["data"] as $note){
                $allNotes += $note;
            }
            $rating = $allNotes / count($test["data"]);

            $roundRating = round($rating,1);

            // Test if the expected result is indeed the result received by the algorithm
            $this->assertEquals($test["result"],$roundRating);
        }
     
    }
}
