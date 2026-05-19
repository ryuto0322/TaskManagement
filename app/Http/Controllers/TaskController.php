<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // 1. 一覧表示
   // 1. 一覧表示
public function index()
{
    // sort_order の数字が小さい順（asc）に並び替えて取得する
    $tasks = Task::orderBy('sort_order', 'asc')->orderBy('created_at', 'desc')->get();
    public function index()
{
    // 💡 1. 綴りが「orderBy」になっているか（Bが大文字）
    // 💡 2. 最後にセミコロン「;」が忘れていないか
    $tasks = Task::orderBy('sort_order', 'asc')
                 ->orderBy('created_at', 'desc')
                 ->get();
    
    // 💡 3. compact('tasks') が正しく入っているか
    return view('tasks.index', compact('tasks'));
}
    return view('tasks.index', compact('tasks'));
}

    // 2. 作成画面表示
    public function create()
    {
        return view('tasks.create');
    }

    // 3. 保存処理
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
        ]);

        Task::create($request->all());

        return redirect()->route('tasks.index')->with('success', 'タスクが作成されました。');
    }

    // 4. 編集画面表示
    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    // 5. 更新処理
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
        ]);

        $task->update($request->all());

        return redirect()->route('tasks.index')->with('success', 'タスクが更新されました。');
    }

    // 6. 削除処理
    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'タスクが削除されました。');
    }
    public function complete(Task $task)//完了処理
    {
        $task->update([
            'is_completed' => !$task->is_completed
        ]);

        return redirect()->route('tasks.index')->with('success', 'タスクの状態を更新しました！');
    }
}