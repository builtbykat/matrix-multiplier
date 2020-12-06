<?php

/**
 * This controller handles our sole endpoint
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Class MatrixController
 *
 * @package App\Http\Controllers
 */
class MatrixController extends Controller
{
    /**
     * @param  Request $request
     * @return object
     * @throws \Exception
     */
    public function multiply(Request $request)
    {
        $content = json_decode($request->getContent(), true);
        if (!$this->validateContent($content['matrices'])) {
            throw new \Exception('Matrices must only contain integers.', 422);
        }

        $matrices = json_decode($content['matrices']);
        $m1 = $matrices[0];
        $m2 = $matrices[1];
        if (!$this->validateMatrices($m1, $m2)) {
            throw new \Exception('Matrix cannot be multiplied.  Matrix is not the same size.', 422);
        }

        $productPlaceholder = $this->createProductPlaceholder($m1, $m2);

        $numProducts = $this->multiplyMatrices($m1, $m2, $productPlaceholder);

        return response()
            ->json(["product" => $this->translateProductToLetters($numProducts)]);
    }

    /**
     * @param  string $content
     * @return bool
     * @throws Exception
     */
    public function validateContent(string $content)
    {
        if (preg_match('/[a-z=!#&*|<>]/i', $content)) {
            return false;
        }
        return true;
    }

    /**
     * @param  array $m1
     * @param  array $m2
     * @return bool
     * @throws Exception
     */
    private function validateMatrices(array $m1, array $m2)
    {
        if (count($m1[0]) !== count($m2)) {
            return false;
        }
        return true;
    }

    /**
     * Set up matrix to populate later, helps prevent undefined index issues
     *
     * @param  array $m1
     * @param  array $m2
     * @return array
     */
    private function createProductPlaceholder(array $m1, array $m2)
    {
        $productPlaceholder = [];
        for ($i = 0; $i < count($m1); $i++) {
            for ($j = 0; $j < count($m2[0]); $j++) {
                $productPlaceholder[$i][$j] = 0;
            }
        }
        return $productPlaceholder;
    }

    /**
     * @param  array $m1
     * @param  array $m2
     * @param  array $product
     * @return array
     */
    private function multiplyMatrices(array $m1, array $m2, array $product)
    {
        for ($i = 0; $i < count($product); $i++) {
            for ($j = 0; $j < count($product); $j++) {
                for ($k = 0; $k < count($m2); $k++) {
                    if (isset($product[$i][$j])) {
                        $product[$i][$j] += $m1[$i][$k] * $m2[$k][$j];
                    }
                }
            }
        }
        return $product;
    }

    /**
     * @param  int $num
     * @return string
     * thanks @StackOverflow, for a much cleaner version than where mine was going
     * https://stackoverflow.com/questions/3302857/algorithm-to-get-the-excel-like-column-name-of-a-number
     */
    private function getLetterFromNumber(int $num)
    {
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
     * @param  array $product
     * @return array
     */
    private function translateProductToLetters(array $product)
    {
        for ($i = 0; $i < count($product); $i++) {
            for ($j = 0; $j < count($product); $j++) {
                if (isset($product[$i][$j]))
                    $product[$i][$j] = $this->getLetterFromNumber($product[$i][$j]);
            }
        }
        return $product;
    }
}
