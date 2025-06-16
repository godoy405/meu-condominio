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
            </div>
            <div class="card-body px-0 pt-0 pb-2">
             
            </div>
          </div>
        </div>
      </div>
     

<?php echo $this->endSection(); ?>


<?php echo $this->section('js'); ?>

<?php echo $this->endSection(); ?>