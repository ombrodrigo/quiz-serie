<?php

namespace QuizSerie\Tests\Unit\Util;

use PHPUnit\Framework\TestCase;
use QuizSerie\Util\ConteudoJson;

class ConteudoJsonTest extends TestCase
{
    private $class = null;

    public function setUp()
    {
        $this->class = new ConteudoJson();
    }

    public function conteudoSeriesProvider()
    {
        $series = file_get_contents(DATA_JSON_PATH . DIRECTORY_SEPARATOR . 'series.json');
        return [compact('series')];
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testCapturarException()
    {
        $this->class->capturar('serie');
    }

    /**
     * @dataProvider conteudoSeriesProvider
     */
    public function testCapturarSerie($conteudoComparar)
    {
        $this->assertEquals($conteudoComparar, $this->class->capturar('series'));
    }

    /**
     * @dataProvider conteudoSeriesProvider
     */
    public function testCapturarSerieErro($conteudoComparar)
    {
        $this->assertNotEquals($conteudoComparar, $this->class->capturar('perguntas_respostas'));
    }

    /**
     * @dataProvider conteudoSeriesProvider
     */
    public function testConverterJsonParaArray($conteudoComparar)
    {
        $this->assertJson($conteudoComparar);
        $this->assertInternalType('array', json_decode($conteudoComparar));
    }
}
