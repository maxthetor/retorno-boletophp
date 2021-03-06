<?php

namespace ManoelCampos\RetornoBoleto;

require_once("RetornoAbstract.php");

/** 
 * Classe para leitura_arquivos_retorno_cobranças_padrão CNAB240.
 * Layout Padrão <a href="http://www.febraban.org.br">Febraban</a> 240 posições V08.4 de 01/09/2009.<p/>
 * 
 * @license <a href="https://opensource.org/licenses/MIT">MIT License</a>
 * @author <a href="http://manoelcampos.com/contact">Manoel Campos da Silva Filho</a>
 * @version 1.1
 */
class RetornoCNAB240 extends RetornoAbstract {
    protected function processarHeaderArquivo($linha) {
        $vetor = array();
        $vetor["banco"] = substr($linha, 1, 3); //NUMERICO //Código do Banco na Compensação
        $vetor["lote"] = substr($linha, 4, 4); //num - default 0000 //Lote de Serviço
        $vetor["registro"] = substr($linha, 8, 1); //num - default 0 //Tipo de Registro
        $vetor["cnab1"] = substr($linha, 9, 9); //BRANCOS //Uso Exclusivo FEBRABAN / CNAB
        $vetor["tipo_inscricao_empresa"] = substr($linha, 18, 1); //num - 1-CPF, 2-CGC //Tipo de Inscrição da Empresa
        $vetor["num_inscricao_empresa"] = substr($linha, 19, 14); //numerico  //Número de Inscrição da Empresa
        $vetor["cod_convenio"] = substr($linha, 33, 20); //alfanumerico  //Código do Convênio no Banco
        $vetor["agencia"] = substr($linha, 53, 5); //numerico //Agência Mantenedora da Conta
        $vetor["dv_agencia"] = substr($linha, 58, 1); //alfanumerico //DV da Agência
        $vetor["conta_corrente"] = substr($linha, 59, 12); //numerico //Número da Conta Corrente
        $vetor["dv_conta"] = substr($linha, 71, 1); //alfanumerico  //DV da Conta Corrent
        $vetor["dv_ag_conta"] = substr($linha, 72, 1); //alfanumerico 
        $vetor["nome_empresa"] = substr($linha, 73, 30); //alfanumerico 
        $vetor["nome_banco"] = substr($linha, 103, 30); //alfanumerico 
        $vetor["uso_febraban_cnab2"] = substr($linha, 133, 10); //brancos //Uso Exclusivo FEBRABAN / CNAB
        $vetor["cod_arq"] = substr($linha, 143, 1); //num - 1-REM E 2-RET ?? //Código do arquivo de remessa/retorno
        $vetor["data_geracao_arq"] = substr($linha, 144, 8); //num - formato ddmmaaaa
        $vetor["hora_geracao_arq"] = substr($linha, 152, 6); //num - formato hhmmss
        $vetor["sequencia"] = substr($linha, 158, 6); //numerico //Número Sequencial do Arquivo
        $vetor["versao_layout_arq"] = substr($linha, 164, 3); //num 084 //Num da Versão do Layout do Arquivo
        $vetor["densidade"] = substr($linha, 167, 5); //numerico //Densidade de Gravação do Arquivo
        $vetor["reservado_banco"] = substr($linha, 172, 20); //alfanumerico //Para Uso Reservado do Banco
        $vetor["reservado_empresa"] = substr($linha, 192, 20); //alfanumerico //Para Uso Reservado da Empresa
        $vetor["uso_febraban_cnab3"] = substr($linha, 212, 29); //brancos //Uso Exclusivo FEBRABAN / CNAB
        
        return $vetor;
    }

