<?php echo $this->extend('Layouts/main'); ?>

<?php echo $this->section('title'); ?>

<?php echo $title ?>

<?php echo $this->endSection(); ?>

<?php echo $this->section('css'); ?>

<link href="https://cdn.datatables.net/v/bs5/jq-3.7.0/dt-2.2.2/r-3.0.3/datatables.min.css" rel="stylesheet">

<?php echo $this->endSection(); ?>

<?php echo $this->section('content'); ?>

<div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6><?php echo $title; ?></h6>
              <?php if(auth()->user()->inGroup('user')):?>
                <a href="<?php echo route_to('visits.new'); ?>" class="btn btn-success float-end">
                  <i class="fas fa-plus"></i>&nbsp;Nova
                </a>
              <?php endif ?>  
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table id="table" class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Código</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Residente</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Foi usada</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Válida até</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Criada</th>
                      <th class="text-secondary opacity-7"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach($visits as $visit): ?>
                    <tr>
                      <td>
                        <div class="d-flex px-2 py-1">                          
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm"><?php echo $visit->code; ?></h6>
                            <p class="text-xs text-secondary mb-0">Quem: <?php echo $visit->name; ?></p>
                          </div>
                        </div>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0"><?php echo $visit->resident; ?></p>                        
                      </td>                      
                      <td>
                        <div class="d-flex px-2 py-1">                          
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm"><?php echo $visit->used(); ?></h6>
                            <p class="text-xs text-secondary mb-0">Quando: <?php echo $visit->usedIn; ?></p>
                          </div>
                        </div>
                      </td>
                      <td>
                        <div class="d-flex px-2 py-1">                          
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm"><?php echo $visit->valid_until; ?></h6>
                            <p class="text-xs text-secondary mb-0">Válida: <?php echo $visit->isValid() ? 'Sim' : 'Inválida'; ?></p>
                          </div>
                        </div>
                      </td>
                      <td class="align-middle">
                        <span class="text-secondary"><?php echo $visit->created_at->humanize(); ?></span>                          
                      </td>
                      <td class="align-middle text-center">
                        <?php if($visit->canBeDeleted()): ?>
                          <?php echo form_open(
                                    action: route_to('visits.destroy', $visit->code),
                                    attributes: ['onsubmit' => 'return confirm("Tem certeza ?");'],
                                    hidden: ['_method' => 'DELETE']
                                ); ?>
                                <button type="submit" class="btn btn-danger">
                                    Excluir
                                </button>  
                          <?php echo form_close();?>      
                        <?php endif; ?>  
                      </td>
                    </tr>
                    <?php endforeach ?>              
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

      

<?php echo $this->endSection(); ?>


<?php echo $this->section('js'); ?>

<script src="https://cdn.datatables.net/v/bs5/jq-3.7.0/dt-2.2.2/r-3.0.3/datatables.min.js"></script>

<script>
  $('#table').DataTable({
    order: [],
  });
</script>

<?php echo $this->endSection(); ?>