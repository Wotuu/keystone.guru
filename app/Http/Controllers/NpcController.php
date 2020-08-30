<?php

namespace App\Http\Controllers;

use App\Events\ModelChangedEvent;
use App\Http\Controllers\Traits\ChangesMapping;
use App\Http\Requests\NpcFormRequest;
use App\Models\Enemy;
use App\Models\Npc;
use App\Models\NpcBolsteringWhitelist;
use App\Models\NpcClassification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NpcController extends Controller
{
    use ChangesMapping;

    /**
     * Checks if the incoming request is a save as new request or not.
     * @param Request $request
     * @return bool
     */
    private function isSaveAsNew(Request $request)
    {
        return $request->get('submit', 'submit') !== 'Submit';
    }

    /**
     * @param NpcFormRequest $request
     * @param Npc $npc
     * @return array|mixed
     * @throws \Exception
     */
    public function store(NpcFormRequest $request, Npc $npc = null)
    {
        $oldId = -1;
        // If we're saving as new, make a new NPC and save that instead
        if ($npc === null || $this->isSaveAsNew($request)) {
            $npc = new Npc();
        } else {
            $oldId = $npc->id;
        }

        $npcBefore = clone $npc;

        $npc->id = $request->get('id');
        $npc->dungeon_id = $request->get('dungeon_id');
        $npc->classification_id = $request->get('classification_id');
        $npc->npc_class_id = $request->get('npc_class_id');
        $npc->name = $request->get('name');
        // Remove commas or dots in the name; we want the integer value
        $npc->base_health = str_replace(',', '', $request->get('base_health'));
        $npc->base_health = str_replace('.', '', $npc->base_health);
        $npc->enemy_forces = $request->get('enemy_forces');
        $npc->enemy_forces_teeming = $request->get('enemy_forces_teeming', -1);
        $npc->aggressiveness = $request->get('aggressiveness');
        $npc->dangerous = $request->get('dangerous', 0);
        $npc->truesight = $request->get('truesight', 0);
        $npc->bursting = $request->get('bursting', 0);
        $npc->bolstering = $request->get('bolstering', 0);
        $npc->sanguine = $request->get('sanguine', 0);

        // Bolstering whitelist, if set
        $bolsteringWhitelistNpcs = $request->get('bolstering_whitelist_npcs', []);
        // Clear current whitelists
        $npc->npcbolsteringwhitelists()->delete();
        foreach ($bolsteringWhitelistNpcs as $whitelistNpcId) {
            NpcBolsteringWhitelist::insert([
                'npc_id'           => $npc->id,
                'whitelist_npc_id' => $whitelistNpcId
            ]);
        }

        if ($npc->save()) {
            if ($oldId > 0) {
                Enemy::where('npc_id', $oldId)->update(['npc_id' => $npc->id]);
            }
            broadcast(new ModelChangedEvent($npc->dungeon, Auth::user(), $npc));

            // Trigger mapping changed event so the mapping gets saved across all environments
            $this->mappingChanged($npcBefore, $npc);
        } // We gotta update any existing enemies with the old ID to the new ID, makes it easier to convert ids
        else {
            abort(500, 'Unable to save npc!');
        }

        $portrait = $request->file('portrait');
        // Save was successful, now do any file handling that may be necessary
        if ($portrait !== null) {
//            $portrait->move(public_path('images/enemyportraits'), $npc->id . '.png');
            // Move file to the enemyportraits folder
            dd($portrait->storeAs('images/enemyportraits', $npc->id . '.png', 'public'));
        }

        return $npc;
    }

    /**
     * Show a page for creating a new npc.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function new()
    {
        return view('admin.npc.edit', [
            'classifications' => NpcClassification::all()->pluck('name', 'id'),
            'headerTitle'     => __('New npc')
        ]);
    }

    /**
     * @param Request $request
     * @param Npc $npc
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request, Npc $npc)
    {
        return view('admin.npc.edit', [
            'model'           => $npc,
            'classifications' => NpcClassification::all()->pluck('name', 'id'),
            'headerTitle'     => __('Edit npc')
        ]);
    }

    /**
     * Override to give the type hint which is required.
     * @param NpcFormRequest $request
     * @param Npc $npc
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     * @throws \Exception
     */
    public function update(NpcFormRequest $request, Npc $npc)
    {
        if ($this->isSaveAsNew($request)) {
            return $this->savenew($request);
        } else {
            // Store it and show the edit page again
            $npc = $this->store($request, $npc);

            // Message to the user
            \Session::flash('status', __('Npc updated'));

            // Display the edit page
            return $this->edit($request, $npc);
        }
    }

    /**
     * @param NpcFormRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function savenew(NpcFormRequest $request)
    {
        // Store it and show the edit page
        $npc = $this->store($request);

        // Message to the user
        \Session::flash('status', sprintf(__('Npc %s created'), $npc->name));

        return redirect()->route('admin.npc.edit', ['npc' => $npc->id]);
    }

    /**
     * Handles the viewing of a collection of items in a table.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\
     */
    public function list()
    {
        return view('admin.npc.list', ['models' => Npc::all()]);
    }
}
