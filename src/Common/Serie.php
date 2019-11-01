<?php

namespace QuizSerie\Common;

use QuizSerie\Util\ConteudoJson;

/**
 * Classe responsável por gerenciar as séries
 *
 * @author Rodrigo Conceição de Araujo <omb.rodrigo@gmail.com>
 *
 * @package QuizSerie\Common
 **/
class Serie
{
    /**
     * Atributo que mantem o nome do arquivo json com os dados
     *
     * @access private
     *
     * @var  String
     */
    private $jsonFile = 'series';

    /**
     * Atributo que ira receber a referencia a ser utilizada no momento de uma pesquisa
     *
     * @access private
     *
     * @var String
     */
    private $referencia = null;

    /**
     * Método responsável por listar todas as séries
     *
     * @access public
     *
     * @return Array
     */
    public function listar()
    {
        $conteudoJson = new ConteudoJson();
        $series = $conteudoJson->capturar($this->jsonFile);

        if ($series) {
            return json_decode($series);
        }

        return [];
    }

    /**
     * Método responsável por pesquisar uma série por sua referencia
     *
     * @access public
     *
     * @param String $referencia referencia da serie a ser pesquisada
     *
     * @return Array
     */
    public function pesquisarPorReferencia($referencia)
    {
        $series = $this->listar();
        $this->referencia = $referencia;
        $serie = $this->filtrar($series);

        if (!array_key_exists(0, $serie)) {
            return null;
        }

        return current($serie);
    }

    /**
     * Método responsável por filtrar as séries com base na refrência do objeto
     *
     * @access private
     *
     * @param Array $series series que serão filtradas
     *
     * @return Array
     */
    private function filtrar($series)
    {
        return array_values(array_filter($series, function ($serie) {
            return $this->checarReferencia($serie);
        }));
    }

    /**
     * Método responsável por checar se a referência da série corresponde a referência do objeto
     *
     * @access private
     *
     * @param \stdClass $serie série a ser testada
     *
     * @return Boolean
     */
    private function checarReferencia(\stdClass $serie)
    {
        return (strcmp(strtoupper($serie->referencia), strtoupper($this->referencia)) == 0);
    }
}
