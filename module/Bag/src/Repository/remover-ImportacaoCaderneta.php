<?php

namespace Bag\Repository;

use Bag\Entity\ImportacaoCaderneta as ImportacaoCadernetaEntity;

class ImportacaoCaderneta extends AbstractRepository {

    public function getQuery($search = array()) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('i')
                ->from(ImportacaoCadernetaEntity::class, 'i')
                ->orderby('i.dataImportacao','ASC');
       return $qb;
       
    }
    
    public function delete($id) {
        $row = $this->find($id);
        if ($row) {
            $this->getEntityManager()->remove($row);
            $this->getEntityManager()->flush();
        }
    }
    
    public function incluir_ou_editar($dados, $id = null){
        
        $row = null;
        if ( !empty($id)) { // verifica se foi passado o codigo (se sim, considera edicao)
            $row = $this->find($id); // busca o registro para poder alterar
        }    
        if ( empty($row)) {
            $row = new ImportacaoCadernetaEntity();
        }
        
        $row->setData($dados); // setar os dados da model a partir dos dados capturados do formulario
        $this->getEntityManager()->persist($row); // persiste o model ( preparar o insert / update)
        $this->getEntityManager()->flush(); // Confirma a atualizacao
        
        return $row;
    }
    
    public function importacao($dados) {
        $nomeArquivo = "";
        if (isset($dados['nomeArquivo'])) {
            $nomeArquivo = $dados['nomeArquivo'];
        }
        error_log("/home/aplicacoes/bagarquivos/cadernetas/".$nomeArquivo);

        $conteudo = fopen("/home/aplicacoes/bagarquivos/cadernetas/".$nomeArquivo, "r");
            $linha = trim(fgets($conteudo));
            while($linha = fgets($conteudo)) {
                error_log($linha);
            }
        fclose($conteudo);
        
        return true;
    }

}