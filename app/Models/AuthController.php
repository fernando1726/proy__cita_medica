<?php

public function register(RegisterRequest $request)
{
    $user = User::create([
        'name'     => $request->name,
        'email'    => $request->email,
        'password' => Hash::make($request->password), // bcrypt/argon2
    ]);
    // ...
}