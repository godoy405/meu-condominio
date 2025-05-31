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
              <a href="<?php echo route_to('residents.new'); ?>" class="btn btn-success float-end">
                <i class="fas fa-plus"></i>&nbsp;Novo
              </a>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table id="table" class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Residente</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Telefone</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Apartamento</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Criado</th>
                      <th class="text-secondary opacity-7"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach($residents as $resident): ?>
                    <tr>
                      <td>
                        <div class="d-flex px-2 py-1">                          
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm"><?php echo $resident->name; ?></h6>
                            <p class="text-xs text-secondary mb-0"><?php echo $resident->code; ?></p>
                          </div>
                        </div>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0"><?php echo $resident->mobile_phone; ?></p>                        
                      </td>
                      <td class="align-middle text-center text-sm">
                        <span class="badge badge-sm bg-gradient-success"><?php echo $resident->apartment; ?></span>
                      </td>
                      <td class="align-middle text-center">
                      <span class="text-secondary font-weight-bold text-xs"><?php echo $resident->created_at->humanize(); ?></span>
                      </td>
                      <td class="align-middle text-center">
                        <a href="<?php echo route_to('residents.show', $resident->code) ?>" class="btn btn-sm btn-dark" data-toggle="tooltip" data-original-title="Detalhes">
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