Route::filter('auth.basic', function()
{
    return Auth::basic('username');
});