<?php

namespace Bag\Repository;
use Bag\Entity\Instituicao as InstituicaoEntity;
use Bag\Entity\Pais as Pais;

class Instituicao extends AbstractRepository {

    public function getQuery($search = []) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('i')
                ->from(InstituicaoEntity::class, 'i')
                ->orderBy('i.razaoSocial', 'ASC')
                ->where('i.desPfPj = :tipo')
                ->andWhere('i.razaoSocial != :empty')
                ->setParameter('tipo', "Pessoa Jurídica")
                ->setParameter('empty', " ");
        if (!empty($search['combo'])) {
            if ($search['combo'] == 1) {
                $array = [];
                $list =  $qb->getQuery()->getResult();
                foreach($list  as $row){
                    $array[] = ["id" => $row->codInstituicao, "razaoSocial" => $row->razaoSocial];
                }
                return $array;
            } else {
                return $qb->getQuery()->getResult();
            }
        } else {
            return $qb->getQuery();
        }
    }
    
    public function getListParaCombo()
    {
        $array = array();
        $list = $this->findAll();
        foreach($list  as $row){
            $array[] = array("id" => $row->id, "nome" => $row->desRazaoSocial);
        }
        return $array;
    }
    
    public function incluir_ou_editar($dados, $id = null) 
    {
        $row = null;
        if ( !empty($id)) { // verifica se foi passado o codigo (se sim, considera edicao)
            $row = $this->find($id); // busca o registro para poder alterar
        }    
        if ( empty($row)) {
            $row = new InstituicaoEntity();
            $row->setInclusao($dados['login']);
            $row->setDataInclusao($dados['dataAtual']);
        } else {
            $row->setAlteracao($dados['login']);
            $row->setDataAlteracao($dados['dataAtual']);
            $row->setDataAtualizacao($dados['dataAtual']);
        }
        $row->setRecebeNewsletter('N');
        $row->setLideranca('N');

        if($dados['tipoPessoa'] == 1) {
            $row->setDesPfPj('Pessoa Jurídica');
        } else {
            $row->setDesPfPj('Pessoa Física');
        }
        $cnpj = str_replace(['-','.','/'], '', $dados['cnpj']);
        $row->setCnpj($cnpj);
        
        if (!empty($dados['pais'])) {
            $pais = $this->getEntityManager()->find(Pais::class, $dados['pais']);
            $row->setPais($pais->getDescricao());
        }

        unset($dados['login']);
        unset($dados['tipoPessoa']);
        unset($dados['cnpj']);
        unset($dados['pais']);
        
        $row->setData($dados); // setar os dados da model a partir dos dados capturados do formulario
        $this->getEntityManager()->persist($row); // persiste o model ( preparar o insert / update)
        $this->getEntityManager()->flush(); // Confirma a atualizacao
        return $row;
    }
}



