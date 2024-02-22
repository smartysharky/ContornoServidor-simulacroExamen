<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

class proveedoresModel extends \Com\Daw2\Core\BaseModel {
    
    const SELECT_FROM = "SELECT * FROM proveedor LEFT JOIN aux_tipo_proveedor ON aux_tipo_proveedor.id_tipo_proveedor = proveedor.id_tipo_proveedor LEFT JOIN aux_continente ON proveedor.id_continente = aux_continente.id_continente";
    const ORDER_ARRAY = ['alias', 'nombre_completo', 'nombre_tipo_proveedor', 'nombre_continente', 'anho_fundacion'];
    
    function showAll() : array {
        $stmt = $this->pdo->query(self::SELECT_FROM);
        
        return $stmt->fetchAll();
    }
    
    private function CalcFiltros($filtros) : array {
        $condiciones = [];
        $vars = [];
        
        if(!empty($filtros["alias"])){
            $condiciones[] = "alias LIKE :alias";
            $vars["alias"] = "%$filtros[alias]%";
        }
        if(!empty($filtros["nombre_completo"])){
            $condiciones[] = "nombre_completo LIKE :nombre_completo";
            $vars["nombre_completo"] = "%$filtros[nombre_completo]%";
        }
        if(!empty($filtros['id_tipo']) && is_array($filtros['id_tipo'])){
            $ids = [];
            $bind = [];
            $i = 1;
            foreach($filtros['id_tipo'] as $c){
                $key = 'id_tipo'.$i;
                $ids[] = ":$key";
                $bind[$key] = $c;
                $i++;
            }
            $condiciones[] = "aux_tipo_proveedor.id_tipo_proveedor IN (".implode(", ", $ids).")";
            $vars = array_merge($vars, $bind);
        }
        if(!empty($filtros['id_continente']) && filter_var($filtros['id_continente'], FILTER_VALIDATE_INT)){
            $condiciones[] = 'aux_continente.id_continente = :id_continente';
            $vars['id_continente'] = $filtros['id_continente'];
        }
        if(!empty($filtros['min_anho']) && is_numeric($filtros['min_anho'])){
            $condiciones[] = 'anho_fundacion >= :min_anho';
            $vars['min_anho'] = $filtros['min_anho'];
        }
        if(!empty($filtros['max_anho']) && is_numeric($filtros['max_anho'])){
            $condiciones[] = 'anho_fundacion <= :max_anho';
            $vars['max_anho'] = $filtros['max_anho'];
        }
        return [
            'condiciones' => $condiciones,
            'vars' => $vars
        ];
    }
    
    private function executeQuery(string $query, array $vars) : array{
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($vars);
        return $stmt->fetchAll();
    }
    
    public function filter($filtros) : array {
        
        $whereVars = $this->CalcFiltros($filtros);
        
        $order = $this->getOrder($filtros);
        $campoOrder = self::ORDER_ARRAY[abs($order) - 1];
        
        if(empty($whereVars['condiciones'])){
            $query = self::SELECT_FROM . " order by $campoOrder " . $this->getSentido($order);
            return $this->pdo->query($query)->fetchAll();
        }
        else{
            $query = self::SELECT_FROM . " WHERE ".implode(" AND ", $whereVars['condiciones']) . " order by $campoOrder " . $this->getSentido($order);
            
            return $this->executeQuery($query, $whereVars['vars']);
        }
    }
    
    private function getSentido(int $order){
        return ($order >= 0) ? 'asc' : 'desc';
    }
    
    public function getOrder(array $filtros) : int{
        if(!isset($filtros['order']) || abs($filtros['order']) < 1 || abs($filtros['order']) > count(self::ORDER_ARRAY)){
            $order = 1;
        }
        else{
            $order = (int)$filtros['order'];
        }
        return $order;
    }
}
