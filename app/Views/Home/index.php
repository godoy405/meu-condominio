<?php $this->extend('layouts/main'); ?>

<?php $this->section('title'); ?>
<?php echo $title; ?>
<?php $this->endSection(); ?>

<?php $this->section('css'); ?>

<?php $this->endSection(); ?>

<?php $this->section('content'); ?>

<div class="row">
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-sm mb-0 text-capitalize font-weight-bold">Contas pendentes</p>
                            <h5 class="font-weight-bolder mb-0">                                
                                <span class="text-danger font-weight-bolder"><?php echo $amount_pending_bills; ?></span>
                            </h5>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                            <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-sm mb-0 text-capitalize font-weight-bold">Total de reservas</p>
                            <h5 class="font-weight-bolder mb-0">                               
                                <span class="text-success font-weight-bolder"><?php echo $total_reservations; ?></span>
                            </h5>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                            <i class="ni ni-world text-lg opacity-10" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-sm mb-0 text-capitalize font-weight-bold">Total de ocorrências</p>
                            <h5 class="font-weight-bolder mb-0">                                
                                <span class="text-primary font-weight-bolder"><?php echo $total_occurrences; ?></span>
                            </h5>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                            <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if(auth()->user()->inGroup('user')): ?>
        <?php  echo $this->include('Home/_cards_user');?>
    <?php else: ?>
        <?php  echo $this->include('Home/_cards_superadmin');?>
    <?php endif;?>
</div>

<?php $this->endSection(); ?>

<?php $this->section('js'); ?>

<?php $this->endSection(); ?>