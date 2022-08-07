<?php

namespace App\Http\Controllers;

use App\Imports\SinifImport;
use App\Models\Sinif;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class ClassController extends Controller
{
    /* SINIFLAR */

    public function classes()
    {
        $classes = Sinif::all();
        return view('admin.pages.add-classes', compact('classes'));
    }

    public function addClasses(Request $request)
    {
        $file = $request->file('file')->store('class');

        $request->validate([
            'file' => 'required',
        ]);

        if (empty($file))
        {
            return back()
                ->with('message_warning', 'Lütfen herhangi bir dosya seçin...');
        }
        else
        {
            try {
                $import = new SinifImport();
                $import->import($file);

                return back()
                    ->with('message_success', 'Excel dosyası başarıyla aktarıldı.');
            } catch (Throwable $e) {
                return back()
                    ->with('message_danger', $e->getMessage()/*'Yüklemeye çalıştığınız veriler, veritabanında kayıtlı verilerle aynı veya verilerde bir hata var!'*/);
            }
        }
    }

    public function addClass()
    {
        return view('admin.pages.add-class');
    }

    public function addClassData(Request $request)
    {
        try {
            $request->validate( [
                'sinav_ili' =>'required',
                'universite' => 'required',
                'fakulte' => 'required',
                'kat' => 'required',
                'sinif' => 'required',
                'kapasite' => 'required|numeric'
            ]);

            $credentials = [
                'sinav_ili' => $request->input('sinav_ili'),
                'universite' => $request->input('universite'),
                'fakulte' => $request->input('fakulte'),
                'kat' => $request->input('kat'),
                'sinif' => $request->input('sinif'),
                'kapasite' => $request->input('kapasite')
            ];

            Sinif::create($credentials);

            return back()
                ->with('message_success', 'Ekleme işlemi başarıyla tamamlandı.');
        } catch (Exception $e) {
            return back()
                ->with('message_danger', 'Ekleme işlemi yapılamadı');
        }
    }

    public function listClassData()
    {
        $classes = Sinif::all();
        $capacity = Sinif::sum('kapasite');
        $documents = DB::table('sinav_giris_belge')->count('id');
        return view('admin.pages.list-class-data', compact('classes', 'capacity', 'documents'));
    }

    public function deleteClass($id)
    {
        Sinif::destroy($id);
        return back()
            ->with('message_delete', 'Sınıf başarıyla silindi.');
    }

    public function deleteAllClass()
    {
        Sinif::truncate();
        DB::table('sinav_giris_belge')->delete();
        DB::table('kullanilan_sinif_sayisi')->delete();
        return back()
            ->with('delete_all', 'Sınıflar başarıyla silindi.');
    }

    public function editClass($id)
    {
        $siniflar = Sinif::where('id', $id)->get();
        $sinif = $siniflar[0];
        return view('admin.pages.edit-class', compact('sinif'));
    }

    public function updateClass()
    {

        Sinif::where('id', request('id'))->update([
            'sinav_ili' => request('sinav_ili'),
            'universite' => request('universite'),
            'fakulte' => request('fakulte'),
            'kat' => request('kat'),
            'sinif' => request('sinif'),
            'kapasite' => request('kapasite')
        ]);

        return redirect()->intended('admin/siniflar/sinif-listele')
            ->with('message_update', 'Sınıf biilgisi başarıyla güncellendi');
    }
}
