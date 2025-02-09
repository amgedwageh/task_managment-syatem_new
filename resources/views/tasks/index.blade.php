{{-- resources/views/tasks/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">إدارة المهام</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    <div class="mb-3">
        <a href="{{ route('tasks.create') }}" class="btn btn-primary">إضافة مهمة جديدة</a>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>المهمة</th>
                <th>الحالة</th>
                <th>المستخدمون</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tasks as $task)
                <tr>
                    <td>{{ $task->task_name }}</td>
                    <td>{{ ucfirst($task->status) }}</td>
                    <td>
                        @foreach($task->users as $user)
                            <span class="badge bg-info">{{ $user->name }}</span>
                        @endforeach
                    </td>
                    <td>
                        <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-warning btn-sm">تعديل</a>
                        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">حذف</button>
                        </form>
                        @if(auth()->user()->tasks->contains($task) && $task->status !== 'completed')
                            <form action="{{ route('tasks.complete', $task->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">إتمام المهمة</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
