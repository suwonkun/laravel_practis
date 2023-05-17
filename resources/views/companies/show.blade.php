<h1>詳細画面</h1>
<h2>{{ $company->name }}</h2>


<p>作成日時: {{ $company->created_at }}</p>
<p>更新日時: {{ $company->updated_at }}</p>

<form action="/companies">
    <button type="submit">戻る</button>
</form>

<form method="POST" action="{{ route('companies.destroy', $company) }}">
    @csrf
    @method('DELETE')
    <button type="submit">削除</button>
</form>
