<?php

return [
    'dungeon'                    => [
        'edit' => [
            'title_new'                          => '',
            'title_edit'                         => '',
            'header_new'                         => '',
            'header_edit'                        => '',
            'active'                             => '',
            'speedrun_enabled'                   => '',
            'speedrun_difficulty_10_man_enabled' => '',
            'speedrun_difficulty_25_man_enabled' => '',
            'facade_enabled'                     => '',
            'id'                                 => '',
            'game_version_id'                    => '',
            'zone_id'                            => '',
            'map_id'                             => '',
            'challenge_mode_id'                  => '',
            'mdt_id'                             => '',
            'dungeon_name'                       => '',
            'key'                                => '',
            'slug'                               => '',
            'submit'                             => '',

            'floor_management' => [
                'title'                => '',
                'add_floor'            => '',
                'table_header_id'      => '',
                'table_header_index'   => '',
                'table_header_name'    => '',
                'table_header_actions' => '',
                'floor_edit_edit'      => '',
                'floor_edit_mapping'   => '',
            ],

            'mapping_versions' => [
                'title'                    => '',
                'add_bare_mapping_version' => '',
                'add_mapping_version'      => '',
                'delete'                   => '',
                'table_header_merged'      => '',
                'table_header_facade'      => '',
                'table_header_id'          => '',
                'table_header_version'     => '',
                'table_header_created_at'  => '',
                'table_header_actions'     => '',
            ],
        ],
        'list' => [
            'title'                             => '',
            'header'                            => '',
            'table_header_active'               => '',
            'table_header_expansion'            => '',
            'table_header_game_version'         => '',
            'table_header_name'                 => '',
            'table_header_enemy_forces'         => '',
            'table_header_enemy_forces_teeming' => '',
            'table_header_timer'                => '',
            'table_header_actions'              => '',
            'edit'                              => '',
        ],
    ],
    'dungeonspeedrunrequirednpc' => [
        'new' => [
            'title_10_man'   => '',
            'title_25_man'   => '',
            'header_10_man'  => '',
            'header_25_man'  => '',
            'npc_id'         => '',
            'linked_npc_ids' => '',
            'count'          => '',
            'submit'         => '',
        ],
    ],
    'expansion'                  => [
        'edit' => [
            'title_new'     => '',
            'header_new'    => '',
            'title_edit'    => '',
            'header_edit'   => '',
            'active'        => '',
            'name'          => '',
            'shortname'     => '',
            'icon'          => '',
            'current_image' => '',
            'color'         => '',
            'edit'          => '',
            'submit'        => '',
        ],
        'list' => [
            'title'                => '',
            'header'               => '',
            'create_expansion'     => '',
            'table_header_active'  => '',
            'table_header_icon'    => '',
            'table_header_id'      => '',
            'table_header_name'    => '',
            'table_header_color'   => '',
            'table_header_actions' => '',
            'edit'                 => '',
        ],
    ],
    'floor'                      => [
        'flash'   => [
            'invalid_floor_id'           => '',
            'invalid_mapping_version_id' => '',
            'floor_updated'              => '',
            'floor_created'              => '',
        ],
        'edit'    => [
            'title_new'                          => '',
            'header_new'                         => '',
            'title_edit'                         => '',
            'header_edit'                        => '',
            'active'                             => '',
            'index'                              => '',
            'mdt_sub_level'                      => '',
            'ui_map_id'                          => '',
            'floor_name'                         => '',
            'min_enemy_size'                     => '',
            'max_enemy_size'                     => '',
            'enemy_engagement_max_range'         => '',
            'enemy_engagement_max_range_patrols' => '',
            'percentage_display_zoom'            => '',
            'default'                            => '',
            'default_title'                      => '',
            'facade'                             => '',
            'facade_title'                       => '',
            'connected_floors'                   => '',
            'connected_floors_title'             => '',
            'connected'                          => '',
            'direction'                          => '',
            'floor_direction'                    => [
                'none'  => '',
                'up'    => '',
                'down'  => '',
                'left'  => '',
                'right' => '',
            ],
            'submit'                             => '',

            'speedrun_required_npcs' => [
                'title_10_man'         => '',
                'title_25_man'         => '',
                'add_npc'              => '',
                'table_header_id'      => '',
                'table_header_npc'     => '',
                'table_header_count'   => '',
                'table_header_actions' => '',
                'npc_delete'           => '',
            ],
        ],
        'mapping' => [
            'title'  => '',
            'header' => '',
        ],
    ],
    'npc'                        => [
        'flash' => [
            'npc_updated' => '',
            'npc_created' => '',
        ],
        'edit'  => [
            'title_new'                            => '',
            'header_new'                           => '',
            'title_edit'                           => '',
            'header_edit'                          => '',
            'name'                                 => '',
            'game_id'                              => '',
            'classification'                       => '',
            'aggressiveness'                       => '',
            'type'                                 => '',
            'class'                                => '',
            'base_health'                          => '',
            'scaled_health_to_base_health_apply'   => '',
            'scaled_health_placeholder'            => '',
            'scaled_health_percentage_placeholder' => '',
            'scaled_type_none'                     => '',
            'scaled_type_fortified'                => '',
            'scaled_type_tyrannical'               => '',
            'health_percentage'                    => '',
            'enemy_forces'                         => '',
            'enemy_forces_teeming'                 => '',
            'dangerous'                            => '',
            'truesight'                            => '',
            'bursting'                             => '',
            'bolstering'                           => '',
            'sanguine'                             => '',
            'runs_away_in_fear'                    => '',
            'bolstering_npc_whitelist'             => '',
            'bolstering_npc_whitelist_count'       => '',
            'spells'                               => '',
            'spells_count'                         => '',
            'submit'                               => '',
            'save_as_new_npc'                      => '',
            'all_npcs'                             => '',
            'all_dungeons'                         => '',
        ],
        'list'  => [
            'all_dungeons'                => '',
            'title'                       => '',
            'header'                      => '',
            'create_npc'                  => '',
            'table_header_id'             => '',
            'table_header_name'           => '',
            'table_header_dungeon'        => '',
            'table_header_enemy_forces'   => '',
            'table_header_enemy_count'    => '',
            'table_header_classification' => '',
            'table_header_actions'        => '',
        ],
    ],
    'npcenemyforces'             => [
        'title'                        => '',
        'mapping_version_read_only'    => '',
        'edit_enemy_forces'            => '',
        'table_header_id'              => '',
        'table_header_mapping_version' => '',
        'table_header_enemy_forces'    => '',
        'table_header_actions'         => '',
        'edit'                         => [
            'title'                => '',
            'header'               => '',
            'enemy_forces'         => '',
            'enemy_forces_teeming' => '',
            'submit'               => '',
        ],
    ],
    'release'                    => [
        'edit' => [
            'title_new'    => '',
            'header_new'   => '',
            'title_edit'   => '',
            'header_edit'  => '',
            'version'      => '',
            'title'        => '',
            'silent'       => '',
            'spotlight'    => '',
            'changelog'    => '',
            'description'  => '',
            'ticket_nr'    => '',
            'change'       => '',
            'add_change'   => '',
            'edit'         => '',
            'submit'       => '',
            'release_json' => '',
        ],
        'list' => [
            'title'                => '',
            'view_releases'        => '',
            'create_release'       => '',
            'table_header_id'      => '',
            'table_header_version' => '',
            'table_header_title'   => '',
            'table_header_actions' => '',
            'edit'                 => '',
        ],
    ],
    'spell'                      => [
        'edit' => [
            'title_new'         => '',
            'header_new'        => '',
            'title_edit'        => '',
            'header_edit'       => '',
            'game_id'           => '',
            'name'              => '',
            'icon_name'         => '',
            'category'          => '',
            'dispel_type'       => '',
            'cooldown_group'    => '',
            'schools'           => '',
            'aura'              => '',
            'selectable'        => '',
            'submit'            => '',
            'save_as_new_spell' => '',
        ],
        'list' => [
            'title'                => '',
            'header'               => '',
            'create_spell'         => '',
            'table_header_icon'    => '',
            'table_header_id'      => '',
            'table_header_name'    => '',
            'table_header_actions' => '',
            'edit'                 => '',
        ],
    ],
    'tools'                      => [
        'datadump'     => [
            'viewexporteddungeondata' => [
                'title'   => '',
                'header'  => '',
                'content' => '',
            ],
            'viewexportedrelease'     => [
                'title'   => '',
                'header'  => '',
                'content' => '',
            ],
        ],
        'dungeonroute' => [
            'view'            => [
                'title'      => '',
                'header'     => '',
                'public_key' => '',
                'submit'     => '',
            ],
            'viewcontents'    => [
                'title'  => '',
                'header' => '',
            ],
            'mappingversions' => [
                'title'                             => '',
                'header'                            => '',
                'table_header_mapping_version_name' => '',
                'table_header_count'                => '',
                'table_header_actions'              => '',
            ],
        ],
        'enemyforces'  => [
            'title'                    => '',
            'header'                   => '',
            'paste_mennos_export_json' => '',
            'submit'                   => '',
            'recalculate'              => [
                'title'  => '',
                'header' => '',
                'submit' => '',
            ],
        ],
        'exception'    => [
            'select' => [
                'title'                     => '',
                'header'                    => '',
                'select_exception_to_throw' => '',
                'submit'                    => '',
            ],
        ],
        'mdt'          => [
            'diff'                              => [
                'title'                 => '',
                'header'                => '',
                'headers'               => [
                    'mismatched_health'               => '',
                    'mismatched_enemy_count'          => '',
                    'mismatched_enemy_type'           => '',
                    'missing_npc'                     => '',
                    'mismatched_enemy_forces'         => '',
                    'mismatched_enemy_forces_teeming' => '',
                ],
                'table_header_dungeon'  => '',
                'table_header_npc'      => '',
                'table_header_message'  => '',
                'table_header_actions'  => '',
                'no_dungeon_name_found' => '',
                'no_npc_name_found'     => '',
                'npc_message'           => '',
                'apply_mdt_kg'          => '',
            ],
            'dungeonroute'                      => [
                'title'      => '',
                'header'     => '',
                'public_key' => '',
                'submit'     => '',
            ],
            'string'                            => [
                'title'                        => '',
                'header'                       => '',
                'paste_your_mdt_export_string' => '',
                'submit'                       => '',
            ],
            'dungeonmappinghash'                => [
                'title'  => '',
                'header' => '',
                'submit' => '',
            ],
            'dungeonmappingversiontomdtmapping' => [
                'title'  => '',
                'header' => '',
                'submit' => '',
            ],
        ],
        'npcimport'    => [
            'title'                   => '',
            'header'                  => '',
            'paste_npc_import_string' => '',
            'submit'                  => '',
        ],
        'list'         => [
            'title'            => '',
            'header'           => '',
            'header_tools'     => '',
            'subheader_import' => '',
            'mass_import_npcs' => '',

            'subheader_dungeonroute'                  => '',
            'view_dungeonroute_details'               => '',
            'view_dungeonroute_mapping_version_usage' => '',

            'subheader_mdt'                               => '',
            'view_mdt_string'                             => '',
            'view_mdt_string_as_dungeonroute'             => '',
            'view_dungeonroute_as_mdt_string'             => '',
            'view_mdt_diff'                               => '',
            'view_dungeon_mapping_hash'                   => '',
            'view_dungeon_mapping_version_to_mdt_mapping' => '',

            'subheader_enemy_forces' => '',
            'enemy_forces_import'    => '',

            'subheader_wowtools'                 => '',
            'wowtools_import_ingame_coordinates' => '',

            'subheader_misc'     => '',
            'drop_caches'        => '',
            'throw_an_exception' => '',

            'subheader_mapping'  => '',
            'force_sync_mapping' => '',

            'subheader_actions'   => '',
            'export_dungeon_data' => '',
            'export_releases'     => '',

            'enemy_forces_recalculate' => '',

            'subheader_thumbnails'  => '',
            'thumbnails_regenerate' => '',
        ],
        'thumbnails'   => [
            'regenerate' => [
                'title'        => '',
                'header'       => '',
                'only_missing' => '',
                'submit'       => '',
            ],
        ],
        'wowtools'     => [
            'importingamecoordinates' => [
                'title'                                  => '',
                'header'                                 => '',
                'map_table_xhr_response'                 => '',
                'ui_map_group_member_table_xhr_response' => '',
                'ui_map_assignment_table_xhr_response'   => '',
                'submit'                                 => '',
            ],
        ],
    ],
    'user'                       => [
        'list' => [
            'title'                   => '',
            'header'                  => '',
            'table_header_id'         => '',
            'table_header_name'       => '',
            'table_header_email'      => '',
            'table_header_routes'     => '',
            'table_header_roles'      => '',
            'table_header_registered' => '',
            'table_header_actions'    => '',
            'table_header_patreons'   => '',
        ],
    ],
    'userreport'                 => [
        'list' => [
            'title'                    => '',
            'header'                   => '',
            'table_header_id'          => '',
            'table_header_author_name' => '',
            'table_header_category'    => '',
            'table_header_message'     => '',
            'table_header_contact_at'  => '',
            'table_header_create_at'   => '',
            'table_header_actions'     => '',
            'handled'                  => '',
        ],
    ],
];
