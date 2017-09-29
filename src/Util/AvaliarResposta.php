<?php

namespace QuizSerie\Util;

/**
 * Classe responsável por avaliar as resposta do quiz
 *
 * @author Rodrigo Conceição de Araujo <omb.rodrigo@gmail.com>
 *
 * @package QuizSerie\Util
 **/
class AvaliarResposta
{
    /**
     * Método responsável por verificar qual as respostas que possuem maior número de ocorrências
     *
     * @access public
     *
     * @param Array $respostas respostas do quiz
     *
     * @return Array
     */
    public function maiorNumeroOcorrencia($respostas)
    {
        $agrupaRespostas                    = array_count_values($respostas);
        $maiorNumeroOcorrencias             = max($agrupaRespostas);
        $respostasComMaiorNumeroOcorrencias = [];

        foreach ($agrupaRespostas as $resposta => $ocorrencia) {
            if ($ocorrencia < $maiorNumeroOcorrencias) {
                continue;
            }

            $respostasComMaiorNumeroOcorrencias[$resposta] = $ocorrencia;
        }

        return $respostasComMaiorNumeroOcorrencias;
    }

    /**
     * Método responsável por verificar qual a resposta ou respostas com maior peso
     *
     * @access public
     *
     * @param Array $respostas respostas que serão analisadas
     *
     * @return Array
     */
    public function maiorPeso($respostas)
    {
        $respostasComMaiorNumeroOcorrencias = array_keys($this->maiorNumeroOcorrencia($respostas));
        $respostasEPesos                    = [];

        foreach ($respostasComMaiorNumeroOcorrencias as $resposta) {
            $respostasEPesos[$resposta] = $this->maiorPesoResposta($resposta, $respostas);
        }

        arsort($respostasEPesos);
        return $respostasEPesos;
    }

    /**
     * Método responsável por verificar qual o maior peso para uma resposta
     *
     * @access private
     *
     * @param String    $resposta   resposta a ser capturado o peso
     * @param Array     $respostas  respostas do quiz
     *
     * @return Integer
     */
    private function maiorPesoResposta($resposta, $respostas)
    {
        return max(array_keys($respostas, $resposta)) + 1;
    }
}
