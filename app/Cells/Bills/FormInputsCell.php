<div class="mb-3">
    <label for="amount">Valor da Cobrança</label>
    <input type="text" class="form-control price_formatted" name="amount" value="<?php echo old('amount', $bill?->amount); ?>" id="amount" />
</div>

<div class="mb-3">
    <label for="due_date">Data de vencimento</label>
    <input type="date" class="form-control" name="due_date" value="<?php echo old('due_date', $bill?->due_date?->format('Y-m-d')); ?>" id="due_date" />
</div>

<div class="mb-3">
    <label for="status">Status do pagamento</label>
    <select name="status" id="status" class="form-control" required>
        <option value="">---Escolha---</option>
        <option value="paid" <?php echo $bill?->isPaid() ? 'selected' : ''; ?> >Pago</option>
        <option value="pending" <?php echo !$bill?->isPaid() ? 'selected' : ''; ?> >Pendente</option>
    </select>
</div>

<div class="mb-3">
    <label for="notes">Observações da cobrança</label>
    <textarea name="notes" id="notes" rows="5" class="form-control"><?php echo old('notes', $bill?->notes); ?></textarea>
</div>