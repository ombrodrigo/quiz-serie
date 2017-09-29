<?php

namespace QuizSerie\Tests\Unit\Common;

use PHPUnit\Framework\TestCase;
use QuizSerie\Common\Serie;
use QuizSerie\Util\ConteudoJson;

class SerieTest extends TestCase
{
    private $class = null;

    public function setUp()
    {
        $this->class = new Serie();
    }

    public function seriesProvider()
    {
        $conteudoJson   = new ConteudoJson();
        $conteudo       = $conteudoJson->capturar('series');
        return [[json_decode($conteudo)]];
    }

    /**
     * @dataProvider seriesProvider
     */
    public function testListar($seriesComparar)
    {
        $serieComparar      = current($seriesComparar);
        $series             = $this->class->listar();
        $primeiraSerieLista = current($series);
        $this->assertEquals($serieComparar, $primeiraSerieLista);
    }

    /**
     * @dataProvider seriesProvider
     */
    public function testChecarReferencia($series)
    {
        $serie = current($series);

        $reflectionClass = new \ReflectionClass($this->class);

        $referenciaProperty = $reflectionClass->getProperty('referencia');
        $referenciaProperty->setAccessible(true);

        $checarReferenciaMethod = $reflectionClass->getMethod('checarReferencia');
        $checarReferenciaMethod->setAccessible(true);

        // teste true
        $referenciaProperty->setValue($this->class, 'a');
        $this->assertTrue($checarReferenciaMethod->invokeArgs($this->class, array($serie)));

        // teste false
        $referenciaProperty->setValue($this->class, 'b');
        $this->assertFalse($checarReferenciaMethod->invokeArgs($this->class, array($serie)));
    }

    /**
     * @dataProvider seriesProvider
     */
    public function testFiltrar($series)
    {
        $reflectionClass = new \ReflectionClass($this->class);

        $referenciaProperty = $reflectionClass->getProperty('referencia');
        $referenciaProperty->setAccessible(true);

        $pesquisarMethod = $reflectionClass->getMethod('filtrar');
        $pesquisarMethod->setAccessible(true);

        // teste true
        $referenciaProperty->setValue($this->class, 'd');

        $resultadoSerieD = $pesquisarMethod->invokeArgs($this->class, array($series));
        $this->assertArrayHasKey(0, $resultadoSerieD);
        $this->assertArrayNotHasKey(1, $resultadoSerieD);

        $resultadoSerieD    = current($resultadoSerieD);
        $serieComparar      = $series[3];
        $this->assertEquals($serieComparar, $resultadoSerieD);
    }

    /**
     * @dataProvider seriesProvider
     */
    public function testPesquisarPorReferencia($series)
    {
        $serieComparar      = end($series);
        $resultadoPesquisa  = $this->class->pesquisarPorReferencia('e');
        $this->assertEquals($serieComparar, $resultadoPesquisa);
    }
}
