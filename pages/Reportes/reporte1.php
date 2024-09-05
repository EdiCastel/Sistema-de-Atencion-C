<h4 class="mx-3">REPORTE <b>ESTADISTICAS DE LAS SOLICITUDES.</b></h4>

<a href="index.php" class="btn btn-sm btn-primary d-print-none ml-3"> <i class="fas fa-chevron-left"></i> Regresar </a>

<button href="#" class="btn btn-primary btn-sm d-print-none float-end mr-3" onclick="window.print();"><i class="fas fa-print"></i> Imprimir</button>

<hr class="mx-3">

<?php

    include "config.php";
    $conn = getConnection();

    $sqlQuery1 = "SELECT * FROM departamentos;";
    $stmt1 = $conn->prepare($sqlQuery1);
    $stmt1 -> execute();

?>

<div class="row mx-1">
    <div class="col">
        <label for="">Departamento:</label>
        <select name="" id="select-departamento" class="custom-select">
            <option value="" selected>(Todos)</option>
            <?php while($row = $stmt1 -> fetch(PDO::FETCH_ASSOC)){ ?>
                <option value="<?= $row['id_departamento']; ?>"><?= $row['departamento']; ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="col">
        <label for="">Tipo de Apoyo:</label>
        <!-- <span><i class="fas fa-spinner fa-spin"></i></span> -->
        <select name="" id="select-tipo-apoyo" class="custom-select">
            <option value="" selected>(Todos)</option>
            <?php while($row = $stmt1 -> fetch(PDO::FETCH_ASSOC)){ ?>
                <option value=""><?= $row['departamento']; ?></option>
            <?php } ?>
        </select>
    </div>
</div>

<br>

<div class="row">
    <div class="col">
        <div id="contenido"></div>
    </div>
</div><br><br>


<script>

    $(document).ready(function(){

        $('#contenido').load('pages/Reportes/reporte1-sub1.php');
        $('#select-tipo-apoyo').attr('disabled', true);

        // CAMBIO DINAMICO DE SUBPAGINAS.
        $('#select-departamento').change(function(){

            if ($('#select-departamento').val() == 0) { 
                // todos los departamentos
                $('#contenido').load('pages/Reportes/reporte1-sub1.php');
                $('#select-tipo-apoyo').val(0);
                $('#select-tipo-apoyo').attr('disabled', true);

            } else {
                // depto espefico. poblar lista de tipos de apoyo y posteriormente cargar el reporte.

                $('#select-tipo-apoyo').attr('disabled', false);
                
                var departamentoElegido = $(this).val();
                $.ajax({
                    url: 'services/lista_tipos_apoyo.php',
                    method: 'get',
                    data: {
                        id_departamento : departamentoElegido
                    },
                    success: function(response) {
                        $('#select-tipo-apoyo').empty(); // vaciar select
                        var tipos_apoyo = JSON.parse(response); // parsear respuesta
                        $('#select-tipo-apoyo').append('<option value="" selected>(Todos)</option>');
                        tipos_apoyo.forEach(
                            (element) => $('#select-tipo-apoyo').append('<option value="' + element.id_tipo_apoyo + '">' + element.nombre_apoyo + '</option>')
                        );

                        $('#select-tipo-apoyo').trigger('change');
                    }
                });

            }
        });

        $('#select-tipo-apoyo').change(function(){

            if ($('#select-tipo-apoyo').val() == 0) {
                // todos los tipos de apoyo.
                $('#contenido').load('pages/Reportes/reporte1-sub2.php?depto=' + $('#select-departamento').val());
            } else {
                // tipo de apoyo especifico
                $('#contenido').load('pages/Reportes/reporte1-sub3.php?tipo=' + $('#select-tipo-apoyo').val() + '&depto=' + $('#select-departamento').val());
            }

        });

    });

</script>
