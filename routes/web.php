<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\EleveController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\FormateurController;
use App\Http\Controllers\FormationController;
use App\Http\Controllers\SalleController;
use App\Http\Controllers\EmploiDuTempsController;

Auth::routes();

// Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::resource('services', ServiceController::class);
    
    // User Management Routes - Only accessible to admin users
    Route::get('/users', [App\Http\Controllers\UserManagementController::class, 'index'])->name('users.index');
    Route::get('/users/create', [App\Http\Controllers\UserManagementController::class, 'create'])->name('users.create');
    Route::post('/users', [App\Http\Controllers\UserManagementController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [App\Http\Controllers\UserManagementController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [App\Http\Controllers\UserManagementController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [App\Http\Controllers\UserManagementController::class, 'destroy'])->name('users.destroy');
});

Route::get('/public', [ServiceController::class, 'public'])->name('public');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});
Route::get('/profile/password', [ProfileController::class, 'passwordForm'])->name('profile.password.form');
Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');


Route::resource('news', NewsController::class)->middleware('auth');
Route::patch('/news/{news}/toggle-active', [NewsController::class, 'toggleActive'])->name('news.toggleActive');


Route::middleware(['auth'])->group(function () {
    Route::resource('eleves', EleveController::class)->parameters([
        'eleves' => 'eleve'
    ]);
});

// Paiement routes
Route::middleware(['auth'])->group(function () {
    Route::resource('paiements', PaiementController::class);
    Route::patch('/paiements/{paiement}/toggle-confirmation', [PaiementController::class, 'toggleConfirmation'])->name('paiements.toggleConfirmation');
    Route::get('/eleves/{eleve}/paiements', [PaiementController::class, 'elevePaiements'])->name('paiements.eleve');
    Route::get('/formations/{formation}/paiements', [PaiementController::class, 'formationPaiements'])->name('paiements.formation');
});



Route::resource('formateurs', FormateurController::class);

// Formation routes
Route::resource('formations', FormationController::class);
Route::get('/formations/{formation}/eleves', [FormationController::class, 'eleves'])->name('formations.eleves');
Route::get('/formations/{formation}/eleves/payes', [FormationController::class, 'elevesPayes'])->name('formations.eleves.payes');
Route::get('/formations/{formation}/eleves/non-payes', [FormationController::class, 'elevesNonPayes'])->name('formations.eleves.non-payes');
Route::get('/formations/{formation}/inscription', [FormationController::class, 'inscriptionForm'])->name('formations.inscription.form');
Route::post('/formations/{formation}/inscription', [FormationController::class, 'inscription'])->name('formations.inscription');
Route::patch('/formations/{formation}/eleves/{eleve}/statut', [FormationController::class, 'updateStatut'])->name('formations.eleves.statut');
Route::get('/formations/filter', [FormationController::class, 'filterByLevel'])->name('formations.filter');

// Salle (Classroom) routes
Route::resource('salles', SalleController::class);
Route::get('/emploi-du-temps', [SalleController::class, 'emploiDuTemps'])->name('salles.emploi-du-temps');
Route::post('/salles/check-availability', [SalleController::class, 'checkAvailability'])->name('salles.check-availability');

// Emploi du temps (Schedule) routes
Route::resource('emploi-du-temps', EmploiDuTempsController::class);
Route::get('/formateurs/{formateur}/emploi-du-temps', [EmploiDuTempsController::class, 'formateurSchedule'])->name('emploi-du-temps.formateur');
Route::get('/formations/{formation}/emploi-du-temps', [EmploiDuTempsController::class, 'formationSchedule'])->name('emploi-du-temps.formation');

