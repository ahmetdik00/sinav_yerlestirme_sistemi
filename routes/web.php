<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [LoginController::class, 'login_form'])->name('giris');
Route::post('/', [LoginController::class, 'login']);
Route::post('signout', [LoginController::class, 'signout'])->name('oturumu-kapat');

Route::get('/kullanici-dogrula', [LoginController::class, 'authetication_form'])->name('authetication');
Route::post('/kullanici-dogrula', [LoginController::class, 'authetication']);

Route::prefix('admin')->middleware('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin');

    Route::get('ogrenciler', [StudentController::class, 'students'])->name('ogrenciler');
    Route::post('ogrenciler', [StudentController::class, 'addStudent'])->name('ogrenci-ekle');
    Route::get('ogrenciler/ogrenci-listele', [StudentController::class, 'listStudentData'])->name('ogrenci-listele');
    Route::get('ogrenciler/sil', [StudentController::class, 'deleteAllstudent']);
    Route::get('ogrenciler/giris-belgesi/{aday_no}', [StudentController::class, 'entryDocument'])->name('giris-belgesi');
    Route::get('ogrenciler/giris-belgesi/yazdir/{aday_no?}', [StudentController::class, 'entryDocumentPrint'])->name('giris-belgesi-pdf');
    Route::get('ogrenciler/sonuc-belgesi/{aday_no}/{email}', [StudentController::class, 'resultDocument'])->name('sonuc-belgesi');
    Route::get('ogrenciler/sonuc-belgesi/yazdir/{aday_no}/{email}', [StudentController::class, 'resultDocumentPrint'])->name('sonuc-belgesi-pdf');
    Route::get('ogrenciler/sonuc-bilgileri/sil', [StudentController::class, 'deleteAllResultOfExam'])->name('sonucları-sil');

    Route::get('siniflar', [ClassController::class, 'classes'])->name('siniflar');
    Route::post('siniflar', [ClassController::class, 'addClasses'])->name('siniflar-ekle');
    Route::get('siniflar/sinif-ekle', [ClassController::class, 'addClass'])->name('sinif-ekle');
    Route::post('siniflar/sinif-ekle', [ClassController::class, 'addClassData']);
    Route::get('siniflar/sinif-listele', [ClassController::class, 'listClassData'])->name('sinif-listele');
    Route::get('siniflar/sinif-duzenle/{id}', [ClassController::class, 'editClass'])->name('sinif');
    Route::post('siniflar/sinif-duzenle', [ClassController::class, 'updateClass'])->name('sinif-duzenle');
    Route::get('siniflar/sinif-listele/sil/{id}', [ClassController::class, 'deleteClass']);
    Route::get('siniflar/sil', [ClassController::class, 'deleteAllclass']);


    Route::get('sinav', [ExamController::class, 'exam'])->name('sinav');
    Route::get('sinav-yerlestir', [ExamController::class, 'examPlace'])->name('sinif-yerlestir');
    Route::get('sinav/sinif-goruntule/{universite}/{sinif}', [ExamController::class, 'showClass'])->name('sinif-goruntule');
    Route::get('sinav/sil', [ExamController::class, 'deleteAllPlaces']);
    Route::get('sinav/sinav-siniflari', [ExamController::class, 'listExamClass'])->name('sinav-siniflari');
    Route::get('sinav/sinav-sonuclari', [ExamController::class, 'resultOfExam'])->name('sinav-sonuclari');
    Route::post('sinav/sinav-sonuclari', [ExamController::class, 'uploadResultOfExam'])->name('sinav-sonuclari-yukle');
});



Route::prefix('kullanici')->middleware('student')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('user');
    Route::get('giris-belge', [UserController::class, 'entryDocument'])->name('giris-belge');
    Route::get('giris-belge/goruntule', [UserController::class, 'entryDocumentPrintOut'])->name('giris-belge-cikti');
    Route::get('sonuc-belge', [UserController::class, 'resultDocument'])->name('sonuc-belge');
    Route::get('sonuc-belge/goruntule', [UserController::class, 'resultDocumentPrintOut'])->name('sonuc-belge-cikti');
});


