<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('タスク一覧') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <h1 class="fs-3 mb-4 fw-bold">タスク一覧</h1>

                <a href="{{ route('tasks.create') }}" class="btn btn-primary mb-3">新しいタスクを作成</a>

               @if (session('success'))
                <div class="alert alert-success mb-3">
                    {{ session('success') }}
                </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger mb-3">
                        {{ session('error') }}
                    </div>
                @endif

                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>タイトル</th>
                            <th>説明</th>
                            <th>期限</th>
                            <th>操作</th>
                            <th>完了・削除</th>
                            <th>優先度</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tasks as $task)
                            <tr>
                                <td>{{ $task->title }}</td>
                                <td>{{ $task->description }}</td>
                                <td>{{$task->due_date}}</td>
                              <td style="white-space: nowrap; width: 1px;">
                                    <div style="display: flex; gap: 6px; align-items: center; justify-content: center;">
                                        <form action="{{ route('tasks.moveUp', $task) }}" method="POST" style="margin: 0; display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-secondary" style="width: 32px; height: 31px; padding: 0; line-height: 1;">▲</button>
                                        </form>

                                        <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-danger" style="height: 31px; display: inline-flex; align-items: center; justify-content: center;">編集</a>

                                        <form action="{{ route('tasks.moveDown', $task) }}" method="POST" style="margin: 0; display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-secondary" style="width: 32px; height: 31px; padding: 0; line-height: 1;">▼</button>
                                        </form>
                                    </div>
                                </td>

                                <td class="px-6 py-4 flex items-center gap-2 whitespace-nowrap">
                                    <form action="{{ route('tasks.complete', $task) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        @if($task->is_completed)
                                            <button type="submit" class="bg-gray-400 hover:bg-gray-500 text-white font-bold py-3 px-3 rounded text-sm">
                                                戻す
                                            </button>
                                        @else
                                            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-3 rounded text-sm">
                                                完了！
                                            </button>
                                        @endif
                                    </form>
                                    <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="inline" onsubmit="return confirm('本当に削除しますか？');">
                                            @csrf
                                            @method('DELETE')<button type="submmit" class="btn btn-danger">削除</button>
                                    </form>                                   
                                </td>
                                <td class="px-6 py-4 text-center whitespace-nowrap text-sm font-medium">
                                    @if($task->sort_order == 1)  
                                        <span class="text-black font-bold bg-red-500 px-3 py-2 rounded">高</span>
                                    @elseif($task->sort_order == 2)
                                        <span class="text-orange-300 font-bold bg-green-500 px-3 py-2 rounded">中</span>
                                    @else
                                        <span class="text-green-400 font-bold bg-blue-500 px-3 py-2 rounted">低</span>
                                    @endif
                                </td>
                            </tr>
                            
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>