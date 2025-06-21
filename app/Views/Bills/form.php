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

                <?php if ($bill->code === null): ?>
                    <a href="<?php echo route_to('bills'); ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-angle-double-left"></i>&nbsp;Listar cobranças
                    </a>
                <?php else: ?>
                    <a href="<?php echo route_to('bills.show', $bill->code); ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-angle-double-left"></i>&nbsp;Detalhes da Cobrança
                    </a>
                <?php endif; ?>
            </div>
            <div class="card-body">
            <?php echo form_open(
                    action: $route,
                    attributes: ['class' => 'd-inline', 'id' => 'form'],
                    hidden: $hidden ?? []
            ); ?>
            
            <div class="mb-3">
                <label for="resident_id">Residente</label>
                <select name="resident_id" id="resident_id" class="form-control" required>
                    <option value="">---Escolha um residente---</option>
                    <?php foreach($residents as $resident): ?>
                        <option value="<?php echo $resident->id ?>" <?php echo old('resident_id', $bill->resident_id) == $resident->id ? 'selected' : '' ?>>
                            <?php echo $resident->name ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="mb-3">
                <label for="amount">Valor da Cobrança</label>
                <input type="text" class="form-control price_formatted" name="amount" value="<?php echo old('amount', $bill->amount); ?>" id="amount" />
            </div>

            <div class="mb-3">
                <label for="due_date">Data de vencimento</label>
                <input type="date" class="form-control" name="due_date" value="<?php echo old('due_date', $bill->due_date?->format('Y-m-d')); ?>" id="due_date" />
            </div>

            <div class="mb-3">
                <label for="status">Status do pagamento</label>
                <select name="status" id="status" class="form-control" required>
                    <option value="">---Escolha---</option>
                    <option value="paid" <?php echo $bill->isPaid() ? 'selected' : ''; ?> >Pago</option>
                    <option value="pending" <?php echo !$bill->isPaid() ? 'selected' : ''; ?> >Pendente</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="notes">Observações da cobrança</label>
                <textarea name="notes" id="notes" rows="5" class="form-control"><?php echo old('notes', $bill->notes); ?></textarea>
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