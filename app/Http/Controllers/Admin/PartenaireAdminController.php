<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partenaire;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class PartenaireAdminController extends Controller
{
    public function index()
    {
        $partenaires = Partenaire::orderBy('ordre')->orderBy('nom')->paginate(20);

        return view('admin.partenaires.index', compact('partenaires'));
    }

    public function create()
    {
        return view('admin.partenaires.create');
    }

    public function store(Request $request)
    {
        Partenaire::create($this->validated($request));

        return redirect()->route('admin.partenaires.index')->with('success', 'Partenaire ajouté.');
    }

    public function edit(Partenaire $partenaire)
    {
        return view('admin.partenaires.edit', compact('partenaire'));
    }

    public function update(Request $request, Partenaire $partenaire)
    {
        $partenaire->update($this->validated($request, $partenaire));

        return redirect()->route('admin.partenaires.index')->with('success', 'Partenaire mis à jour.');
    }

    public function destroy(Partenaire $partenaire)
    {
        $this->deleteLocalLogo($partenaire->logo);
        $partenaire->delete();

        return redirect()->route('admin.partenaires.index')->with('success', 'Partenaire supprimé.');
    }

    public function reorder(Request $request)
    {
        $request->validate(['ids' => 'required|array', 'ids.*' => 'integer|exists:partenaires,id']);

        foreach ($request->ids as $index => $id) {
            Partenaire::where('id', $id)->update(['ordre' => $index]);
        }

        return back()->with('success', 'Ordre des partenaires mis à jour.');
    }

    private function validated(Request $request, ?Partenaire $existing = null): array
    {
        $data = $request->validate([
            'nom' => 'required|string|max:255',
            'logo' => 'nullable|image|max:2048',
            'logo_url' => 'nullable|url|max:500',
            'description' => 'nullable|string|max:500',
            'url' => 'nullable|url|max:500',
            'ordre' => 'nullable|integer|min:0',
            'actif' => 'nullable|boolean',
        ]);

        if ($request->hasFile('logo')) {
            $data['logo'] = $this->storeLocalLogo($request->file('logo'), $existing?->logo);
        } elseif ($request->filled('logo_url')) {
            if ($existing && $this->isLocalLogoPath($existing->logo)) {
                $this->deleteLocalLogo($existing->logo);
            }
            $data['logo'] = $request->input('logo_url');
        } elseif ($existing) {
            $data['logo'] = $existing->logo;
        } else {
            throw ValidationException::withMessages([
                'logo' => 'Ajoutez un fichier logo ou une URL.',
            ]);
        }

        unset($data['logo_url']);

        $data['actif'] = $request->boolean('actif', true);
        $data['ordre'] = $data['ordre'] ?? (int) Partenaire::max('ordre') + 1;

        return $data;
    }

    private function storeLocalLogo(UploadedFile $file, ?string $previousLogo = null): string
    {
        $directory = public_path('upload/partenaires');
        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $base = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) ?: 'logo';
        $extension = strtolower($file->getClientOriginalExtension() ?: 'jpg');
        $filename = $base.'-'.Str::random(8).'.'.$extension;

        $file->move($directory, $filename);

        if ($previousLogo && $this->isLocalLogoPath($previousLogo)) {
            $this->deleteLocalLogo($previousLogo);
        }

        return 'upload/partenaires/'.$filename;
    }

    private function isLocalLogoPath(?string $logo): bool
    {
        return is_string($logo) && str_starts_with($logo, 'upload/partenaires/');
    }

    private function deleteLocalLogo(?string $logo): void
    {
        if (! $this->isLocalLogoPath($logo)) {
            return;
        }

        $path = public_path($logo);
        if (is_file($path)) {
            @unlink($path);
        }
    }
}
