<?php
use App\Enum\Reservation\Status;
?>

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
                    <a href="<?php echo route_to('reservations'); ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-angle-double-left"></i>&nbsp;Listar reservas
                    </a>
                    <?php if(auth()->user()->inGroup('user')): ?>
                        <div class="mb-3">
                            <a href="<?php echo route_to('reservations.new'); ?>" class="btn btn-success">+ Nova</a>
                            <?php if($reservation->status !== Status::CANCELLED): ?>
                                <?php echo form_open(
                                    action: route_to('reservations.cancel', $reservation->code),
                                    attributes: ['class' => 'd-inline ms-2', 'onsubmit' => 'return confirm("Tem certeza que deseja cancelar essa reserva?");'],
                                    hidden: ['_method' => 'PUT']
                                ); ?>
                                    <button type="submit" class="btn btn-danger">
                                        Cancelar
                                    </button>
                                <?php echo form_close(); ?>
                            <?php endif; ?>                            
                        </div>
                    <?php endif; ?>

                    <!-- Debug temporário - remover depois -->
                    <p><strong>Status atual:</strong> <?php echo $reservation->status; ?></p>                   
                </div>
                <div class="card-body">                
                    <p><strong>Área: </strong><?php echo $reservation?->area?->name; ?></p>
                    <p><strong>Data ehora desejados: </strong><?php echo $reservation->desired_date; ?></p>
                    <p><strong>Status: </strong><?php echo $reservation->status(); ?></p>
                    <p><strong>Razão status: </strong><?php echo $reservation->reason_status; ?></p>
                    <p><strong>Dados da cobrança</strong><br>
                        [][] ****** DADOS DA COBRANÇA [][]
                    </p>
                    <p><strong>Residente: </strong><?php echo $reservation?->resident?->name; ?></p>
                    <p><strong>Criada: </strong><?php echo $reservation->created_at->humanize(); ?></p>
                    <p><strong>Atualizada: </strong><?php echo $reservation->updated_at->humanize(); ?></p>
                    <p><strong>Observações do residente: </strong><?php echo $reservation->notes; ?></p>  

                    <?php if(auth()->user()->inGroup('superadmin')): ?>
                        <a href="<?php echo route_to('reservations.bills', $reservation->code); ?>" class="btn btn-primary">
                            Gerenciar cobrança
                        </a>
                    <?php endif;?>                                   
                </div>
            </div>
        </div>
    </div>      
<?php echo $this->endSection(); ?>

<?php echo $this->section('js'); ?>
<?php echo $this->endSection(); ?>