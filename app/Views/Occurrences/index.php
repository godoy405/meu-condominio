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
            <?php if(auth()->user()->inGroup('user')): ?>
              <a href="<?php echo route_to('occurrences.new'); ?>" class="btn btn-success float-end">
                <i class="fas fa-plus"></i>&nbsp;Nova
              </a>
            <?php endif?>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table id="table" class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Código</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Título</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Atualizada</th>
                      <th class="text-secondary opacity-7"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach($occurrences as $occurrence): ?>
                    <tr>
                      <td>
                        <div class="d-flex px-2 py-1">                          
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm"><?php echo $occurrence->code; ?></h6>
                            <p class="text-xs text-secondary mb-0">Criada: <?php echo $occurrence->created_at->humanize(); ?></p>
                          </div>
                        </div>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0"><?php echo ellipsize($occurrence->title, 50); ?></p>                        
                      </td>                      
                      <td class="align-middle text-center">
                      <span class="text-secondary font-weight-bold text-xs"><?php echo $occurrence->status(); ?></span>
                      </td>
                      <td class="align-middle text-center">
                      <span class="text-secondary font-weight-bold text-xs"><?php echo $occurrence->updated_at->humanize(); ?></span>
                      </td>
                      <td class="align-middle text-center">
                        <a href="<?php echo route_to('occurrences.show', $occurrence->code) ?>" class="btn btn-sm btn-dark" data-toggle="tooltip" data-original-title="Detalhes">
                          Detalhes
                        </a>
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