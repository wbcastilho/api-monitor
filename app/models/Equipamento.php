<?php

namespace app\models;

use Doctrine\DBAL\Connection;

class Equipamento
{
    private $db;

    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    public function findAll(): array
    {        
        $queryBuilder = $this->db->createQueryBuilder();
        
        $queryBuilder->select('*')->from('tb_equipamentos');
         
        $users = $queryBuilder->execute()->fetchAll(); 

        return $users;
    }

    public function peloSerial(string $serial): array
    {
        $queryBuilder = $this->db->createQueryBuilder();
               
        $queryBuilder
            ->select('*')
            ->from('tb_equipamentos')
            ->where('serial = :serial')
            ->andWhere('status_equipamentos = :status_equipamentos')
            ->andWhere('status = :status')
            ->setParameters([
                'serial' => $serial,
                'status_equipamentos' => 1,
                'status' => 1
            ]);
        
        $equipamento = $queryBuilder->execute()->fetchAll();
        
        // Transforma array associativo em um array simples
        $result = array_values($equipamento)[0];

        return $result;
    }

    public function getAccessCodsEvents(int $fabricante = null, $modelo = null): array
    {
        $queryBuilder = $this->db->createQueryBuilder();
               
        $queryBuilder
            ->select('maior', 'minor', 'condomino', 'status', 'cor', 'fotoCap', 'fotoCad')
            ->from('tb_access_cods');
        
        if ($fabricante) {
            $queryBuilder->andWhere('id_equipamentos_fabricante = :fabricante')
                ->setParameter('fabricante', $fabricante);
        }
        if ($modelo) {
            $queryBuilder->andWhere('id_equipamentos_modelo = :modelo')
                ->setParameter('modelo', $modelo);
        }       
        
        $cods = $queryBuilder->execute()->fetchAllAssociative();

        $arrCods = Array();
        foreach ($cods as $key => $colValue) {
            $arrCods[$colValue['maior']][$colValue['minor']]['condomino'] = $colValue['condomino'];
            $arrCods[$colValue['maior']][$colValue['minor']]['status'] = $colValue['status'];
            $arrCods[$colValue['maior']][$colValue['minor']]['cor'] = $colValue['cor'];
            $arrCods[$colValue['maior']][$colValue['minor']]['fotoCap'] = $colValue['fotoCap'];
            $arrCods[$colValue['maior']][$colValue['minor']]['fotoCad'] = $colValue['fotoCad'];
        }
               
        return $arrCods;
    }

    public function eventoRecente(int $id_evento_terminal, int $id_equipamentos, int $id_condominio, int $intervalo = 3600): int
    {
        $queryBuilder = $this->db->createQueryBuilder();

        $queryBuilder->select('COUNT(*)')
            ->from('tb_equipamentos_monitor')
            ->where('id_evento_terminal = :id_evento_terminal')
            ->andWhere('id_equipamentos = :id_equipamentos')
            ->andWhere('id_condominio = :id_condominio')
            ->andWhere('(TIMESTAMPDIFF(second,dt_ins_equipamentos_monitor,NOW()) <= :intervalo)')
            ->setParameters([
                'id_evento_terminal' => $id_evento_terminal,
                'id_equipamentos' => $id_equipamentos,
                'id_condominio' => $id_condominio,
                'intervalo' => $intervalo
            ]);
       
        $count = $queryBuilder->execute()->fetchOne();

        return $count;
    }

    public function registrarEvento(array $dados): int
    {        
        $this->db->insert('tb_equipamentos_monitor', $dados);
        
        return $this->db->lastInsertId();       
    }   
    
    public function updImgAcesso($id, $imagem)
    {        
        $queryBuilder = $this->db->createQueryBuilder();

        $queryBuilder->update('tb_equipamentos_monitor')
            ->set('imagem', ':imagem')
            ->setParameter('imagem', $imagem)
            ->where('id_equipamentos_monitor = :id')
            ->setParameter('id', $id);

        $result = $queryBuilder->execute();

        return $result ? 1 : 0;
    }
}