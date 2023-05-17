<h1>会社一覧</h1>
<form action="/companies/create">
    <button type="submit">会社作成</button>
</form>

@foreach ($companies as $company)
    <div>
        <h2>{{ $company->name }}</h2>
        <p>{{ $company->description }}</p>
        <a href="{{ route('companies.show', $company) }}">詳細を見る</a>
    </div>
@endforeach

