<?php

use App\Models\{
    Course,
    Image,
    Permission,
    User,
    Preference
};

use Illuminate\Support\Facades\Route;

Route::get('/one-to-many-polimorphic', function () {
    $course = Course::find(1);

    $course->comments()->create([
        'subject' => 'Novo (2) comentário',
        'content' => 'Apenas (2) um comentário'
    ]);

    $course->refresh();
    dd($course->comments);
});

Route::get('/one-to-one-polimorphic', function () {
    $user = User::find(6);

    $data = ['path' => 'path/nome-imagem-teste.gif'];

    if ($user->image) {
        $user->image->update($data);
    } else {
        // $user->image()->save(new Image($data));
        $user->image()->create($data);
    }
    
    dd($user->image);
});

Route::get('/many-to-many-pivot', function () {
    $user = User::with('permissions')->find(9);

    $user->permissions()->attach([
        1 => ['active' => false], // {id-da-permissão} => ['active' => true/false]
        4 => ['active' => true] // {id-da-permissão} => ['active' => true/false]
    ]);
    $user->refresh();
    echo $user->name, "<br><br>";
    foreach ($user->permissions as $permission) {
        echo "• {$permission->name} - {$permission->pivot->active}<br>";
    }
});

Route::get('/many-to-many', function () {
    $user = User::with('permissions')->find(3);
    $permission = Permission::find(2);

    // $user->permissions()->save($permission); // salva uma nova permissão
    // $user->permissions()->sync([3]); // apaga as permissoões existentes e insere a indicada
    $user->permissions()->attach([1, 4]); // insere as permissões indicadas, sem apagar as existentes

    $user->refresh();

    dd($user);
});

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
