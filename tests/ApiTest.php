<?php

/**
 * @uses \App\Http\Controllers\MatrixController
 */
class ApiTest extends TestCase
{
    /**
     * @covers \App\Http\Controllers\MatrixController::multiply()
     * @throws Exception
     */
    public function testCallToMultiply()
    {
        $json = '{"matrices":"[[[1,2,3],[4,5,6]],[[7,8],[9,10],[11,12]]]"}';
        $this->call('POST', '/api/try', [], [], [], [], $json);

        $expected = [
            "product" => [
                ["BF","BL"],
                ["EI","EX"],
            ]
        ];
        $this->assertEquals(json_encode($expected), $this->response->getContent());
    }
}
