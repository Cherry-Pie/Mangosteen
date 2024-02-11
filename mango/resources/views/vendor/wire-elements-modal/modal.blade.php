<div>
    @isset($jsPath)
        <script>{!! file_get_contents($jsPath) !!}</script>
    @endisset
    @isset($cssPath)
        <style>{!! file_get_contents($cssPath) !!}</style>
    @endisset

    <div x-data="LivewireUIModal()"
         x-init="init()"
         x-on:close.stop="setShowPropertyTo(false)"
         x-on:keydown.escape.window="closeModalOnEscape()"
         x-on:keydown.tab.prevent="$event.shiftKey || nextFocusable().focus()"
         x-on:keydown.shift.tab.prevent="prevFocusable().focus()"
         x-show="show"
         id="bmodal"
    >
        <div
            class="modal fade show"
            style="display: block;"
            aria-modal="true"
            role="dialog"
            tabindex="-1"
        >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" x-on:click="closeModal()" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div
                        x-show="show && showActiveComponent"
                        x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave="ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"

                        class="modal-body"
                        id="modal-container"
                    >
                        @forelse($components as $id => $component)
                            <div x-show.immediate="activeComponent == '{{ $id }}'" x-ref="{{ $id }}" wire:key="{{ $id }}">
                                @livewire($component['name'], $component['attributes'], key($id))
                            </div>
                        @empty
                        @endforelse
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" x-on:click="closeModal()">close</button>
                        <button type="button" class="btn btn-primary">Test</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
