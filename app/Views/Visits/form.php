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
                <a href="<?php echo route_to('visits'); ?>" class="btn btn-outline-secondary">
                   <i class="fas fa-angle-double-left"></i>&nbsp;Listar visitas
                </a>            
            </div>
            <div class="card-body">
            <?php echo form_open(
                    action: $route,
                    attributes: ['class' => 'd-inline', 'id' => 'form'],
                    hidden: $hidden ?? []
            ); ?>

            <div class="mb-3">
                <label for="valid_until">Visita poderá ser usada até: </label>
                <input type="text" class="form-control" disabled value="<?php echo \CodeIgniter\I18n\Time::now()->addHours(24)->format('d-m-Y H:i'); ?>">
            </div>

            <div class="mb-3">
                <label for="name">Nome</label>
                <input type="text" class="form-control" required name="name" value="<?php echo old('name', $visit->name ?? '') ?>" id="name" placeholder="Nome">
            </div>          
                  
            <button type="submit" id="btnSubmit" class="btn mt-3 btn-success">
                Criar visita
            </button>
            <?php echo form_close(); ?>

            </div>
        </div>
    </div>
</div>


<?php echo $this->endSection(); ?>

<?php echo $this->section('js'); ?>

<?php echo $this->endSection(); ?>