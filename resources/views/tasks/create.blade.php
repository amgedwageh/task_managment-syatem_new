@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center">
    <div class="card shadow-lg p-4" style="max-width: 600px; width: 100%;">
        <h2 class="text-center mb-4 text-primary">إضافة مهمة جديدة</h2>

        <form action="{{ route('tasks.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label fw-bold">اسم المهمة</label>
                <input type="text" name="task_name" class="form-control border-primary" placeholder="أدخل اسم المهمة" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">المستخدمون</label>
                <select name="users[]" class="form-select border-primary" multiple>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">الحالة</label>
                <select name="status" class="form-select border-primary">
                    <option value="pending">قيد الانتظار</option>
                    <option value="in_progress">جاري التنفيذ</option>
                    <option value="completed">مكتملة</option>
                </select>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('tasks.index') }}" class="btn btn-secondary">إلغاء</a>
                <button type="submit" class="btn btn-success">حفظ المهمة</button>
            </div>
        </form>
    </div>
</div>
@endsection
