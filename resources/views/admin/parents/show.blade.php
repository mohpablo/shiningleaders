<x-admin>
    <div class="space-y-6">
        <div class="rounded-3xl border-2 border-midnight bg-white p-5 shadow-[8px_8px_0px_0px_#0B132B] sm:p-8">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-midnight">{{ $parent->name }}</h1>
                    <p class="mt-2 text-sm text-midnight/70">تفاصيل ولي الأمر، أبناؤه والدورات المسجلة لكل طالب.</p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('admin.parents.index') }}" class="rounded-3xl border border-midnight px-5 py-3 text-sm font-bold text-midnight">عودة إلى القائمة</a>
                    <form action="{{ route('admin.parents.destroy', $parent) }}" method="POST" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="rounded-3xl bg-rose-500 px-5 py-3 text-sm font-bold text-white" onclick="return confirm('هل تريد حذف هذا ولي الأمر؟ سيتم حذف طلابه أيضًا.');">حذف ولي الأمر</button>
                    </form>
                </div>
            </div>

            <div class="mt-6 grid gap-6 md:grid-cols-3">
                <div class="rounded-3xl bg-sand p-6 shadow-sm border border-sand">
                    <p class="text-sm text-midnight/70">البريد الإلكتروني</p>
                    <p class="mt-3 font-bold text-midnight">{{ $parent->email }}</p>
                </div>
                <div class="rounded-3xl bg-sand p-6 shadow-sm border border-sand">
                    <p class="text-sm text-midnight/70">عدد الأبناء</p>
                    <p class="mt-3 font-bold text-midnight">{{ $parent->students->count() }}</p>
                </div>
                <div class="rounded-3xl bg-sand p-6 shadow-sm border border-sand">
                    <p class="text-sm text-midnight/70">الدورات المرتبطة</p>
                    <p class="mt-3 font-bold text-midnight">{{ $parent->students->flatMap(fn($student) => $student->subscriptions->pluck('course.name'))->unique()->count() }}</p>
                </div>
            </div>
        </div>

        <div class="rounded-3xl border-2 border-midnight bg-white p-5 shadow-[8px_8px_0px_0px_#0B132B] sm:p-8">
            <h2 class="text-2xl font-bold text-midnight">الطلاب</h2>
            <p class="mt-2 text-sm text-midnight/70">قائمة الأبناء المرتبطة بهذا ولي الأمر ومعلومات الدورة الخاصة بكل طالب.</p>

            <div class="mt-6 space-y-4">
                @forelse($parent->students as $student)
                    <div class="rounded-3xl border border-sand bg-sand/60 p-6">
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <p class="font-bold text-midnight">{{ $student->name }}</p>
                                <p class="mt-1 text-sm text-midnight/70">{{ $student->school }} - {{ $student->academic_year }}</p>
                            </div>
                            <p class="text-sm text-midnight/70">العمر: {{ $student->age }}</p>
                        </div>
                        <div class="mt-4 space-y-4">
                            <h3 class="text-base font-semibold text-midnight">الدورات المسجلة</h3>
                            @if($student->subscriptions->isEmpty())
                                <p class="text-sm text-midnight/70">لا توجد دورات مسجلة لهذا الطالب.</p>
                            @else
                                <div class="grid gap-4 sm:grid-cols-2">
                                    @foreach($student->subscriptions as $subscription)
                                        <div class="rounded-3xl bg-white p-4 shadow-sm border border-sand">
                                            <p class="font-semibold text-midnight">{{ $subscription->course->name ?? 'دورة محذوفة' }}</p>
                                            <p class="mt-1 text-sm text-midnight/70">حالة: {{ ucfirst($subscription->status) }}</p>
                                            <p class="mt-1 text-sm text-midnight/70">حتى: {{ $subscription->valid_until ? $subscription->valid_until->format('Y-m-d') : 'غير محدد' }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="rounded-3xl border border-sand bg-sand/60 p-6 text-center text-midnight/70">
                        لا يوجد طلاب لهذا ولي الأمر.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-admin>
