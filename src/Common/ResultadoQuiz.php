<?php

namespace QuizSerie\Common;

use QuizSerie\Util\AvaliarResposta;

/**
 * Classe responsável por avaliar as respostas do quiz
 *
 * @author Rodrigo Conceição de Araujo <omb.rodrigo@gmail.com>
 *
 * @package QuizSerie\Common
 **/
class ResultadoQuiz
{
    /**
     * Método responsável por avaliar as respostas do quiz
     *
     * @access public
     *
     * @param Array $respostas respostas do quiz
     *
     * @return String referência da série
     */
    public function avaliarRespostas($respostas)
    {
        $avaliarResposta = new AvaliarResposta();

        $respostaComMaiorNumeroDeOcorrencias = $avaliarResposta->maiorNumeroOcorrencia($respostas);

        if (count($respostaComMaiorNumeroDeOcorrencias) == 1) {
            return $this->serieCorrespondenteAoResultado($respostaComMaiorNumeroDeOcorrencias);
        }

        $respostasComMaiorPeso = $avaliarResposta->maiorPeso($respostas);
        $respostaComMaiorPeso = array_slice($respostasComMaiorPeso, 0, 1);
        return $this->serieCorrespondenteAoResultado($respostaComMaiorPeso);
    }


    /**
     * Método responsável por retornar a série correspondente ao resultado do quiz
     *
     * @access private
     *
     * @param Array $resultadoQuiz resultado do quiz
     *
     * @return Array
     */
    private function serieCorrespondenteAoResultado($resultadoQuiz)
    {
        $referenciaSerie = key($resultadoQuiz);
        $series = new Serie();
        return (array) $series->pesquisarPorReferencia($referenciaSerie);
    }
}
