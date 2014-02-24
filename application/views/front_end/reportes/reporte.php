<?php $this->load->view("partial/header"); ?>
<br />
<fieldset id="report_message">
    <legend>Datos Paciente</legend>
    <div class="field_row clearfix">
        <?php echo form_label('Número de Carnet:', 'reportes', array('class' => 'small_wide')); ?>
        <div class='form_field'>
            <?php
            echo form_label($paciente->usuario, 'motivo', array('class' => 'wide'));
            ?>
        </div>
    </div>
    <div class="field_row clearfix">
        <?php echo form_label('Nombres:', 'reportes', array('class' => 'small_wide')); ?>
        <div class='form_field'>
            <?php
            echo form_label($paciente->nombre . ' ' . $paciente->apellido, 'motivo', array('class' => 'wide'));
            ?>
        </div>
    </div>
</fieldset>
    <br>

<fieldset id="report_message">
    <legend>Datos Consultas</legend>
    <h3>Consultas</h3>
    <?php foreach ($consultas as $consulta) { ?>
    <fieldset id="report_message">
    <legend>Consulta <?php echo $consulta['fecha_actualizacion']?></legend>
        <div class="field_row clearfix">
            <?php echo form_label('Motivo:', 'motivo', array('class' => 'small_wide')); ?>
            <div class='form_field clearfix'>
                <?php
                echo form_label($consulta['motivo'], 'motivo', array('class' => 'wide'));
                ?>
            </div>
        </div>
        <div class="field_row clearfix">
            <?php echo form_label('Enfermedad:', 'motivo', array('class' => 'small_wide')); ?>
            <div class='form_field'>
                <?php
                echo form_label($consulta['enfermedad'], 'motivo', array('class' => 'wide'));
                ?>
            </div>
        </div>
        <div class="field_row clearfix">
            <?php echo form_label('Presión Arterial:', 'motivo', array('class' => 'small_wide')); ?>
            <div class='form_field'>
                <?php
                echo form_label($consulta['presion_arterial'], 'motivo', array('class' => 'wide'));
                ?>
            </div>
        </div>
        <div class="field_row clearfix">
            <?php echo form_label('Frecuencia Cardiaca:', 'motivo', array('class' => 'small_wide')); ?>
            <div class='form_field'>
                <?php
                echo form_label($consulta['frecuencia_cardiaca'], 'motivo', array('class' => 'wide'));
                ?>
            </div>
        </div>
        <div class="field_row clearfix">
            <?php echo form_label('Temperatura:', 'motivo', array('class' => 'small_wide')); ?>
            <div class='form_field'>
                <?php
                echo form_label($consulta['temperatura'], 'motivo', array('class' => 'wide'));
                ?>
            </div>
        </div>
        <div class="field_row clearfix">
            <?php echo form_label('Frecuencia Respiratoria:', 'motivo', array('class' => 'small_wide')); ?>
            <div class='form_field'>
                <?php
                echo form_label($consulta['frecuencia_respiratoria'], 'motivo', array('class' => 'wide'));
                ?>
            </div>
        </div>
        <div class="field_row clearfix">
            <?php echo form_label('Receta:', 'motivo', array('class' => 'small_wide')); ?>
            <div class='form_field'>
                <?php
                echo form_label($consulta['receta'], 'motivo', array('class' => 'wide'));
                ?>
            </div>
        </div>

</fieldset>
    <?php } ?>
</fieldset>
    <br>
    <fieldset id="report_message">
    <legend>Datos Defunción</legend>
    <h3>Defunción</h3>
    <?php if($defuncion){?>
    <fieldset id="report_message">
    <legend>Consulta <?php echo $defuncion->fecha_actualizacion?></legend>
        <div class="field_row clearfix">
            <?php echo form_label('Motivo:', 'motivo', array('class' => 'small_wide')); ?>
            <div class='form_field clearfix'>
                <?php
                echo form_label($defuncion->motivo, 'motivo', array('class' => 'wide'));
                ?>
            </div>
        </div>
        <div class="field_row clearfix">
            <?php echo form_label('Observaciones:', 'motivo', array('class' => 'small_wide')); ?>
            <div class='form_field'>
                <?php
                echo form_label($defuncion->observaciones, 'motivo', array('class' => 'wide'));
                ?>
            </div>
        </div>
        <div class="field_row clearfix">
            <?php echo form_label('Valor Alcocheck:', 'motivo', array('class' => 'small_wide')); ?>
            <div class='form_field'>
                <?php
                echo form_label($defuncion->valor_alcochek, 'motivo', array('class' => 'wide'));
                ?>
            </div>
        </div>
        <div class="field_row clearfix">
            <?php echo form_label('Factores Agravantes:', 'motivo', array('class' => 'small_wide')); ?>
            <div class='form_field'>
                <?php
                echo form_label($defuncion->factores_agravantes, 'motivo', array('class' => 'wide'));
                ?>
            </div>
        </div>

</fieldset>
    <?php }else{?>
    <h3>No hay datos.</h3>
    <?php }?>
</fieldset>
<?php $this->load->view("partial/footer"); ?>
