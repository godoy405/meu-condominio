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
                <h5 class="card-title mb-2"><?php echo $title; ?></h5>
                <a href="<?php echo route_to('announcements'); ?>" class="btn btn-outline-secondary"><i class="fas fa-angle-double-left"></i> Listar anúncios</a>
                <?php if(auth()->user()?->inGroup('user')) : ?>
                    <a href="<?php echo route_to('announcements.new'); ?>" class="btn btn-success ms-2"><i class="fas fa-plus"></i> Novo</a>
                <?php endif; ?>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link me-2 active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Anúncio</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Comentários</button>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
                        <h2><?php echo $announcement->title; ?></h2>
                        <p>Publicado: <?php echo $announcement->created_at->humanize(); ?></p>
                        <p>Author: <?php echo $announcement->author(); ?></p>
                        <p>
                            <?php echo $announcement->content; ?>
                        </p>
                        <?php if ($announcement->canBeDeleted()): ?>
                            <?php echo form_open(
                                action: route_to('announcements.destroy', $announcement->code),
                                attributes: ['class' => 'mt-3 mb-4', 'onsubmit' => 'return confirm("Tem certeza que deseja excluir esse registro?")'],
                                hidden: ['_method' => 'DELETE']
                            ); ?>
                            <!-- Usamos esse input para atualizar o CSRF Token para permitir o envio do form de exclusão -->
                            <!-- Nesse mesmo DOM temos formulário de comentários e precisamos atualizar o token -->
                            <input type="hidden" class="csrf_input" autocomplete="off" name="<?php echo csrf_token(); ?>" value="<?php echo csrf_hash(); ?>">
                            <button type="submit" class="btn btn-danger">Excluir</button>
                            <?php echo form_close(); ?>
                        <?php endif; ?>
                    </div>
                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">
                        <h6>Comentários</h6>
                        <?php if(auth()->user()?->inGroup('user')) : ?>
                            <?php echo form_open(
                                action: route_to('announcements.comments.create', $announcement->code),
                                attributes: ['id' => 'form-comment']
                            ); ?>
                            <div class="mb-3">
                                <textarea name="comment" class="form-control" placeholder="Escreva seu comentário" required id="comment" rows="3"></textarea>
                            </div>
                            <!-- Usamos esse input para atualizar o CSRF Token para permitir o envio do form do comentário -->
                            <input type="hidden" class="csrf_input" autocomplete="off" name="<?php echo csrf_token(); ?>" value="<?php echo csrf_hash(); ?>">
                            <button type="submit" id="btnSubmitComment" class="btn btn-sm btn-dark badge">Publicar</button>
                            <?php echo form_close(); ?>
                        <?php endif; ?>                       
                        <div id="list-comments" class="mt-5">
                            <?php foreach ($announcement->comments as $comment): ?>
                                <div class="card shadow-lg mb-2">
                                    <div class="card-body">
                                        <p class="mb-0"><?php echo $comment->comment; ?></p>
                                        <small class="text-muted">
                                            <?php echo $comment->created_at; ?>
                                            por <?php echo $comment->author; ?>
                                        </small>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $this->endSection(); ?>

<?php echo $this->section('js'); ?>
<script>
    const formComment = document.getElementById('form-comment');
    const listComments = document.getElementById('list-comments');

    // Event listener para o envio do formulário de comentário
    formComment.addEventListener('submit', function(event) {
        event.preventDefault(); // Evita o envio padrão do formulário

        const commentData = new FormData(formComment); // Cria um objeto FormData com os dados do formulário

        // Envia os dados usando a Fetch API
        fetch(formComment.action, {
                method: 'POST',
                body: commentData, // Dados do formulário
                headers: {
                    'Accept': 'application/json', // Indica que queremos receber uma resposta JSON
                }
            })
            .then(response => response.json()) // Converte a resposta para JSON
            .then(data => {
                // Atualiza o token CSRF em todos os inputs com a classe `csrf_input`
                // pois temos formulário de comentário e de excluusão de anúncio
                const csrfInputs = document.querySelectorAll('.csrf_input'); // Seleciona todos os inputs com a classe `.csrf_input`
                csrfInputs.forEach(input => {
                    input.value = data.token; // Atualiza o valor do token
                });

                if (!data.success) {
                    throw new Error("Erro ao enviar o comentário");
                }

                Toastify({
                    text: 'Sucesso!',
                    duration: 10000,
                    close: true,
                    gravity: "top",
                    position: 'right',
                    backgroundColor: '#4fbe87'
                }).showToast();

                // Cria um novo item de lista com o novo comentário
                const newComment = document.createElement('div');
                newComment.className = 'card shadow-lg mb-2';
                newComment.innerHTML = `
                    <div class="card-body">
                        <p class="mb-0">${data.comment.comment}</p>
                        <small class="text-muted">
                            ${data.comment.created_at} por ${data.comment.resident}
                        </small>
                    </div>
                `;

                // Adiciona o novo comentário no começo da lista de comentários
                listComments.prepend(newComment);

                // Limpa o campo de texto
                document.getElementById('comment').value = '';
            })
            .catch(error => {
                console.error('Erro ao postar o comentário:', error);

                Toastify({
                    text: 'Erro ao postar o comentário',
                    duration: 10000,
                    close: true,
                    gravity: "bottom",
                    position: 'left',
                    backgroundColor: '#dc3454'
                }).showToast();
            });
    });
</script>
<?php echo $this->endSection(); ?>