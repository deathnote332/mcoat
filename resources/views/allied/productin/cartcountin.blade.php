{{ \App\TempProductout::where('type',4)->where('user_id',\Illuminate\Support\Facades\Auth::user()->id)->count() }}
