<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Experience;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;


class ProfController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //select = from profiles;
        $profiles = Profile::all();
        return view('admin.profile.index', compact('profiles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.profile.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'picture' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nama_lengkap' => 'required|string|max:55',
            'no_telpon' => 'required|string|max:15',
            'email' => 'required|string|email|max:55',
            'description' => 'nullable|string',
            'facebook' => 'nullable|url',
            'twitter' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'instagram' => 'nullable|url',
            'alamat' => 'nullable|string|max:250'
        ]);
        //menghandle file upload-an
        if ($request->hasFile('picture')) {
            $image = $request->file('picture');
            $path = $image->store('public/image');
            $name = basename($path); //menyimpan nama filenya saja
        }
        // Insert into profiles() value() :
        profile::create([
            'picture' => $name,
            'nama_lengkap' => $request->nama_lengkap,
            'no_telpon' => $request->no_telpon,
            'email' => $request->email,
            'description' => $request->description,
            'facebook' => $request->facebook,
            'twitter' => $request->twitter,
            'linkedin' => $request->linkedin,
            'instagram' => $request->instagram,
            'alamat' => $request->alamat
        ]);
        return redirect()->route('profiles.index')->with('success', 'Data berhasil ditambah');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Profile::findOrFail($id);
        $idprofile = $data->id;
        $experience = Experience::where('id_profile', $idprofile)->get();


        $pdf = pdf::loadView('admin.generate-pdf.index', compact(['data', 'experience']));

        return $pdf->download('portofolio.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $profile = Profile::findOrfail($id);
        return view('admin.profile.edit', compact('profile'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $profile = Profile::findOrFail($id);
        $request->validate([
            'picture' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nama_lengkap' => 'required|string|max:55',
            'no_telpon' => 'required|string|max:15',
            'email' => 'required|string|email|max:55',
            'description' => 'nullable|string',
            'facebook' => 'nullable|url',
            'twitter' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'instagram' => 'nullable|url',
            'alamat' => 'nullable|string|max:250'
        ]);
        //simpan gambar jika ada di upload
        if ($request->hasFile('picture')) {
            //Hapus gambar lama jika ada :
            if ($profile->picture) {
                Storage::delete('public/image/' . $profile->picture);
            }
            $image = $request->file('picture');
            $path = $image->store('public/image');
            $name = basename($path);
            $profile->picture = $name;
        }
        $profile->nama_lengkap = $request->nama_lengkap;
        $profile->alamat = $request->alamat;
        $profile->no_telpon = $request->no_telpon;
        $profile->email = $request->email;
        $profile->facebook = $request->facebook;
        $profile->twitter = $request->twitter;
        $profile->linkedin = $request->linkedin;
        $profile->instagram = $request->instagram;
        $profile->description = $request->description;
        $profile->save();

        return redirect()->route('profiles.index')->with('success', 'Update Profile berhasil');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $profile = Profile::withTrashed()->findOrFail($id);
        if ($profile->picture) {
            Storage::delete('public/image/', $profile->picture);
        }

        $profile->forceDelete();
        return redirect()->route('profiles.index')->with('success', 'Data berhasil dihapus');
    }

    public function softDelete(string $id)
    {
        $profile = Profile::findOrfail($id);
        $profile->delete();

        return redirect()->route('profiles.index')->with('success', 'Update Profile berhasil');
    }

    // public function backToData() {}

    public function updateStatus($id): JsonResponse
    {
        // Select Profile nya berdasarkan bukan id baru di update menjadi 0
        Profile::where('id', '!=', $id)->update(['status' => 0]);
        // Select profile nya berdasarkan id lalu di update menjadi 1
        $profile = Profile::findOrFail($id);
        $profile->status = 1;
        $profile->save();

        return response()->json(['success' => 'status berhasil di perbarui']);
    }

    public function recycle()
    {
        $profiles = profile::onlyTrashed()->paginate(15);
        return view('admin.profile.recycle', compact('profiles'));
    }

    public function restore($id)
    {
        $profile = profile::withTrashed()->findOrFail($id);
        $profile->restore();

        return redirect()->route('profiles.index')->with('success', 'data berhasil di restore');
    }
}
