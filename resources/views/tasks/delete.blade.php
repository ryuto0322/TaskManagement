<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('削除履歴一覧') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <h1 class="fs-3 mb-4 fw-bold">削除履歴一覧</h1>

                <div class="mb-3">
                    <a href="{{ route('tasks.index') }}" class="btn btn-secondary">タスク一覧に戻る</a>
                </div>

                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>タイトル</th>
                            <th>説明</th>
                            <th>完了日時</th>
                            <th>優先度</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($deletedTasks as $task)
                            <tr>
                                <td>{{ $task->title }}</td>
                                <td>{{ $task->description }}</td>
                                <td>{{ $task->updated_at->format('m/d H:i') }}</td>
                                <td>
                                    @if($task->sort_order == 1)  
                                        <span class="text-black font-bold bg-red-500 px-3 py-2 rounded">高</span>
                                    @elseif($task->sort_order == 2)
                                        <span class="text-orange-300 font-bold bg-green-500 px-3 py-2 rounded">中</span>
                                    @else
                                        <span class="text-green-400 font-bold bg-blue-500 px-3 py-2 rounded">低</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-4 text-center text-muted">完了したタスクはまだありません。</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</x-app-layout>