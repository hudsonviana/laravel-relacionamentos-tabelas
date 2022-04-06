<?php

use App\Models\{
    User,
    Preference
};

use Illuminate\Support\Facades\Route;

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
