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
                    <a href="<?php echo route_to('areas'); ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-angle-double-left"></i>&nbsp;Listar áreas
                    </a>
                    <a href="<?php echo route_to('areas.new'); ?>" class="btn btn-success">
                        <i class="fas fa-plus"></i>&nbsp;nova
                    </a>
                </div>
                <div class="card-body">            
                    <p><strong>Nome: </strong><?php echo $area->name; ?></p>
                    <p><strong>Código: </strong><?php echo $area->code; ?></p>
                    <p><strong>Criada: </strong><?php echo $area->created_at->humanize(); ?></p>
                    <p><strong>Atualizada: </strong><?php echo $area->updated_at->humanize(); ?></p>  
                    <p><strong>Descrião: </strong><br><?php echo $area->description; ?></p>                 
                    <hr>
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Ações
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="<?php echo route_to('areas.edit', $area->code); ?>" class="dropdown-item mb-2">
                                    Editar
                                </a>
                            </li>
                            <li>                              
                            </li> 
                            <li>
                                <?php echo form_open(
                                    action: route_to('areas.destroy', $area->code),
                                    attributes: ['class' => 'd-inline', 'onsubmit' => 'return confirm("Tem certeza que deseja excluir esse residente?");'],
                                    hidden: ['_method' => 'DELETE']
                                ); ?>
                                <button type="submit" class="dropdown-item text-danger">
                                    Excluir
                                </button>  
                                <?php echo form_close();?>                     
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