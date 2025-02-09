@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">تعديل المهمة</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('tasks.update', $task->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label fw-bold">اسم المهمة</label>
                    <input type="text" name="task_name" class="form-control border-primary" value="{{ $task->task_name }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">المستخدمون</label>
                    <select name="users[]" class="form-select border-primary" multiple>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" @if($task->users->contains($user->id)) selected @endif>{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">الحالة</label>
                    <select name="status" class="form-select border-primary">
                        <option value="pending" @if($task->status == 'pending') selected @endif>قيد الانتظار</option>
                        <option value="in_progress" @if($task->status == 'in_progress') selected @endif>جاري التنفيذ</option>
                        <option value="completed" @if($task->status == 'completed') selected @endif>مكتملة</option>
                    </select>
                </div>
                <div class="d-flex justify-content-between">
                    <a href="{{ route('tasks.index') }}" class="btn btn-secondary">إلغاء</a>
                    <button type="submit" class="btn btn-success">تحديث</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
