<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo App</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-blue-100 min-h-screen py-8 px-4">
    <div class="max-w-xl mx-auto">
        <h1 class="text-4xl font-bold text-gray-800 mb-8">Todo App</h1>

        {{-- エラー表示 --}}
        @if ($errors->any())
            <div class="mb-4 text-red-600 text-sm">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        {{-- 新規作成フォーム --}}
        <form action="{{ route('todos.store') }}" method="POST" class="flex gap-3 mb-6">
            @csrf
            <input type="text" name="title" placeholder="新しいタスクを入力..." value="{{ old('title') }}"
                class="flex-1 px-4 py-3 border-2 border-gray-300 rounded-lg text-base focus:outline-none focus:border-blue-500">
            <button type="submit"
                class="px-6 py-3 bg-blue-500 text-white rounded-lg text-base font-medium hover:bg-blue-600 transition-colors">
                追加
            </button>
        </form>
        {{-- 成功メッセージ --}}
        @if (session('success'))
            <div class="mb-4 text-green-600 text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if (session('delete'))
            <div class="mb-4 text-red-600 text-sm">
                {{ session('delete') }}
            </div>
        @endif

        {{-- Todo一覧 --}}
        @if ($todos->isEmpty())
            <p class="text-center text-gray-500 py-10">タスクがありません</p>
        @else
            <ul class="space-y-3">
                @foreach ($todos as $todo)
                    <li class="flex items-center gap-4 p-4 bg-white rounded-lg shadow">
                        <span
                            class="flex-1 text-base {{ $todo->is_completed ? 'line-through text-gray-400' : 'text-gray-800' }}">
                            {{ $todo->title }}
                        </span>

                        {{-- 完了/未完了切り替え --}}
                        <form action="{{ route('todos.toggle', $todo) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                class="px-4 py-2 bg-green-500 text-white text-sm rounded hover:bg-green-600 transition-colors">
                                {{ $todo->is_completed ? '戻す' : '完了' }}
                            </button>
                        </form>

                        {{-- 削除 --}}
                        <form action="{{ route('todos.destroy', $todo) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="px-4 py-2 bg-red-500 text-white text-sm rounded hover:bg-red-600 transition-colors">
                                削除
                            </button>
                        </form>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</body>

</html>
