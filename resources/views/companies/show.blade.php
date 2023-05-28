<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Companies') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                {{ Html::linkRoute('companies.index', '一覧に戻る') }}

                {{ Html::linkRoute('companies.edit', '編集', compact('company')) }}

                <dl>
                    <dt class="mt-3">ID</dt>
                    <dd>{{ $company->id }}</dd>
                    <dt class="mt-3">会社名</dt>
                    <dd>{{ $company->name }}</dd>
                    <dt class="mt-3">会社作成日</dt>
                    <dd>{{ $company->created_at }}</dd>
                    <dt class="mt-3">会社更新日</dt>
                    <dd>{{ $company->updated_at }}</dd>
                </dl>

                <div class="mt-6">
                    <h3>部署一覧</h3>
                    <ul>
                        @foreach($company->sections as $section)
                            <div class="mt-2">
                                <a href="{{ route('sections.show', ['company' => $company, 'section' => $section]) }}">
                                    {{ $section->name }}
                                </a>
                                <br>
                                {{ Html::linkRoute('sections.edit', '編集', ['company' => $company, 'section' => $section]) }}
                                {{ Form::open(['route' => ['sections.destroy', 'company' => $company, 'section' => $section], 'method' => 'delete', 'style' => 'display:inline']) }}
                                {{ Form::submit('削除', ['onclick' => "return confirm('本当に削除しますか？')"]) }}
                                {{ Form::close() }}
                            </div>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
