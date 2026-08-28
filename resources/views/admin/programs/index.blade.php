<x-admin>
    <div class="space-y-6">
        <div class="rounded-3xl bg-white p-8 shadow-xl border border-sand">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-midnight">إدارة المدرسين</h1>
                    <p class="mt-2 text-sm text-midnight/70">أضف مدرسين، اضبط نسبة أرباحهم من كل دورة، وتابع عدد الدورات المرتبطة بهم.</p>
                </div>
                <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
                    <div class="rounded-3xl bg-sand p-4 text-right shadow-sm">
                        <p class="text-xs uppercase tracking-[0.18em] text-midnight/60">المدرسون</p>
                        <p class="mt-2 text-2xl font-bold text-midnight">{{ $teachers->total() }}</p>
                    </div>
                    <div class="rounded-3xl bg-sand p-4 text-right shadow-sm">
                        <p class="text-xs uppercase tracking-[0.18em] text-midnight/60">آخر تحديث</p>
                        <p class="mt-2 text-lg font-bold text-midnight">{{ now()->format('Y-m-d') }}</p>
                    </div>
                    <div class="rounded-3xl bg-sand p-4 text-right shadow-sm">
                        <p class="text-xs uppercase tracking-[0.18em] text-midnight/60">أعلى نسبة</p>
                        <p class="mt-2 text-lg font-bold text-midnight">{{ $teachers->max('teacher_share') ?? 0 }}%</p>
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div class="mt-6 rounded-3xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800">
                    {{ session('success') }}
                </div>
            @endif
        </div>

        <div class="flex flex-col gap-6">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-xl font-bold text-midnight">قائمة المدرسين</h2>
                    <p class="mt-1 text-sm text-midnight/70">يمكنك حذف المدرسين أو تعديل بياناتهم ونسبة أرباحهم.</p>
                </div>
                <a href="{{ route('admin.programs.create') }}" class="inline-flex items-center rounded-3xl bg-midnight px-5 py-3 text-sm font-bold text-sand transition hover:bg-amber-600">
                    إنشاء مدرس جديد
                </a>
            </div>

            <form method="GET" action="{{ route('admin.programs.index') }}" class="flex flex-col gap-3 sm:flex-row">
                <input type="search" name="q" value="{{ request('q') }}" placeholder="ابحث بالاسم أو البريد الإلكتروني" class="min-w-0 flex-1 border-2 border-midnight bg-white px-4 py-3 text-right text-midnight outline-none focus:bg-sand">
                <button type="submit" class="bg-midnight px-5 py-3 font-bold text-sand transition hover:bg-terracotta">بحث</button>
            </form>

            <div class="overflow-x-auto border-2 border-midnight bg-sand p-4 shadow-[8px_8px_0px_0px_#0B132B]">
                <table class="w-full min-w-190 border-collapse text-right text-sm text-midnight">
                    <thead class="bg-midnight text-sand">
                        <tr>
                            <th class="border-2 border-midnight p-4 text-right font-bold">الاسم</th>
                            <th class="border-2 border-midnight p-4 text-right font-bold">البريد</th>
                            <th class="border-2 border-midnight p-4 text-right font-bold">الدورات</th>
                            <th class="border-2 border-midnight p-4 text-right font-bold">النسبة</th>
                            <th class="border-2 border-midnight p-4 text-right font-bold">إجراءات</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-sand/80">
                        @forelse($teachers as $teacher)
                            <tr class="hover:bg-midnight/5 transition-colors">
                                <td class="border-2 border-midnight p-4 font-semibold text-midnight">{{ $teacher->name }}</td>
                                <td class="border-2 border-midnight p-4">{{ $teacher->email }}</td>
                                <td class="border-2 border-midnight p-4">{{ $teacher->courses->count() }}</td>
                                <td class="border-2 border-midnight p-4">{{ $teacher->teacher_share }}%</td>
                                <td class="flex flex-wrap gap-2 border-2 border-midnight p-4 text-left">
                                    <a href="{{ route('admin.programs.edit', $teacher) }}" class="inline-flex items-center rounded-full bg-amber-500 px-4 py-2 text-xs font-bold text-white transition hover:bg-amber-600">تعديل</a>
                                    <form action="{{ route('admin.programs.destroy', $teacher) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center rounded-full bg-rose-500 px-4 py-2 text-xs font-bold text-white transition hover:bg-rose-600" onclick="return confirm('هل تريد حذف هذا المدرس؟');">حذف</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="border-2 border-midnight p-8 text-center text-midnight/70">لا يوجد مدرسين بعد.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="border-t-2 border-midnight bg-sand p-4 sm:p-6">
                    {{ $teachers->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</x-admin>
