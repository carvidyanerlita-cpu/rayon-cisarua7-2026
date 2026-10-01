<?php

namespace App\Http\Controllers;

use App\Models\BkPost;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class BkController extends Controller
{
    public function index(Request $request): View
    {
        $category = $request->input('category');

        $articlesQuery = BkPost::articles()->latest();
        if ($category && $category !== 'Semua') {
            $articlesQuery->where('category', $category);
        }
        $articles = $articlesQuery->get();

        $user = Auth::user();
        // HANYA ADMIN
        $isAdmin = $user && $user->role === 'admin';

        return view('bk.index', compact(
            'articles',
            'isAdmin',
            'category'
        ));
    }

    public function storeArticle(Request $request): RedirectResponse
    {
        $user = Auth::user();
        
        // HANYA ADMIN
        if (! $user || $user->role !== 'admin') {
            return redirect()->route('bk.index')
                ->with('error', 'Akses ditolak. Hanya Admin yang diizinkan mengunggah infografis.');
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:200'],
            'category' => ['required', 'string', 'max:100'],
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'content' => ['nullable', 'string'],
        ]);

        $imagePath = $request->file('image')->store('infographics', 'public');

        BkPost::create([
            'type' => 'ARTICLE',
            'title' => $validated['title'],
            'category' => $validated['category'],
            'image' => $imagePath,
            'content' => $validated['content'] ?? null,
            'author' => 'Admin',
            'status' => 'Dipublikasikan',
        ]);

        return redirect()->route('bk.index')
            ->with('success', 'Infografis berhasil diunggah!');
    }

    public function destroy(BkPost $post): RedirectResponse
    {
        $user = Auth::user();

        // HANYA ADMIN
        if (! $user || $user->role !== 'admin') {
            return redirect()->route('bk.index')->with('error', 'Akses ditolak.');
        }

        if ($post->image && Storage::disk('public')->exists($post->image)) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return redirect()->route('bk.index')->with('success', 'Infografis berhasil dihapus.');
    }
}