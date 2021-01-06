<?php

return [

    'bans'            => [
        'listing' => [
            'table' => [
                'col1' => 'ID',
                'col2' => 'Игра',
                'col3' => 'Игрок',
                'col4' => 'Админ',
                'col5' => 'Статус',
                'col6' => 'Забанен',
                'col7' => 'Истекает',
                'col8' => 'По',
                'col9' => 'Причина',
            ],
        ],
        'edit'    => [
            'fields'  => [
                'field1'  => 'Игрок',
                'field2'  => 'Админ',
                'field3'  => 'Заметка',
                'field4'  => 'Причина',
                'field5'  => 'Сервер',
                'field6'  => 'Дата и время',
                'field7'  => 'Статус',
                'field8'  => 'Тип',
                'field9'  => 'По GUID',
                'field10' => 'По имени',
                'field11' => 'По IP',
            ],
            'buttons' => [
                'submit'  => [
                    'text1' => 'Применить изменения',
                    'text2' => 'Пожалуйста ждите...',
                    'text3' => 'Разбанить',
                ],
                'cancel'  => 'Отмена',
                'profile' => 'Вернуться к профилю игрока',
            ],
        ],
        'prompts' => [
            'unban' => [
                'request_failed' => 'Ошибка запроса. Попробуйте позже.',
                'reason'         => 'Введите причину разбана',
                'notes'          => 'Хотите ли вы обновить заметку бана?\nНажмите "Отмена", чтобы оставить текущую заметку.',
            ],
        ],
    ],
    'special_players' => [
        'listing' => [
            'table' => [
                'col1' => 'ID',
                'col2' => 'Игра',
                'col3' => 'Игрок',
                'col4' => 'Группа',
                'col5' => 'Создан',
                'col6' => 'Истекает',
            ],
        ],
    ],
    'users'           => [
        'no_soldiers' => 'Нет ассоциированных солдатов.',
        'no_users'    => 'Пользователи не найдены.',
        'soldiers'    => 'Солдаты',
        'listing'     => [
            'buttons' => [
                'create' => 'Добавить пользователя',
            ],
            'table'   => [
                'col1' => 'Пользователь',
                'col2' => 'Email',
                'col3' => 'Группа',
                'col4' => 'Истекает',
                'col5' => 'Солдаты',
                'col6' => 'Заметки',
            ],
        ],
        'edit'        => [
            'details' => 'Детали',
            'buttons' => [
                'save'   => 'Сохранить изменения',
                'cancel' => 'Отмена',
                'delete' => 'Удалить пользователя',
            ],
            'inputs'  => [
                'username'   => [
                    'label' => 'Имя',
                ],
                'email'      => [
                    'label' => 'Email',
                ],
                'role'       => [
                    'label' => 'Группа',
                ],
                'expiration' => [
                    'label' => 'Истекает',
                    'help'  => 'Оставьте поле пустым, чтобы применить стандартный срок.',
                ],
                'notes'      => [
                    'label' => 'Заметки',
                ],
                'soldiers'   => [
                    'label' => 'ID солдатов',
                    'help'  => 'Перечислите ID солдатов через запятую, чтобы ассоциировать их с данным игроком.',
                ],
                'soldier'    => [
                    'label' => 'Имя игрока',
                    'help'  => 'Введите имя игрока в Battlelog, чтобы автоматически добавить ID его солдатов.',
                ],
            ],
            'table'   => [
                'col1' => 'ID',
                'col2' => 'Игра',
                'col3' => 'Имя',
            ],
        ],
    ],

];
