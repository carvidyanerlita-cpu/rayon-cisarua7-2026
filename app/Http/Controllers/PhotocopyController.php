<?php

namespace App\Http\Controllers;

use App\Models\Photocopy;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PhotocopyController extends Controller
{
    public function index(): View
    {
        $photocopies = Photocopy::latest()->get();

        return view('photocopy.index', compact('photocopies'));
    }

    public function store(Request $request): RedirectResponse
    {
        $user = Auth::user();
        if (! $user || ! $user->isAdmin()) {
            return redirect()->route('photocopy.index')
                ->with('error', 'Hanya Pengurus/Admin yang berhak menambahkan lokasi fotokopi.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'distance' => ['required', 'string', 'max:100'],
            'hours' => ['required', 'string', 'max:100'],
            'map_url' => ['required', 'url'],
            'services' => ['required', 'array'],
            'prices' => ['required', 'array'],
            'notes' => ['nullable', 'array'],
        ]);

        $priceList = [];
        foreach ($validated['services'] as $index => $service) {
            if (! empty($service)) {
                $priceList[] = [
                    'service' => $service,
                    'price' => $validated['prices'][$index] ?? '-',
                    'note' => $validated['notes'][$index] ?? '',
                ];
            }
        }

        Photocopy::create([
            'name' => $validated['name'],
            'distance' => $validated['distance'],
            'hours' => $validated['hours'],
            'map_url' => $validated['map_url'],
            'price_list' => $priceList,
        ]);

        return redirect()->route('photocopy.index')
            ->with('success', 'Lokasi fotokopi baru berhasil ditambahkan.');
    }

    public function destroy(Photocopy $photocopy): RedirectResponse
    {
        $user = Auth::user();
        if (! $user || ! $user->isAdmin()) {
            return redirect()->route('photocopy.index')
                ->with('error', 'Hanya Pengurus/Admin yang berhak menghapus lokasi fotokopi.');
        }

        $name = $photocopy->name;
        $photocopy->delete();

        return redirect()->route('photocopy.index')
            ->with('success', "Data {$name} berhasil dihapus.");
    }
}
