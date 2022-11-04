<?php

return [

    'success' => [
        'create'       => 'Cadastrado com sucesso',
        'update'       => 'Atualizado com sucesso',
        'delete'       => 'Excluído com sucesso',
        'exclude'      => 'Excluído permanentemente com sucesso',
        'recover'      => 'Reativado com sucesso',
        'disable'      => 'Desativado com sucesso',
        'operation'    => 'Operação realizada com sucesso',
        'delete-many'  => 'Excluídos com sucesso',
        'recover-many' => 'Reativados com sucesso',
        'undo-exclude' => 'Movido para excluidos com sucesso',
    ],

    'error' => [
        'list'         => 'Não foi possível obter os registros',
        'create'       => 'Não foi possível cadastrar',
        'update'       => 'Não foi possível atualizar',
        'delete'       => 'Não foi possível excluir',
        'exclude'      => 'Não foi possível excluir permanentemente',
        'recover'      => 'Não foi possível reativar',
        'disable'      => 'Não foi possível desativar',
        'operation'    => 'Não foi possível realizar a operação',
        'not-found'    => 'Não foi possível encontrar o :name solicitado',
        'delete-many'  => 'Não foi possível excluir os itens selecionados',
        'recover-many' => 'Não foi possível reativar os itens selecionados',
        'undo-exclude' => 'Não foi possível mover para excluidos',
        'limit'        => 'Não foi possível realizar a operação, limite contratado atingido',
    ],

    'gate' => [
        'vehicle'  => 'Acesso negado! Este veículo não faz parte do seu estoque.',
        'category' => 'Acesso negado! Está categoria não está relacionado a sua empresa.',
    ],
];
