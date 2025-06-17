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
              <a href="<?php echo route_to('announcements.new'); ?>" class="btn btn-success float-end">
                <i class="fas fa-plus"></i>&nbsp;Novo anúncio
              </a>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <?php if(empty($announcements)):?>
                <div class="alert alert-light text-center">Aqui serão exibidos os anúncios</div>
              <?php endif; ?>

              <div class="row">
                <?php foreach($announcements as $announcement):?>
                  <div class="col-lx-3 col-md-6 mb-lx-0 mb-4">
                    <div class="card shadow-lg border">
                      <div class="card-body p-3">
                        <a href="<?php echo route_to('announcements.show', $announcement->code); ?>"> 
                          <h5><?php echo ellipsize($announcement->title, 30); ?></h5>                         
                        </a>
                        <p class="mb-4 text-sm">
                          <?php echo ellipsize($announcement->content, 40); ?>
                        </p>
                        <div class="d-flex align-items-center justify-content-between">
                          <a class="btn btn-dark btn-sm mb-0" href="<?php echo route_to('announcements.show', $announcement->code); ?>"> 
                              Detalhes                  
                          </a>
                          <small><?php echo $announcement->created_at->humanize(); ?></small>
                        </div>
                      </div>>  
                    </div>>    
                  </div>      
                <?php endforeach; ?>        
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