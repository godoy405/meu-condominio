<?php echo $this->extend('Layouts/main'); ?>

<?php echo $this->section('title'); ?>
<?php echo $title; ?>
<?php echo $this->endSection(); ?>

<?php echo $this->section('css'); ?>

<?php echo $this->endSection(); ?>

<?php echo $this->section('content'); ?>


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0"><?php echo $title; ?></h5>
            </div>
            <div class="card-body">

                <?php if (empty($notifications)): ?>

                    <div class="alert alert-light text-center" role="alert">
                        <h4 class="alert-heading">As notificações serão exibidas aqui.</h4>
                    </div>


                <?php else: ?>

                    <div class="row">

                        <?php foreach ($notifications as $notification): ?>

                            <div class="col-xl-3 col-md-6 mb-xl-0 mb-4">
                                <div class="card shadow-lg border">
                                    <div class="card-body p-3">
                                        <a href="javascript:;" class="btn-notification" data-notification="<?php echo htmlspecialchars(json_encode($notification), ENT_QUOTES, 'UTF-8'); ?>">
                                            <h5>
                                                <?php echo ellipsize($notification->title, 30); ?>
                                            </h5>
                                        </a>
                                        <p class="mb-4 text-sm">
                                            <?php echo ellipsize($notification->message, 40); ?>
                                        </p>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <button type="button" class="btn-notification btn btn-outline-primary btn-sm mb-0" data-notification="<?php echo htmlspecialchars(json_encode($notification), ENT_QUOTES, 'UTF-8'); ?>">Detalhes</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php endforeach; ?>


                        <!-- Modal -->
                        <div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="notificationModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="notificationModalLabel">Detalhes da Notificação</h5>
                                        <button type="button" class="btn-close bg-secondary" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <h6 id="modalTitle"></h6>
                                        <p id="modalCreatedAt"></p>
                                        <p id="modalReadAt"></p> <!-- Lida em: DD/MM/YYYY HH:MM:SS -->
                                        <p id="modalMessage"></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                <?php endif; ?>

            </div>
        </div>
    </div>
</div>

<?php echo $this->endSection(); ?>


<?php echo $this->section('js'); ?>

<script>
    // Seleciona todos os botões de detalhes
    const detailButtons = document.querySelectorAll('.btn-notification');

    // Verifica se existem botões de detalhes
    if (detailButtons) {
        // Adiciona o evento de clique para cada botão
        detailButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Recupera a notificação como um objeto JSON
                const notification = JSON.parse(this.getAttribute('data-notification'));

                // Atualiza o conteúdo do modal com os dados da notificação
                document.getElementById('modalTitle').innerHTML = notification.title + ' <br>#' + notification.code;
                document.getElementById('modalMessage').innerHTML = notification.message;

                const createdAt = new Date(notification.created_at.date);
                const formattedDate = createdAt.toLocaleDateString('pt-BR'); // DD/MM/YYYY
                document.getElementById('modalCreatedAt').innerHTML = `Criada em: ${formattedDate}`;

                // Verifica se a notificação já foi lida e armazena a data de leitura apenas na primeira vez
                const storedReadTime = localStorage.getItem(`notification_${notification.code}`);

                if (!storedReadTime) {
                    // Armazenamos a data/hora da leitura no localStorage apenas se não existir
                    localStorage.setItem(`notification_${notification.code}`, new Date().toISOString());
                }

                // Recupera o momento da leitura do localStorage
                const readTime = localStorage.getItem(`notification_${notification.code}`);
                if (readTime) {
                    const readDate = new Date(readTime);
                    // Exclui os segundos na hora
                    const readFormattedDate = readDate.toLocaleDateString('pt-BR') + ' ' + readDate.toLocaleTimeString('pt-BR', {
                        hour: '2-digit',
                        minute: '2-digit'
                    }); // Exclui os segundos
                    document.getElementById('modalReadAt').innerHTML = `Lida em: ${readFormattedDate}`;
                }

                // Exibe o modal
                const modal = new bootstrap.Modal(document.getElementById('notificationModal'));
                modal.show();
            });
        });
    }
</script>


<?php echo $this->endSection(); ?>