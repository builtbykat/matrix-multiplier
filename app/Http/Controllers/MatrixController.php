<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;

class MatrixController extends Controller
{
    /**
     * @param Request $request
     * @return object
     * @throws Exception
     */
    public function multiply(Request $request) {
        $content = json_decode($request->getContent(), true);
        $matrices = json_decode($content['matrices']);

        $m1 = $matrices[0];
        $m2 = $matrices[1];

        $productPlaceholder = $this->validateMatrices($m1, $m2);

        $numProducts = $this->multiplyMatrices($m1, $m2, $productPlaceholder);

        return response()
            ->json(["product" => $this->translateProductToLetters($numProducts)]);
    }

    /**
     * @param array $m1
     * @param array $m2
     * @return array $productPlaceholder
     * @throws Exception
     */
    private function validateMatrices(array $m1, array $m2) {
        if (count($m1[0]) !== count($m2)) { // col count, row count
            throw new Exception('Matrix cannot be multiplied.  Matrix is not the same size.', 422);
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

    /**
     * @param array $m1
     * @param array $m2
     * @param array $product
     * @return array
     */
    private function multiplyMatrices(array $m1, array $m2, array $product) {
        for ($i = 0; $i < count($product); $i++) {
            for ($j = 0; $j < count($product); $j++) {
                for ($k = 0; $k < count($m2); $k++) {
                    if (isset($product[$i][$j]))
                        $product[$i][$j] += $m1[$i][$k] * $m2[$k][$j];
                }
            }
        }
        return $product;
    }

    /**
     * @param int $num
     * @return string
     * thanks @StackOverflow, for a much cleaner version than where mine was going
     * https://stackoverflow.com/questions/3302857/algorithm-to-get-the-excel-like-column-name-of-a-number
     */
    private function getLetterFromNumber(int $num) {
        $numeric = ($num - 1) % 26;
        $letter = chr(65 + $numeric);
        $num2 = intval(($num - 1) / 26);
        if ($num2 > 0) {
            return $this->getLetterFromNumber($num2) . $letter;
        } else {
            return $letter;
        }
    }

    /**
     * @param array $product
     * @return array
     */
    private function translateProductToLetters(array $product) {
        for ($i = 0; $i < count($product); $i++) {
            for ($j = 0; $j < count($product); $j++) {
                $product[$i][$j] = $this->getLetterFromNumber($product[$i][$j]);
            }
        }
        return $product;
    }
}
