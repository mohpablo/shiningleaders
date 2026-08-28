<x-admin title="مجموعات المعلم">
    <div class="space-y-6 sm:space-y-8">
        <div class="rounded-3xl border border-sand bg-white p-5 shadow-xl sm:p-8">
            <h1 class="text-2xl font-bold text-midnight sm:text-3xl">مجموعاتك</h1>
            <p class="mt-2 text-sm text-midnight/70">تابع طلاب كل مجموعة وسجل حضورهم وواجباتهم.</p>
        </div>

        <div class="grid gap-4 sm:grid-cols-2">
            @forelse($groups as $group)
                <article class="flex min-w-0 flex-col rounded-3xl border border-sand bg-white p-5 shadow-xl">
                    <p class="text-sm font-bold text-terracotta">{{ $group->course->name }}</p>
                    <h2 class="mt-1 wrap-break-word text-2xl font-bold text-midnight">{{ $group->name }}</h2>
                    <p class="mt-2 wrap-break-word text-sm text-midnight/70">{{ $group->schedule }}</p>
                    <div class="mt-5 grid grid-cols-2 gap-3">
                        <div class="rounded-2xl bg-sand p-4">
                            <p class="text-xs text-midnight/70">الطلاب</p>
                            <p class="mt-1 text-lg font-bold text-midnight">{{ $group->students_count }}</p>
                        </div>
                        <div class="rounded-2xl bg-sand p-4">
                            <p class="text-xs text-midnight/70">الجلسات</p>
                            <p class="mt-1 text-lg font-bold text-midnight">{{ $group->sessions_completed }} / {{ $group->course->monthly_sessions }}</p>
                        </div>
                    </div>
                    <a href="{{ route('teacher.groups.show', $group) }}" class="mt-5 w-full rounded-2xl bg-midnight px-4 py-3 text-center text-sm font-bold text-sand transition hover:bg-amber-600">فتح المجموعة</a>
                </article>
            @empty
                <div class="rounded-3xl border border-sand p-6 text-center text-midnight/70 sm:col-span-2">لا توجد مجموعات حالياً.</div>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $groups->links() }}
        </div>
    </div>
</x-admin>
