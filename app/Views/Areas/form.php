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

                <?php if ($area->code === null): ?>
                    <a href="<?php echo route_to('areas'); ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-angle-double-left"></i>&nbsp;Listar areas
                    </a>
                <?php else: ?>
                    <a href="<?php echo route_to('areas.show', $area->code); ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-angle-double-left"></i>&nbsp;Detalhes da Área
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
                <label for="name">Nome</label>
                <input type="text" class="form-control" required name="name" value="<?php echo old('name', $area->name) ?>" id="name" placeholder="Nome">
            </div>

            <div class="mb-3">
                <label for="code">Código</label>
                <input type="text" class="form-control" required name="code" value="<?php echo old('code', $area->code) ?>" id="code" placeholder="Código da área">
            </div>

            <div class="mb-3">
                <label for="description">Descrição</label>
                <textarea class="form-control" name="description" id="description" rows="5"><?php echo old('description', $area->description)?></textarea>
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