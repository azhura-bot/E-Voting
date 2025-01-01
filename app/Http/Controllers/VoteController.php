<?php

namespace App\Http\Controllers;

use App\Models\Calon;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{
    public function index()
    {
        $candidates = Calon::all();
        return view('voting.index', compact('candidates'));
    }

    public function vote(Request $request)
    {
        $user = Auth::user();

        if ($user->role !== 'user') {
            return redirect()->back()->with('error', 'Only users can vote.');
        }

        if ($user->voted) {
            return redirect()->back()->with('error', 'You have already voted.');
        }

        $validatedData = $request->validate([
            'candidates' => 'required|array|min:9|max:9',
            'candidates.*' => 'exists:candidates,id',
        ]);

        foreach ($validatedData['candidates'] as $candidateId) {
            Vote::create([
                'user_id' => $user->id,
                'candidate_id' => $candidateId,
            ]);
        }

        $user->update(['voted' => true]);

        return redirect()->route('voting.index')->with('success', 'Your vote has been submitted.');
    }
}