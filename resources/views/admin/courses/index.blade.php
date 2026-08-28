<x-admin>
    <div class="space-y-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-midnight">الدورات</h1>
                <p class="mt-2 text-sm text-midnight/70">عرض جميع الدورات، مع إمكانية تحرير الدورة وإدارتها وإنشاء مجموعات جديدة.</p>
            </div>

            <a href="{{ route('admin.course.create') }}" class="inline-flex items-center justify-center rounded-3xl bg-midnight px-5 py-3 text-sm font-bold text-sand transition hover:bg-amber-600">
                إنشاء دورة جديدة
            </a>
        </div>

        @if(session('success'))
        <div class="rounded-3xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800">
            {{ session('success') }}
        </div>
        @endif

        <form method="GET" action="{{ route('admin.course') }}" class="flex flex-col gap-3 sm:flex-row">
            <input type="search" name="q" value="{{ request('q') }}" placeholder="ابحث باسم الدورة أو الصف الدراسي" class="min-w-0 flex-1 border-2 border-midnight bg-white px-4 py-3 text-right text-midnight outline-none focus:bg-sand">
            <button type="submit" class="bg-midnight px-5 py-3 font-bold text-sand transition hover:bg-terracotta">بحث</button>
        </form>

        <div class="overflow-x-auto border-2 border-midnight bg-sand p-4 shadow-[8px_8px_0px_0px_#0B132B]">
            <table class="w-full min-w-225 border-collapse text-right text-sm text-midnight">
                <thead class="bg-midnight text-sand">
                    <tr>
                        <th class="border-2 border-midnight p-4 font-bold">الدورة</th>
                        <th class="border-2 border-midnight p-4 font-bold">الصف الدراسي</th>
                        <th class="border-2 border-midnight p-4 font-bold">المجموعات</th>
                        <th class="border-2 border-midnight p-4 font-bold">الطلاب</th>
                        <th class="border-2 border-midnight p-4 font-bold">الجلسات/الشهر</th>
                        <th class="border-2 border-midnight p-4 font-bold">الرسوم الشهرية</th>
                        <th class="border-2 border-midnight p-4 font-bold">إجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-sand/70">
                    @forelse($courses as $course)
                    <tr class="hover:bg-midnight/5 transition-colors">
                        <td class="border-2 border-midnight p-4 font-semibold text-midnight">{{ $course->name }}</td>

                        <!-- Grade Column with Fallback Badge -->
                        <td class="border-2 border-midnight p-4">
                            @if($course->grade)
                            <span class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-800 border border-slate-300">
                                {{ $course->grade }}
                            </span>
                            @else
                            <a href="{{ route('admin.course.edit', $course) }}" class="inline-flex items-center gap-1 rounded-full bg-rose-100 px-3 py-1 text-xs font-bold text-rose-700 hover:bg-rose-200 transition">
                                ⚠️ أضف صف دراسي
                            </a>
                            @endif
                        </td>

                        <td class="border-2 border-midnight p-4">{{ $course->groups_count }}</td>
                        <td class="border-2 border-midnight p-4">{{ $course->total_students_count }}</td
                            <td class="border-2 border-midnight p-4">{{ $course->monthly_sessions ?? 0 }}</td>
                        <td class="border-2 border-midnight p-4">{{ number_format($course->monthly_fee, 2) }} د.إ</td>
                        <td class="border-2 border-midnight p-4 space-x-2 space-x-reverse whitespace-nowrap text-left">
                            <a href="{{ route('admin.course.edit', $course) }}" class="inline-flex items-center rounded-full bg-amber-500 px-4 py-2 text-xs font-bold text-white transition hover:bg-amber-600">تحرير</a>
                            <form action="{{ route('admin.course.destroy', $course) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center rounded-full bg-rose-500 px-4 py-2 text-xs font-bold text-white transition hover:bg-rose-600" onclick="return confirm('هل أنت متأكد من حذف هذه الدورة؟');">حذف</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="border-2 border-midnight p-8 text-center text-midnight/70">لا توجد دورات حتى الآن.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-4 border-t-2 border-midnight pt-4">
                {{ $courses->withQueryString()->links() }}
            </div>
        </div>
    </div>
</x-admin>