<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

class auxTipoModel extends \Com\Daw2\Core\BaseModel {

    function showAll() : array {
        $stmt = $this->pdo->query("SELECT * FROM aux_tipo_proveedor");
        
        return $stmt->fetchAll();
    }
}
