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
                    <a href="<?php echo route_to('announcements'); ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-angle-double-left"></i>&nbsp;Listar anúncios
                    </a>
                    <a href="<?php echo route_to('announcements.new'); ?>" class="btn btn-success">
                        <i class="fas fa-plus"></i>&nbsp;Novo anúncio
                    </a>
                </div>
                <div class="card-body">            
                    <p><strong>Título: </strong><?php echo $announcement->title; ?></p>
                    <p><strong>Código: </strong><?php echo $announcement->code; ?></p>
                    <p><strong>Criado: </strong><?php echo $announcement->created_at->humanize(); ?></p>
                    <p><strong>Atualizado: </strong><?php echo $announcement->updated_at->humanize(); ?></p>  
                    <p><strong>Conteúdo: </strong><br><?php echo $announcement->content; ?></p>                 
                    <hr>
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Ações
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="<?php echo route_to('announcements.edit', $announcement->code); ?>" class="dropdown-item mb-2">
                                    Editar
                                </a>
                            </li>
                            <li>                              
                            </li> 
                            <li>
                                <?php echo form_open(
                                    action: route_to('announcements.destroy', $announcement->code),
                                    attributes: ['class' => 'd-inline', 'onsubmit' => 'return confirm("Tem certeza que deseja excluir esse anúncio?");'],
                                    hidden: ['_method' => 'DELETE']
                                ); ?>
                                <button type="submit" class="dropdown-item text-danger">
                                    Excluir
                                </button>  
                                <?php echo form_close(); ?>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php echo $this->endSection(); ?>

<?php echo $this->section('js'); ?>
<?php echo $this->endSection(); ?>