<?php

use App\Http\Controllers\MatrixController;

/**
 * @uses \App\Http\Controllers\MatrixController
 */
class MatrixTest extends TestCase
{
    /**
     * @var MatrixController|object
     */
    protected object $mc;
    /**
     * @var string
     */
    protected string $mcName;

    protected function setUp() : void
    {
        $this->mc = new App\Http\Controllers\MatrixController();
        $this->mcName = App\Http\Controllers\MatrixController::class;
    }

    public function providerContent()
    {
        return [
            [
                '[[[0=1,2,3],[4,5,6]],[[7,8],[9,10],[11,12]]]',
                false,
            ],
            [
                '[[[A,B,C],[4,5,6]],[[7,8],[9,10],[11,12]]]',
                false,
            ],
            [
                '[[[1,2,3],[4,5,6]],[[7,8],[9,10],[11,12]]]',
                true,
            ],
        ];
    }

    /**
     * @covers \App\Http\Controllers\MatrixController::validateContent
     * @dataProvider providerContent
     * @param string $content
     * @param bool $expected
     * @throws ReflectionException
     */
    public function testValidateContent(string $content, bool $expected)
    {
        $validateContent = new ReflectionMethod($this->mcName, 'validateContent');
        $validateContent->setAccessible(true);
        $this->assertEquals($expected, $validateContent->invoke($this->mc, $content));
    }

    public function providerMatrices()
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
                ],
                false,
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
                ],
                false,
            ],
            [
                [ //m1
                    [1,2,3],
                    [4,5,6],
                ],
                [ //m2
                    [1,2],
                    [3,4],
                    [5,6],
                ],
                true,
            ],
        ];
    }

    /**
     * @covers \App\Http\Controllers\MatrixController::validateMatrices()
     * @dataProvider providerMatrices
     * @param array $m1
     * @param array $m2
     * @param bool $expected
     * @throws ReflectionException
     */
    public function testValidateMatrices(array $m1, array $m2, bool $expected)
    {
        $validateMatrices = new ReflectionMethod($this->mcName, 'validateMatrices');
        $validateMatrices->setAccessible(true);
        $this->assertEquals($expected, $validateMatrices->invoke($this->mc, $m1, $m2));
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
                ],
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
                ],
            ],
        ];
    }

    /**
     * @covers \App\Http\Controllers\MatrixController::createProductPlaceholder()
     * @dataProvider providerGoodMatrices
     * @param array $m1
     * @param array $m2
     * @param array $expected product size
     * @throws ReflectionException
     */
    public function testCreateProductPlaceholder(array $m1, array $m2, array $expected)
    {
        $productPlaceholder = new ReflectionMethod($this->mcName, 'createProductPlaceholder');
        $productPlaceholder->setAccessible(true);
        $this->assertSameSize($expected, $productPlaceholder->invoke($this->mc, $m1, $m2));
    }

    /**
     * @covers \App\Http\Controllers\MatrixController::multiplyMatrices()
     * @dataProvider providerGoodMatrices
     * @param array $m1
     * @param array $m2
     * @param array $expected product matrix
     * @param array $stub product matrix set to zeros
     * @throws ReflectionException
     */
    public function testMultiplyMatrices(array $m1, array $m2, array $expected, array $stub)
    {
        $multiplyMatrices = new ReflectionMethod($this->mcName, 'multiplyMatrices');
        $multiplyMatrices->setAccessible(true);
        $this->assertEquals($expected, $multiplyMatrices->invoke($this->mc, $m1, $m2, $stub));
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
     * @covers \App\Http\Controllers\MatrixController::getLetterFromNumber()
     * @dataProvider providerNumber
     * @param int $n
     * @param string $expected
     * @throws ReflectionException
     */
    public function testGetLetterFromNumber(int $n, string $expected)
    {
        $getLetterFromNumber = new ReflectionMethod($this->mcName, 'getLetterFromNumber');
        $getLetterFromNumber->setAccessible(true);
        $this->assertEquals($expected, $getLetterFromNumber->invoke($this->mc, $n));
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
                ],
            ],
            [
                [
                    [11,19],
                    [28,14558],
                ],
                [
                    ['K','S'],
                    ['AB','UMX'],
                ],
            ],
        ];
    }

    /**
     * @covers \App\Http\Controllers\MatrixController::translateProductToLetters()
     * @dataProvider providerProductMatrix
     * @param array $numProduct
     * @param array $expected
     * @throws ReflectionException
     */
    public function testTranslateProductToLetters(array $numProduct, array $expected)
    {
        $translateProductToLetters = new ReflectionMethod($this->mcName, 'translateProductToLetters');
        $translateProductToLetters->setAccessible(true);
        $this->assertEquals($expected, $translateProductToLetters->invoke($this->mc, $numProduct));
    }

    public function providerMultiply()
    {
        return [
            [
                '{"matrices":"[[[1,2,3],[4,5,6]],[[7,8],[9,10],[11,12]]]"}',
                [
                    "product" => [
                        ["BF","BL"],
                        ["EI","EX"],
                    ]
                ],
            ]
        ];
    }

    /**
     * @covers \App\Http\Controllers\MatrixController::multiply()
     * @dataProvider providerMultiply
     * @param string $willReturn
     * @param array $expected
     * @throws Exception
     */
    public function testMultiplyMethod(string $willReturn, array $expected)
    {
        $request = $this->getMock(\Illuminate\Http\Request::class);
        $request->expects($this->once())
            ->method('getContent')
            ->willReturn($willReturn);

        $actual = $this->mc->multiply($request);

        $this->assertEquals(json_encode($expected), $actual->getContent());
    }

    /**
     * @covers \App\Http\Controllers\MatrixController::multiply()
     * @throws Exception
     */
    public function testMultiplyUnvalidatedContent()
    {
        $this->expectException(Exception::class);

        $request = $this->getMock(\Illuminate\Http\Request::class);
        $request->expects($this->once())
            ->method('getContent')
            ->willReturn('{"matrices":"[[[A,2,3],[4,5,6]],[[7,8],[9,10],[11,Z]]"}');

        $this->mc->multiply($request);
    }

    /**
     * @covers \App\Http\Controllers\MatrixController::multiply()
     * @throws Exception
     */
    public function testMultiplyUnvalidatedMatrix()
    {
        $this->expectException(Exception::class);

        $request = $this->getMock(\Illuminate\Http\Request::class);
        $request->expects($this->once())
            ->method('getContent')
            ->willReturn('{"matrices":"[[[1,2,3],[4,5,6]],[[7,8],[9,10]]]"}');

        $this->mc->multiply($request);
    }

    /**
     * @covers \App\Http\Controllers\MatrixController::multiply()
     * @dataProvider providerMultiply
     * @param string $json
     * @param array $expected
     * @throws Exception
     */
    /*public function testCallToMultiply(string $json, array $expected)
    {
        $this->call('POST', '/api/try', [], [], [], [], $json);

        $this->assertEquals(json_encode($expected), $this->response->getContent());
    }*/
}
