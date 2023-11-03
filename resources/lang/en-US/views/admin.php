<?php

return [
    'dungeon'                    => [
        'edit' => [
            'title_new'        => 'New dungeon',
            'title_edit'       => 'Edit dungeon',
            'header_new'       => 'New dungeon',
            'header_edit'      => 'Edit dungeon',
            'active'           => 'Active',
            'speedrun_enabled' => 'Speedrun enabled',
            'id'               => 'ID',
            'game_version_id'  => 'Game Version ID',
            'zone_id'          => 'Zone ID',
            'map_id'           => 'Map ID',
            'mdt_id'           => 'MDT ID',
            'dungeon_name'     => 'Dungeon name',
            'key'              => 'Key',
            'slug'             => 'Slug',
            'submit'           => 'Submit',

            'floor_management' => [
                'title'                => 'Floor management',
                'add_floor'            => 'Add floor',
                'table_header_id'      => 'Id',
                'table_header_index'   => 'Index',
                'table_header_name'    => 'Name',
                'table_header_actions' => 'Actions',
                'floor_edit_edit'      => 'Edit',
                'floor_edit_mapping'   => 'Mapping',
            ],

            'mapping_versions' => [
                'title'                   => 'Mapping versions',
                'add_mapping_version'     => 'Add mapping version',
                'delete'                  => 'Delete',
                'table_header_merged'     => 'Merged',
                'table_header_id'         => 'Id',
                'table_header_version'    => 'Version',
                'table_header_created_at' => 'Created at',
                'table_header_actions'    => 'Actions',
            ],
        ],
        'list' => [
            'title'                             => 'Dungeon listing',
            'header'                            => 'View dungeons',
            'table_header_active'               => 'Active',
            'table_header_expansion'            => 'Exp.',
            'table_header_game_version'         => 'Version',
            'table_header_name'                 => 'Name',
            'table_header_enemy_forces'         => 'Enemy Forces',
            'table_header_enemy_forces_teeming' => 'Teeming EF',
            'table_header_timer'                => 'Timer',
            'table_header_actions'              => 'Actions',
            'edit'                              => 'Edit',
        ],
    ],
    'dungeonspeedrunrequirednpc' => [
        'new' => [
            'title_10_man'   => 'New 10-man Speedrun Required NPC',
            'title_25_man'   => 'New 25-man Speedrun Required NPC',
            'header_10_man'  => 'New 10-man Speedrun Required NPC for :dungeon',
            'header_25_man'  => 'New 25-man Speedrun Required NPC for :dungeon',
            'npc_id'         => 'Npc ID',
            'linked_npc_ids' => 'Linked NPCs (optional)',
            'count'          => 'Count',
            'submit'         => 'Submit',
        ],
    ],
    'expansion'                  => [
        'edit' => [
            'title_new'     => 'New expansion',
            'header_new'    => 'New expansion',
            'title_edit'    => 'Edit expansion',
            'header_edit'   => 'Edit expansion',
            'active'        => 'Active',
            'name'          => 'Name',
            'shortname'     => 'Shortname',
            'icon'          => 'Icon',
            'current_image' => 'Current image',
            'color'         => 'Color',
            'edit'          => 'Edit',
            'submit'        => 'Submit',
        ],
        'list' => [
            'title'                => 'Expansion listing',
            'header'               => 'View expansions',
            'create_expansion'     => 'Create expansion',
            'table_header_active'  => 'Active',
            'table_header_icon'    => 'Icon',
            'table_header_id'      => 'Id',
            'table_header_name'    => 'Name',
            'table_header_color'   => 'Color',
            'table_header_actions' => 'Actions',
            'edit'                 => 'Edit',
        ],
    ],
    'floor'                      => [
        'flash'   => [
            'invalid_floor_id'           => 'Floor %s is not a part of dungeon %s',
            'invalid_mapping_version_id' => 'Mapping version is not for dungeon %s',
            'floor_updated'              => 'Floor updated',
            'floor_created'              => 'Floor created',
        ],
        'edit'    => [
            'title_new'                          => 'New Floor - %s',
            'header_new'                         => 'New Floor - %s',
            'title_edit'                         => 'Edit Floor - %s',
            'header_edit'                        => 'Edit Floor - %s',
            'active'                             => 'Active',
            'index'                              => 'Index',
            'mdt_sub_level'                      => 'MDT sub level',
            'ui_map_id'                          => 'UI Map ID',
            'floor_name'                         => 'Floor name',
            'min_enemy_size'                     => 'Minimum enemy size (default: %d)',
            'max_enemy_size'                     => 'Maximum enemy size (default: %d)',
            'enemy_engagement_max_range'         => 'Enemy engagement max range (default: %d)',
            'enemy_engagement_max_range_patrols' => 'Enemy engagement max range for patrols (default: %d)',
            'percentage_display_zoom'            => 'Map zoom level at which percentages are displayed (higher is more zoomed in)',
            'default'                            => 'Default',
            'default_title'                      => 'If marked as default, this floor is opened first when editing routes for this dungeon (only one should be marked as default)',
            'facade'                             => 'Facade',
            'facade_title'                       => 'Facade floors do not actually have enemies on them, but using Floor Unions and Floor Union Areas you can make them render enemies of other floors instead.',
            'connected_floors'                   => 'Connected floors',
            'connected_floors_title'             => 'A connected floor is any other floor that we may reach from this floor',
            'connected'                          => 'Connected',
            'direction'                          => 'Direction',
            'floor_direction'                    => [
                'none'  => 'None',
                'up'    => 'Up',
                'down'  => 'Down',
                'left'  => 'Left',
                'right' => 'Right',
            ],
            'submit'                             => 'Submit',

            'speedrun_required_npcs' => [
                'title_10_man'         => '10-man Speedrun Required Npcs',
                'title_25_man'         => '25-man Speedrun Required Npcs',
                'add_npc'              => 'Add NPC',
                'table_header_id'      => 'Id',
                'table_header_npc'     => 'Npc',
                'table_header_count'   => 'Count',
                'table_header_actions' => 'Actions',
                'npc_delete'           => 'Delete',
            ],
        ],
        'mapping' => [
            'title'  => 'Edit Mapping - %s',
            'header' => 'Edit Mapping - %s',
        ],
    ],
    'npc'                        => [
        'flash' => [
            'npc_updated' => 'Npc updated',
            'npc_created' => 'Npc %s created',
        ],
        'edit'  => [
            'title_new'                            => 'New NPC',
            'header_new'                           => 'New NPC',
            'title_edit'                           => 'Edit NPC :name',
            'header_edit'                          => 'Edit NPC :name',
            'name'                                 => 'Name',
            'game_id'                              => 'Game ID',
            'classification'                       => 'Classification',
            'aggressiveness'                       => 'Aggressiveness',
            'type'                                 => 'Type',
            'class'                                => 'Class',
            'base_health'                          => 'Base health',
            'scaled_health_to_base_health_apply'   => '<- Apply to Base Health',
            'scaled_health_placeholder'            => 'Enter scaled health',
            'scaled_health_percentage_placeholder' => 'Enter percentage',
            'scaled_type_none'                     => 'None',
            'scaled_type_fortified'                => ':affix (trash only)',
            'scaled_type_tyrannical'               => ':affix (bosses only)',
            'health_percentage'                    => 'Health percentage',
            'enemy_forces'                         => 'Enemy forces (-1 for unknown)',
            'enemy_forces_teeming'                 => 'Enemy forces teeming (-1 for same as normal)',
            'dangerous'                            => 'Dangerous',
            'truesight'                            => 'Truesight',
            'bursting'                             => 'Bursting',
            'bolstering'                           => 'Bolstering',
            'sanguine'                             => 'Sanguine',
            'runs_away_in_fear'                    => 'Runs away in fear',
            'bolstering_npc_whitelist'             => 'Bolstering NPC Whitelist',
            'bolstering_npc_whitelist_count'       => '{0} NPCs',
            'spells'                               => 'Spells',
            'spells_count'                         => '{0} Spells',
            'submit'                               => 'Submit',
            'save_as_new_npc'                      => 'Save as new npc',
            'all_npcs'                             => 'All npcs',
            'all_dungeons'                         => 'All dungeons',
        ],
        'list'  => [
            'all_dungeons'                => 'All',
            'title'                       => 'Npc listing',
            'header'                      => 'View NPCs',
            'create_npc'                  => 'Create NPC',
            'table_header_id'             => 'Id',
            'table_header_name'           => 'Name',
            'table_header_dungeon'        => 'Dungeon',
            'table_header_enemy_forces'   => 'Enemy forces',
            'table_header_enemy_count'    => 'Enemy count',
            'table_header_classification' => 'Classification',
            'table_header_actions'        => 'Action',
        ],
    ],
    'npcenemyforces'             => [
        'title'                        => 'Enemy forces',
        'mapping_version_read_only'    => 'Mapping version is read-only',
        'edit_enemy_forces'            => 'Edit enemy forces',
        'table_header_id'              => 'Id',
        'table_header_mapping_version' => 'Mapping Version',
        'table_header_enemy_forces'    => 'Enemy Forces',
        'table_header_actions'         => 'Actions',
        'edit'                         => [
            'title'                => 'Edit enemy forces for :name',
            'header'               => 'Edit enemy forces for :name',
            'enemy_forces'         => 'Enemy forces',
            'enemy_forces_teeming' => 'Enemy forces (teeming)',
            'submit'               => 'Submit',
        ],
    ],
    'release'                    => [
        'edit' => [
            'title_new'    => 'New release',
            'header_new'   => 'New release',
            'title_edit'   => 'Edit release',
            'header_edit'  => 'Edit release',
            'version'      => 'Version',
            'title'        => 'Title',
            'silent'       => 'Silent',
            'spotlight'    => 'Spotlight',
            'changelog'    => 'Changelog',
            'description'  => 'Description',
            'ticket_nr'    => 'Ticket nr.',
            'change'       => 'Change',
            'add_change'   => 'Add change',
            'edit'         => 'Edit',
            'submit'       => 'Submit',
            'release_json' => 'Release json',
        ],
        'list' => [
            'title'                => 'Release listing',
            'view_releases'        => 'View releases',
            'create_release'       => 'Create release',
            'table_header_id'      => 'Id',
            'table_header_version' => 'Version',
            'table_header_title'   => 'Title',
            'table_header_actions' => 'Actions',
            'edit'                 => 'Edit',
        ],
    ],
    'spell'                      => [
        'edit' => [
            'title_new'         => 'New spell',
            'header_new'        => 'New spell',
            'title_edit'        => 'Edit spell',
            'header_edit'       => 'Edit spell',
            'game_id'           => 'Game ID',
            'name'              => 'Name',
            'icon_name'         => 'Icon name',
            'dispel_type'       => 'Dispel type',
            'schools'           => 'Schools',
            'aura'              => 'Aura',
            'submit'            => 'Submit',
            'save_as_new_spell' => 'Save as new spell',
        ],
        'list' => [
            'title'                => 'Spell listing',
            'header'               => 'View spells',
            'create_spell'         => 'Create spell',
            'table_header_icon'    => 'Icon',
            'table_header_id'      => 'Id',
            'table_header_name'    => 'Name',
            'table_header_actions' => 'Actions',
            'edit'                 => 'Edit',
        ],
    ],
    'tools'                      => [
        'datadump'     => [
            'viewexporteddungeondata' => [
                'title'   => 'Exported!',
                'header'  => 'Dumped dungeon data',
                'content' => 'Exported!',
            ],
            'viewexportedrelease'     => [
                'title'   => 'Exported!',
                'header'  => 'Dumped dungeon data',
                'content' => 'Exported!',
            ],
        ],
        'dungeonroute' => [
            'view'            => [
                'title'      => 'View dungeonroute',
                'header'     => 'View dungeonroute',
                'public_key' => 'Dungeonroute public key',
                'submit'     => 'Submit',
            ],
            'viewcontents'    => [
                'title'  => 'View contents for :dungeonRouteTitle',
                'header' => 'View contents for %s',
            ],
            'mappingversions' => [
                'title'                             => 'View mapping version usage',
                'header'                            => 'View mapping version usage',
                'table_header_mapping_version_name' => 'Mapping Version',
                'table_header_count'                => 'Dungeon Route #',
                'table_header_actions'              => 'Actions',
            ],
        ],
        'enemyforces'  => [
            'title'                    => 'Import Enemy Forces',
            'header'                   => 'Import Enemy Forces',
            'paste_mennos_export_json' => 'Paste Menno\'s Export Json',
            'submit'                   => 'Submit',
            'recalculate'              => [
                'title'  => 'Recalculate enemy forces for dungeonroutes of dungeon',
                'header' => 'Recalculate enemy forces for dungeonroutes of dungeon',
                'submit' => 'Submit',
            ],
        ],
        'exception'    => [
            'select' => [
                'title'                     => 'Throw an exception',
                'header'                    => 'Throw an exception',
                'select_exception_to_throw' => 'Select exception to throw',
                'submit'                    => 'Submit',
            ],
        ],
        'mdt'          => [
            'diff'                              => [
                'title'                 => 'MDT Diff',
                'header'                => 'MDT Diff',
                'headers'               => [
                    'mismatched_health'               => 'Mismatched health',
                    'mismatched_enemy_count'          => 'Mismatched enemy count',
                    'mismatched_enemy_type'           => 'Mismatched enemy type',
                    'missing_npc'                     => 'Missing NPC',
                    'mismatched_enemy_forces'         => 'Mismatched enemy forces',
                    'mismatched_enemy_forces_teeming' => 'Mismatched enemy forces (teeming)',
                ],
                'table_header_dungeon'  => 'Dungeon',
                'table_header_npc'      => 'NPC',
                'table_header_message'  => 'Message',
                'table_header_actions'  => 'Actions',
                'no_dungeon_name_found' => 'No dungeon name found',
                'no_npc_name_found'     => 'No NPC name found',
                'npc_message'           => ':npcName (:npcId, :count usages)',
                'apply_mdt_kg'          => 'Apply (MDT -> KG)',
            ],
            'dungeonroute'                      => [
                'title'      => 'View dungeonroute as MDT String',
                'header'     => 'View dungeonroute as MDT String',
                'public_key' => 'Dungeonroute public key',
                'submit'     => 'Submit',
            ],
            'string'                            => [
                'title'                        => 'View MDT String Contents',
                'header'                       => 'View MDT String Contents',
                'paste_your_mdt_export_string' => 'Paste your Mythic Dungeon Tools export string',
                'submit'                       => 'Submit',
            ],
            'dungeonmappinghash'                => [
                'title'  => 'View MDT Dungeon Mapping Hash',
                'header' => 'View MDT Dungeon Mapping Hash',
                'submit' => 'Submit',
            ],
            'dungeonmappingversiontomdtmapping' => [
                'title'  => 'Convert Dungeon Mapping to MDT Mapping',
                'header' => 'Convert Dungeon Mapping to MDT Mapping',
                'submit' => 'Submit',
            ],
        ],
        'npcimport'    => [
            'title'                   => 'Mass import NPCs',
            'header'                  => 'Mass import NPCs',
            'paste_npc_import_string' => 'Paste the NPC import string',
            'submit'                  => 'Submit',
        ],
        'list'         => [
            'title'            => 'Admin tools',
            'header'           => 'Admin tools',
            'header_tools'     => 'Tools',
            'subheader_import' => 'Import',
            'mass_import_npcs' => 'Mass import NPCs',

            'subheader_dungeonroute'                  => 'Dungeonroute',
            'view_dungeonroute_details'               => 'View Dungeonroute details',
            'view_dungeonroute_mapping_version_usage' => 'View Dungeonroute Mapping Version usage',

            'subheader_mdt'                               => 'MDT',
            'view_mdt_string'                             => 'View MDT String contents',
            'view_mdt_string_as_dungeonroute'             => 'View MDT String as Dungeonroute',
            'view_dungeonroute_as_mdt_string'             => 'View Dungeonroute as MDT String',
            'view_mdt_diff'                               => 'View MDT Diff',
            'view_dungeon_mapping_hash'                   => 'View dungeon mapping hash',
            'view_dungeon_mapping_version_to_mdt_mapping' => 'Convert mapping version to MDT mapping',

            'subheader_enemy_forces' => 'Enemy Forces',
            'enemy_forces_import'    => 'Import enemy forces',

            'subheader_wowtools'                 => 'WoW.tools',
            'wowtools_import_ingame_coordinates' => 'Import in-game coordinates',

            'subheader_misc'     => 'Misc',
            'drop_caches'        => 'Drop caches',
            'throw_an_exception' => 'Throw an exception',

            'subheader_mapping'  => 'Mapping',
            'force_sync_mapping' => 'Force sync mapping',

            'subheader_actions'   => 'Actions',
            'export_dungeon_data' => 'Export dungeon data',
            'export_releases'     => 'Export releases',

            'enemy_forces_recalculate' => 'Mass recalculate enemy forces for routes',

            'subheader_thumbnails'  => 'Thumbnails',
            'thumbnails_regenerate' => 'Mass regenerate thumbnails',
        ],
        'thumbnails'   => [
            'regenerate' => [
                'title'  => 'Mass regenerate thumbnails',
                'header' => 'Mass regenerate thumbnails',
                'submit' => 'Submit',
            ],
        ],
        'wowtools'     => [
            'importingamecoordinates' => [
                'title'                                  => 'Import in-game coordinates',
                'header'                                 => 'Import in-game coordinates',
                'map_table_xhr_response'                 => 'Map table XHR response (dungeon data, see https://wow.tools/dbc/?dbc=map&build=10.0.0.45232, set to 1000 results and view source)',
                'ui_map_group_member_table_xhr_response' => 'UI map group member table XHR response (floor data, see https://wow.tools/dbc/?dbc=uimapgroupmember&build=10.0.0.45232, set to 1000 results and view source)',
                'ui_map_assignment_table_xhr_response'   => 'UI map assignment table XHR response (in-game coordinates to map coordinates per floor, see https://wow.tools/dbc/?dbc=uimapassignment&build=10.0.0.45232, set to 1000 results and view network. Copy as fetch, edit length to 25000)',
                'submit'                                 => 'Submit',
            ],
        ],
    ],
    'user'                       => [
        'list' => [
            'title'                   => 'User list',
            'header'                  => 'View users',
            'table_header_id'         => 'Id',
            'table_header_name'       => 'Name',
            'table_header_email'      => 'Email',
            'table_header_routes'     => 'Routes',
            'table_header_roles'      => 'Roles',
            'table_header_registered' => 'Registered',
            'table_header_actions'    => 'Actions',
            'table_header_patreons'   => 'Patreon',
        ],
    ],
    'userreport'                 => [
        'list' => [
            'title'                    => 'User reports',
            'header'                   => 'View user reports',
            'table_header_id'          => 'Id',
            'table_header_author_name' => 'Author name',
            'table_header_category'    => 'Category',
            'table_header_message'     => 'Message',
            'table_header_contact_at'  => 'Contact at',
            'table_header_create_at'   => 'Created at',
            'table_header_actions'     => 'Actions',
            'handled'                  => 'Handled',
        ],
    ],
];
