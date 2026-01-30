<?php

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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('landing');
})->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/consultations', \App\Livewire\ConsultationList::class)->name('consultations.list');
    Route::get('/consultation-calendar', \App\Livewire\ConsultationCalendar::class)->name('consultations.calendar');
    Route::get('/consultation-new', \App\Livewire\OptometryConsultation::class)->name('consultation.new');
    Route::get('/consultation/{consultation}/edit', \App\Livewire\OptometryConsultation::class)->name('consultation.edit');
});
