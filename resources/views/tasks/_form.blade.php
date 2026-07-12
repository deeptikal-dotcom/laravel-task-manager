{{-- Shared form fragment used by create + edit --}}
<div class="form-group mb-4">
    <label for="title" class="form-section-label">Task Title <span class="text-danger">*</span></label>
    <input type="text"
           id="title"
           name="title"
           value="{{ old('title', $task->title ?? '') }}"
           required
           maxlength="255"
           placeholder="What needs to be done?"
           class="form-control form-control-lg @error('title') is-invalid @enderror">
    @error('title')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group mb-4">
    <label for="description" class="form-section-label">Description <small class="text-muted font-weight-normal">(optional)</small></label>
    <textarea id="description"
              name="description"
              rows="4"
              placeholder="Add any extra detail…"
              class="form-control @error('description') is-invalid @enderror">{{ old('description', $task->description ?? '') }}</textarea>
    @error('description')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group mb-4">
    <label for="status" class="form-section-label">Status <span class="text-danger">*</span></label>
    <select id="status"
            name="status"
            required
            class="form-control @error('status') is-invalid @enderror">
        <option value="">— Select a status —</option>
        @foreach ($statuses as $option)
            <option value="{{ $option }}"
                    @selected(old('status', $task->status ?? '') === $option)>
                {{ ucfirst($option) }}
            </option>
        @endforeach
    </select>
    @error('status')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
