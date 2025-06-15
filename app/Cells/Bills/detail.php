<p><strong>Status: </strong><?php echo $bill?->status(); ?></p>
<p><strong>Valor: </strong><?php echo $bill?->amount(); ?></p>
<p><strong>Data de vencimento: </strong><?php echo $bill?->dueDate(); ?></p>
<p><strong>Criada: </strong><?php echo $bill?->created_at?->humanize(); ?></p>
<p><strong>Atualizada: </strong><?php echo $bill?->updated_at?->humanize(); ?></p>
<p><strong>Observações: </strong><?php echo $bill?->notes(); ?></p>
