<x-admin>
    <div class="space-y-6">
        <div class="rounded-3xl bg-white p-8 shadow-xl border border-sand">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-midnight">تعديل كلمة المرور</h1>
                    <p class="mt-2 text-sm text-midnight/70">تغيير كلمة المرور لولي الأمر: <span class="font-bold text-midnight">{{ $parent->name }}</span></p>
                </div>
                <a href="{{ route('admin.parents.index') }}" class="bg-midnight px-5 py-2.5 rounded-full font-bold text-sand transition hover:bg-terracotta text-sm text-center">العودة للقائمة</a>
            </div>

            @if($errors->any())
                <div class="mt-6 rounded-3xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-800">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.parents.update', $parent) }}" class="mt-6 space-y-4 max-w-lg">
                @csrf
                @method('PUT')

                <div>
                    <label for="password" class="block font-bold text-midnight text-sm mb-2">كلمة المرور الجديدة</label>
                    <input type="password" name="password" id="password" required class="w-full border-2 border-midnight bg-white px-4 py-3 text-right text-midnight outline-none focus:bg-sand">
                </div>

                <div>
                    <label for="password_confirmation" class="block font-bold text-midnight text-sm mb-2">تأكيد كلمة المرور الجديدة</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required class="w-full border-2 border-midnight bg-white px-4 py-3 text-right text-midnight outline-none focus:bg-sand">
                </div>

                <div class="pt-4">
                    <button type="submit" class="bg-midnight px-6 py-3 font-bold text-sand transition hover:bg-terracotta">حفظ كلمة المرور</button>
                </div>
            </form>
        </div>
    </div>
</x-admin>