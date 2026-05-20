<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('タスク作成') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <h1 class="fs-3 mb-4 fw-bold">新しいタスクを作成</h1>

                <form action="{{ route('tasks.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="title" class="form-label fw-bold">タイトル</label>
                        <input type="text" name="title" class="form-control" id="title" placeholder="タスクのタイトルを入力してください" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label fw-bold">説明</label>
                        <textarea name="description" class="form-control" id="description" rows="3" placeholder="タスクの詳細説明を入力してください"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="due_date" class="form-label fw-bold">期限</label>
                        <input type="datetime-local" name="due_date" class = "form-control" id="due_date">
                    </div>  
                    <select name="sort_order" id="sort_order" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="1" {{ old('sort_order') == 1 ? 'selected' : '' }}>高</option>
                            <option value="2" {{ old('sort_order') == 2 ? 'selected' : '' }}>中</option>
                            <option value="3" {{ old('sort_order') == 3 ? 'selected' : '' }}>低</option>
                        </select>

                    <div class="d-flex align-items-center gap-3">
                        <button type="submit" class="btn btn-primary">作成</button>
                        <a href="{{ route('tasks.index') }}" class="text-secondary text-decoration-none">戻る</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>