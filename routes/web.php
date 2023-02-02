<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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

Route::get('/', function () {
    return view('index');
})->name('index');

// Route::get('/result', function () {
//     return view('result');
// })->name('result');

Route::post('/', function (Request $request) {
    $employees = [];
    $total_female = 0;
    $total_male_married_rich = 0;
    $total_female_widow_not_poor = 0;
    for ($i=0; $i < 5; $i++) {
        $employee = [
            'name' => $request->input('name'. ($i + 1) ),
            'lastname' => $request->input('lastname'. ($i + 1) ),
            'age' => $request->input('age'. ($i + 1) ),
            'status' => $request->input('civilStatus'. ($i + 1) ),
            'gender' => $request->input('gender'. ($i + 1) ),
            'salary' => $request->input('salary'. ($i + 1) )
        ];
        array_push($employees, $employee);
        if ($employee['gender'] === 'f') $total_female += 1;
        if ($employee['gender'] === 'm' && $employee['status'] === 'casado' && intval($employee['salary']) > 2500) $total_male_married_rich += 1;
        if ($employee['gender'] === 'f' && $employee['status'] === 'viudo' && intval($employee['salary']) > 1000) $total_female_widow_not_poor += 1;
    }
    $male_count = 0;
    $male_ages_sum = 0;
    foreach ($employee as $key => $value) {
        if ($employee['gender'] === 'm') {
            $male_count += 1;
            $male_ages_sum += intval($employee['age']);
        }
    }
    $result = [
        'employees' => $employees,
        'total_female' => $total_female,
        'total_male_married_rich' => $total_male_married_rich,
        'total_female_widow_not_poor' => $total_female_widow_not_poor,
        'male_age_average' => ($male_ages_sum / $male_count)
    ];

    // return redirect()->route('result')->with('result', $result);
    return view('result', compact('result'));
})->name('index.submit');
