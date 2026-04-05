<x-app-layout title="Edit Kegiatan">

    <div class="max-w-2xl mx-auto">
        <div class="mb-10 text-center">
            <p class="text-blue-600 text-[10px] font-black uppercase tracking-[0.2em] mb-2">Internal Terminal // Job Modification</p>
            <h1 class="text-4xl font-black uppercase tracking-tighter leading-none">Edit Kegiatan</h1>
        </div>

        <form action="{{ route('student.activities.update', $activity) }}" method="POST" class="bg-white border-4 border-slate-900 p-8 shadow-[8px_8px_0px_#1e40af]">
            @csrf @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                {{-- Type --}}
                <div class="md:col-span-1">
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Category (Job/Freelance/etc)</label>
                    <input type="text" name="type" value="{{ old('type', $activity->type) }}" required
                           class="w-full border-2 border-slate-900 text-sm font-bold uppercase py-3 px-4 focus:ring-0 focus:border-blue-600">
                </div>

                {{-- Day --}}
                <div class="md:col-span-1">
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Day (HARI)</label>
                    <select name="day" required class="w-full border-2 border-slate-900 text-sm font-bold uppercase py-3 px-4 focus:ring-0 focus:border-blue-600">
                        @foreach(['SENIN', 'SELASA', 'RABU', 'KAMIS', 'JUMAT', 'SABTU', 'MINGGU'] as $day)
                            <option value="{{ $day }}" {{ $activity->day === $day ? 'selected' : '' }}>{{ $day }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Title --}}
                <div class="md:col-span-2">
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Activity Title</label>
                    <input type="text" name="title" value="{{ old('title', $activity->title) }}" required
                           class="w-full border-2 border-slate-900 text-sm font-bold uppercase py-3 px-4 focus:ring-0 focus:border-blue-600">
                </div>

                {{-- Time Start --}}
                <div class="md:col-span-1">
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Start Time (HH:MM)</label>
                    <input type="text" name="time_start" value="{{ old('time_start', $activity->time_start) }}" required
                           class="w-full border-2 border-slate-900 text-sm font-black uppercase py-3 px-4 focus:ring-0 focus:border-blue-600">
                </div>

                {{-- Time End --}}
                <div class="md:col-span-1">
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">End Time (HH:MM)</label>
                    <input type="text" name="time_end" value="{{ old('time_end', $activity->time_end) }}" required
                           class="w-full border-2 border-slate-900 text-sm font-black uppercase py-3 px-4 focus:ring-0 focus:border-blue-600">
                </div>

                {{-- Location --}}
                <div class="md:col-span-2">
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Location (Optional)</label>
                    <input type="text" name="location" value="{{ old('location', $activity->location) }}"
                           class="w-full border-2 border-slate-900 text-sm font-bold uppercase py-3 px-4 focus:ring-0 focus:border-blue-600">
                </div>

                {{-- Description --}}
                <div class="md:col-span-2">
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Notes / Description (Optional)</label>
                    <textarea name="description" rows="3" class="w-full border-2 border-slate-900 text-sm font-medium py-3 px-4 focus:ring-0 focus:border-blue-600">{{ old('description', $activity->description) }}</textarea>
                </div>
            </div>

            <div class="flex gap-4">
                <a href="{{ route('student.activities.index') }}" 
                   class="flex-1 text-center py-4 text-[10px] font-black uppercase tracking-widest border-2 border-slate-900 hover:bg-slate-50 transition-colors">
                    Back to Terminal
                </a>
                <button type="submit" class="flex-[2] bg-slate-900 text-white py-4 text-[10px] font-black uppercase tracking-widest hover:bg-blue-700 transition-colors">
                    Commit Changes (Save)
                </button>
            </div>
        </form>
    </div>

</x-app-layout>
