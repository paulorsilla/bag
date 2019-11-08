<?php
namespace Bag\Service;

class FileUpload {
    
    protected $entityManager;
    
    public function getEntityManager() {
        return $this->entityManager;
    }
    
    public function setEntityManager($entityManager) {
        $this->entityManager = $entityManager;
    }

    public function __construct($entityManager){ //$serviceInst
        $this->entityManager = $entityManager;
    }
    
    public function uploadMaterial($file) {

        $fileName = $file['tmp_name'];
        $ponteiro = fopen ( $fileName, 'r' );
        $contador = 0;
        $dados = [];
        
	while ( !feof( $ponteiro ) ) {
            $linha = fgets($ponteiro);
            if($contador > 0) {
                $l = explode(";", $linha);
                if (count($l) >= 4) {
                    $cgs = str_replace('"', '', $l[0]);
                    $qtdeSolicitada = str_replace('"', '', $l[1]);
                    $qtdeAtendida = str_replace('"', '', $l[2]);
                    $obs = str_replace('"', '', $l[3]);
                    $dados[$contador] = ["cgs" => $cgs, "quantidadeSolicitada" => $qtdeSolicitada, "quantidadeAtendida" => $qtdeAtendida, "observacao" => $obs];
                }
            }
            $contador += 1;
        }
        fclose($ponteiro);
        return $dados;
    }
    
    public function uploadMaterialRegeneracao($file) {

        $fileName = $file['tmp_name'];
        $ponteiro = fopen ( $fileName, 'r' );
        $contador = 0;
        $dados = [];
        
	while ( !feof( $ponteiro ) ) {
            $linha = fgets($ponteiro);
            if($contador > 0) {
                $l = explode(";", $linha);
                if (count($l) >= 4) {
                    $cgs = str_replace('"', '', $l[0]);
                    $estaca = str_replace('"', '', $l[1]);
                    $acesso = str_replace('"', '', $l[2]);
                    $quantidadePlantada = str_replace('"', '', $l[3]);
                    $acoes = str_replace('"', '', $l[4]);
                    $dados[$contador] = [
                        "cgs" => $cgs,
                        "estaca" => $estaca,
                        "acesso" => $acesso,
                        "quantidadePlantada" => $quantidadePlantada,
                        "acoes" => $acoes
                    ];
                }
            }
            $contador += 1;
        }
        fclose($ponteiro);
        return $dados;
    }
    
    public function uploadAtm($file)
    {
        $fileNameAux = trim($file['name']);
        $fileName = str_replace(' ', '_', $fileNameAux);
	$uploadDir = "/home/aplicacoes/bagarquivos/atm/";
        $tmp_fileName = $file['tmp_name'];
        if ( file_exists($tmp_fileName) ) {
            move_uploaded_file ( $tmp_fileName, $uploadDir . $fileName);
        }
    }
    
    public function uploadCaderneta($file, $fileName, $uploadDir)
    {
        $tmp_fileName = $file['tmp_name'];
        if ( file_exists($tmp_fileName) ) {
            move_uploaded_file ( $tmp_fileName, $uploadDir . $fileName );
        }
    }
    
        
//    public function uploadFoto($file)
//    {
//        $fileName = $file['name'];
//	$uploadDir = __DIR__."/../../../../public/img/fotos/jpg/";
//        $tmp_fileName = $file['tmp_name'];
//        if ( (file_exists($tmp_fileName)) && (getimagesize($tmp_fileName) !== FALSE) ) {
           // move_uploaded_file ( $tmp_fileName, $uploadDir . $matricula.".jpg");
//        }
//    }
}
