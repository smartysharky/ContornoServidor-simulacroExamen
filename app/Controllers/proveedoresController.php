<?php
declare(strict_types = 1);
namespace Com\Daw2\Controllers;

class proveedoresController extends \Com\Daw2\Core\BaseController {
    
    public function mostrarFiltros() {
        $model = new \Com\Daw2\Models\proveedoresModel();
        $proveedores = $model->filter($_GET);
        
        $tiposModel = new \Com\Daw2\Models\auxTipoModel();
        $tipos = $tiposModel->showAll();
        
        $continenteModel = new \Com\Daw2\Models\auxContinenteModel();
        $continentes = $continenteModel->showAll();
        
        $copiaGet = $_GET;
        unset($copiaGet['order']);
        unset($copiaGet['page']);
        
        $input = filter_var_array($_GET, FILTER_SANITIZE_SPECIAL_CHARS);
        
        $data = array(
            'titulo' => 'Proveedores',
            'breadcrumb' => ['Inicio', 'Proveedores'],
            'seccion' => '/proveedores',
            'proveedores' => $proveedores,
            'tipos' => $tipos,
            'continentes' => $continentes,
            'input' => $input,
            'parameters' => http_build_query($copiaGet),
            'order'  => $model->getOrder($_GET)
        );                
        $this->view->showViews(array('templates/header.view.php', 'proveedores.view.php', 'templates/footer.view.php'), $data);
    }
    
    

}