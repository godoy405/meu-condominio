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

                <?php if ($resident->code === null): ?>
                    <a href="<?php echo route_to('residents'); ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-angle-double-left"></i>&nbsp;Listar residentes
                    </a>
                <?php else: ?>
                    <a href="<?php echo route_to('residents.show', $resident->code); ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-angle-double-left"></i>&nbsp;Detalhes do residentes
                    </a>
                <?php endif; ?>
            </div>
            <div class="card-body">
            <?php echo form_open(
                    action: $route,
                    attributes: ['class' => 'd-inline', 'id' => 'form'],
                    hidden: $hidden ?? []
            ); ?>
            <div class="mb-3">
                <label for="name">Nome completo</label>
                <input type="text" class="form-control" required name="name" value="<?php echo old('name', $resident->name) ?>" id="name" placeholder="Nome completo">
            </div>

            <div class="mb-3">
                <label for="mobile_phone">Telefone</label>
                <input type="tel" class="form-control" required name="mobile_phone" value="<?php echo old('mobile_phone', $resident->mobile_phone) ?>" id="mobile_phone" placeholder="Telefone">
            </div>
            <div class="mb-3">
                <label for="apartment">Apartamento</label>
                <input type="text" class="form-control" required name="apartment" value="<?php echo old('apartment', $resident->apartment) ?>" id="apartment" placeholder="Apartamento">
            </div>

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