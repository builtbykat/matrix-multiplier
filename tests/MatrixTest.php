<?php

class MatrixTest extends TestCase
{
    public function providerBadMatrices()
    {
        return [
            [//0
                [ //m1
                    [1,2,3],
                    [4,5,6],
                ],
                [ //m2
                    [1,2],
                    [3,4],
                ]
            ],
            [//1
                [ //m1
                    [1,2],
                    [4,5],
                ],
                [ //m2
                    [1,2],
                    [3,4],
                    [5,6],
                ]
            ],
        ];
    }

    /**
     * @dataProvider providerBadMatrices
     * @param array $m1
     * @param array $m2
     */
    public function testWhenMatrixColRowInequal(array $m1, array $m2)
    {
        $this->expectException(Exception::class);
        $c = new App\Http\Controllers\MatrixController();
        $validateMatrices = new ReflectionMethod('App\Http\Controllers\MatrixController', 'validateMatrices');
        $validateMatrices->setAccessible(true);
        $validateMatrices->invoke($c, $m1, $m2);
    }

    public function providerGoodMatrices()
    {
        return [
            [//0
                [ //m1
                    [1,2,3],
                    [4,5,6],
                ],
                [ //m2
                    [1,2],
                    [3,4],
                    [5,6],
                ],
                [
                    [22,28],
                    [49,64],
                ],
                [
                    [0,0],
                    [0,0],
                ]
            ],
            [//1
                [ //m1
                    [1,2,3,4],
                    [5,6,7,8],
                ],
                [ //m2
                    [1,2],
                    [3,4],
                    [5,6],
                    [7,8],
                ],
                [
                    [50,60],
                    [114,140],
                ],
                [
                    [0,0],
                    [0,0],
                ]
            ],
        ];
    }

    /**
     * @dataProvider providerGoodMatrices
     * @param array $m1
     * @param array $m2
     * @param array $expected product size
     */
    public function testWhenMatrixColRowEqual(array $m1, array $m2, array $expected)
    {
        $c = new App\Http\Controllers\MatrixController();
        $validateMatrices = new ReflectionMethod('App\Http\Controllers\MatrixController', 'validateMatrices');
        $validateMatrices->setAccessible(true);
        $this->assertSameSize($expected, $validateMatrices->invoke($c, $m1, $m2));
    }

    /**
     * @dataProvider providerGoodMatrices
     * @param array $m1
     * @param array $m2
     * @param array $expected product matrix
     * @param array $stub product matrix set to zeros
     */
    public function testMultiplyMatrices(array $m1, array $m2, array $expected, array $stub)
    {
        $c = new App\Http\Controllers\MatrixController();
        $multiplyMatrices = new ReflectionMethod('App\Http\Controllers\MatrixController', 'multiplyMatrices');
        $multiplyMatrices->setAccessible(true);
        $this->assertEquals($expected, $multiplyMatrices->invoke($c, $m1, $m2, $stub));
    }

    public function providerNumber()
    {
        return [
            [1, 'A'],
            [26, 'Z'],
            [27, 'AA'],
            [28, 'AB'],
            [14558, 'UMX'],
        ];
    }

    /**
     * @dataProvider providerNumber
     * @param int $n
     * @param string $expected
     */
    public function testGetLetterFromNumber(int $n, string $expected)
    {
        $c = new App\Http\Controllers\MatrixController();
        $getLetterFromNumber = new ReflectionMethod('App\Http\Controllers\MatrixController', 'getLetterFromNumber');
        $getLetterFromNumber->setAccessible(true);
        $this->assertEquals($expected, $getLetterFromNumber->invoke($c, $n));
    }

    public function providerProductMatrix()
    {
        return [
            [
                [
                    [1,2],
                    [26,27],
                ],
                [
                    ['A','B'],
                    ['Z','AA'],
                ]
            ],
            [
                [
                    [11,19],
                    [28,14558],
                ],
                [
                    ['K','S'],
                    ['AB','UMX'],
                ]
            ]
        ];
    }

    /**
     * @dataProvider providerProductMatrix
     * @param array $numProduct
     * @param array $expected
     */
    public function testTranslateProductToLetters(array $numProduct, array $expected)
    {
        $c = new App\Http\Controllers\MatrixController();
        $translateProductToLetters = new ReflectionMethod('App\Http\Controllers\MatrixController', 'translateProductToLetters');
        $translateProductToLetters->setAccessible(true);
        $this->assertEquals($expected, $translateProductToLetters->invoke($c, $numProduct));
    }
}
