<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\PreInscriptionNotification;
use App\Models\PreInscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PreInscriptionController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'prenom' => 'required|string|max:100',
            'nom' => 'required|string|max:100',
            'date_naissance' => 'required|date|before:today',
            'categorie_id' => 'required|exists:categories,id',
            'email_parent' => 'required|email|max:255',
            'telephone' => 'nullable|string|max:30',
            'message' => 'nullable|string|max:2000',
        ]);

        $inscription = PreInscription::create($data);
        $inscription->load('categorie');

        $notifyTo = env('ADMIN_EMAIL');
        if ($notifyTo) {
            $inscriptionId = $inscription->id;
            dispatch(function () use ($notifyTo, $inscriptionId) {
                $record = PreInscription::with('categorie')->find($inscriptionId);
                if (! $record) {
                    return;
                }
                try {
                    Mail::to($notifyTo)->send(new PreInscriptionNotification($record));
                } catch (\Throwable) {
                    // Registration is already saved.
                }
            })->afterResponse();
        }

        return response()->json(['message' => 'Pré-inscription enregistrée.', 'id' => $inscription->id], 201);
    }
}
