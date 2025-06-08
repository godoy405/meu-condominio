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
            <div class="card-body">
            <?php echo form_open(
                    action: $route,
                    attributes: ['class' => 'd-inline', 'id' => 'form'],
                    hidden: $hidden ?? []
            ); ?>
            <div class="mb-3">
                <label for="area_id">Área delazer</label>
                <select name="area_id" id="area_id" class="form-control" required>
                    <option value="">--- Escolha ---</option>
                    <?php foreach($areas as $area):?>
                    <option value="<?php echo $area->id; ?>" >
                        <?php echo $area->name; ?>
                    </option>
                    <?php endforeach;?>
                </select>                
            </div>

            <div class="mb-3">
                <label for="desired_date">Data e hora de ínicio da reserva</label>
                <input type="datetime-local" class="form-control" required name="desired_date" value="<?php echo old('desired_date', $reservation->desired_date) ?>" id="desired_date">
            </div>
            <div class="mb-3">
                <label for="notes">Obeservações</label>  
                <textarea name="notes" id="notes" class="form-control" rows="5"><?php echo old('notes', $reservation->notes);?></textarea>              
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