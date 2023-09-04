<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

    {{-- check if user is logged in --}}
    @auth
    <p>Congrats, you are logged in</p>

    <form action="/logout" method='POST'>
        @csrf
        <button>Log out</button>
    </form>

    <div style="border: 1px solid black">
        <h2>Create a new post</h2>
        <form action="/create-post" method="POST">
            @csrf
            <input name="title" type="text" placeholder="Title..." />
            <textarea name="body" placeholder="Body content..."></textarea>
            <button>Create new post</button>
        </form>
    </div>

    <div style="border: 1px solid black">
        <h2>All posts</h2>

        {{-- looping through a collection --}}
        @foreach($posts as $post)
            <div style="background-color: gray; padding: 10px; margin: 10px;">
                <h3>{{ $post['title'] }} by {{ $post->user->name }}</h3>
                {{ $post['body'] }}
                <p><a href="/edit-post/{{ $post->id }}">Edit</a></p>
                <form action="/delete-post/{{ $post->id }}" method="POST">
                    @csrf

                    {{-- special feature from Laravel: we can add the Delete method directly in the form --}}
                    @method('DELETE')

                    <button>Delete</button>
                </form>
            </div>
        @endforeach
    </div>

    {{-- if user is not logged in --}}
    @else
        <div style="border: 1px solid black">
            <h2>Register</h2>
            <form action="/register" method="POST">
                @csrf
                <input type="name" name="name" placeholder="name" />
                <input type="email" name="email" placeholder="email" />
                <input type="password" name="password" placeholder="password" />

                <button>Register</button>
            </form>
        </div>

        <div style="border: 1px solid black">
            <h2>Login</h2>
            <form action="/login" method="POST">
                @csrf
                <input type="name" name="loginname" placeholder="name" />
                <input type="password" name="loginpassword" placeholder="password" />

                <button>Log in</button>
            </form>
        </div>
    @endauth

    
</body>
</html>