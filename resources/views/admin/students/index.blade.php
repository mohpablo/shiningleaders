<x-admin title="قائمة الطلاب والطلبات">
    <div class="space-y-8">
        <!-- Header -->
        <div class="border-b-4 border-midnight pb-4 flex justify-between items-end">
            <div>
                <h2 class="text-3xl font-heading font-bold">الطلاب والطلبات</h2>
                <p class="text-terracotta font-bold mt-1">عرض جميع الطلاب والكورسات المرغوبة</p>
            </div>
        </div>

        <!-- Table Card -->
        <div class="bg-sand border-2 border-midnight p-6 shadow-[8px_8px_0px_0px_#0B132B] overflow-x-auto">
            <table class="w-full text-right border-collapse">
                <thead>
                    <tr class="bg-midnight text-sand">
                        <th class="p-4 font-bold border-2 border-midnight">اسم الطالب</th>
                        <th class="p-4 font-bold border-2 border-midnight">العمر</th>
                        <th class="p-4 font-bold border-2 border-midnight">المدرسة / السنة</th>
                        <th class="p-4 font-bold border-2 border-midnight">ولي الأمر</th>
                        <th class="p-4 font-bold border-2 border-midnight w-1/3">الكورسات المطلوبة</th>
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
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-6 text-center border-2 border-midnight font-bold text-terracotta">
                            لا يوجد طلاب مسجلين حتى الآن.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination Links -->
            <div class="mt-6" >
                {{ $students->links() }}
            </div>
        </div>
    </div>
</x-admin>