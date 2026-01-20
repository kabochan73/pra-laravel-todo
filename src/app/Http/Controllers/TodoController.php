<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    // 一覧表示
    public function index()
    {
        $todos = Todo::orderBy('created_at', 'desc')->get();
        return view('todos.index', compact('todos'));
    }

    // 新規作成
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
        ]);

        Todo::create([
            'title' => $request->title,
        ]);

        return redirect()->route('todos.index')->with('success', 'タスクが追加されました。');
    }

    // 完了/未完了の切り替え
    public function toggle(Todo $todo)
    {
        $todo->update([
            'is_completed' => !$todo->is_completed,
        ]);

        return redirect()->route('todos.index');
    }

    // 削除
    public function destroy(Todo $todo)
    {
        $todo->delete();

        return redirect()->route('todos.index')->with('delete', 'タスクが削除されました。');
    }
}
