<?php
/** @var \App\Models\DungeonRoute $model */
/** @var \App\Models\Dungeon $dungeon */
?>
@include('common.general.inline', ['path' => 'common/maps/killzonessidebar'])

@section('sidebar-content')
@endsection

@component('common.maps.sidebar', [
'header' => __('Pulls'),
'anchor' => 'right',
'id' => 'killzonesidebar',
'customSubHeader' => '<div class="sidebar-header-pulls-spacer"></div><button class="btn btn-primary w-100"><i class="fas fa-plus"></i> ' . __('New Pull') . '</button>',
'selectedFloorId' => 0
])
    <div class="bg-danger h-100">
        Killzone sidebar!
    </div>
@endcomponent