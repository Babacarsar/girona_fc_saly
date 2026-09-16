<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PreInscription;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PreInscriptionAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = PreInscription::with('categorie')->latest();

        if ($request->boolean('non_traite')) {
            $query->where('traite', false);
        }

        $inscriptions = $query->paginate(25)->withQueryString();

        return view('admin.pre_inscriptions.index', compact('inscriptions'));
    }

    public function toggleTraite(PreInscription $preInscription)
    {
        $preInscription->update(['traite' => ! $preInscription->traite]);

        return back()->with('success', 'Statut mis à jour.');
    }

    public function export(): StreamedResponse
    {
        $filename = 'pre-inscriptions-'.now()->format('Y-m-d').'.csv';

        return response()->streamDownload(function () {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, [
                'ID', 'Prénom', 'Nom', 'Date naissance', 'Catégorie',
                'Email parent', 'Téléphone', 'Message', 'Traité', 'Créé le',
            ], ';');

            PreInscription::with('categorie')->orderBy('id')->chunk(200, function ($rows) use ($handle) {
                foreach ($rows as $row) {
                    fputcsv($handle, [
                        $row->id,
                        $row->prenom,
                        $row->nom,
                        $row->date_naissance->format('Y-m-d'),
                        $row->categorie->nom ?? '',
                        $row->email_parent,
                        $row->telephone,
                        $row->message,
                        $row->traite ? 'oui' : 'non',
                        $row->created_at->format('Y-m-d H:i'),
                    ], ';');
                }
            });

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }
}
