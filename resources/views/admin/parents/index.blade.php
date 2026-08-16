<x-admin>
    <div class="space-y-6">
        <div class="rounded-3xl bg-white p-8 shadow-xl border border-sand">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-midnight">أولياء الأمور</h1>
                    <p class="mt-2 text-sm text-midnight/70">عرض جميع أولياء الأمور مع أبنائهم والدورات المرتبطة والخيارات الإدارية.</p>
                </div>
            </div>

            @if(session('success'))
                <div class="mt-6 rounded-3xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mt-6 overflow-hidden rounded-3xl border border-sand bg-white shadow-xl">
                <table class="min-w-full text-right text-sm text-midnight">
                    <thead class="bg-sand text-midnight/80">
                        <tr>
                            <th class="px-4 py-4">اسم ولي الأمر</th>
                            <th class="px-4 py-4">البريد الإلكتروني</th>
                            <th class="px-4 py-4">عدد الأبناء</th>
                            <th class="px-4 py-4">الدورات المرتبطة</th>
                            <th class="px-4 py-4">إجراءات</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-sand/80">
                        @forelse($parents as $parent)
                            <tr class="hover:bg-sand/50">
                                <td class="px-4 py-4 font-semibold text-midnight">{{ $parent->name }}</td>
                                <td class="px-4 py-4">{{ $parent->email }}</td>
                                <td class="px-4 py-4">{{ $parent->students->count() }}</td>
                                <td class="px-4 py-4">{{ $parent->students->flatMap(fn($student) => $student->subscriptions->pluck('course.name'))->unique()->count() }}</td>
                                <td class="px-4 py-4 text-left">
                                    <a href="{{ route('admin.parents.show', $parent) }}" class="inline-flex items-center rounded-full bg-amber-500 px-4 py-2 text-xs font-bold text-white transition hover:bg-amber-600">عرض</a>
                                    <form action="{{ route('admin.parents.destroy', $parent) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center rounded-full bg-rose-500 px-4 py-2 text-xs font-bold text-white transition hover:bg-rose-600" onclick="return confirm('هل تريد حذف هذا ولي الأمر؟ سيتم حذف طلابه أيضًا.');">حذف</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-midnight/70">لا يوجد أولياء أمور بعد.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="rounded-3xl bg-white p-6 shadow-xl border border-sand">
                {{ $parents->links() }}
            </div>
        </div>
    </div>
</x-admin>
