<?php

namespace QuizSerie\Util;

/**
 * Classe responsável por retornar o conteúdo de um arquivo de dados json
 *
 * @author Rodrigo Conceição de Araujo <omb.rodrigo@gmail.com>
 *
 * @package QuizSerie\Util
 **/
class ConteudoJson
{
    /**
     * Constante que define o caminho dos arquivo json com os dados
     */
    const PATH_JSON = 'data/';

    /**
     * Método responsável por capturar o conteúdo de um arquivo Json
     *
     * @access public
     *
     * @param String $nomeArquivo nome do arquivo a ser capturado o conteúdo
     *
     * @throws InvalidArgumentException caso o arquivo não exista
     *
     * @return String
     */
    public function capturar($nomeArquivo)
    {
        if ($this->arquivoExiste($nomeArquivo) === false) {
            throw new \InvalidArgumentException(sprintf("Arquivo %s não localizado", $nomeArquivo));
        }

        return file_get_contents($this->caminhoArquivo($nomeArquivo));
    }

    /**
     * Método responsável por verificar se um arquivo existe
     *
     * @access private
     *
     * @param String $nomeArquivo nome do arquivo a ser capturado o conteúdo
     *
     * @return Boolean
     */
    private function arquivoExiste($nomeArquivo)
    {
        return file_exists($this->caminhoArquivo($nomeArquivo));
    }

    /**
     * Método responsável por montar o caminho do arquivo json
     *
     * @access private
     *
     * @param String $nomeArquivo nome do arquivo a ser capturado o conteúdo
     *
     * @return String
     */
    private function caminhoArquivo($nomeArquivo)
    {
        return sprintf('%s%s.json', self::PATH_JSON, $nomeArquivo);
    }
}
