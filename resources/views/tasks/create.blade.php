

{{-- resources/views/tasks/create.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>إضافة مهمة جديدة</h2>
    <form action="{{ route('tasks.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">اسم المهمة</label>
            <input type="text" name="task_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">المستخدمون</label>
            <select name="users[]" class="form-control" multiple>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">الحالة</label>
            <select name="status" class="form-control">
                <option value="pending">قيد الانتظار</option>
                <option value="in_progress">جاري التنفيذ</option>
                <option value="completed">مكتملة</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">حفظ</button>
    </form>
</div>
@endsection
