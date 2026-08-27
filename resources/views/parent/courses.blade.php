<x-app title="الدورات المتاحة">
    <div class="space-y-8">
        <div class="border-b-4 border-midnight pb-6">
            <h2 class="text-4xl font-heading font-bold">الدورات المتاحة</h2>
            <p class="mt-2 text-midnight/70">استعرض الدورات الحالية واختر الأنسب لطفلك.</p>
        </div>

        <div class="grid gap-6 lg:grid-cols-3">
            @foreach($courses as $course)
            <div class="rounded-3xl bg-white p-6 shadow-xl border border-sand">
                <h3 class="text-2xl font-bold text-midnight">{{ $course->name }}</h3>
                <p class="mt-2 text-sm text-midnight/70">{{ $course->description }}</p>
                <div class="mt-6 space-y-3">
                    <div class="rounded-3xl bg-sand p-4">
                        <p class="text-sm text-midnight/70">الرسوم الشهرية</p>
                        <p class="mt-2 font-semibold text-midnight">{{ number_format($course->monthly_fee, 2) }} د.إ</p>
                    </div>
                    <div class="rounded-3xl bg-sand p-4">
                        <p class="text-sm text-midnight/70">عدد الجلسات</p>
                        <p class="mt-2 font-semibold text-midnight">{{ $course->monthly_sessions }}</p>
                    </div>
                </div>

                <div class="mt-6">
                    @if($students->isEmpty())
                    <div class="rounded-3xl border border-rose-200 bg-rose-50 p-4 text-rose-700">
                        أضف طالباً أولاً حتى تتمكن من الاشتراك في هذه الدورة.
                    </div>
                    <a href="{{ route('parent.add-student') }}" class="mt-4 inline-flex items-center justify-center rounded-3xl bg-midnight px-5 py-3 text-sm font-bold text-sand hover:bg-amber-600 transition">إضافة ابن</a>
                    @else
                    <div class="space-y-3">
                        @foreach($students as $student)
                        <form action="{{ route('parent.student.subscribe', $student) }}" method="POST" class="rounded-3xl bg-white p-3 border border-midnight/10">
                            @csrf
                            <input type="hidden" name="course_id" value="{{ $course->id }}">
                            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                <p class="font-semibold text-midnight">اشترك لـ {{ $student->name }}</p>
                                <button type="submit" class="rounded-3xl bg-midnight px-5 py-3 text-sm font-bold text-sand hover:bg-amber-600 transition">اشتراك</button>
                            </div>
                        </form>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $courses->links() }}
        </div>
    </div>
</x-app>