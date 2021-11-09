<?php

return [
    'edit'      => [
        'title'                   => 'Профиль',
        'profile'                 => 'Профиль',
        'account'                 => 'Аккаунт',
        'patreon'                 => 'Patreon',
        'change_password'         => 'Сменить пароль',
        'privacy'                 => 'Конфиденциальность',
        'reports'                 => 'Жалобы',
        'menu_title'              => '%s\'s профиль',
        'avatar'                  => 'Аватар',
        'avatar_title'            => 'Аватар пользователя',
        'username'                => 'Имя пользователя',
        'username_title'          => 'Поскольку вы вошли в систему с помощью внешней службы аутентификации, вы можете изменить свое имя пользователя один раз.',
        'email'                   => 'Электронный адрес',
        'region'                  => 'Регион',
        'select_region'           => 'Выбрать регион',
        'show_as_anonymous'       => 'Отображать как аноним',
        'show_as_anonymous_title' => 'Включение этой опции будет отображать вас как анонима при просмотре маршрутов, которые не являются частью какой-либо команды, частью которой вы являетесь.
                             Для ваших собственных маршрутов и для маршрутов, входящих в состав ваших команд, ваше имя всегда будет видно.',
        'echo_color'              => 'Синхронизация редактирования цвета маршрута',
        'echo_color_title'        => 'При редактировании маршрута совместно с членом команды этот цвет будет идентифицировать вас.',
        'save'                    => 'Сохранить',

        'account_delete_consequences'                      => 'Если вы удалите свою учетную запись Keystone.guru, произойдет следующее:',
        'account_delete_consequence_routes'                => 'Маршруты',
        'account_delete_consequence_routes_delete'         => 'Ваш %s маршрут(ы) будут удален.',
        'account_delete_consequence_teams'                 => 'Команды',
        'account_delete_consequence_teams_you_are_removed' => 'Вы будете удалены из этой команды.',
        'account_delete_consequence_teams_new_admin'       => '%s будет назначен администратором этой команды.',
        'account_delete_consequence_teams_team_deleted'    => 'Эта команда будет удалена (вы единственный пользователь в этой команде).',
        'account_delete_consequence_patreon'               => 'Связь между Patreon и Keystone.guru будет прервана. Вы больше не будете получать бонусы Patreon.',
        'account_delete_consequence_reports'               => 'Жалобы',
        'account_delete_consequence_reports_unresolved'    => 'Ваши неразрешенные жалобы (%s) будут удалены.',
        'account_delete_warning'                           => 'Ваша учетная запись будет удалена без возможности восстановления. Пути назад нет  .',
        'account_delete_confirm'                           => 'Удалить мою учетную запись на Keystone.guru',

        'unlink_from_patreon'          => 'Отменить связь с Patreon',
        'link_to_patreon_success'      => 'Ваша учетная запись привязана к Patreon. Спасибо!',
        'link_to_patreon'              => 'Ссылка на Патреон',
        'link_to_patreon_description'  => 'Чтобы получить бонусы подписчика Patreon, вам необходимо привязать свою учетную запись к Patreon.',
        'link_to_patreon_experimental' => 'Реализация Patreon находиться в экспериментальном виде. Если ваши бонусы недоступны после связывания с Patreon, свяжитесь со мной напрямую в Discord или Patreon, и я исправлю это.',

        'current_password'     => 'Текущий пароль',
        'new_password'         => 'Новый пароль',
        'new_password_confirm' => 'Подтвердить новый пароль',
        'submit'               => 'Подтвердить',

        'ga_cookies_opt_out'  => 'Отключение файлов cookie Google Analytics',
        'reports_description' => 'Здесь будут перечислены все маршруты, враги и другие отчеты, которые вы сделали на сайте.',

        'reports_table_header_id'         => 'ID',
        'reports_table_header_category'   => 'Категория',
        'reports_table_header_message'    => 'Сообщение',
        'reports_table_header_created_at' => 'Дата создания',
        'reports_table_header_status'     => 'Статус',
        'reports_table_action_handled'    => 'Обработано',
    ],
    'favorites' => [
        'title' => 'Избранное',
    ],
    'overview'  => [
        'title'                    => '@todo ru: .overview.title',
        'favorites'                => '@todo ru: .overview.favorites',
        'tags'                     => '@todo ru: .overview.tags',
        'teams'                    => '@todo ru: .overview.teams',
        'profile'                  => '@todo ru: .overview.profile',
        'welcome_text'             => '@todo ru: .overview.welcome_text',
        'create_route'             => '@todo ru: .overview.create_route',
        'create_route_description' => '@todo ru: .overview.create_route_description',
        'create_team'              => '@todo ru: .overview.create_team',
        'create_team_description'  => '@todo ru: .overview.create_team_description',

    ],
    'routes'    => [
        'title' => 'Мои маршруты',
    ],
    'tags'      => [
        'title'                             => 'Мои теги',
        'header'                            => 'Мои теги',
        'description'                       => 'Функция маркировки позволяет вам организовать свои маршруты так, как вы считаете нужным. Вы можете добавлять теги к маршрутам, просматривая Действия для каждого маршрута в %s. Здесь вы можете управлять тегами для своих маршрутов. Никто другой не сможет просматривать ваши теги - для маршрутов, прикрепленных к группе, вы можете управлять отдельным набором тегов только для этой группы, посетив раздел Теги при просмотре своей команды.',
        'link_your_personal_route_overview' => 'Просмотр вашего маршрута',
    ],
    'view'      => [
        'title'  => '%s\'s маршруты',
        'header' => '%s\'s маршруты',
    ],
];
