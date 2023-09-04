<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Edit Post</h1>
    <form action="/edit-post/{{ $post->id }}" method="POST">
        @csrf

        {{-- Change method to 'PUT' thanks to laravel feature --}}
        @method('PUT')

        <input name="title" value="{{ $post->title }}"" />
        <textarea name="body">{{  $post->body }}</textarea>

        <button>Save changes</button>
    </form>
</body>
</html>