<a href="{{ route('sections.show', ['company' => $company, 'section' => $section]) }}">
    {{ $section->name }}
</a>
<form action="{{ route('section_user.store', ['company' => $company, 'section' => $section]) }}" method="POST">
    @csrf
    <select name="user_id">
        @foreach($unjoin_users as $user)
            <option value="{{ $user->id }}">{{ $user->name }}</option>
        @endforeach
    </select>
    <button type="submit">部署に追加する</button>
    <h2>所属しているユーザー</h2>
    @foreach($section->users as $user)
        <option value="{{ $user->id }}">{{ $user->name }}</option>
    @endforeach
</form>
