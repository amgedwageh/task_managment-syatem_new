<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $tasks = Task::query();

        // التحقق من دور المستخدم
        if (auth()->user()->role !== 'admin') {
            // المستخدم العادي يرى فقط المهام المخصصة له
            $tasks->whereHas('users', function ($query) {
                $query->where('user_id', auth()->id());
            });
        }

        // فلترة المهام حسب الحالة إذا تم تحديدها
        if ($request->has('status')) {
            $tasks->where('status', $request->status);
        }

        // فلترة حسب المستخدم فقط إذا كان المشرف يبحث عن مهام مستخدم معين
        if ($request->has('user_id') && auth()->user()->role === 'admin') {
            $tasks->whereHas('users', function ($query) use ($request) {
                $query->where('user_id', $request->user_id);
            });
        }

        return view('tasks.index', ['tasks' => $tasks->get()]);
    }
    /**
     * عرض جميع المهام مع إمكانية التصفية.
     */
    // public function index(Request $request)
    // {
    //     $tasks = Task::query();

    //     if ($request->has('status')) {
    //         $tasks->where('status', $request->status);
    //     }

    //     if ($request->has('user_id')) {
    //         $tasks->whereHas('users', function ($query) use ($request) {
    //             $query->where('user_id', $request->user_id);
    //         });
    //     }

    //     return view('tasks.index', ['tasks' => $tasks->get()]);
    // }

    /**
     * عرض صفحة إنشاء مهمة جديدة.
     */
    public function create()
    {
        if (auth()->user()->role !== 'admin') {
            return redirect()->back()->with('error', ' you have no permission to do that        ');
        }
        $users = User::all();
        return view('tasks.create', compact('users'));
    }

    /**
     * تخزين المهمة الجديدة.
     */
    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            return redirect()->back()->with('error', ' you have no permission to do that        ');
        }
        $request->validate([
            'task_name' => 'required|string|max:255',
            'status' => 'required|in:pending,in_progress,completed',
            'active' => 'boolean',
            'users' => 'array',
        ]);

        $task = Task::create([
            'task_name' => $request->task_name,
            'status' => $request->status,
            'active' => $request->active ?? true,
        ]);

        if ($request->has('users')) {
            $task->users()->attach($request->users);
        }

        return redirect()->route('tasks.index')->with('success', 'تم إنشاء المهمة بنجاح!');
    }

    /**
     * عرض صفحة تعديل مهمة.
     */
    public function edit(Task $task)
    {
        if (auth()->user()->role !== 'admin') {
            return redirect()->back()->with('error', ' you have no permission to do that        ');
        }
        $users = User::all();
        return view('tasks.edit', compact('task', 'users'));
    }

    /**
     * تحديث بيانات المهمة.
     */
    public function update(Request $request, Task $task)
    {
        if (auth()->user()->role !== 'admin') {
            return redirect()->back()->with('error', ' you have no permission to do that        ');
        }
        $request->validate([
            'task_name' => 'required|string|max:255',
            'status' => 'required|in:pending,in_progress,completed',
            'active' => 'boolean',
            'users' => 'array',
        ]);

        $task->update([
            'task_name' => $request->task_name,
            'status' => $request->status,
            'active' => $request->active ?? true,
        ]);

        if ($request->has('users')) {
            $task->users()->sync($request->users);
        }

        return redirect()->route('tasks.index')->with('success', 'تم تحديث المهمة بنجاح!');
    }

    /**
     * حذف المهمة.
     */
    public function destroy(Task $task)
    {
        if (auth()->user()->role !== 'admin') {
            return redirect()->back()->with('error', ' you have no permission to do that        ');
        }
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'تم حذف المهمة بنجاح!');
    }

    /**
     * يقوم المستخدم بتحديث حالة المهمة إلى "مكتملة".
     */
    public function complete(Task $task)
    {
        if (!auth()->user()->tasks->contains($task)) {
            return redirect()->route('tasks.index')->with('error', 'هذه المهمة ليست مخصصة لك.');
        }

        $task->update(['status' => 'completed']);

        return redirect()->route('tasks.index')->with('success', 'تم وضع المهمة كمكتملة.');
    }
}
