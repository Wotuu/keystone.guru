<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\ChangesMapping;
use App\Http\Requests\SpellFormRequest;
use App\Models\Spell;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Session;

class SpellController extends Controller
{
    use ChangesMapping;

    /**
     * Checks if the incoming request is a save as new request or not.
     *
     * @return bool
     */
    private function isSaveAsNew(Request $request)
    {
        return $request->get('submit', 'submit') !== 'Submit';
    }

    /**
     * @return array|mixed
     *
     * @throws Exception
     */
    public function store(SpellFormRequest $request, ?Spell $spell = null)
    {
        // If we're saving as new, make a new Spell and save that instead
        if ($spell === null || $this->isSaveAsNew($request)) {
            $spell = new Spell();
        }

        //        else {
        //            $oldId = $spell->id;
        //        }

        $spellBefore = clone $spell;

        $spell->id = $request->get('id');
        $spell->dispel_type = $request->get('dispel_type');
        $spell->icon_name = $request->get('icon_name');
        $spell->name = $request->get('name');
        $schools = $request->get('schools', []);
        $mask = 0;
        foreach ($schools as $school) {
            $mask |= (int) $school;
        }

        $spell->schools_mask = $mask;
        $spell->aura = $request->get('aura', false);

        if ($spell->save()) {
            //            if ($oldId > 0) {
            //                Enemy::where('spell_id', $oldId)->update(['spell_id' => $spell->id]);
            //            }

            // Trigger mapping changed event so the mapping gets saved across all environments
            $this->mappingChanged($spellBefore, $spell);
        } // We gotta update any existing enemies with the old ID to the new ID, makes it easier to convert ids
        else {
            abort(500, 'Unable to save spell!');
        }

        return $spell;
    }

    /**
     * Show a page for creating a new spell.
     *
     * @return Factory|View
     */
    public function new()
    {
        return view('admin.spell.edit', [
            'dispelTypes' => Spell::ALL_DISPEL_TYPES,
            'schools' => Spell::ALL_SCHOOLS,
        ]);
    }

    /**
     * @return Factory|View
     */
    public function edit(Request $request, Spell $spell)
    {
        return view('admin.spell.edit', [
            'spell' => $spell,
            'dispelTypes' => Spell::ALL_DISPEL_TYPES,
            'schools' => Spell::ALL_SCHOOLS,
        ]);
    }

    /**
     * Override to give the type hint which is required.
     *
     * @return Factory|RedirectResponse|View
     *
     * @throws Exception
     */
    public function update(SpellFormRequest $request, Spell $spell)
    {
        if ($this->isSaveAsNew($request)) {
            return $this->savenew($request);
        } else {
            // Store it and show the edit page again
            $spell = $this->store($request, $spell);

            // Message to the user
            Session::flash('status', __('controller.spell.flash.spell_updated'));

            // Display the edit page
            return $this->edit($request, $spell);
        }
    }

    /**
     * @return RedirectResponse
     *
     * @throws Exception
     */
    public function savenew(SpellFormRequest $request)
    {
        // Store it and show the edit page
        $spell = $this->store($request);

        // Message to the user
        Session::flash('status', sprintf(__('controller.spell.flash.spell_created'), $spell->name));

        return redirect()->route('admin.spell.edit', ['spell' => $spell->id]);
    }

    /**
     * Handles the viewing of a collection of items in a table.
     *
     * @return Factory|
     */
    public function list()
    {
        return view('admin.spell.list', ['models' => Spell::all()]);
    }
}
