use App\Cells\Bills\FormInputsCell;
use App\Models\BillModel;
use App\Models\ReservationModel;
use App\Models\ResidentModel;

<?php echo $this->extend('Layouts/main'); ?>

<?php echo $this->section('title'); ?>

<?php echo $title ?>

<?php echo $this->endSection(); ?>

<?php echo $this->section('css'); ?>

<?php echo $this->endSection(); ?>

<?php echo $this->section('content'); ?>

<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6><?php echo $title; ?></h6>               
                    <a href="<?php echo isset($resident) ? route_to('reservations.show', $resident->code) : route_to('reservations'); ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-angle-double-left"></i>&nbsp;Detalhes da reserva
                    </a>                 
            </div>
            <div class="card-body">
            <?php echo form_open(
                    action: $route,
                    attributes: ['class' => 'd-inline', 'id' => 'form'],
                    hidden: $hidden ?? []
            ); ?>

            <div>
                <p>Residente: <?php echo $reservation?->resident?->name; ?></p>
                <p>Área: <?php echo $reservation?->area?->name; ?></p>
            </div>          
            <?php if ($reservation !== null): ?>
                <?php echo view_cell(library: \App\Cells\Bills\FormInputsCell::class, params: ['bill' => $reservation->bill ?? null]) ?>
            <?php else: ?>
                <!-- Mensagem ou conteúdo alternativo quando não há reserva -->
                <div class="alert alert-warning">Nenhuma reserva encontrada.</div>
            <?php endif; ?>
            <button type="submit" id="btnSubmit" class="btn btn-success">
                Salvar
            </button>
            <?php echo form_close(); ?>

            </div>
        </div>
    </div>
</div>


<?php echo $this->endSection(); ?>

<?php echo $this->section('js'); ?>

<?php echo $this->endSection(); ?>