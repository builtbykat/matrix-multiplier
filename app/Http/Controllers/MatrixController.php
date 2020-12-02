<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;

class MatrixController extends Controller
{
    /**
     * @param Request $request
     * @return array
     * @throws Exception
     */
    public function multiply(Request $request) {
        $request = $request->all();
        $matrices = json_decode($request['matrices']);

        $m1 = $matrices[0];
        $m2 = $matrices[1];
        if ($productPlaceholder = $this->validateMatrices($m1, $m2)) {
            return [];
        }

        return [];
    }

    /**
     * @param array $m1
     * @param array $m2
     * @return array $productPlaceholder
     * @throws Exception
     */
    private function validateMatrices(array $m1, array $m2) {
        if (count($m1[0]) !== count($m2)) { // col count, row count // || count($m1) !== count($m2[0])
            throw new Exception("Matrix cannot be multiplied.  Matrix is not the same size.");
        }
        // set up matrix to populate later, helps prevent undefined index issues
        $productSize = count($m1) * count($m2[0]);
        $productPlaceholder = [];
        for ($i = 0; $i < $productSize/2; $i++) {
            for ($j = 0; $j < $productSize/2; $j++) {
                $productPlaceholder[$i][$j] = 0;
            }
        }
        return $productPlaceholder;
    }
}
