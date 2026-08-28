<x-admin title="قائمة الطلاب والطلبات">
    <div class="space-y-8">
        <!-- Header -->
        <div class="border-b-4 border-midnight pb-4 flex justify-between items-end">
            <div>
                <h2 class="text-3xl font-heading font-bold">الطلاب والطلبات</h2>
                <p class="text-terracotta font-bold mt-1">عرض جميع الطلاب والكورسات المرغوبة</p>
            </div>
        </div>

        @if(session('success'))
        <div class="border-2 border-emerald-700 bg-emerald-50 p-4 font-bold text-emerald-800">
            {{ session('success') }}
        </div>
        @endif

        <form method="GET" action="{{ route('admin.students.index') }}" class="flex flex-col gap-3 sm:flex-row">
            <input type="search" name="q" value="{{ request('q') }}" placeholder="ابحث باسم الطالب أو المدرسة أو ولي الأمر" class="min-w-0 flex-1 border-2 border-midnight bg-white px-4 py-3 text-right text-midnight outline-none focus:bg-sand">
            <button type="submit" class="bg-midnight px-5 py-3 font-bold text-sand transition hover:bg-terracotta">بحث</button>
        </form>

        <!-- Table Card -->
        <div class="overflow-x-auto border-2 border-midnight bg-sand p-4 shadow-[8px_8px_0px_0px_#0B132B] sm:p-6">
            <table class="w-full min-w-225 border-collapse text-right">
                <thead>
                    <tr class="bg-midnight text-sand">
                        <th class="p-4 font-bold border-2 border-midnight">اسم الطالب</th>
                        <th class="p-4 font-bold border-2 border-midnight">العمر</th>
                        <th class="p-4 font-bold border-2 border-midnight">المدرسة / السنة</th>
                        <th class="p-4 font-bold border-2 border-midnight">ولي الأمر</th>
                        <th class="p-4 font-bold border-2 border-midnight w-1/3">الكورسات المطلوبة</th>
                        <th class="p-4 font-bold border-2 border-midnight">إجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $student)
                    <tr class="hover:bg-midnight/5 transition-colors">
                        <td class="p-4 border-2 border-midnight font-bold">{{ $student->name }}</td>
                        <td class="p-4 border-2 border-midnight">{{ $student->age }}</td>
                        <td class="p-4 border-2 border-midnight text-sm">
                            {{ $student->school ?? '-' }} <br>
                            <span class="text-terracotta">{{ $student->academic_year ?? '-' }}</span>
                        </td>
                        <td class="p-4 border-2 border-midnight">
                            {{ $student->parent?->name ?? 'غير متوفر' }} <br>
                            <span class="text-sm font-bold">{{ $student->phone_number ?? $student->parent?->phone ?? '-' }}</span>
                        </td>
                        <td class="p-4 border-2 border-midnight">
                            @if($student->courses->count() > 0)
                            <div class="flex flex-wrap gap-2">
                                @foreach($student->courses as $course)
                                <span class="bg-terracotta text-white text-xs px-2 py-1 font-bold border border-midnight rounded-md">
                                    {{ $course->name }}
                                </span>
                                @endforeach
                            </div>
                            @else
                            <span class="text-gray-500 text-sm font-bold">لم يسجل في أي كورس</span>
                            @endif
                        </td>
                        <td class="p-4 border-2 border-midnight">
                            <form action="{{ route('admin.students.destroy', $student) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-rose-600 px-3 py-2 text-xs font-bold text-white transition hover:bg-rose-700" onclick="return confirm('هل تريد حذف هذا الطالب؟ سيتم حذف اشتراكاته ودورات التسجيل المرتبطة به.');">حذف</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-6 text-center border-2 border-midnight font-bold text-terracotta">
                            لا يوجد طلاب مسجلين حتى الآن.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination Links -->
            <div class="mt-4 border-t-2 border-midnight pt-4">
                {{ $students->withQueryString()->links() }}
            </div>
        </div>
    </div>
</x-admin>