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
                    <a href="<?php echo route_to('bills'); ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-angle-double-left"></i>&nbsp;Listar cobranças
                    </a>
                    <a href="<?php echo route_to('bills.new'); ?>" class="btn btn-success">
                        <i class="fas fa-plus"></i>&nbsp;nova
                    </a>
                </div>
                <div class="card-body">            
                    <p><strong>Residente: </strong><?php echo $bill->resident->name; ?></p>
                    <p><strong>Código: </strong><?php echo $bill->code; ?></p>
                    <p><strong>Valor: </strong><?php echo show_price($bill->amount); ?></p>
                    <p><strong>Data de vencimento: </strong><?php echo $bill->due_date->format('d/m/Y'); ?></p>
                    <p><strong>Status: </strong><?php echo $bill->isPaid() ? 'Pago' : 'Pendente'; ?></p>
                    <p><strong>Criada: </strong><?php echo $bill->created_at->humanize(); ?></p>
                    <p><strong>Atualizada: </strong><?php echo $bill->updated_at->humanize(); ?></p>  
                    <p><strong>Observações: </strong><br><?php echo $bill->notes; ?></p>                 
                    <hr>
                    <?php if(auth()->user()->inGroup('superadmin')): ?>
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Ações
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="<?php echo route_to('bills.edit', $bill->code); ?>" class="dropdown-item mb-2">
                                    Editar
                                </a>
                            </li>
                            <li>                              
                            </li> 
                            <li>
                                <?php echo form_open(
                                    action: route_to('bills.destroy', $bill->code),
                                    attributes: ['class' => 'd-inline', 'onsubmit' => 'return confirm("Tem certeza que deseja excluir essa cobrança?");'],
                                    hidden: ['_method' => 'DELETE']
                                ); ?>
                                <button type="submit" class="dropdown-item text-danger">
                                    Excluir
                                </button>  
                                <?php echo form_close();?>                     
                            </li>
                        </ul>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>      
<?php echo $this->endSection(); ?>

<?php echo $this->section('js'); ?>
<?php echo $this->endSection(); ?>