    protected function processarHeaderLote($linha) {
        //SEGMENTO J - Pagamento de Títulos de Cobrança
        $vetor = array();
        $vetor["banco"] = substr($linha, 1, 3); //numerico //Código do Banco na Compensação
        $vetor["lote"] = substr($linha, 4, 4); //numerico //Lote de Serviço
        $vetor["registro"] = substr($linha, 8, 1); //num - default 1 //Tipo de Registro
        $vetor["operacao"] = substr($linha, 9, 1); //alfanumerico - default C //Tipo da Operação
        $vetor["servico"] = substr($linha, 10, 2); //num  //Tipo do Serviço
        $vetor["forma_lancamento"] = substr($linha, 12, 2); //num //Forma de Lançamento
        $vetor["layout_lote"] = substr($linha, 14, 3); //num - default '030' //No da Versão do Layout do Lote
        $vetor["cnab1"] = substr($linha, 17, 1); //alfa - default brancos  //Uso Exclusivo da FEBRABAN/CNAB

        $vetor["tipo_inscricao_empresa"] = substr($linha, 18, 1); //num - 1-CPF, 2-CGC //Tipo de Inscrição da Empresa
        $vetor["num_inscricao_empresa"] = substr($linha, 19, 14); //numerico //Número de Inscrição da Empresa
        $vetor["cod_convenio"] = substr($linha, 33, 20); //alfanumerico //Código do Convênio no Banco

        $vetor["agencia"] = substr($linha, 53, 5); //numerico //Agência Mantenedora da Conta
        $vetor["dv_agencia"] = substr($linha, 58, 1); //alfanumerico //DV da Agência Mantenedora da Conta
        $vetor["conta_corrente"] = substr($linha, 59, 12); //numerico 
        $vetor["dv_conta"] = substr($linha, 71, 1); //alfanumerico 
        $vetor["dv_ag_conta"] = substr($linha, 72, 1); //alfanumerico //Dígito Verificador da Ag/Conta
        $vetor["nome_empresa"] = substr($linha, 73, 30); //alfanumerico 
        $vetor["mensagem1"] = substr($linha, 103, 40); //alfanumerico 

        $vetor["logradouro_empresa"] = substr($linha, 143, 30); //alfa //Logradouro da Empresa - Nome da Rua, Av, Pça, Etc
        $vetor["numero_empresa"] = substr($linha, 173, 5); //num //Número do endereço da empresa
        $vetor["complemento_empresa"] = substr($linha, 178, 15); //alfa //Complemento - Casa, Apto, Sala, Etc
        $vetor["cidade_empresa"] = substr($linha, 193, 20); //alfa //Cidade da Empresa
        $vetor["cep_empresa"] = substr($linha, 213, 5); //num //5 primeiros dígitos do CEP da Empresa
        $vetor["complemento_cep_empresa"] = substr($linha, 218, 3); //alfa //3 últimos dígitos do CEP da empresa
        $vetor["estado"] = substr($linha, 221, 2); //  alfa  //Sigla do Estado
        $vetor["cnab"] = substr($linha, 223, 8); // alfa - default brancos //Uso Exclusivo da FEBRABAN/CNAB 
        $vetor["ocorrencias"] = substr($linha, 231, 10); //alfa //Código das Ocorrências p/ Retorno  

        return $vetor;
    }

    protected function processarDetalhe($linha) {
        //LIQUIDACAO_TITULOS_CARTEIRA_COBRANCA - SEGMENTO J (Pagamento de Títulos de Cobrança) REMESSA/RETORNO
        $vetor = array();
        $vetor["banco"] = substr($linha, 1, 3); //   Num //Código no Banco da Compensação     
        $vetor["lote"] = substr($linha, 4, 4); //   Num //Lote de Serviço                    
        $vetor["registro"] = substr($linha, 8, 1); //   Num  default '3' //Tipo de Registro                   
        $vetor["num_registro_lote"] = substr($linha, 9, 5); //   Num  //No Sequencial do Registro no Lote  
        $vetor["segmento"] = substr($linha, 14, 1); //   Alfa  default 'J' //Código de Segmento no Reg. Detalhe 
        $vetor["tipo_movimento"] = substr($linha, 15, 1); //   Num //Tipo de Movimento 
        $vetor["cod_movimento"] = substr($linha, 16, 2); //   Num  //Código da Instrução p/ Movimento   
        $vetor["cod_barras"] = substr($linha, 18, 44); //   Num           
        $vetor["nome_cedente"] = substr($linha, 62, 30); //   Alfa          
        $vetor["data_vencimento"] = substr($linha, 92, 8); //   Num  //Data do Vencimento (Nominal)       
        $vetor["valor_titulo"] = substr($linha, 100, 13); //   Num, 2 casas decimais //Valor do Título (Nominal)          
        $vetor["desconto"] = substr($linha, 115, 13); //   Num, 2 casas decimais //Valor do Desconto + Abatimento     
        $vetor["acrescimos"] = substr($linha, 130, 13); //   Num, 2 casas decimais //Valor da Mora + Multa              
        $vetor["data_pagamento"] = substr($linha, 145, 8); //   Num           
        $vetor["valor_pagamento"] = substr($linha, 153, 13); //   Num, 2 casas decimais
        $vetor["quantidade_moeda"] = substr($linha, 168, 10); //   Num, 5 casas decimais
        $vetor["referencia_sacado"] = substr($linha, 183, 20); //   Alfa //Num. do Documento Atribuído pela Empresa 
        $vetor["nosso_numero"] = substr($linha, 203, 20); //   Alfa //Num. do Documento Atribuído pelo Banco
        $vetor["cod_moeda"] = substr($linha, 223, 2); //   Num 
        $vetor["cnab"] = substr($linha, 225, 6); //   Alfa - default Brancos //Uso Exclusivo FEBRABAN/CNAB
        $vetor["ocorrencias"] = substr($linha, 231, 10); //   Alfa //Códigos das Ocorrências p/ Retorno
        
        return $vetor;
    }

