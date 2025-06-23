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
                <a href="<?php echo route_to('occurrences'); ?>" class="btn btn-outline-secondary"><i class="fas fa-angle-double-left"></i> Listar ocorrências</a>

                <!-- Só user (residente) pode criar uma nova ocorrência -->
                <?php if (auth()->user()->inGroup('user')) : ?>
                    <a href="<?php echo route_to('occurrences.new'); ?>" class="btn btn-success ms-2"><i class="fas fa-plus"></i> Nova</a>
                <?php endif; ?>
            </div>
            <div class="card-body">

                <ul class="nav nav-tabs mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link me-2 active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Ocorrência</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Atualizações</button>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">

                        <h2><?php echo $occurrence->title; ?></h2>

                        <p>Criada: <?php echo $occurrence->created_at->humanize(); ?></p>
                        <p>Autor: <?php echo $occurrence->resident->name; ?></p>

                        <p>
                            Status: <span id="status"><?php echo $occurrence->status(); ?></span>
                        </p>
                        <p>
                            <?php echo $occurrence->description; ?>
                        </p>

                        <?php if($occurrence->isClosed()): ?>
                            <p>
                                <strong>Solução aplicada:  </strong><?php echo $occurrence->solution; ?>
                            </p>
                        <?php endif; ?>                        

                        <?php if ($occurrence->permitAction()): ?>
                            <a href="<?php echo route_to('occurrences.resolve', $occurrence->code); ?>" class="btn btn-dark"><i class="fas fa-check"></i> Resolver</a>
                        <?php endif; ?>

                    </div>

                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">

                        <h6>Atualizações</h6>

                        <?php if ($occurrence->permitAction()): ?>

                            <?php echo form_open(
                                action: route_to('occurrences.updates.create', $occurrence->code),
                                attributes: ['id' => 'form-updates'],
                            ); ?>

                            <div class="mb-3">
                                <textarea name="description" class="form-control" placeholder="Descreva" required id="description" rows="3"></textarea>
                            </div>

                            <!-- Usamos esse input para atualizar o CSRF Token para permitir o envio do form do atualização -->
                            <input type="hidden" class="csrf_input" autocomplete="off" name="<?php echo csrf_token(); ?>" value="<?php echo csrf_hash(); ?>">


                            <button type="submit" id="btnSubmitUpdate" class="btn btn-sm btn-dark badge">Salvar</button>

                            <?php echo form_close(); ?>


                        <?php endif; ?>


                        <div id="list-updates" class="mt-5">
                            <?php foreach ($occurrence->updates as $update): ?>
                                <div class="card shadow-lg mb-2">
                                    <div class="card-body">
                                        <p class="mb-0"><?php echo $update->description; ?></p>
                                        <small class="text-muted">
                                            <?php echo $update->created_at; ?>
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
    // Captura o formulário de atualização e o botão de envio
    const formUpdates = document.getElementById('form-updates');
    const listUpdates = document.getElementById('list-updates');

    // Verifica se o formulário de atualização existe
    if (formUpdates) {

        // Event listener para o envio do formulário de atualização
        formUpdates.addEventListener('submit', function(event) {
            event.preventDefault(); // Evita o envio padrão do formulário

            const formData = new FormData(formUpdates); // Cria um objeto FormData com os dados do formulário

            console.log(formUpdates.action);

            // Envia os dados usando a Fetch API
            fetch(formUpdates.action, {
                    method: 'POST',
                    body: formData, // Dados do formulário
                    headers: {
                        'Accept': 'application/json', // Indica que queremos receber uma resposta JSON
                    }
                })
                .then(response => response.json()) // Converte a resposta para JSON
                .then(data => {

                    // Atualiza o token CSRF em todos os inputs com a classe `csrf_input`
                    const csrfInputs = document.querySelectorAll('.csrf_input'); // Seleciona todos os inputs com a classe `.csrf_input`
                    csrfInputs.forEach(input => {
                        input.value = data.token; // Atualiza o valor do token
                    });

                    if (!data.success) {
                        throw new Error("Erro ao enviar o atualização");
                    }

                    Toastify({
                        text: 'Sucesso!',
                        duration: 10000,
                        close: true,
                        gravity: "top",
                        position: 'right',
                        backgroundColor: '#4fbe87'
                    }).showToast();

                    // Cria um novo item de lista com a nova atualização
                    const newUpdate = document.createElement('div');
                    newUpdate.className = 'card shadow-lg mb-2';
                    newUpdate.innerHTML = `
                            <div class="card-body">
                                <p class="mb-0">${data.update.description}</p>
                                <small class="text-muted">
                                    ${data.update.created_at}
                                </small>
                            </div>
                        `;

                    // Adiciona o novo atualização no começo da lista de atualizaçãos
                    listUpdates.prepend(newUpdate);

                    // Limpa o campo de texto
                    document.getElementById('description').value = '';

                })
                .catch(error => {
                    console.error('Erro ao postar o atualização:', error);

                    Toastify({
                        text: 'Erro ao postar o atualização',
                        duration: 10000,
                        close: true,
                        gravity: "bottom",
                        position: 'left',
                        backgroundColor: '#dc3454'
                    }).showToast();

                });
        });
    }
</script>

<?php echo $this->endSection(); ?>