<div>
    <form method="POST">
        {{ csrf_field() }}
        Category name:
        <input type="text" name="name" required>
        <br/>
        Category root:
        <select name="parent_id">
            <option value="0">root</option>
            @foreach($allCategories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
        <br/>
        <input type="submit">
    </form>
</div>