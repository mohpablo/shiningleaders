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

            <form method="GET" action="{{ route('admin.parents.index') }}" class="mt-6 flex flex-col gap-3 sm:flex-row">
                <input type="search" name="q" value="{{ request('q') }}" placeholder="ابحث باسم ولي الأمر أو البريد الإلكتروني" class="min-w-0 flex-1 border-2 border-midnight bg-white px-4 py-3 text-right text-midnight outline-none focus:bg-sand">
                <button type="submit" class="bg-midnight px-5 py-3 font-bold text-sand transition hover:bg-terracotta">بحث</button>
            </form>

            <div class="mt-6 overflow-x-auto border-2 border-midnight bg-sand p-4 shadow-[8px_8px_0px_0px_#0B132B]">
                <table class="w-full min-w-190 border-collapse text-right text-sm text-midnight">
                    <thead class="bg-midnight text-sand">
                        <tr>
                            <th class="border-2 border-midnight p-4 font-bold">اسم ولي الأمر</th>
                            <th class="border-2 border-midnight p-4 font-bold">البريد الإلكتروني</th>
                            <th class="border-2 border-midnight p-4 font-bold">عدد الأبناء</th>
                            <th class="border-2 border-midnight p-4 font-bold">الدورات المرتبطة</th>
                            <th class="border-2 border-midnight p-4 font-bold">إجراءات</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-sand/80">
                        @forelse($parents as $parent)
                            <tr class="hover:bg-midnight/5 transition-colors">
                                <td class="border-2 border-midnight p-4 font-semibold text-midnight">{{ $parent->name }}</td>
                                <td class="border-2 border-midnight p-4">{{ $parent->email }}</td>
                                <td class="border-2 border-midnight p-4">{{ $parent->students->count() }}</td>
                                <td class="border-2 border-midnight p-4">{{ $parent->students->flatMap(fn($student) => $student->subscriptions->pluck('course.name'))->unique()->count() }}</td>
                                <td class="border-2 border-midnight p-4 text-left">
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
                                <td colspan="5" class="border-2 border-midnight p-8 text-center text-midnight/70">لا يوجد أولياء أمور بعد.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="border-x-2 border-b-2 border-midnight bg-sand p-4 sm:p-6">
                {{ $parents->withQueryString()->links() }}
            </div>
        </div>
    </div>
</x-admin>
