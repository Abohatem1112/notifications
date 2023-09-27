<h1>create a new post</h1>
<form action="{{ route('posts.store') }}" method="POST">
    @csrf
    <input type="text" name="title" placeholder="enter title">
    <input type="text" name="body" placeholder="enter body">
    <button type="submit">submit</button>


</form>
