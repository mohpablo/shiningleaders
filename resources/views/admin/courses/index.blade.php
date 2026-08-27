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

        <div class="overflow-hidden rounded-3xl border border-sand bg-white shadow-xl">
            <table class="min-w-full text-right text-sm text-midnight">
                <thead class="bg-sand text-midnight/80">
                    <tr>
                        <th class="px-4 py-4">الدورة</th>
                        <th class="px-4 py-4">الصف الدراسي</th>
                        <th class="px-4 py-4">المجموعات</th>
                        <th class="px-4 py-4">الطلاب</th>
                        <th class="px-4 py-4">الجلسات/الشهر</th>
                        <th class="px-4 py-4">الرسوم الشهرية</th>
                        <th class="px-4 py-4">إجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-sand/70">
                    @forelse($courses as $course)
                    <tr class="hover:bg-sand/50">
                        <td class="px-4 py-4 font-semibold text-midnight">{{ $course->name }}</td>

                        <!-- Grade Column with Fallback Badge -->
                        <td class="px-4 py-4">
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

                        <td class="px-4 py-4">{{ $course->groups_count }}</td>
                        <td class="px-4 py-4">{{ $course->students_count }}</td>
                        <td class="px-4 py-4">{{ $course->monthly_sessions ?? 0 }}</td>
                        <td class="px-4 py-4">{{ number_format($course->monthly_fee, 2) }} د.إ</td>
                        <td class="px-4 py-4 space-x-2 space-x-reverse whitespace-nowrap text-left">
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
                        <td colspan="7" class="px-4 py-8 text-center text-midnight/70">لا توجد دورات حتى الآن.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="rounded-3xl bg-white p-6 shadow-xl border border-sand">
            {{ $courses->links() }}
        </div>
    </div>
</x-admin>