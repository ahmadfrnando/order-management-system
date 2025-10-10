<?php

namespace App\Http\Controllers;

use App\Http\Requests\MenuRequest;
use App\Models\Category;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Str;
use PhpParser\Node\Stmt\TryCatch;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $menu = Menu::all();
        $categories = Category::all();
        return Inertia::render('Menu/Index', [
            'menu' => $menu,
            'categories' => $categories,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MenuRequest $request)
    {
        $payload = $request->validated();
        try {
            $slug = Str::slug($payload['name']);
            if ($request->hasFile('image')) {
                $folder = 'images';
                if (!Storage::disk('public')->exists($folder)) {
                    Storage::disk('public')->makeDirectory($folder);
                }
                $fileName = $slug . '.' . $request->file('image')->extension();
                $request->file('image')->storeAs($folder, $fileName, 'public');
                $payload['image'] = 'storage/' . $folder . '/' . $fileName;
            }

            Menu::create($payload);

            return redirect()->back()->with([
                'flash' => [
                    'type' => 'success',
                    'message' => 'Menu telah selesai disimpan!'
                ]
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with([
                'flash' => [
                    'type' => 'error',
                    'message' => 'Terjadi kesalahan saat menyimpan menu: ' . $th->getMessage()
                ]
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MenuRequest $request, Menu $menu)
    {   
        $payload = $request->validated();
        try {
            if( $request->hasFile('image')) {
                // delete old image if exists
                if ($menu->image && Storage::disk('public')->exists(str_replace('storage/', '', $menu->image))) {
                    Storage::disk('public')->delete(str_replace('storage/', '', $menu->image));
                }
                $slug = Str::slug($request->name);
                $folder = 'images';
                if (!Storage::disk('public')->exists($folder)) {
                    Storage::disk('public')->makeDirectory($folder);
                }
                $fileName = $slug . '.' . $request->file('image')->extension();
                $request->file('image')->storeAs($folder, $fileName, 'public');
                $payload = array_merge($payload, ['image' => 'storage/' . $folder . '/' . $fileName]);
            } else {
                $payload = array_merge($payload, ['image' => $menu->image]);
            }
            $menu->update($payload);
            return redirect()->back()->with([
                'flash' => [
                    'type' => 'success',
                    'message' => 'Menu telah selesai disimpan!'
                ]
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with([
                'flash' => [
                    'type' => 'error',
                    'message' => 'Terjadi kesalahan saat menyimpan menu: ' . $th->getMessage()
                ]
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {   
        try {
            $menu = Menu::findOrFail($id)->delete();
            return redirect()->back()->with([
                    'flash' => [
                        'type' => 'success',
                        'message' => 'Menu telah berhasil dihapus!'
                    ]
                ]);
        } catch (\Throwable $th) {
            return redirect()->back()->with([
                'flash' => [
                    'type' => 'error',
                    'message' => 'Terjadi kesalahan saat menghapus menu: ' . $th->getMessage()
                ]
            ]);
        }
    }
}
