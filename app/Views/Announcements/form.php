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

                <?php if ($announcement->content === null): ?>
                    <a href="<?php echo route_to('announcements'); ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-angle-double-left"></i>&nbsp;Listar anúncio
                    </a>
                <?php else: ?>
                    <a href="<?php echo route_to('announcements.show', $announcement->content); ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-angle-double-left"></i>&nbsp;Detalhes do anúncio
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
                <label for="title">Título</label>
                <input type="text" class="form-control" required name="title" value="<?php echo old('title', $announcement->title) ?>" id="title" placeholder="Título">
            </div>         
     
            <div class="mb-3">
                <label for="content">Descrição</label>
                <textarea class="form-control" name="content" id="content" rows="5"><?php echo old('content', $announcement->content)?></textarea>
            </div>     
            
            <div class="form-check form-switch ps-0 mb-3">
                <input type="hidden" value="0" name="is_public">
                <input class="form-check-input ms-auto" name="is_public" <?php echo $announcement->is_public ? 'checked' : ''; ?>value="1" type="checkbox" id="is_public">
                <label class="form-check-label text-body ms-3 text-truncate w-80 mb-0" for="is_public">Anúncio público (exibir meus dados)</label>
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