@include('admin.include.header')

<main class="dashboard-content">
  <div class="container-fluid px-3 px-lg-4 py-4">

    <div class="page-heading">
      <div class="page-heading-copy">
        <span class="page-icon"><i class="bi bi-send" aria-hidden="true"></i></span>
        <div>
          <p class="eyebrow mb-1">New</p>
          <h1 class="h3 mb-1">ផ្ញើសារ / Send Notification</h1>
        </div>
      </div>
    </div>

    @if ($errors->any())
      <div class="alert alert-danger mt-3">
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <section class="panel mt-3">
      <form method="POST" action="{{ route('admin.notifications.store') }}">
        @csrf

        <div class="row g-3">
          <div class="col-12 col-md-6">
            <label class="form-label" for="recipient_type">ផ្ញើទៅ / Send To</label>
            <select name="recipient_type" id="recipient_type" class="form-select" required>
              <option value="">-- Select --</option>
              <option value="student">All Students</option>
              <option value="teacher">All Teachers</option>
              <option value="parent">All Parents</option>
            </select>
          </div>

          <div class="col-12 col-md-6">
            <label class="form-label" for="recipient_id">លេខសម្គាល់ជាក់លាក់ / Specific ID <span class="text-muted">(optional)</span></label>
            <input type="text" name="recipient_id" id="recipient_id" class="form-control" placeholder="e.g. STU0001 — leave blank to send to everyone in that role" value="{{ old('recipient_id') }}">
          </div>

          <div class="col-12">
            <label class="form-label" for="title">ចំណងជើង / Title</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required>
          </div>

          <div class="col-12">
            <label class="form-label" for="body">សារ / Message</label>
            <textarea name="body" id="body" rows="4" class="form-control">{{ old('body') }}</textarea>
          </div>
        </div>

        <button type="submit" class="btn btn-primary mt-3">
          <i class="bi bi-send" aria-hidden="true"></i> ផ្ញើ / Send
        </button>
        <a href="{{ route('admin.notifications.index') }}" class="btn btn-outline-secondary mt-3">បោះបង់ / Cancel</a>
      </form>
    </section>

  </div>
</main>

@include('admin.include.footer')
