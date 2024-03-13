<?php

return [
    'affixgroup'   => [
        'affixgroup' => [

        ],
    ],
    'dungeon'      => [
        'griddiscover' => [
            'popular'   => 'Популярные',
            'this_week' => 'Текущая неделя',
            'next_week' => 'Следующая неделя',
            'new'       => 'Новые',
        ],
        'select'       => [
            'dungeon'                  => 'Подземелье',
            'all'                      => 'Все',
            'all_dungeons'             => 'Все подземелья',
            'all_expansion_dungeons'   => '',
            'seasons'                  => '',
            'siege_of_boralus_warning' => 'Так как подземелье Осада Боралуса отличаются для Орды и Альянса вам необходимо выбрать фракцию.',
        ],
    ],
    'dungeonroute' => [
        'search'     => [
            'loadmore' => [
                'loading' => 'Загрузка...',
            ],
        ],
        'attributes' => [
            'attributes'              => 'Атрибуты',
            'no_attributes_title'     => 'Выберите дополнительные возможности для вашей группы, с которым вам проще проходить подземелье.',
            'select_attributes_title' => 'Атрибуты описывают особенности вашего маршрута, которые другие не могут пройти из-за различий в составе группы или навыков. Правильная маркировка атрибутов позволяет другим легче находить маршруты, которые им подходят.',
            'attributes_selected'     => '{0} Атрибутов',
        ],
        'card'       => [
            'no_description'           => 'Нет описания',
            'outdated_mapping_version' => '',
            'by_author'                => 'Автор',
            'updated_at'               => 'Обновлено %s',
            'report'                   => 'Жалоба',
            'refresh_thumbnail'        => 'Обновить миниатюры',
        ],
        'cardlist'   => [
            'no_dungeonroutes' => 'Маршруты не найдены',
        ],
        'rating'     => [
            'nr_of_votes' => '%s голосов',
        ],
        'table'      => [
            'team'                  => 'Команда',
            'affixes'               => 'Аффиксы',
            'affixes_selected'      => '{0} аффиксов выбрано',
            'requirements'          => 'Требования',
            'enemy_enemy_forces'    => 'Достаточно вражеских сил',
            'favorite'              => 'Любимые',
            'requirements_selected' => '{0} требований',
            'tags'                  => 'Теги',
            'tags_title'            => 'Нет доступных тегов',
            'tags_selected'         => '{0} тегов выбрано',
            'filter'                => 'Фильтр',
        ],
        'tier'       => [
            'data_by_archon_gg' => '%s -  данные https://mplus.subcreation.net',
        ],
    ],
    'forms'        => [
        'createroute'          => [
            'title'                                          => 'Название',
            'title_title'                                    => 'Выберите заголовок, который будет отличать ваши маршрут от других аналогичных маршрутов, которые вы можете создать. Заголовок будет виден другим пользователям, как только вы опубликуете свой маршрут.',
            'dungeon_speedrun_required_npc_difficulty'       => '',
            'dungeon_speedrun_required_npc_difficulty_title' => '',
            'description'                                    => 'Описание',
            'description_title'                              => 'Необязательное описание вашего маршрута. Описание будет видно другим пользователям, как только вы опубликуете свой маршрут. Вы всегда можете изменить свое описание позже.',
            'key_levels'                                     => 'Уровень ключа',
            'key_levels_title'                               => 'Укажите, для ключей каких уровней подходит ваш маршрут. Это может помочь другим легче найти ваш маршрут.',
            'migrate_to_seasonal_type'                       => '',
            'advanced_options'                               => 'Расширенные настройки',
            'affixes'                                        => 'Аффиксы',
            'group_composition'                              => 'Состав группы',
            'admin'                                          => 'Админ',
            'demo_route'                                     => 'Демо-маршрут',
            'create_route'                                   => 'Создать маршрут',
            'save_settings'                                  => 'Сохранить настройки',
        ],
        'createtemporaryroute' => [
            'key_levels'                => '',
            'key_levels_title'          => '',
            'unregistered_user_message' => 'Если вы незарегистрированный пользователь, все созданные вами маршруты будут временными, срок действия которых истечет через %d часа.',
            'registered_user_message'   => 'Временный маршрут не будет отображаться в вашем профиле и будет автоматически удален через %d часов.',
            'create_route'              => 'Создать маршрут',
        ],
        'login'                => [
            'login'                => 'Войти',
            'email_address'        => 'Электронный адрес',
            'password'             => 'Пароль',
            'remember_me'          => 'Запомнить меня',
            'forgot_your_password' => 'Забыли пароль?',
            'login_through_oauth2' => 'Авторизация с помощью OAuth2',
        ],
        'mapsettings'          => [
            'map_facade_style'                              => '',
            'map_facade_style_title'                        => '',
            'map_facade_style_facade_option'                => '',
            'map_facade_style_split_floors_option'          => '',
            'map_facade_style_change_requires_page_refresh' => '',

            'enemies'                                => 'Враги',
            'enemy_number_style'                     => 'Стиль числа врагов',
            'enemy_number_style_title'               => 'Это управляет тем, что означают числа, когда вы наводите указатель мыши на врагов или когда вы выбираете тип отображения \'Силы врага\'.',
            'percentage'                             => 'Проценты',
            'enemy_forces'                           => 'Силы врага',
            'unkilled_enemy_opacity'                 => 'Непрозрачность невыделенных врагов',
            'unkilled_enemy_opacity_title'           => 'Эта опция позволяет вам менее заметными врагов, которые не будут частью вашего пула. Это может уменьшить количество врагов, которых вы хотите игнорировать.',
            'unkilled_important_enemy_opacity'       => 'Непрозрачность невыделенных важных врагов',
            'unkilled_important_enemy_opacity_title' => 'Важные враги - это те, которые либо Полные Гордыни, Вдохновляющие, либо отмечены как требуемые. Их можно визуализировать с другой непрозрачностью, чем у других врагов, чтобы подчеркнуть их важность, если вы уменьшите непрозрачность всех других врагов.',
            'show_aggressiveness_border'             => 'Показать агрессивных врагов',
            'show_aggressiveness_border_title'       => 'Включение этого параметра отобразит всех врагов рамкой, указывающей на их агрессивность. Красный для агрессивных врагов, желтый для нейтральных врагов, зеленый для дружественных врагов и т. Д.',
            'highlight_dangerous_enemies'            => 'Выделите опасных врагов',
            'highlight_dangerous_enemies_title'      => 'Опасные враги отмечены оранжевой внутренней границей. Keystone.guru отбирает этих врагов вручную. Эти враги - мини-боссы, обладающие большим здоровьем по сравнению с другими, использующими опасные способности или требующие особого подхода.',
            'drawing'                                => 'Рисование',
            'default_line_weight'                    => 'Толщина линии по умолчанию',
            'default_line_weight_title'              => 'Это контролирует ширину всех линий по умолчанию, которые вы создаете на карте, например, контуров и свободных линий.',
            'default_line_color'                     => 'Цвет линии по умолчанию',
            'default_line_color_title'               => 'Эта настройка отвечает за цвет по умолчанию для любых линий, которые вы рисуете на карте, например, контуры.',
        ],
        'mdtimport'            => [
            'paste_mdt_export_string'                => 'Вставьте строку экспорта Mythic Dungeon Tools',
            'reset_title'                            => 'Сброс настроек',
            'unregistered_user_all_routes_temporary' => 'Так как вы незарегистрированный пользователь, все импортированные маршруты будут временными маршрутами, срок действия которых истечет через %s часа.',
            'temporary_route'                        => 'Временный маршрут',
            'temporary_route_title'                  => 'Временный маршрут не будет отображаться в вашем профиле и будет автоматически удален через %d часов.',
            'parsing_your_string'                    => 'Разбор вашей строки MDT...',
            'import_as_this_week'                    => '',
            'import_route'                           => 'Импорт маршрута',
        ],
        'oauth'                => [
            'battletag_warning' => 'Если вы публикуете маршруты, ваше имя пользователя battletag/discord будет видно до тех пор, пока вы не измените имя пользователя в своем профиле.',
        ],
        'pullsettings'         => [
            'pull_number_style'                 => 'Стиль номера пула',
            'pull_number_style_title'           => 'Это управляет номерами ваших пулов на боковой панели',
            'pull_number_style_percentage'      => 'Проценты',
            'pull_number_style_enemy_forces'    => 'Силы врага',
            'show_floor_breakdown'              => 'Показывать на каком уровне подземелья находятся враги.',
            'show_floor_breakdown_title'        => 'Эта настройка отображает название уровня подземелья на боковой панели.',
            'pull_color_gradient'               => 'Градиент цвета для пулов',
            'pull_color_gradient_title'         => 'Установка градиента для пулов позволит Keystone.guru автоматически раскрашивать ваши пулы по градиенту. Используя эту функцию, вы можете более легко различить, какой пул принадлежит какой части маршрута, что полезно и для нелинейных маршрутов. Эта настройка уникальна для каждого маршрута.',
            'apply_now'                         => 'Применить сейчас',
            'apply_now_title'                   => 'Применить к текущему пулу',
            'always_apply_on_pull_change'       => 'Всегда применять, когда я меняю пулл',
            'always_apply_on_pull_change_title' => 'Включение этого параметра будет обновлять цвета ваших пулов, когда вы редактируете их на основе градиента пулов, настроенного выше. Эта настройка уникальна для каждого маршрута.',
        ],
        'register'             => [
            'register'                => 'Регистрация',
            'username'                => 'Имя пользователя',
            'username_title'          => 'Ваше имя пользователя будет видно, если вы решите опубликовать маршруты, которые вы создаете.',
            'email_address'           => 'Электронный адрес',
            'email_address_title'     => 'Адрес электронной почты потребуется при входе в систему. Подтверждение электронного адреса не требуется, но он будет использован, если вы забудете свой пароль, чтобы отправить вам ссылку для сброса пароля по электронной почте.',
            'select_region'           => 'Выбрать регион',
            'region'                  => 'Регион',
            'password'                => 'Пароль',
            'confirm_password'        => 'Подтвердить пароль',
            'legal_agree'             => 'Я прочитал и согласен с %s, %s и %s.',
            'register_through_oauth2' => 'Зарегистрироваться через OAuth2',
            'legal_agree_oauth2'      => 'Регистрируясь через OAuth2, вы подтверждаете, что прочитали и согласны с %s, %s и %s.',
            'terms_of_service'        => 'Условиями использования',
            'privacy_policy'          => 'Политикой конфиденциальности',
            'cookie_policy'           => 'Политикой в отношении файлов cookie',
        ],
        'timezoneselect'       => [
            'africa'     => 'Африка',
            'america'    => 'Америка',
            'antarctica' => 'Антарктида',
            'asia'       => 'Азия',
            'atlantic'   => 'Атлантика',
            'europe'     => 'Европа',
            'indian'     => 'Индия',
            'pacific'    => 'Тихоокеанский',
            'timezone'   => 'Временная зона',
        ],
    ],
    'general'      => [
        'linkpreview' => [
            'title_suffix'               => '',
            'description_suffix'         => '',
            'twitter_title_suffix'       => '',
            'twitter_description_suffix' => '',
        ],
    ],
    'group'        => [
        'affixes'     => [
            'seasonal_index_preset'    => 'Задано :count',
            'awakened_enemy_set'       => 'Набор Пробудившихся врагов',
            'awakened_enemy_set_title' => 'Пробужденных врагов (Пилары) для M+ уровней 10 и выше бывает два набора. Каждый набор аффиксов помечен буквой A или B. Вы можете прикрепить к своему маршруту несколько аффиксов, которые могут иметь наборы как A, так и B. Здесь выберите, какой набор будет отображаться на карте. Вы всегда можете изменить свой выбор в меню Настройки маршрута позже.',
            'tormented_preset'         => 'Набор Истязающих врагов',
            'tormented_preset_title'   => 'Истязающие враги для M+ уровней 10 и выше доступны в %s наборах. Вы можете прикрепить к своему маршруту несколько аффиксов, которые могут содержать любую комбинацию набора. Выберите здесь, какой набор будет отображаться на карте. Вы всегда можете изменить свой выбор в меню Настройки маршрута позже.',
        ],
        'composition' => [
            'faction'         => 'Фракция',
            'undo'            => 'Отменить',
            'party_member_nr' => 'Член группы  #%d',
        ],
    ],
    'layout'       => [
        'footer'  => [
            'developer'           => '',
            'api_documentation'   => '',
            'keystone_guru'       => '',
            'changelog'           => 'Журнал изменений',
            'changelog_new'       => 'НОВОЕ',
            'credits'             => 'Благодарности',
            'about'               => 'О нас',
            'external'            => 'Внешние ссылки',
            'patreon'             => 'Patreon',
            'discord'             => 'Discord',
            'github'              => 'Github',
            'legal'               => 'Права',
            'terms_of_service'    => 'Условия использования',
            'privacy_policy'      => 'Политика конфиденциальности',
            'cookie_policy'       => 'Политика использования файлов cookie',
            'trademark'           => 'Торговая марка',
            'trademark_footer'    => 'World of Warcraft, Warcraft и Blizzard Entertainment являются товарными знаками или зарегистрированными товарными знаками Blizzard Entertainment, Inc. в США и / или других странах. Этот веб-сайт не связан с Blizzard Entertainment ».',
            'social'              => 'Социальные сети',
            'all_rights_reserved' => '©:date :nameAndVersion - Все права защищены',
        ],
        'header'  => [
            'toggle_navigation_title' => 'Включить навигацию',
            'create_route'            => 'Создать маршрут',
            'search'                  => 'Поиск',
            'expansion_routes'        => '',
            'routes'                  => ':expansion',
            'explore'                 => '',
            'affixes'                 => 'Аффиксы',
            'new'                     => 'Новые',
        ],
        'navuser' => [
            'login'             => 'Войти',
            'register'          => 'Регистрация',
            'telescope'         => 'Телескоп',
            'tools'             => 'Инструменты',
            'view_releases'     => 'Показать релизы',
            'view_expansions'   => 'Показать дополнения',
            'view_dungeons'     => 'Показать подземелья',
            'view_npcs'         => 'Показать NPCs',
            'view_spells'       => 'Показать способности',
            'view_users'        => 'Показать пользователей',
            'view_user_reports' => 'Показать жалобы',
            'my_routes'         => 'Мои маршруты',
            'my_favorites'      => 'Избранное',
            'my_tags'           => 'Мои теги',
            'my_teams'          => 'Моя команда',
            'my_profile'        => 'Мой профиль',
            'account_settings'  => '',
            'logout'            => 'Выйти',
        ],
    ],
    'maps'         => [
        'controls' => [
            'draw'           => [
                'admin'           => '',
                'view_this_route' => '',
            ],
            'elements'       => [
                'dungeonrouteinfo'         => [
                    'timer'            => 'Таймер',
                    'timer_title'      => '+2: %s, +3: %s',
                    'group_setup'      => 'Настройка группы',
                    'affixes'          => 'Аффиксы',
                    'route_info_title' => 'Информация',
                ],
                'enemyvisualtype'          => [
                    'portrait'                => 'Портрет',
                    'npc_class'               => 'Класс',
                    'npc_type'                => 'Тип',
                    'enemy_forces'            => 'Силы врага',
                    'enemy_visual_type'       => 'Визуализация',
                    'enemy_visual_type_title' => 'Визуализация',
                ],
                'floor_switch'             => [
                    'switch_floors' => 'Уровни',
                    'floors'        => 'Уровни',
                ],
                'mapobjectgroupvisibility' => [
                    'toggle_map_elements' => 'Элементы',
                ],
                'labeltoggle'              => [
                    'hide_labels' => 'Скрыть',
                ],
                'mdtclones'                => [
                    'mdt'        => 'MDT',
                    'auto_solve' => '',
                ],
                'rating'                   => [
                    'rate_this_route'          => 'Оцените этот маршрут',
                    'unable_to_rate_own_route' => 'Вы не можете оценить собственный маршрут',
                    'your_rating'              => 'Ваш рейтинг',
                ],
            ],
            'enemyinfo'      => [
                'enemy_info'      => 'Информация о враге',
                'report_an_issue' => 'Сообщить о проблеме',
            ],
            'header'         => [
                'toggle_navigation'              => 'Включить навигацию',
                'stop'                           => 'Стоп',
                'start'                          => 'Старт',
                'live_session_expires_in'        => 'Истекает %s',
                'edit_route'                     => 'Редактировать маршрут',
                'view_route'                     => 'Показать маршрут',
                'save_to_profile'                => 'Сохранить в профиль',
                'edit_route_admin_settings'      => '',
                'simulate_route'                 => '',
                'edit_route_settings'            => '',
                'edit_mapping_version'           => '',
                'share'                          => 'Поделиться',
                'start_live_session'             => 'Начать живую сессию',
                'start_live_session_paragraph_1' => 'После запуска маршрута в игре вы можете создать сеанс в реальном времени, в котором Keystone.guru поможет вам пройти M+ ключ. Вы можете следить за перемещениями карты другого пользователя, щелкнув на иконку вверху.',
                'start_live_session_paragraph_2' => 'Любой участник живого сеанса также может выбрать любой из ваших существующих пулов (ваш текущий пул), а затем любого врага, который не является частью вашего маршрута, чтобы указать на случайной пул. Затем Keystone.guru попытается исправить ваш маршрут, исключив всех врагов, которые являются частью вашего текущего маршрута, которые потенциально можно пропустить без использования Скрывающий покров/зелья невидимости.',
                'start_live_session_paragraph_3' => 'Ваш живой сеанс может быть доступен кому угодно, просто поделитесь URL-адресом. Они смогут присоединиться, как только войдут в Keystone.guru.',
                'start_live_session_paragraph_4' => 'Если ваш маршрут предназначен команде, частью которой вы являетесь, все члены этой команды, просматривающие в данный момент этот маршрут, получат приглашение на ваш сеанс подключения в реальном времени.',
                'create_live_session'            => 'Создать живую сессию',
                'live_session_concluded'         => 'Живая сессия завершена',
                'rate_this_route'                => 'Оцените этот маршрут',
                'rate_this_route_explanation'    => 'Оценка маршрута поможет другим пользователям открыть для себя этот маршрут, если он хороший. Спасибо!',
                'you_cannot_rate_your_own_route' => 'Вы не можете оценить свой собственный маршрут',
                'review_live_session'            => 'Просмотреть сеанс в прямом эфире',
            ],
            'pulls'          => [
                'settings_title'              => 'Настройки карты/пула',
                'new_pull'                    => 'Новый пул',
                'delete_all_pulls_title'      => 'Удалить все пулы',
                'toggle_all_required_enemies' => '',
                'loading'                     => 'Загрузка...',
                'no_pulls_created_edit'       => 'Никаких пулов еще не создано. Нажмите кнопку выше или на врага, чтобы создать ваш первый пул.',
                'no_pulls_created_view'       => 'Никаких пулов еще не создано.',
            ],
            'pullsworkbench' => [
                'modal'            => [
                    'description' => [
                        'label' => '',
                        'save'  => '',
                    ],
                    'spells'      => [
                        'label' => '',
                        'save'  => '',
                    ],
                ],
                'description'      => '',
                'spells'           => '',
                'add_kill_area'    => '',
                'remove_kill_area' => '',
                'delete_killzone'  => '',
            ],
            'view'           => [
                'edit_this_route_title'          => 'Редактировать это маршрут',
                'clone_this_route_title'         => 'Клонировать',
                'report_for_moderation'          => 'Сообщить',
                'report_for_moderation_finished' => 'Отправлено',
            ],
        ],
        'map'      => [
            'no_teeming'      => 'Всегда видимые',
            'visible_teeming' => 'Показывать только на Кишащем',
            'hidden_teeming'  => 'Спрятать только на Кишащем',

            'any'      => 'Любая',
            'alliance' => 'Альянс',
            'horde'    => 'Орда',

            'new_mapping_version_header_title'       => '',
            'new_mapping_version_header_description' => '',
            'explore_header_title'                   => '',
            'admin_header_title'                     => '',

            'route' => 'Маршрут',
        ],
    ],
    'modal'        => [
        'userreport'         => [
            'dungeonroute' => [
                'report_route'           => 'Отправить жалобу',
                'your_name'              => 'Ваше имя',
                'why_report_this_route'  => 'Почему вы хотите отправить жалобу на этот маршрут? (макс. 1000 символов)',
                'contact_by_email'       => 'Свяжитесь со мной по электронной почте,если потребуется дальнейшее разбирательство',
                'contact_by_email_guest' => 'Свяжитесь со мной по электронной почте, для дальнейшего разбирательства (добавьте свой адрес электронной почты в форму жалобы)',
                'submit'                 => 'Отправить',
            ],
            'enemy'        => [
                'report_enemy_bug'       => 'Сообщить об ошибке врага',
                'your_name'              => 'Ваше имя',
                'what_is_wrong'          => 'Что случилось',
                'contact_by_email'       => 'Свяжитесь со мной по электронной почте,если потребуется дальнейшее разбирательство',
                'contact_by_email_guest' => 'Свяжитесь со мной по электронной почте, для дальнейшего разбирательства (добавьте свой адрес электронной почты в форму жалобы)',
                'submit'                 => 'Отправить',
            ],
        ],
        'createroute'        => [
            'create_route'           => 'Создать маршрут',
            'create_temporary_route' => 'Создать временный маршрут',
            'import_from_mdt'        => 'Импорт из MDT',
        ],
        'legal'              => [
            'welcome_back_agree' => 'С возвращением! Чтобы продолжить, вы должны согласиться с нашими %s, %s и %s.',
            'terms_of_service'   => 'Условиями использования',
            'privacy_policy'     => 'Политикой конфиденциальности',
            'cookie_policy'      => 'Политикой в отношении файлов cookie',
            'i_agree'            => 'Согласен',
        ],
        'mappingversion'     => [
            'enemy_forces_required'           => '',
            'enemy_forces_required_teeming'   => '',
            'enemy_forces_shrouded'           => '',
            'enemy_forces_shrouded_zul_gamux' => '',
            'timer_max_seconds'               => '',
            'save'                            => '',
        ],
        'mapsettings'        => [
            'map_settings'  => '',
            'pull_settings' => '',
        ],
        'routeadminsettings' => [
            'title'                             => '',
            'dungeon_route_info'                => '',
            'links'                             => '',
            'edit_mapping_version'              => '',
            'combatlog_info'                    => '',
            'challenge_mode_run'                => '',
            'challenge_mode_run_data'           => '',
            'route_not_created_from_combat_log' => '',
            'route_not_created_through_api'     => '',
        ],
        'routesettings'      => [
            'title' => '',
        ],
        'share'              => [
            'share'                            => 'Поделиться',
            'publish'                          => 'Опубликовать',
            'review_route_settings'            => 'Предпросмотр %s перед публикацией маршрута',
            'route_settings'                   => 'Настройки маршрута',
            'link'                             => 'Ссылка',
            'short_link'                       => '',
            'copy_shareable_link_to_clipboard' => 'Скопировать ссылку в буфер обмена',
            'embed'                            => 'Встраивание',
            'copy_embed_code_to_clipboard'     => 'Скопируйте код для встраивания в буфер обмена',
            'mdt_string'                       => 'Строка MDT',
            'loading'                          => 'Загрузка...',
            'copy_to_clipboard'                => 'Скопировать в буфер обмена',
        ],
        'simulate'           => [
            'intro'                                   => '',
            'title'                                   => '',
            'key_level'                               => '',
            'key_level_title'                         => '',
            'shrouded_bounty_type'                    => '',
            'shrouded_bounty_type_title'              => '',
            'shrouded_bounty_types'                   => [
                'none'    => '',
                'crit'    => '',
                'haste'   => '',
                'mastery' => '',
                'vers'    => '',
            ],
            'affix'                                   => '',
            'affix_title'                             => '',
            'affixes'                                 => [
                'fortified'  => '',
                'tyrannical' => '',
            ],
            'simulate_thundering_clear_seconds'       => '',
            'simulate_thundering_clear_seconds_title' => '',
            'bloodlust'                               => '',
            'bloodlust_title'                         => '',
            'arcane_intellect'                        => '',
            'power_word_fortitude'                    => '',
            'battle_shout'                            => '',
            'mystic_touch'                            => '',
            'chaos_brand'                             => '',
            'hp_percent'                              => '',
            'hp_percent_title'                        => '',
            'bloodlust_per_pull'                      => '',
            'bloodlust_per_pull_title'                => '',
            'ranged_pull_compensation_yards'          => '',
            'ranged_pull_compensation_yards_title'    => '',
            'use_mounts'                              => '',
            'use_mounts_title'                        => '',
            'get_simulationcraft_string'              => '',
            'simulationcraft_string'                  => '',
            'loading'                                 => '',
            'copy_to_clipboard'                       => '',
        ],
        'simulateoptions'    => [
            'advanced' => [
                'patreon_link_text' => '',
                'patreon_only'      => '',
                'advanced_options'  => '',
                'description'       => '',
            ],
        ],
    ],
    'release'      => [
        'release' => [
            'new' => 'Новые',
        ],
    ],
    'tag'          => [
        'manager' => [
            'route_personal' => 'Маршрут',
            'route_team'     => 'Маршрут',
            'name'           => 'Название',
            'color'          => 'Цвет',
            'usage'          => 'Использование',
            'actions'        => 'Действия',
            'save'           => 'Сохранить',
            'delete_all'     => 'Удалить все',
            'create_tag'     => 'Создать тег',
            'create_new_tag' => 'Создать новый тег',
        ],
    ],
    'team'         => [
        'details' => [
            'name'            => 'Название',
            'description'     => 'Описание',
            'logo'            => 'Логотип',
            'current_logo'    => 'Создать логотип',
            'team_logo_title' => 'Логотип команды',
            'save'            => 'Сохранить',
            'submit'          => 'Подтвердить',
            'disband_team'    => 'Распустить команду',
        ],
        'select'  => [
            'select_team' => 'Выбрать команду...',
            'team'        => 'Команда',
            'create_team' => 'Создать команду',
        ],
    ],
    'thirdparty'   => [
        'nitropay'      => [
            'adcontrols' => [
                'remove_ads' => 'Убрать рекламу',
            ],
        ],
        'patreon'       => [
            'fancylink' => [
                'patreon' => '',
            ],
        ],
        'cookieconsent' => [
            'learn_more' => 'Дополнительная информация',
        ],
    ],
    'user'         => [
        'name' => [
            'avatar_title' => 'Аватар',
        ],
    ],

];