    protected function processarTrailerLote($linha) {
        $vetor = array();
        $vetor["banco"] = substr($linha, 1, 3); //numerico  //Código do Banco na Compensação
        $vetor["lote"] = substr($linha, 4, 4); //numerico //Lote de Serviço
        $vetor["registro"] = substr($linha, 8, 1); //num - default 5 //Tipo de Registro
        $vetor["cnab1"] = substr($linha, 9, 9); //alfa - default brancos Uso Exclusivo FEBRABAN/CNAB
        $vetor["quant_regs"] = substr($linha, 18, 6); //numerico //Quantidade de Registros do Lote
        $vetor["valor"] = substr($linha, 24, 16); //numerico, 2 casas decimais  //Somatória dos Valores
        $vetor["quant_moedas"] = substr($linha, 42, 13); //numerico, 5 casas decimais  //Somatória de Quantidade de Moedas
        $vetor["num_aviso_debito"] = substr($linha, 60, 6); //numerico //Número Aviso de Débito
        $vetor["cnab2"] = substr($linha, 66, 165); //alfa, default brancos //Uso Exclusivo FEBRABAN/CNAB
        $vetor["ocorrencias"] = substr($linha, 231, 10); //alfa  //Códigos das Ocorrências para Retorno
        
        return $vetor;
    }

    protected function processarTrailerArquivo($linha) {
        $vetor = array();
        $vetor["banco"] = substr($linha, 1, 3); //numerico  //Código do Banco na Compensação
        $vetor["lote"] = substr($linha, 4, 4); // num - default 9999  //Lote de Serviço
        $vetor["registro"] = substr($linha, 8, 1); //num - default 9   //Tipo de Registro           
        $vetor["cnab1"] = substr($linha, 9, 9); //alpha - default brancos //Uso Exclusivo FEBRABAN/CNAB     
        $vetor["quant_lotes"] = substr($linha, 18, 6); //num. //Quantidade de Lotes do Arquivo
        $vetor["quant_regs"] = substr($linha, 24, 6); //num. //Quantidade de Registros do Arquivo
        $vetor["quant_contas_conc"] = substr($linha, 30, 6); //num. //Qtde de Contas p/ Conc. (Lotes)
        $vetor["cnab2"] = substr($linha, 36, 205); //alpha - default brancos  //Uso Exclusivo FEBRABAN/CNAB   
        
        return $vetor;
    }
    
    public function getIdDetalhe() {
        return 3;        
    }

    public function getIdHeaderArquivo() {
        return 0;        
    }

    public function getIdHeaderLote() {
        return 1;        
    }

    public function getIdTrailerArquivo() {
        return 9;
    }

    public function getIdTrailerLote() {
        return 5;
    }

    protected function getTipoLinha($linha) {
        return substr($linha, 8, 1);
    }

    public function getTotalCaracteresPorLinha() {
        return 240;
    }
}