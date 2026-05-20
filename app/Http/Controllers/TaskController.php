<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
public function index()
{
    // 【修正】まだ完了していない（is_completed が false の）タスクだけを並び替えて取得する
    $tasks = Task::where('is_completed', false)
                ->where('is_deleted',false)
                ->orderBy('sort_order', 'asc')
                ->get();

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
            'due_date' => 'nullable|date',
            'sort_order' => 'required|integer|in:1,2,3',
        ]);

        $maxOrder = Task::max('sort_order')??0;

        Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'sort_order' => $maxOrder + 1,
        ]);

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
        // 1. 入力チェック
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'due_date' => 'nullable|date',
        ]);

        // 💡 ここを追加：期限が空っぽ（null）なら、今日の日付を代わりにセットする
        $dueDate = $request->due_date ?? now()->format('Y-m-d');

        // 2. データベースを更新
        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $dueDate, // 💡 安全になった日付を入れる
            'sort_order' => $request->sort_order, // 🟢 「高・中・低」の数字をそのまま保存！
        ]);

        return redirect()->route('tasks.index')->with('success', 'タスクが更新されました。');
    }
    // 6. 削除処理
    public function destroy(Task $task)
    {
        $task->update([
            'is_deleted' => true
        ]);
    
        return redirect()->route('tasks.index')->with('success', 'タスクが削除されました。');
    }

    public function complete(Task $task)//完了処理
    {
        $task->update([
            'is_completed' => !$task->is_completed
        ]);

        return redirect()->route('tasks.index')->with('success', 'タスクの状態を更新しました！');
    }
    


   // 上ボタン (▲)
    public function moveUp(Task $task)
    {
        // 画面上で「1つ上」にある（＝自分より sort_order が小さい）タスクを1つ取得
        $previousTask = Task::where('sort_order', '<', $task->sort_order)
                            ->orderBy('sort_order', 'desc') // 自分に一番近い上
                            ->first();

        if ($previousTask) {
            $currentOrder = $task->sort_order;
            
            $task->timestamps = false;
            $previousTask->timestamps = false;

            // お互いの並び順の数値を入れ替える（これで中身ごと位置が入れ替わります）
            $task->update(['sort_order' => $previousTask->sort_order]);
            $previousTask->update(['sort_order' => $currentOrder]);
        }
        
        return redirect()->back();
    }

    // 下ボタン (▼)
    public function moveDown(Task $task)
    {
        // 画面上で「1つ下」にある（＝自分より sort_order が大きい）タスクを1つ取得
        $nextTask = Task::where('sort_order', '>', $task->sort_order)
                        ->orderBy('sort_order', 'asc') // 自分に一番近い下
                        ->first();

        if ($nextTask) {
            $currentOrder = $task->sort_order;
            
            $task->timestamps = false;
            $nextTask->timestamps = false;

            // お互いの並び順の数値を入れ替える
            $task->update(['sort_order' => $nextTask->sort_order]);
            $nextTask->update(['sort_order' => $currentOrder]);
        }
        
        return redirect()->back();
    }
    public function history()
    {
        $completedTasks = Task::where('is_completed',true)
                            ->orderBy('updated_at','desc')
                                ->get();

        return view('tasks.history',compact('completedTasks'));
    }
    public function delete()
    {
        $deletedTasks = Task::where('is_deleted',true)
                            ->orderBy('updated_at','desc')
                            ->get();

        return view('tasks.delete',compact('deletedTasks'));
    }

}