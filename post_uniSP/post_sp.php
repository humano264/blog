<div class="container">
        <div class="row" style="min-height: 500px;">
            <div class="col-md-10" style="padding-top: 50px;">
                <h2>Página Inicial</h2>

                <?php
                include '../includes/busca.php';
                ?>

                <?php
                date_default_timezone_set("America/Sao_Paulo");
                require_once '../includes/funcoes.php';
                require_once '../core/conexao_mysql.php';
                require_once '../core/sql.php';
                require_once '../core/mysql.php';

                foreach ($_GET as $indice => $dado) {
                    $$indice = limparDados($dado);
                }

                $data_atual = date('Y-m-d H:i:s');

                $criterio = [
                    ['data_postagem', '<=', $data_atual]
                ];

                if (!empty($busca)) {
                    $criterio[] = [
                        'AND',
                        'titulo',
                        'like',
                        "%{$busca}%"
                    ];
                }

                $posts = buscar(
                    'post',
                    [
                        'titulo',
                        'data_postagem',
                        'id',
                        'sig',
                        ' (select nome 
                                from usuario
                                where usuario.id = post.usuario_id) as nome'
                    ],
                    $criterio,
                    'data_postagem DESC'
                );
                
                ?>

                <div>
                    <div class="list-group">
                        <?php
                         if ($posts['sig'] == 'sp'){
                        foreach ($posts as $post) :
                            $data = date_create($post['data_postagem']);
                            $data = date_format($data, 'd/m/Y H:i:s');
                        ?>
                            <a class="list-group-item list-group-item-action" href="post_detalhe.php?post=<?php echo $post['id'] ?>">
                                <strong><?php echo $post['titulo'] ?></strong>
                                [<?php echo $post['nome'] ?>]
                                <span class="badge badge-dark"><?php echo $data ?></span>
                            </a>
                        <?php endforeach; }; ?>
                    </div>
 
                </div>
            </div>
        </div>