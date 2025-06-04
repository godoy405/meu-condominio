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
                    <a href="<?php echo route_to('residents.show', $resident->code); ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-angle-double-left"></i>&nbsp;Detalhes do residente
                    </a>  
                    
                    <?php if($resident?->user !== null):?>
                        <?php echo form_open(
                                    action: route_to('residents.user.action', $resident->code),
                                    attributes: ['class' => 'd-inline'],
                                    hidden: ['_method' => 'PUT']
                                ); ?>

                                <?php $isBanned = $resident?->user?->isBAnned();?>
                                <button type="submit" class="btn ms-2 btn-<?php echo $isBanned ? 'primary' : 'danger'; ?>">
                                <?php echo $isBanned ? 'Liberar' : 'Bloquear'; ?>&nbsp; acesso
                                </button>  
                                <?php echo form_close();?>   
                    <?php endif;?>

            </div>
            <div class="card-body">
            <?php echo form_open(
                    action: $route,
                    attributes: ['class' => 'd-inline', 'id' => 'form'],
                    hidden: $hidden ?? []
            ); ?>
            <div class="mb-3">
                <label for="email">E-mail de acesso</label>
                <input type="email" class="form-control" required name="email" value="<?php echo old('email', $resident?->user?->email) ?>" id="email" placeholder="E-mail de acesso">
            </div>

            <div class="mb-3">
                <label for="password">Senha <?php echo $resident?->user !== null ? '(opcional)'  : ''; ?></label>
                <input type="password" class="form-control" <?php echo $resident?->user == null ? 'required'  : ''; ?> name="password" id="password" placeholder="Senha de acesso">
            </div>

            <div class="mb-3">
                <label for="password_confirm">Confirme a senha </label>
                <input type="password" class="form-control" name="password_confirm" id="password_confirm" placeholder="Confirme a senha">
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