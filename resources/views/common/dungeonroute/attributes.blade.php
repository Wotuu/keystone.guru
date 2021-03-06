<?php
/** @var $dungeonroute \App\Models\DungeonRoute */
$showNoAttributes = isset($showNoAttributes) ? $showNoAttributes : false;
?>

<div class="form-group">
    @if($showNoAttributes)
        <label for="attributes" data-toggle="tooltip"
               title="{{ __('Select the attributes that your group is comfortable with handling.') }}">
            {{ __('Attributes') }}
        </label>
    @else
        <label for="attributes">{{ __('Attributes') }}</label>
        <i class="fas fa-info-circle" data-toggle="tooltip" title="{{
        __('Attributes describe what features your route has that others may not be able to complete due to composition ' .
            'differences or skill. Marking attributes properly enables others to find routes that fit them more easily.')
         }}"></i>
    @endif
    <?php
    $allAttributes = \App\Models\RouteAttribute::all();
    $allAttributeCount = $allAttributes->count();
    /** @var \Illuminate\Support\Collection $attributes */
    $attributes = $allAttributes->groupBy('category');

    if ($showNoAttributes) {
        // Create a dummy attribute which users can tick on/off to include routes with no attributes.
        $noAttributes = new \App\Models\RouteAttribute();
        $noAttributes->id = -1;
        $noAttributes->name = 'no-attributes';
        $noAttributes->description = 'No attributes';

        $attributes['meta'] = new \Illuminate\Support\Collection([$noAttributes]);
    }

    /** @var \Illuminate\Support\Collection $routeAttributes */
    $selectedIds = isset($selectedIds) ? $selectedIds : (!isset($dungeonroute) ? [] : $dungeonroute->routeattributes->pluck('id')->toArray());
    ?>
    <select multiple name="attributes[]" id="attributes" class="form-control selectpicker"
            size="{{ $allAttributeCount + $attributes->count() }}"
            data-selected-text-format="count > 1" data-count-selected-text="{{__('{0} attributes')}}">
        @foreach ($attributes as $category => $categoryAttributes)
            <optgroup label="{{ ucfirst($category) }}">
                @foreach ($categoryAttributes as $attribute) {
                <option value="{{ $attribute->id }}"
                        {{ in_array($attribute->id, $selectedIds) ? 'selected' : '' }}>
                    {{ $attribute->description }}
                </option>
                @endforeach
            </optgroup>
        @endforeach
    </select>
</div>