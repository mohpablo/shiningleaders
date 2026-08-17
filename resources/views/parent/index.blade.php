<x-app title="إدارة الأبناء">
    <div class="space-y-8">
        @if(session('success'))
        <div class="bg-midnight text-sand border-2 border-midnight p-4 shadow-[4px_4px_0px_0px_#D97706] flex items-center justify-between">
            <span class="font-bold">{{ session('success') }}</span>
            <span class="text-terracotta font-bold">✓</span>
        </div>
        @endif
        <!-- Header & Add Button -->
        <div class="flex flex-col gap-6 md:flex-row md:items-end md:justify-between border-b-4 border-midnight pb-6">
            <div>
                <h2 class="text-4xl font-heading font-bold">أبنائي ({{ $count }})</h2>
                <p class="text-midnight/70 mt-2">تابع أبناءك، اشتراكاتهم، حالات الدفع، والتقدم اليوم.</p>
            </div>
            <a href="{{ route('add-student') }}"
                class="bg-midnight text-sand px-6 py-3 font-bold border-2 border-midnight shadow-[6px_6px_0px_0px_#D97706] hover:bg-terracotta hover:text-white transition-all">
                + إضافة ابن جديد
            </a>
        </div>

        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4 mt-6">
            <div class="rounded-3xl bg-white p-6 shadow-xl border border-sand">
                <p class="text-sm text-midnight/70">إجمالي الأبناء</p>
                <p class="mt-3 text-3xl font-bold text-midnight">{{ $count }}</p>
            </div>
            <div class="rounded-3xl bg-white p-6 shadow-xl border border-sand">
                <p class="text-sm text-midnight/70">إجمالي الاشتراكات</p>
                <p class="mt-3 text-3xl font-bold text-midnight">{{ $totalSubscriptions ?? 0 }}</p>
            </div>
            <div class="rounded-3xl bg-white p-6 shadow-xl border border-sand">
                <p class="text-sm text-midnight/70">الاشتراكات النشطة</p>
                <p class="mt-3 text-3xl font-bold text-midnight">{{ $activeSubscriptions ?? 0 }}</p>
            </div>
            <div class="rounded-3xl bg-white p-6 shadow-xl border border-sand">
                <p class="text-sm text-midnight/70">المدفوعات الناجحة</p>
                <p class="mt-3 text-3xl font-bold text-midnight">{{ $successfulPayments ?? 0 }}</p>
            </div>
        </div>

        <!-- Children Table -->
        <div class="overflow-x-auto border-2 border-midnight shadow-[8px_8px_0px_0px_#0B132B]">
            <table class="w-full text-right">
                <thead class="bg-midnight text-sand">
                    <tr>
                        <th class="p-4">الاسم</th>
                        <th class="p-4">السنة الدراسية</th>
                        <th class="p-4">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y-2 divide-midnight">
                    @forelse($children as $child)
                    <tr class="hover:bg-sand-light transition">
                        <td class="p-4 font-bold">{{ $child->name }}</td>
                        <td class="p-4">{{ $child->academic_year }}</td>
                        <td class="p-4">
                            <a href="{{ route('parent.student.show', $child) }}" class="text-terracotta font-bold underline">متابع</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="p-8 text-center font-bold">لم يتم إضافة أبناء بعد.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app>