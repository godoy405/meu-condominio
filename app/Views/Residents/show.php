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
              <a href="<?php echo route_to('residents'); ?>" class="btn btn-outline-secondary">
                <i class="fas fa-angle-double-left"></i>&nbsp;Listar residentes
              </a>
              <a href="<?php echo route_to('residents.new'); ?>" class="btn btn-success">
                <i class="fas fa-plus"></i>&nbsp;novo
              </a>
            </div>
            <div class="card-body">

                <?php if(!$resident->hasUser()): ?>

                  <div class="alert bg-warning mb-3" role="alert">
                    <h4 class="alert-heading">Atenção !</h4>
                    <p>Esse residente ainda não possui um usuário associado.</p>
                    <a href="<?php echo route_to('residents.user', $resident->code); ?>" class="btn btn-dark btn-sm">
                      <i class="fas fa-plus"></i>&nbsp;Criar usuário
                    </a>
                  </div>
                <?php endif; ?>  
                <p><strong>Nome: </strong><?php echo $resident->name; ?></p>
                <p><strong>Telefone: </strong><?php echo $resident->mobile_phone; ?></p>
                <p><strong>Apartamento: </strong><?php echo $resident->apartment; ?></p>
                <p><strong>Criado: </strong><?php echo $resident->created_at->humanize(); ?></p>
                <p><strong>Atualizado:  </strong><?php echo $resident->updated_at->humanize(); ?></p>  

                <hr>
                <div class="dropdown">
                  <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Ações
                  </button>
                  <ul class="dropdown-menu">
                    <li>
                      <a href="<?php echo route_to('residents.edit', $resident->code); ?>" class="dropdown-item mb-2">
                          Editar
                      </a>
                    </li>
                    <li>
                      <a href="<?php echo route_to('residents.user', $resident->code); ?>" class="dropdown-item mb-2">
                          Gerenciar usuário
                      </a>
                    </li> 
                    
                    <li>
                      <?php echo form_open(
                        action: route_to('residents.destroy', $resident->code),
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