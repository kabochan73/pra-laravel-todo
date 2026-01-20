<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo App</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'Hiragino Sans', 'Meiryo', sans-serif;
            background-color: #f5f5f5;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }
        .todo-form {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }
        .todo-form input[type="text"] {
            flex: 1;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 6px;
            font-size: 16px;
        }
        .todo-form input[type="text"]:focus {
            outline: none;
            border-color: #007bff;
        }
        .todo-form button {
            padding: 12px 24px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
        }
        .todo-form button:hover {
            background-color: #0056b3;
        }
        .error {
            color: #dc3545;
            margin-bottom: 10px;
            font-size: 14px;
        }
        .todo-list {
            list-style: none;
        }
        .todo-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 15px;
            background-color: white;
            border-radius: 6px;
            margin-bottom: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .todo-item.completed .todo-title {
            text-decoration: line-through;
            color: #888;
        }
        .todo-title {
            flex: 1;
            font-size: 16px;
        }
        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }
        .btn-toggle {
            background-color: #28a745;
            color: white;
        }
        .btn-toggle:hover {
            background-color: #1e7e34;
        }
        .btn-delete {
            background-color: #dc3545;
            color: white;
        }
        .btn-delete:hover {
            background-color: #c82333;
        }
        .empty-message {
            text-align: center;
            color: #888;
            padding: 40px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Todo App</h1>

        {{-- エラー表示 --}}
        @if ($errors->any())
            <div class="error">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        {{-- 新規作成フォーム --}}
        <form action="{{ route('todos.store') }}" method="POST" class="todo-form">
            @csrf
            <input type="text" name="title" placeholder="新しいタスクを入力..." value="{{ old('title') }}">
            <button type="submit">追加</button>
        </form>

        {{-- Todo一覧 --}}
        @if ($todos->isEmpty())
            <p class="empty-message">タスクがありません</p>
        @else
            <ul class="todo-list">
                @foreach ($todos as $todo)
                    <li class="todo-item {{ $todo->is_completed ? 'completed' : '' }}">
                        <span class="todo-title">{{ $todo->title }}</span>

                        {{-- 完了/未完了切り替え --}}
                        <form action="{{ route('todos.toggle', $todo) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-toggle">
                                {{ $todo->is_completed ? '未完了に戻す' : '完了' }}
                            </button>
                        </form>

                        {{-- 削除 --}}
                        <form action="{{ route('todos.destroy', $todo) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-delete">削除</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</body>
</html>
