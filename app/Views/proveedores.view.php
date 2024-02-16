<!--Inicio HTML -->
<div class="row">       
    <div class="col-12">
        <div class="card shadow mb-4">
            <form method="get" action="/proveedores">
                <input type="hidden" name="order" value="1"/>
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Filtros</h6>                                    
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <!--<form action="./?sec=formulario" method="post">                   -->
                    <div class="row">
                        <div class="col-12 col-lg-4">
                            <div class="mb-3">
                                <label for="alias">Alias:</label>
                                <input type="text" class="form-control" name="alias" id="alias" value="<?php echo isset($input["alias"]) ? $input["alias"] : ""; ?>" />
                            </div>
                        </div>  
                        <div class="col-12 col-lg-4">
                            <div class="mb-3">
                                <label for="nombre_completo">Nombre completo:</label>
                                <input type="text" class="form-control" name="nombre_completo" id="nombre_completo" value="<?php echo isset($input["nombre_completo"]) ? $input["nombre_completo"] : ""; ?>" />
                            </div>
                        </div> 
                        <div class="col-12 col-lg-3">
                            <div class="mb-3">
                                <label for="id_tipo">Tipo:</label>
                                <select name="id_tipo[]" id="id_tipo" class="form-control select2" data-placeholder="Tipo proveedor" multiple>
                                    <option value="">-</option>
                                    <?php
                                    foreach ($tipos as $tipo) {
                                        ?>
                                    <option value="<?php echo $tipo["id_tipo_proveedor"] ?>" <?php echo (isset($input["id_tipo"]) && in_array($tipo["id_tipo_proveedor"], $input["id_tipo"]))? "selected" : ""; ?>><?php echo $tipo["nombre_tipo_proveedor"] ?></option>
                                        <?php
                                    }
                                    ?>                                                                         
                                </select>
                            </div>
                        </div> 
                        <div class="col-12 col-lg-4">
                            <div class="mb-3">
                                <label for="id_continente">Continente:</label>
                                <select name="id_continente" id="id_continente" class="form-control" data-placeholder="Continente">
                                    <option value="">-</option>
                                    <?php
                                    foreach ($continentes as $con) {
                                        ?>
                                        <option value="<?php echo $con["id_continente"] ?>" <?php echo (isset($input["id_continente"]) && $con["id_continente"] == $input["id_continente"])? "selected" : ""; ?> ><?php echo $con["nombre_continente"] ?></option>
                                        <?php
                                    }
                                    ?>                                                                            
                                </select>
                            </div>
                        </div>                        
                        <div class="col-12 col-lg-4">
                            <div class="mb-3">
                                <label for="anho_fundacion">Año fundación:</label>
                                <div class="row">
                                    <div class="col-6">
                                        <input type="text" class="form-control" name="min_anho" id="min_anho" value="<?php echo isset($input["min_anho"]) ? $input["min_anho"] : ""; ?>" placeholder="Mí­nimo" />
                                    </div>
                                    <div class="col-6">
                                        <input type="text" class="form-control" name="max_anho" id="max_anho" value="<?php echo isset($input["max_anho"]) ? $input["max_anho"] : ""; ?>" placeholder="Máximo" />
                                    </div>
                                </div>
                            </div>
                        </div>                           
                    </div>
                </div>
                <div class="card-footer">
                    <div class="col-12 text-right">                     
                        <a href="/proveedores" value="" name="reiniciar" class="btn btn-danger">Reiniciar filtros</a>
                        <input type="submit" value="Aplicar filtros" name="enviar" class="btn btn-primary ml-2"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="col-12">
        <div class="card shadow mb-4">
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Proveedores</h6>                                    
            </div>
            <!-- Card Body -->
            <div class="card-body" id="card_table">
                <div id="button_container" class="mb-3"></div>
                <!--<form action="./?sec=formulario" method="post">                   -->
                <table id="tabladatos" class="table table-striped">                    
                    <thead>
                        <tr>
                            <th><a href="/proveedores?order=1">Alias</a> <i class="fas fa-sort-amount-down-alt"></i></th>
                            <th><a href="/proveedores?order=2">Nombre Completo</a> </th>
                            <th><a href="/proveedores?order=3">Tipo</a> </th>
                            <th><a href="/proveedores?order=4">Continente</a> </th>
                            <th><a href="/proveedores?order=5">Año fundación</a> </th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($proveedores as $prov) {
                            ?>
                            <tr>
                                <td><?php echo $prov["alias"] ?></td>
                                <td><?php echo $prov["nombre_completo"] ?></td>
                                <td><?php echo $prov["nombre_tipo_proveedor"] ?></td>
                                <td><?php echo $prov["nombre_continente"] ?></td>
                                <td><?php echo $prov["anho_fundacion"] ?></td>
                                <td>                                        
                                    <a href="tel: <?php echo $prov["telefono"] ?>" target="_blank" class="btn btn-success ml-1" data-toggle="tooltip" data-placement="top" title="<?php echo $prov["telefono"] ?>"><i class="fas fa-phone"></i></a>
                                    <a href="mailto: <?php echo $prov["email"] ?>" target="_blank" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="<?php echo $prov["email"] ?>"><i class="fas fa-envelope"></i></a>                                        
                                    <?php
                                    if (empty($prov["website"])) {
                                        ?>
                                        <a href="<?php echo $prov["website"] ?>" target="_blank" class="btn btn-light ml-1"><i class="fas fa-globe-europe"></i></a>
                                        <?php
                                    }
                                    ?>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>                    
                </table>
            </div>
            <div class="card-footer">
                <nav aria-label="Navegacion por paginas">
                    <ul class="pagination justify-content-center">
                        <li class="page-item">
                            <a class="page-link" href="/proveedores?page=1&order=1" aria-label="First">
                                <span aria-hidden="true">&laquo;</span>
                                <span class="sr-only">First</span>
                            </a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="/proveedores?page=2&order=1" aria-label="Previous">
                                <span aria-hidden="true">&lt;</span>
                                <span class="sr-only">Previous</span>
                            </a>
                        </li>

                        <li class="page-item active"><a class="page-link" href="#">3</a></li>   
                        <li class="page-item">
                            <a class="page-link" href="/proveedores?page=4&order=1" aria-label="Next">
                                <span aria-hidden="true">&gt;</span>
                                <span class="sr-only">Next</span>
                            </a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="/proveedores?page=8&order=1" aria-label="Last">
                                <span aria-hidden="true">&raquo;</span>
                                <span class="sr-only">Last</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>                        
</div>
<!--Fin HTML -->