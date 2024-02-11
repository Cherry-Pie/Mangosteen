<div class="container-fluid py-4">

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ $activeTab == 'beforeRun' ? 'active' : '' }}" id="run-before-tab" data-bs-toggle="tab" data-bs-target="#run-before" type="button" role="tab" aria-controls="run-before" aria-selected="true">RUN: before</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ $activeTab == 'afterRun' ? 'active' : '' }}" id="run-after-tab" data-bs-toggle="tab" data-bs-target="#run-after" type="button" role="tab" aria-controls="run-after" aria-selected="false">RUN: after</button>
        </li>
        <li class="nav-item">
            <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true"> | </a>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ $activeTab == 'beforeStop' ? 'active' : '' }}" id="stop-before-tab" data-bs-toggle="tab" data-bs-target="#stop-before" type="button" role="tab" aria-controls="stop-before" aria-selected="true">STOP: before</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ $activeTab == 'afterStop' ? 'active' : '' }}" id="stop-after-tab" data-bs-toggle="tab" data-bs-target="#stop-after" type="button" role="tab" aria-controls="stop-after" aria-selected="false">STOP: after</button>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade {{ $activeTab == 'beforeRun' ? 'show active' : '' }}" id="run-before" role="tabpanel" aria-labelledby="run-before-tab">
            <div class="card-body p-3" style="height: 400px; position: relative;">
                <div id="editor-run-before" style="position: absolute;top: 0;right: 0;bottom: 0;left: 0;"  wire:ignore>{{ $codeBeforeRun }}</div>
            </div>
            <div class="card" style="border-top-left-radius: 0; border-top-right-radius: 0;">
                <div class="card-body p-3">
                    <div class="col-12 text-end">
                        <button type="button" wire:click="saveBeforeRun" class="btn btn-outline-primary btn-sm mb-0">Save</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade {{ $activeTab == 'afterRun' ? 'show active' : '' }}" id="run-after" role="tabpanel" aria-labelledby="run-after-tab">
            <div class="card-body p-3" style="height: 400px; position: relative;">
                <div id="editor-run-after" style="position: absolute;top: 0;right: 0;bottom: 0;left: 0;"  wire:ignore>{{ $codeAfterRun }}</div>
            </div>
            <div class="card" style="border-top-left-radius: 0; border-top-right-radius: 0;">
                <div class="card-body p-3">
                    <div class="col-12 text-end">
                        <button type="button" wire:click="saveAfterRun" class="btn btn-outline-primary btn-sm mb-0">Save</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade {{ $activeTab == 'beforeStop' ? 'show active' : '' }}" id="stop-before" role="tabpanel" aria-labelledby="stop-before-tab">
            <div class="card-body p-3" style="height: 400px; position: relative;">
                <div id="editor-stop-before" style="position: absolute;top: 0;right: 0;bottom: 0;left: 0;"  wire:ignore>{{ $codeBeforeStop }}</div>
            </div>
            <div class="card" style="border-top-left-radius: 0; border-top-right-radius: 0;">
                <div class="card-body p-3">
                    <div class="col-12 text-end">
                        <button type="button" wire:click="saveBeforeStop" class="btn btn-outline-primary btn-sm mb-0">Save</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade {{ $activeTab == 'afterStop' ? 'show active' : '' }}" id="stop-after" role="tabpanel" aria-labelledby="stop-after-tab">
            <div class="card-body p-3" style="height: 400px; position: relative;">
                <div id="editor-stop-after" style="position: absolute;top: 0;right: 0;bottom: 0;left: 0;"  wire:ignore>{{ $codeAfterStop }}</div>
            </div>
            <div class="card" style="border-top-left-radius: 0; border-top-right-radius: 0;">
                <div class="card-body p-3">
                    <div class="col-12 text-end">
                        <button type="button" wire:click="saveAfterStop" class="btn btn-outline-primary btn-sm mb-0">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>



@push('scripts')
    <script>
        var editorBefore = ace.edit("editor-run-before");
        editorBefore.setTheme("ace/theme/monokai");
        editorBefore.session.setMode("ace/mode/sh");
        editorBefore.on("change", function(e){
            @this.codeBeforeRun = editorBefore.getValue()
        });

        var editorAfter = ace.edit("editor-run-after");
        editorAfter.setTheme("ace/theme/monokai");
        editorAfter.session.setMode("ace/mode/sh");
        editorAfter.on("change", function(e){
            @this.codeAfterRun = editorAfter.getValue()
        });


        var editorBefore = ace.edit("editor-stop-before");
        editorBefore.setTheme("ace/theme/monokai");
        editorBefore.session.setMode("ace/mode/sh");
        editorBefore.on("change", function(e){
            @this.codeBeforeStop = editorBefore.getValue()
        });

        var editorAfter = ace.edit("editor-stop-after");
        editorAfter.setTheme("ace/theme/monokai");
        editorAfter.session.setMode("ace/mode/sh");
        editorAfter.on("change", function(e){
            @this.codeAfterStop = editorAfter.getValue()
        });
    </script>
@endpush
