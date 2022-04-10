<?php

use App\Models\{
    Course,
    User,
    Preference
};

use Illuminate\Support\Facades\Route;

Route::get('/one-to-many', function () {
    // $course = Course::create(['name' => 'Curso de Laravel']);
    $course = Course::with('modules.lessons')->first();
    

    echo "<h2>Curso: {$course->name}</h2>";
    echo "<ol>";
        foreach ($course->modules as $module) {
            echo "<li>";
                echo $module->name;
                echo "<ul>";
                    foreach ($module->lessons as $lesson) {
                        echo "<li>{$lesson->name}</li>";
                    }
                echo "</ul>";
            echo "</li>";
        }
    echo "</ol>";

    dd($course);

    $data = [
        'name' => 'Módulo xx3 - complemento'
    ];

    $course->modules()->create($data);
    $course->refresh();

    $modules = $course->modules;
    dd($modules);
});

Route::get('/one-to-one', function () {
    $user = User::with('preference')->find(2);

    $data = [
        'background_color' => '#000'
    ];
    
    if ($user->preference) {
        $user->preference->update($data);
    } else {
        // $user->preference()->create($data); // uma forma de se fazer
        $preference = new Preference($data);
        $user->preference()->save($preference); // outra forma de se fazer
    }
    
    $user->refresh();

    $user->preference->delete();

    dd($user->preference);
});

Route::get('/', function () {
    return view('welcome');
});
