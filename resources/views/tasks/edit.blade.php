

{{-- resources/views/tasks/edit.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>تعديل المهمة</h2>
    <form action="{{ route('tasks.update', $task->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">اسم المهمة</label>
            <input type="text" name="task_name" class="form-control" value="{{ $task->task_name }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">المستخدمون</label>
            <select name="users[]" class="form-control" multiple>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" @if($task->users->contains($user->id)) selected @endif>{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">الحالة</label>
            <select name="status" class="form-control">
                <option value="pending" @if($task->status == 'pending') selected @endif>قيد الانتظار</option>
                <option value="in_progress" @if($task->status == 'in_progress') selected @endif>جاري التنفيذ</option>
                <option value="completed" @if($task->status == 'completed') selected @endif>مكتملة</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">تحديث</button>
    </form>
</div>
@endsection
