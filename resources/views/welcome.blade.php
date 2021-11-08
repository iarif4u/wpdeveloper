<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
</head>
<body class="antialiased">
<div class="container mb-2">
    <h2>Github Bot</h2>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if(isset($message))
        <div class="alert alert-danger">
            {{$message}}
        </div>
    @endif
    <form action="{{route('store')}}" method="post" autocomplete="off">
        @csrf
        <div class="form-group">
            <label for="username">Github Username</label>
            <input value="{{old('username')}}" type="text" name="username" class="form-control" id="username"
                   placeholder="Taylorotwell">
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
    </form>
    @if(isset($user))
        <div class="row">
            <img width="200" height="200" src="{{$user->avatar}}" alt="{{$user->username}}">
            <h2>{{$user->name}}</h2>
        </div>
        <div class="row">
            <div class="offset-2">
                <h4>Repositories</h4>
                @if($user->repositories->count()>0)
                    <ol>
                        @foreach($user->repositories as $repository)
                            <li>{{$repository->full_name}}</li>
                        @endforeach
                    </ol>
                @endif
            </div>
        </div>
    @endif
</div>
</body>
</html>
