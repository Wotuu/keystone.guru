@extends('layouts.app', ['custom' => true, 'footer' => false, 'header' => false, 'title' => $model->title, 'cookieConsent' => $model->demo === 1 ? false : null ])
<?php
/** @var $model \App\Models\DungeonRoute */
/** @var $floor \App\Models\Floor */

$affixes = $model->affixes->pluck('text', 'id');
$selectedAffixes = $model->affixes->pluck('id');
if (count($affixes) == 0) {
    $affixes = [-1 => 'Any'];
    $selectedAffixes = -1;w
}
$dungeon = \App\Models\Dungeon::findOrFail($model->dungeon_id);
?>
@section('scripts')
    @parent

    @include('common.handlebars.affixgroupsselect', ['affixgroups' => $model->affixes])
    @include('common.handlebars.groupsetup')

@endsection
@section('content')
    <div class="wrapper">
        @if(!$model->demo)
            @include('common.maps.viewsidebar', [
                'dungeon' => $dungeon,
                'model' => $model,
                'floorSelection' => (!isset($floorSelect) || $floorSelect) && $dungeon->floors->count() !== 1,
                'floorId' => $floor->id,
                'show' => [
                    'sharing' => true,
                    'shareable-link' => !$model->isSandbox(),
                    'embedable-link' => !$model->isSandbox(),
                    'export-mdt-string' => true,
                ]
            ])
        @endif

        @include('common.maps.map', [
            'dungeon' => $dungeon,
            'dungeonroute' => $model,
            'edit' => false,
            'floorId' => $floor->id,
            'noUI' => (bool)$model->demo,
            'gestureHandling' => (bool)$model->demo,
        ])

        @if(!$model->demo)
            @include('common.maps.killzonessidebar', [
                'edit' => false
            ])
        @endif
    </div>
@endsection

