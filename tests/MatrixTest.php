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
    public function testWhenMatrixColRowEqual($m1, $m2, $expected)
    {
        $c = new App\Http\Controllers\MatrixController();
        $validateMatrices = new ReflectionMethod('App\Http\Controllers\MatrixController', 'validateMatrices');
        $validateMatrices->setAccessible(true);
        $this->assertSameSize($expected, $validateMatrices->invoke($c, $m1, $m2));
    }
}
